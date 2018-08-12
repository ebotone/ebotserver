<?php


function go_resp_speaker($data_mas)
{
		
	$body = $data_mas['body'];
	$user_id = $data_mas['user_id'];
	$token = $data_mas['token'];
	$dialog_id = $data_mas['dialog_id'];
	$icons_url = $data_mas['icons_url'];
	
	$resp_arg = array();
	$resp_arg['dialog_id'] = $dialog_id;
	$resp_arg['token'] = $token;
	$resp_arg['icons_url'] = $icons_url;	
	
	$error_isset = false;		
		
	try 
	{		
		
		$body = iconv('utf-8', 'cp1251', $body);	
		
		$resp_ex = new Resp($resp_arg);						
		$body = $resp_ex->getBodySunCharsIncorrect($body);		
		
		$body = $resp_ex->syntaxFix($body);
		
		$data_for_resp = array();
		$data_for_resp['con'] = $body;
		$data_for_resp['chat_id'] = $user_id;	
		
		$resp_data = $resp_ex->parseResp($data_for_resp);
		
		if($resp_data['text'] == "")
		{
			$error_isset = true;
			$error_notice = 'Ответ пуст. Возможно где-то ошибка.';
			
		}	
		else
			return $resp_ex->sendMessage($resp_data);	
		
			

	}
	catch(Exception $e) 
	{
		//ob_end_clean();
		
		$error_isset = true;					
		$error_notice = 'Ошибка выполнения скрипта';		
		

	}
	
	if($error_isset)
	{		
		$resp_ex = new Resp($resp_arg);	
		
		$data = [
		'chat_id' => $user_id,
		'text'    => $error_notice,
		'parse_mode' => 'HTML',	
		];			
		
		return $resp_ex->sendMessage($data);			
	}

	
}



class Resp
{
	protected $dialog_id = '';
	protected $token = '';
	protected $icons_content = '';
	protected $icons_url = '';
	
    public function __construct($data_mas)
    {
		$this->dialog_id = $data_mas['dialog_id'];
		$this->token = $data_mas['token'];
		$this->icons_url = $data_mas['icons_url'];
    } 
	
	public function parseResp($data_mas)
	{
	
		$chat_id = $data_mas['chat_id'];
		$con = $data_mas['con'];
		
		//$con = " " . $con;
		
		//$path_log = 'dialogs/_777.txt';
		//$fp = fopen($path_log, 'a');
		//$trace = fwrite($fp, "\n\n body=" . $con . "  \n\n "); 
		//fclose($fp);
		
		$update = $data_mas['update'];
		$message_id = $data_mas['message_id'];
		
		$radoid_id = $data_mas['radoid_id'];//Только для тестов, так он тут не нужен
		
		$sys = $data_mas['sys'];
		
		$verification = false;
		
		$verification_dialog_id = str_replace('verification_', '', $con) + 0;
		
		if($verification_dialog_id > 0)
		{
			$verification = true;	
			
			$verification_host = $data_mas['verification_host'];

		}		
		
		if($con == '')
		{
			if($chat_id < 0)
			{
				$con = '';
				
			}
			else
				$con = 'lol';
			
		}	
		
		$request_mas = array();

		/*
		$con = str_replace('[b]', '<b>', $con);
		$con = str_replace('[/b]', '</b>', $con);		

		$con = str_replace('[u]', '<u>', $con);
		$con = str_replace('[/u]', '</u>', $con);		

		$con = str_replace('[i]', '<i>', $con);
		$con = str_replace('[/i]', '</i>', $con);		
		*/
		
		$con = $this->replaceUserNamesData($con, $chat_id);
		
		//========================================
		//========================================	

		//Вытащим метаданные			

		$data = $this->getMetaData($con);	
					
		$con = $data['body'];		
		
		//========================================
		//========================================		

		//Вытащим title	
		
		$data = $this->getTitle($con);	
					
		$con = $data['body'];
		$title = $data['title'];	

		//$con = $title . ":\n\n" . $con; 	
		
		//========================================			

		//Получение медиаданных тут
		
		//========================================	
		
		
		
		//========================================
		
		$data_Keyboard_mas = $this->getKeyboardDataImg($con);

		$con = $data_Keyboard_mas['con'];
		$keyboard = $data_Keyboard_mas['keyboard'];//Получили кнопочки	
		$button_names = $data_Keyboard_mas['button_names'];//Имена кнопочем (для замены - на месте не получилось)	

		$con = iconv('cp1251', 'utf-8', $con);
		
		$con = $this->replaceIconsVkg($con);
		
		$keyboard_str = $this->getKeyboardJson($keyboard, $button_names);
		
		$data = [
		'chat_id' => $chat_id,
		'text'    => $con,
		'keyboard_str' => $keyboard_str,
		'parse_mode' => 'HTML',	
		];			

		return $data;			

	}
	
