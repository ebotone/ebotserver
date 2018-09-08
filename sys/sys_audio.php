<?php

class ebotAudio
{
	protected $version = "1.1.1";	
	protected $bot_api_key = "";
	protected $chat_id = "";
	protected $path = "";
	protected $_dir = "";
	protected $subdir = "";
	protected $file_name = "";
	protected $enter_data = [];
	
	protected $type_analisator = "";	
	protected $type_synthesizer = "";
	protected $yandex = [];
	
	public function __construct($data_mas)
    {
		$this->bot_api_key = $data_mas['bot_api_key'];
		$this->chat_id = $data_mas['chat_id'];
		$this->path = $data_mas['path'];
        $this->_dir = $data_mas['dir'];
		$this->subdir = $data_mas['subdir'];
		$this->file_name = $data_mas['file_name'];
		$this->enter_data = $data_mas['enter_data'];
    } 
	
	public function audioParserSettings($data_mas)
	{		
		$this->type_analisator = $data_mas['type_analisator'];
		$this->type_synthesizer = $data_mas['type_synthesizer'];
		$this->yandex = $data_mas['yandex'];
	}		
	
	public function getPath()
	{		
		return $this->path;
	}	
	
	public function getChatId()
	{		
		return $this->chat_id;
	}		
	
	public function getFileName()
	{		
		return $this->file_name;
	}		
	
	public function getSubDir()
	{		
		return $this->subdir;
	}			
	
	public function get_Dir()
	{		
		return $this->_dir;
	}		
	
	public function getVersion()
	{		
		return $this->version;
	}		
	
	public function fileSave()
	{
		$return = [];
		
		$type_object = $this->enter_data['type_object'];	
		
		if($type_object != '')
		{
			$file_id = $this->enter_data['file_info'][$type_object]['file_id'];		
			$mime_type = $this->enter_data['file_info'][$type_object]['mime_type'];
			$file_name = $this->enter_data['file_info'][$type_object]['file_name'];	
			$duration = $this->enter_data['file_info'][$type_object]['duration'];	
			$file_size = $this->enter_data['file_info'][$type_object]['file_size'];		
						
			if($mime_type != "")
			{				
				
				$mime_type_mas = explode('/',  $mime_type);
					

				if($file_name != "")
				{
					$file_name_mas = explode('.', $file_name);	
					$file_end = $file_name_mas[count($file_name_mas) - 1];
				}
				else
				{					
					$file_end = '';//http://www.master-sv.com/blog/mime-types-table/
					
					if($mime_type == 'audio/x-wav')
						$file_end = 'wav';
					
					if($mime_type == 'audio/mpeg')
						$file_end = 'm4a';	

					if($mime_type == 'audio/ogg')// audio/ogg - запись с микрофона
						$file_end = 'ogg';						
					
				}
				
					
				
				if($file_id != "")
				{
					//Получим файл
					
					$url_get_file_info = "https://api.telegram.org/bot" . $this->bot_api_key . "/getFile?file_id=" . $file_id;//По этой ссылке мы получим инфу 
						
					$get_file_info_con = file_get_contents($url_get_file_info);
					
					$url_get_file_info_mas = json_decode($get_file_info_con, true); 
					
					if($url_get_file_info_mas['ok'])
					{			
						
						$file_path = $url_get_file_info_mas['result']['file_path'];
						
						if($file_path != "")
						{
							
							$url_get_file_put = "https://api.telegram.org/file/bot" . $this->bot_api_key . "/" . $file_path;
							
							$_dir = $this->get_Dir();
							$subdir = $this->getSubDir();
							$file_name = $this->getFileName();
							
							if($_dir == "")
								$_dir= $mime_type_mas[0];
							
							if($subdir == "")
								$subdir = $this->getChatId();
							
							if($file_name == "")
								$file_name = time();
							
							mkdir($_dir, 0777);										
							mkdir($_dir . "/" . $subdir, 0777);
							
							$file_save_name = $file_name . "." . $file_end;
							
							$return['file_save_name'] = $file_save_name;
							
							$file_save_path = $this->getPath() ."/" . $_dir . "/" . $subdir . "/" . $file_save_name;
							
							$return['file_save_path'] = $file_save_path;
							
							file_put_contents($file_save_path, file_get_contents($url_get_file_put));	
									
								
						}
					}
					
				}				
			}
								

		}
		
		$return['type_object'] = $type_object;
		
		$return['file_id'] = $file_id;
		$return['mime_type'] = $mime_type;
		$return['file_name'] = $file_name;	
		$return['duration'] = $duration;	
		$return['file_size'] = $file_size;	
		
		return $return;
	}
	
	public function getAnalisatorsList()
	{
		$list = array();
		$list[] = array("name" => "voise_lib");			
		$list[] = array("name" => "voise_lib2");	
		
		return $list;
	}
	
