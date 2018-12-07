<?php

class senderQueue
{
	protected $version = "1.1.5";	
	protected $bot_id = "";	
	protected $user_id = "";	
	protected $key_md5 = "";
	protected $bot_api_key = "";
	protected $chat_id = "";	
	protected $sends_mas = array();
	protected $data_mas = array();
	protected $HTTP_HOST = "";	
	protected $user_name = "";	
	protected $bot_type = "";	
	
	public function __construct($data_mas)
    {		
        $this->bot_id = $data_mas['bot_id'];
		$this->user_id = $data_mas['user_id'];
		$this->key_md5 = $data_mas['key_md5'];
		$this->bot_api_key = $data_mas['bot_api_key'];
		$this->chat_id = $data_mas['to_user_id'];
		$this->sends_mas = $data_mas['sends_mas'];		
		$this->bot_id = $data_mas['bot_id'];		
		$this->HTTP_HOST = $data_mas['HTTP_HOST'];
		$this->user_name = $data_mas['user_name'];
		$this->bot_type = $data_mas['bot_type'];
		
		$this->data_mas = $data_mas;
		
		//print_r($this->data_mas);
    } 
	
	public function getDataMas()
	{		
		return $this->data_mas;
	}
	
	public function getHTTP_HOST()
	{		
		return $this->HTTP_HOST;
	}	
	
	public function getBotId()
	{		
		return $this->bot_id;
	}	

	public function getUserId()
	{		
		return $this->user_id;
	}	
	
	public function getChatId()
	{		
		return $this->chat_id;
	}		
	
	public function getBotType()
	{		
		return $this->bot_type;
	}	

	public function getVersion()
	{		
		return $this->version;
	}	
	
	public function sendToUserBySender()
	{
		$resp_con_mas = [];
		
		//Смотрим - если bot_api_key - то проверка наличия синтаксиса
		
		$editor = false;
		
		if($this->bot_api_key != "")
		{			
			foreach($this->sends_mas as $sends_mas)
			{				
				$test_easy = str_replace("[b]", "", $sends_mas['text']);
				$test_easy = str_replace("[/b]", "", $test_easy);
				
				if(str_replace("[", "", $test_easy) != $test_easy)//Нашли [ помимо жирного текста
					$editor = true;				
			}
			
		}
		else
			$editor = true;
		
		if($editor)
		{
			//Сюда не чаще чем раз в секунду ломиться можно
			
			$sender_data_str = json_encode($this->getDataMas());	
			$HTTP_HOST = $this->getHTTP_HOST();
			$bot_id = $this->getBotId();
			$user_id = $this->getUserId();
			$bot_type = $this->getBotType();
			
			$postvars = array();
			$postvars['data'] = $sender_data_str;
			
			//====================================================
			//====================================================		
				
			if($bot_type == 'vkg')
			{
				$ch = curl_init();	
				curl_setopt($ch, CURLOPT_URL, 'http://' . $HTTP_HOST . '/all/s_radoid/dialogs/api/methods/setSenderVkg.php');
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
				curl_setopt($ch, CURLOPT_POST, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
				$resp_con = curl_exec($ch);	
				curl_close($ch);	

				$resp_con_mas = json_decode($resp_con, true);	
			}	
			else
			{
				$ch = curl_init();	
				curl_setopt($ch, CURLOPT_URL, 'http://' . $HTTP_HOST . '/all/s_radoid/dialogs/api/methods/setSenderQueue.php');
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
				curl_setopt($ch, CURLOPT_POST, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
				$resp_con = curl_exec($ch);	
				curl_close($ch);	

				$resp_con_mas = json_decode($resp_con, true);
				
				if($resp_con_mas['insert_count'] > 0)
				{
					
					$send_url = 'http://' . $HTTP_HOST . '/all/s_radoid/dialogs/api/methods/goSender.php?bot_id=' . $bot_id . '&user_id=' . $user_id . '&host=http://' . $HTTP_HOST; 
					
					$getSenders_str = file_get_contents($send_url);	

					$getSenders = json_decode($getSenders_str, true);		

					$resp_con_mas['goSender.php'] = $getSenders;
					
				}				
				
			}				
		}
		else
		{
			$chat_id = $this->getChatId();
			
			foreach($this->sends_mas as $sends_mas)
			{		
				$parse_mode = "";
			
				$test_easy = str_replace("[b]", "*", $sends_mas['text']);
				$test_easy = str_replace("[/b]", "*", $test_easy);	
				$test_easy = str_replace("<b>", "*", $test_easy);
				$test_easy = str_replace("</b>", "*", $test_easy);	

				if($sends_mas['text'] != $test_easy)
					$parse_mode = "markdown";

				
				$test_easy = str_replace("%0A", "\n", $test_easy);
					
				$urlencode = urlencode($test_easy . "");
					
				$url = "https://api.telegram.org/bot" . $this->bot_api_key . "/sendMessage?chat_id=" . $chat_id . "&parse_mode=" . $parse_mode . "&text=" . $urlencode;
	
				$resp_con_mas['url'] = $url;
				$resp_con_mas['api_telegram_resp'] = file_get_contents($url);	
				
			}			
			
		}
	
		
		return $resp_con_mas;	
		
		
	}
	
}


		
?>