	public function replaceUserNamesData($con, $user_id)
	{
		if(str_replace('{first_name}', '', $con) != $con || str_replace('{last_name}', '', $con) != $con)
		{
			$user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.74&access_token=" . $this->token));        
			$first_name = $user_info->response[0]->first_name;	
			$last_name = $user_info->response[0]->last_name;	
			
			//$fp = fopen("7777.txt", 'a');
			//$trace = fwrite($fp, "\n\n" . date("Y-m-d H:i:s") . " user_id=" . $user_id . "\n\n user_info:\n" . print_r($user_info, true) . "\n\n \n\n"); 
			//fclose($fp);			
				
			$first_name = iconv('utf-8', 'cp1251', $first_name) . ')';
			$last_name = iconv('utf-8', 'cp1251', $last_name) . ')';	
				
			$con = str_replace('{first_name}', $first_name, $con);
			$con = str_replace('{last_name}', $last_name, $con);
		}
		
		return $con;
	}

	public function getEmogiByCode($emoji_code)
	{		
		$emoji = '';
		
		if($this->icons_content == "" && $this->icons_url != "")		
			$this->icons_content = file_get_contents($this->icons_url);
		
		if($this->icons_content != "")
		{
			try{				
				
				$results = phpQuery::newDocument($this->icons_content);	
				
				//$results->find('.article-image')->remove();
				
				$emoji_s = $results->find(".emoji[src='https://vk.com/images/emoji/" . $emoji_code . ".png']");			
				
				foreach ($emoji_s as $emoji_el)
				{						
				
					$emoji = pq($emoji_el)->attr("alt");			
				

				}						
				
				
			} catch (Exception $e) {
				
				
			}				
			
			
		}
		
		
		return $emoji;
	}
	
	public function getKeyboardJson($keyboard, $button_names)
	{	
		$keyboard_str = '';
		
		$keyboard_str = json_encode($keyboard);
		
		$count_button_names = count($button_names);
		
		for($k = 0; $k < $count_button_names; $k++)
		{
			$command_name = $button_names[$k]['command_name'];
			$emoji_code = $button_names[$k]['emoji'];
			
			$emoji = $this->getEmogiByCode($emoji_code) . " "; //'😃 ';
			
			$command_name = iconv('cp1251', 'utf-8', $command_name);
			
			$keyboard_str = str_replace('@' . $button_names[$k]['k'] . '@', $emoji . $command_name, $keyboard_str);
			
			
			
		}
		
		return $keyboard_str;
	}	
	
	
	public function getButtonColor()
	{	
		return 'positive';
	}
	