	public function getSynthesizerList()
	{
		$list = array();
		$list[] = array("name" => "SpeechKit");			
		$list[] = array("name" => "SpeechKit2");	
		
		return $list;
	}	
	
	public function generateRandomSelection($min, $max, $count)
	{
		$result = [];
		if ($min > $max) {
			return $result;
		}
		$count = min(max($count, 0), $max - $min + 1);
		while (count($result) < $count) {
			$value = rand($min, $max - count($result));
			foreach ($result as $used) {
				if ($used <= $value) {
					$value++;
				} else {
					break;
				}
			}
			$result [] = dechex($value);
			sort($result);
		}
		shuffle($result);
		return $result;
	}	
	
	public function recognize($file, $key, $lang = 'ru-RU')
	{
		
		//$file = '/home/f/fb790430/xn--80addj8aakhjc.xn--p1ai/public_html/all/kvest/modules/demo3/scripts/audio/279422532/what_time.wav';
		
		$uuid = $this->generateRandomSelection(0, 30, 64);
		$uuid = implode($uuid);
		$uuid = substr($uuid, 1, 32);
		$curl = curl_init();
		$url = 'https://asr.yandex.net/asr_xml?' . http_build_query([
				'key' => $key,
				'uuid' => $uuid,
				'topic' => 'notes',
				'lang' => $lang,
			]);
		curl_setopt($curl, CURLOPT_URL, $url);

		$data = file_get_contents(realpath($file));
		// MIME
		// Finfo not working correctly (`audio/mpeg` instead of `audio/x-mpeg-3` etc.)
		$ext = strtolower(pathinfo(realpath($file), PATHINFO_EXTENSION));
		switch ($ext) {
			case 'mp3':
				$mime = 'audio/x-mpeg-3';
				break;
			case 'ogg':
				$mime = 'audio/ogg;codecs=opus';
				break;
			default:
				$mime = 'audio/x-wav';
		}
		
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, [
			'Content-Type: ' . $mime,
			//'Transfer-Encoding: chunked',
		]);
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		$response = curl_exec($curl);

		$err = curl_errno($curl);
		curl_close($curl);
		if ($err) {
			throw new \Exception('cURL error: ' . $err);
		}		
		
		$results = new SimpleXMLElement($response);		
			
		/*
		
		<recognitionResults success="1">
			<variant confidence="0">1 2 3 4 5 расскажи что нибудь</variant>
		</recognitionResults>		
		
		foreach ($results->variant as $variant) {
			echo 'Достоверность: ', (100.0 * floatval($variant['confidence'])), '%', PHP_EOL;
			echo $variant, PHP_EOL, PHP_EOL;
		}*/
		