	public function getKeyboardDataImg($body)
	{
		
		$button_names = array();
		
		$keyboard = array();	
		$keyboard['one_time'] = false;		
		
		$keyboards_mas = array();		
		
		$result_count_z = preg_match_all("/\[command\|([^\|]{1,})\|([^\|]{1,})\|([^\|]{1,})\]/i", $body, $result_mas); 
		
		if($result_count_z > 0)
		{							
			for($k = 0; $k < $result_count_z; $k++)
			{	
				$command_name = $result_mas[1][$k];
				$telegram_tr = $result_mas[2][$k];
				$emoji = $result_mas[3][$k];
				
				$el = '[command|' . $command_name . '|' . $telegram_tr . '|' . $emoji . ']';					
				
				$body = str_replace($el, '', $body);
				
				$add = array();
				$add['command_name'] = $command_name;
				$add['telegram_tr'] = $telegram_tr;
				$add['emoji'] = urldecode($emoji);
				
				$keyboards_mas[] = $add;

		
					
			}
		}		
		
		$buttons = array();
		
		$count_keyboards_mas = count($keyboards_mas);	
		
		if($count_keyboards_mas > 0)
		{
			//Формируем правильный порядок для кнопок:
			
			$tr_open = false;
			
			for($k = 0; $k < $count_keyboards_mas; $k++)
			{
				$command_name = $keyboards_mas[$k]['command_name'];
								
				$request_contact = false;
				$request_location = false;
				
				if($keyboards_mas[$k]['command_name'] == 'request_contact')
				{
					$request_contact = true;
			
					
				}
					
				if($keyboards_mas[$k]['command_name'] == 'request_location')
				{
					$request_location = true;
			
					
				}				
				
				$emoji = trim($keyboards_mas[$k]['emoji']);
				$emoji_str = '';
				
				
				$emoji_mas = explode("@", $emoji);
				
				$emoji = $emoji_mas[0];//emoji
				$color = $emoji_mas[1];
				
				if($color == '')
					$color = 'default';
				
				if($emoji != '-' && $emoji != "")
				{
					
					$emoji_str = json_decode('"' . $emoji . '"');
					
					
				}
					
								
			
				if(!$tr_open)
				{
					$tr_open = true;//Начали формировать строку
					
					$tr_mas = array();

				}			
			
				if($keyboards_mas[$k]['telegram_tr'] == 0)
				{

					if($request_contact)
					{

					}
					elseif($request_location)
					{

					}					
					else
					{
						$button_name = array();
						$button_name['command_name'] = $command_name;
						$button_name['emoji'] = $emoji;
						$button_name['k'] = $k;
						
						$button_names[] = $button_name;
						
						//=======================
						
						$btn_add = array();

							$action = array();							
							$action['type'] = "text";	
							$action['payload'] = "{\"button\": \"" . ($k + 1) . "\"}";
							$action['label'] = "@" . $k . "@";								
						
						$btn_add['action'] = $action;						
						$btn_add['color'] = $color; //$this->getButtonColor();
						
						$tr_mas[] = $btn_add;
						
					}
					
					
					
						
				}					
				else
				{
					//Просят перенести.
					//Закрываем строку, добавляем.
					
					if($request_contact)
					{

					}
					elseif($request_location)
					{

					}						
					else
					{
						
						$button_name = array();
						$button_name['command_name'] = $command_name;
						$button_name['emoji'] = $emoji;
						$button_name['k'] = $k;
						
						$button_names[] = $button_name;

						//=======================	
						
						$btn_add = array();

							$action = array();							
							$action['type'] = "text";	
							$action['payload'] = "{\"button\": \"" . ($k + 1) . "\"}";
							$action['label'] = "@" . $k . "@";								
						
						$btn_add['action'] = $action;						
						$btn_add['color'] = $color; //$this->getButtonColor();
						
						$tr_mas[] = $btn_add;
						
					}
					
					$tr_open = false;
					
					if(count($tr_mas) > 0)
					{
						//add tr
						
						$buttons[] = $tr_mas;
						$tr_mas = array();
						
					}						
						

				}	
			
			}
		
			if($tr_open)
			{
				if(count($tr_mas) > 0)				
				{
					//add tr
					
					$buttons[] = $tr_mas;
					$tr_mas = array();					
				}	
			
			}			
			
		
		
		}		
		
		$keyboard['buttons'] = $buttons;	
		
		$return_data_mas = array();
		$return_data_mas['con'] = $body;
		$return_data_mas['keyboard'] = $keyboard;
		$return_data_mas['button_names'] = $button_names;
		
		return $return_data_mas;
	}		
	