		return $results;
	}	
	
	public function VoisLibParserWords($args)
	{			
		
		return $this->recognize($args['file_path'], $args['yandex_key'], $args['lng']);
		
		/*
		
			Array
			(
				[@attributes] => Array
					(
						[success] => 1
					)

				[variant] => сколько времени
			)		
		
		*/
		
	}	
	
	public function wordsParser($args)
	{
		$return = array();
		$return['analisator_status'] = 0;

		
		if($args['file_path'] != "")
		{		
			
			//Теперь смотрим чем парсим
			
			if($this->type_analisator != "")
			{
				

		
				$analisator_check = false;
				$analisator_name = '';
				
				foreach($this->getAnalisatorsList() as $analisator)
				{
					if($analisator['name'] == $this->type_analisator)
					{
						$analisator_check = true;
						$analisator_name = $analisator['name'];
					}
					
				}
					
				if($analisator_check)
				{
					if($analisator_name == 'voise_lib')
					{
						$return['analisator_status'] = 1;
						
						//Раотаем с библиотекой voic.php
											
						$yandex = $this->yandex;				
								
						if($yandex['yandex_key'] != "")
						{							
		
							$args2 = array();
							$args2['file_path'] = $args['file_path'];	
							$args2['yandex_key'] = $yandex['yandex_key'];
							$args2['lng'] = 'ru-RU';	
							
							$words = (array) $this->VoisLibParserWords($args2);							
						
							
							if($args['count'] == 'all')
								$return['words'] = $words['variant'];
							else
							{
								if(count($words['variant']) > 1)
									$return['words'] = $words['variant'][0];
								else
									$return['words'] = $words['variant'];
							}								
						}
						else
							$return['error'] = 'yandex key is empty';	
									
						
					}
					elseif($analisator_name == 'voise_lib2')
					{
						$return['analisator_status'] = 1;
						
						//Работаем с библиотекой voic2.php						
						
					}
					
				}
				else
					$return['error'] = 'analisator is not correct';	
				
			}
			else
				$return['error'] = 'type_analisator is empty';			
			
			
		}
		else
			$return['error'] = 'input_file_path is empty';
		
		return $return;		
		
	}
	
	public function getBodySunCharsIncorrect($body)
	{	
		$body_mas = explode(' ', $body);
		
		if(count($body_mas) > 0)
		{
			$first = $body_mas[0];
			
			
			$char_incorrect = 0;			

			$f_count=preg_match_all("/[^а-яА-ЯёЁa-zA-Z0-9\s]/u",$first, $level_1_mas);
			
			if($f_count > 0)
			{
				$char_incorrect = 1;				
				
			}	
	
			if($char_incorrect == 1)
			{
				$body_mas[0] = '';	
				
				$body = trim(implode(' ', $body_mas));				
				
			}		

		}	
	
	
		return $body;
	}	
	
	public function findPhrase($args)
	{
		$find = false;
		
		$input_mas = $args['search'];
		
		$count_input_mas = count($input_mas);
		
		for($i = 0; $i < $count_input_mas; $i++)
		{
			$db_word = trim($input_mas[$i]);
			$db_word = $this->getBodySunCharsIncorrect($db_word);
								
			if($db_word == $args['words'])
				$find = true;	

			similar_text($db_word, $args['words'], $perc);
			
			if($perc >= $args['proc'])
				$find = true;	
			
		}

		return $find;	
	}	
	
	public function TranslitURL ($text, $translit = 'ru_en') { 
		$RU['ru'] = array( 
			'Ё', 'Ж', 'Ц', 'Ч', 'Щ', 'Ш', 'Ы',  
			'Э', 'Ю', 'Я', 'ё', 'ж', 'ц', 'ч',  
			'ш', 'щ', 'ы', 'э', 'ю', 'я', 'А',  
			'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И',  
			'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',  
			'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ъ',  
			'Ь', 'а', 'б', 'в', 'г', 'д', 'е',  
			'з', 'и', 'й', 'к', 'л', 'м', 'н',  
			'о', 'п', 'р', 'с', 'т', 'у', 'ф',  
			'х', 'ъ', 'ь', '/'
			); 

		$EN['en'] = array( 
			"Yo", "Zh",  "Cz", "Ch", "Shh","Sh", "Y'",  
			"E'", "Yu",  "Ya", "yo", "zh", "cz", "ch",  
			"sh", "shh", "y'", "e'", "yu", "ya", "A",  
			"B" , "V" ,  "G",  "D",  "E",  "Z",  "I",  
			"J",  "K",   "L",  "M",  "N",  "O",  "P",  
			"R",  "S",   "T",  "U",  "F",  "Kh",  "''", 
			"'",  "a",   "b",  "v",  "g",  "d",  "e",  
			"z",  "i",   "j",  "k",  "l",  "m",  "n",   
			"o",  "p",   "r",  "s",  "t",  "u",  "f",   
			"h",  "''",  "'",  "-"
			); 
		if($translit == 'en_ru') { 
			$t = str_replace($EN['en'], $RU['ru'], $text);         
			$t = preg_replace('/(?<=[а-яё])Ь/u', 'ь', $t); 
			$t = preg_replace('/(?<=[а-яё])Ъ/u', 'ъ', $t); 
			} 
		else {
			$t = str_replace($RU['ru'], $EN['en'], $text);
			$t = preg_replace("/[\s]+/u", "_", $t); 
			$t = preg_replace("/[^a-z0-9_\-]/iu", "", $t); 
			$t = strtolower($t);
			}
		return $t; 
	}	
	
	public function dir_size($dir) {
		$totalsize=0;
		if ($dirstream = @opendir($dir)) {
		while (false !== ($filename = readdir($dirstream))) {
		if ($filename!="." && $filename!="..")
		{
		if (is_file($dir."/".$filename))
		$totalsize+=filesize($dir."/".$filename);
		 
		if (is_dir($dir."/".$filename))
		$totalsize += $this->dir_size($dir."/".$filename);
		}
		}
		}
		closedir($dirstream);
		return $totalsize;
	}	
	
	public function genOutputSoundFile($args)
	{
		$return = array();
		$return['synthesizer_status'] = 0;		
		
		$resp_text = $args['text'];
		
		if($resp_text != "")
		{
			
			if($this->type_synthesizer != "")
			{
				$synthesizer_check = false;
				$synthesizer_name = '';
				
				foreach($this->getSynthesizerList() as $synthesizer)
				{
					if($synthesizer['name'] == $this->type_synthesizer)
					{
						$synthesizer_check = true;
						$synthesizer_name = $synthesizer['name'];
					}
					
				}
				
				if($synthesizer_check)
				{
					if($synthesizer_name == 'SpeechKit')
					{
						$return['synthesizer_status'] = 1;
						
						//Раотаем с yandex SpeechKit
						
						$yandex = $this->yandex;

						if($args['emotion'] != "")
							$emotion = $args['emotion'];
						else
							$emotion = $yandex['emotion'];//Дефолтовая эмоция персонажа	

						if($emotion == 'good' || $emotion == 'neutral' || $emotion == 'evil')
						{
							//Эти эмоции яндекс понимает
						}
						else
							$emotion = 'neutral';						

						$resp_text = urlencode($resp_text);
						
						$sound_content = file_get_contents('https://tts.voicetech.yandex.net/generate?text=' . $resp_text . '&format=' . $args['format'] . '&lang=ru-RU&speaker=' . $yandex['speaker'] . '&emotion=' . $emotion . '&speed=' . $yandex['speed'] . '&key=' . $yandex['yandex_key']);
															
						file_put_contents($args['path_output_name'] . '/' . $args['file_output_name'], $sound_content);
						
						
					}
					elseif($synthesizer_name == 'SpeechKit2')
					{
						$return['synthesizer_status'] = 1;											
						
					}
					
				}
				else
					$return['error'] = 'analisator is not correct';					

			}
			else			
				$return['error'] = 'type_synthesizer is empty';	
			
		}
		else
			$return['error'] = 'text output is empty';		
		
		return $return;
	}	
	
	public function genRespFile($args)
	{
		$return = [];
		
		if(!file_exists($this->path . '/cash')) //Для хранения долговременных транслитов
			mkdir($this->path . '/cash', 0777);
				
		if(!file_exists($this->path . '/tmp')) //Сюда складываем и потом чистим при следующем запросе
			mkdir($this->path . '/tmp', 0777);		
		
		$dir_save = $this->path . '/tmp';
		
		if($args['cash'] == 1)
			$dir_save = $this->path . '/cash';		
		
		$gen_go = false;		
		
		//Посмотрим, может для этого бреда у нас уже есть транслит.. Только для Лейн пока что
		$translit_text = $this->TranslitURL($args['resp_words']);									
		
		$file_output_name = $translit_text . '.' . $args['file_end'];
		$save_path = $dir_save . '/' . $file_output_name;		
		
		if($args['cash'] == 1)
		{
			
			//===================
			//Почистим место в соответствии с тем сколько на пользователя можно
			
				$max_size_files = $args['max_size_cash'];
			
				$size_files = $this->dir_size($dir_save);
				
				if($size_files >= $max_size_files && $max_size_files > 0)
				{
					//Удалим пару файлов		

					$sound_files = array_diff(scandir($dir_save), array('..', '.'));		
					sort($sound_files);		

					unlink($dir_save . '/' . $sound_files[0]);	
					unlink($dir_save . '/' . $sound_files[1]);						

				}
			
			
			//===================	

			if(file_exists($save_path))
			{
				//У нас есть уже ранее сохраненный файл											
				$output_file = $args['http_base_path'] . 'cash/' . $translit_text . '.' . $args['file_end'];
				
				//$fp = fopen("www.txt", 'a');
				//$trace = fwrite($fp, date('H:i:s') . ": output_file isset ))) = " . $output_file . "  \n"); 
				//fclose($fp);												
			}
			else
			{
				$gen_go = true;
				
			}			
		}			
		else
		{
			$gen_go = true;//По любому генерируем - мы во временной директории сохраним
			
			//Мы работаем с временной папкой - потрем там все..
			
			$sound_files = array_diff(scandir($dir_save), array('..', '.'));
			
			foreach($sound_files as $sound_file)
				unlink($dir_save . '/' . $sound_file);	
		}	
	

		if($gen_go)
		{
			$yandex = $this->yandex;
			
			$output_data = $this->genOutputSoundFile(array("text" => $args['resp_words'], "path_output_name" => $dir_save, "file_output_name" => $file_output_name, "emotion" => $yandex->emotion, "format" => $args['file_end']));
				
			
			if($output_data['synthesizer_status'] == 1)
			{
				if($args['cash'] == 1)									
					$output_file = $args['http_base_path'] . 'cash/' . $translit_text . '.' . $args['file_end'];
				else
					$output_file = $args['http_base_path'] . 'tmp/' . $translit_text . '.' . $args['file_end'];
		
			}
			else
				$return['error'] = 'Ошибка synthesizer';
			
			//А теперь посмотрим, если нашего вайла нет - значит недачно положили.. попросим еще раз или скажем, что ошибка
			

				
			if (file_exists($save_path)) {
				
				//Все хорошо, вернем его, у нас получилось сгенерировать
				
				
			} else {
				$output_file = $output_file = $args['http_base_path'] . 'default/error_gen_resp.wav';	
			}			
	
	
		}	
		
	
		$return['output_file'] = $output_file;
		
		return $return;
	}
	
}


		
?>