	public function getTitle($body)
	{		
		$return_data = array();		
	
		$result_count_z = preg_match_all("/\[title\|([^\|]{1,})\]/i", $body, $result_mas); 
		
		if($result_count_z > 0)
		{							
			for($k = 0; $k < $result_count_z; $k++)
			{	
				$title = trim($result_mas[1][$k]);				
				
				$el = '[title|' . $title . ']';	
				
				$body = str_replace($el, '', $body);	
				
			
			}
		}	

		$return_data['body'] = $body;
		$return_data['title'] = $title;	
	
		return $return_data;	
	
	}	
	
	public function replaceIconsVkg($body)
	{		
	
		$result_count_z = preg_match_all("/\[icon\|([^\|]{1,})\]/i", $body, $result_mas); 
		
		if($result_count_z > 0)
		{							
			for($k = 0; $k < $result_count_z; $k++)
			{	
				$emoji_code = trim($result_mas[1][$k]);				
				
				$el = '[icon|' . $emoji_code . ']';	

				$emoji = $this->getEmogiByCode($emoji_code);
				
				$body = str_replace($el, $emoji, $body);				

				
			
			}
		}	
	
		return $body;	
	
	
	}	
	
	public function getMetaData($body)
	{		
		
		$return_data = array();		
		$meta_data = array();
	
		$result_count_z = preg_match_all("/\[meta_data\|([^\|]{1,})\]/i", $body, $result_mas); 
		
		if($result_count_z > 0)
		{							
			for($k = 0; $k < $result_count_z; $k++)
			{	
				$meta_data_str = trim($result_mas[1][$k]);				
				
				$el = '[meta_data|' . $meta_data_str . ']';	

				$meta_data_str = urldecode($meta_data_str);	
				
				$body = str_replace($el, '', $body);				
				
				parse_str($meta_data_str, $meta_data);
				
			
			}
		}	

		$return_data['body'] = $body;
		$return_data['meta_data'] = $meta_data;	
	
		return $return_data;	
	
	
	}		

	public function sendMessage($data)
	{		
		$request_params = array(
		'message' => $data['text'],
		'user_id' => $data['chat_id'],		
		'access_token' => $this->token,		
		'v' => '5.74'
		);
		
		//'read_state' => 1,
		
		if($data['keyboard_str'] != "")
			$request_params['keyboard'] = $data['keyboard_str'];	
		
		$post = 1;		
		
		if($post == 1)
		{
			$postvars = http_build_query($request_params, '', '&');

			$ch = curl_init();	
			curl_setopt($ch, CURLOPT_URL, 'https://api.vk.com/method/messages.send');
			curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; CrOS x86_64 8172.45.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.64 Safari/537.36');
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
			$result = curl_exec($ch);	
			curl_close($ch);				
		}
		else
		{
			$get_params = http_build_query($request_params);		
			$result = file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);			
			
		}		
		
		return json_decode($result, true);//Вк может ответить ошибкой. ее нужно или сохранить в базе или в логе
				
	}	
	
	public function getBodySunCharsIncorrect($body)
	{	
		$body_mas = explode(' ', $body);
		
		if(count($body_mas) > 0)
		{
			$first = $body_mas[0];
			
			//echo 'first = ' . $first . '<br>';
			
			$char_incorrect = 0;			

			$f_count=preg_match_all("/[^а-яА-ЯёЁa-zA-Z0-9\/\?\=\:\_\-\s\.\,\(\)\+\{\}\@\#\!\$\%\^\&\*]/u",$first, $level_1_mas);

			//print_r($level_1_mas);
			
			if($f_count > 0)
			{
				$char_incorrect = 1;				
				
			}	

			//echo 'char_incorrect = ' . $char_incorrect . '<br>';	
	
			if($char_incorrect == 1)
			{
				$body_mas[0] = '';	
				
				$body = trim(implode(' ', $body_mas));
				
				
			}		

		}	
	
	
		return $body;
	}	
	
	public function syntaxFix($resp_body)
	{
		$resp_body = str_replace("[b]", "", $resp_body);
		$resp_body = str_replace("[/b]", "", $resp_body);
		
		$resp_body = str_replace("<b>", "", $resp_body);
		$resp_body = str_replace("</b>", "", $resp_body);
		
		$resp_body = str_replace("<br>", " ", $resp_body);
		
		return $resp_body;
	}	
	
}

	






?>