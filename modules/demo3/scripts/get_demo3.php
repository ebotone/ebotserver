<?php
include_once(realpath(__DIR__) . '/../../../includes/session_inc.php');//Получание сессии
require_once(realpath(__DIR__) . '/../../../db_connect.php');//Подключение к базе

require_once(realpath(__DIR__) . '/../../../sys/sys_audio.php');//Подключение к базе

	//ini_set('error_reporting', E_ALL);
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);

require_once(realpath(__DIR__) . '/../../../user_utils.php');//Функции пользователей
require_once(realpath(__DIR__) . '/../../../data_utils.php');//Получение данных с редактора и логирование системой
require_once(realpath(__DIR__) . '/../../../settings.php');//Настройки

	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/../../../locale/locale_data.php');//Это вообще всегда подключаем - это дефолтовый словарь - без него локаль не работает впринципе	
	require_once(realpath(__DIR__) . '/../locale/locale_data.php');//Локаль текущего скрипта (слова которе используются при выводе пользователю бота и т.д.)
	require_once(realpath(__DIR__) . '/../../../locale/locale_utils.php');	
		
	$locale_includes = array();
	$locale_includes[] = 'demo3';//Сюда прописываем название текущего модуля (название папки в modules)

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	

	//=========== locale  ================	

	require_once(realpath(__DIR__) . '/../settings.php');//Настройки (локальные, для этого модуля)		


$data_mas = getEditorData($_GET, $_POST);//Получаем данные от редактора. Если в настройках бота в редакторе проставлен метод получения данных GET то для корректного получения данных потребуется в файле settings.php прописать значения полей key_md5 и admin_user_id

$HTTP_HOST = $data_mas['HTTP_HOST']; //Хост редактора. На момент написания этого демо скрипта это ebot.one
$chat_id = $data_mas['user_id'];//ID пользователя в телеграме
$body = $data_mas['body'];//Текст полученный ботом от пользователя
$username = $data_mas['username'];
$first_name = $data_mas['first_name'];
$last_name = $data_mas['last_name'];
$phone_number = $data_mas['phone_number'];
$language_code = $data_mas['language_code'];

// Ссылку на срипт вы можете подсмотреть в админке на странице Демо

$return_mas = array();
$return_mas['status'] = 0;

$log_file = realpath(__FILE__);
$log_data_dir = realpath(__DIR__);

if($chat_id > 0)
{
	$return_mas['status'] = 1;	
			
	$user_data = array();
	$user_data['user_id'] = $chat_id;
	$user_data['username'] = $username;
	$user_data['first_name'] = $first_name;
	$user_data['last_name'] = $last_name;
	$user_data['phone_number'] = $phone_number;
	$user_data['language_code'] = $language_code;	
	$user_data['user_name'] = $user_name;
	
	userUpdate($user_data);//Создаст пользователя с chat_id если такого нет в системе
	
	//Смотрим язык в таблице пользователей (устанавливать в нее через функцию set_lng, подключив файл locale/locale_utils.php (тут он уже подключен, см. выше). Если язык не определен - getLngByUser вернет деволтовый lng_default, который указан в главном settings.php)
	$lng = getLngByUser($chat_id);
	
	$con = '';
	
	if($bot_type == 'vkg')
	{
		$con .= '[icon|D83DDE42][icon|D83DDE42][icon|D83DDE42]';
	}
	else
	{
		//telegram по умолчанию
		
		$con = ' [title|' . $locale->getLocale('demo_script_title', $lng) . ']';//Вернем заголовок
		
		$con .= "[img_telegram|https://ebot.one/images/ebot_server_logo.png]";//Вернем картинку		
	}
	
	$con .= $locale->getLocale('hello', $lng) . ", {first_name}! \n\n";//Привет, ИМЯ_ПОЛЬЗОВАТЕЛЯ
		
	$con .= $locale->getLocale('demo_script_notice', $lng);//Вернем текст
		
	$args = [];
	$args['bot_api_key'] = $bot_api_key;
	$args['chat_id'] = $chat_id;
	$args['path'] = __DIR__;
	$args['dir'] = '';//Если не указывать этот параметр, то создастся директория в соответствии с mime_type файла. Например, audio
	$args['subdir'] = '';//Если не указывать этот параметр - файл положится в директорию, одноименную с chat_id пользователя, приславшего файл. Например, в audio/379422534/
	$args['file_name'] = 'input';
	$args['enter_data'] = json_decode($data_mas['enter_data_json'], true);
	
	$audio_ex = new ebotAudio($args);	
	$file_data = $audio_ex->fileSave();	
		
	$type_object = $file_data['type_object'];
	$file_id = $file_data['file_id'];
	$mime_type = $file_data['mime_type'];
	$file_name = $file_data['file_name'];
	$file_save_path = $file_data['file_save_path'];
	
	if($type_object == "")
		$con .= "\n\nФайл не прикреплен.";
	else
		$con .= "\n\nФайл прикреплен.";
	
	$con .= "\n\n";
	$con .= '[b]type_object[/b]=' . $type_object . "\n";
	$con .= '[b]file_id[/b]=' . $file_id . "\n";
	$con .= '[b]mime_type[/b]=' . $mime_type . "\n";
	$con .= '[b]file_name[/b]=' . $file_name . "\n";
	$con .= '[b]file_save_path[/b]=' . $file_save_path . "\n";
	
	$args = [];
	$args['type_analisator'] = 'voise_lib';
	$args['type_synthesizer'] = 'SpeechKit';
	
		$yandex_data = array();
		$yandex_data['yandex_key'] = $yandex_key;//Yandex SpeechKit KEY
		$yandex_data['speaker'] = 'alyss';
		$yandex_data['emotion'] = 'good';
		$yandex_data['speed'] = '1.1';
	 
	$args['yandex']	= $yandex_data;
		
	$audio_ex->audioParserSettings($args);//Установим настройки для работы с распознаванием и синтезом речи
	
	$args = [];
	$args['file_path'] = $file_save_path;//Путь к файлу. 
	$args['count'] = 1;//Сколько вернуть результатов. Число или all
		
	$analisator_resp = $audio_ex->wordsParser($args);
	
	if($analisator_resp['analisator_status'] == 1)
	{
		//Анализатор определен и отработал - смотрим что нашел:
		
		$word = $analisator_resp['words'];
		
		$con .= '[b]word[/b]=' . $word . "\n";
		
		if($word != "")
		{
			require_once(realpath(__DIR__) . '/gen_resp.php');//Настройки (локальные, для этого модуля)	
			
			$resp_words = genResp($word);//Собственно функция обработчик. Тут мы определим что ответить
			
			if($resp_words['resp'] != "")
			{
				//Генерируем ответ
				
				$con .= '[b]resp_words[/b]=' . $resp_words['resp'] . "\n";
			
				$SCRIPT_NAME_mas = explode('/', $_SERVER['SCRIPT_NAME']);				
				$SCRIPT_NAME_mas[count($SCRIPT_NAME_mas) - 1] = '';				
				$SCRIPT_path = implode('/', $SCRIPT_NAME_mas);
				
				$args = [];
				$args['resp_words'] = $resp_words['resp'];
				$args['http_base_path'] = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $SCRIPT_path;   //http://xn--80addj8aakhjc.xn--p1ai/all/kvest/modules/demo3/scripts/;
				$args['file_end'] = 'mp3';
				$args['cash'] = $resp_words['cash'];//Сохранять ли результаты
				$args['max_size_cash'] = 500*1000;//Максимальный размер кеша в байтах. 500*1000 - 500 байт
								
				$http_file_resp = $audio_ex->genRespFile($args);
				
				if($http_file_resp['output_file'] != "")
				{
					$con .= '[b]http_file_resp[/b]=' . $http_file_resp['output_file'] . "\n";
					
					$con .= ' [audio_telegram|' . $http_file_resp['output_file'] . ']';
				}
				
				
				
			}
			
		}
		
		
		
		
	}
	else
	{
		$con .= "Ошибка анализатора\n";

	}		
	
	$return_mas['body'] = $con;
	
	setLogByChatId($chat_id, 'input: ' . $body, $log_file);	
	setLogByChatId($chat_id, 'outnput: ' . $con, $log_file);	
	
$data_log = array();
$data_log['datatime'] = date('Y-m-d H:i:s');
$data_log['data_mas'] = $data_mas;	
	
	if($log_data_to_file)//Переменная определена для этого модуля в конфигурационном файле settings.php (этого модуля)
		$path = setLogDataToFile($data_log, $log_data_dir . '/../');


}
else
{
	if($data_mas['error'] == 1)
		setLogByChatId('sys', $locale->getLocale('getEditorData_error_1', $lng), $log_file);	
	
	if($data_mas['error'] == 2)
		setLogByChatId('sys', $locale->getLocale('getEditorData_error_2', $lng), $log_file);	

	if($data_mas['error'] == 3)
		setLogByChatId('sys', $locale->getLocale('getEditorData_error_3', $lng), $log_file);
	
}

/*

Array
(
    [HTTP_HOST] => ebot.one
    [bot_id] => 5312
    [user_id] => 279422532
    [body] => get_info
    [username] => 
    [first_name] => 
    [last_name] => 
    [phone_number] => 
    [language_code] => 
    [enter_data] => Array
    [enter_data_json] => {"type_private":"private","start_data":"","message_id":"64","language_code":"ru-RU","type_object":"document","file_info":{"message_id":"64","from":{"id":"279422532","is_bot":"0","first_name":"include","last_name":"encode","username":"include_encode","language_code":"ru-RU"},"chat":{"id":"279422532","first_name":"include","last_name":"encode","username":"include_encode","type":"private"},"date":"1536321613","document":{"file_name":"what_time.wav","mime_type":"audio\/x-wav","file_id":"BQADAgADWAIAApnukEiD-Om3DoB5uQI","file_size":"376876"},"raw_data":{"message_id":"64","from":{"id":"279422532","is_bot":"0","first_name":"include","last_name":"encode","username":"include_encode","language_code":"ru-RU"},"chat":{"id":"279422532","first_name":"include","last_name":"encode","username":"include_encode","type":"private"},"date":"1536321613","document":{"file_name":"what_time.wav","mime_type":"audio\/x-wav","file_id":"BQADAgADWAIAApnukEiD-Om3DoB5uQI","file_size":"376876"}},"bot_name":"orderto_bot"}}
    [command_id] => 28711
    [value_last_comand_button] => 
    [sys] => 2
    [method] => post
)

Array
(
    [type_private] => private
    [start_data] => 
    [message_id] => 67
    [language_code] => ru-RU
    [type_object] => document
    [file_info] => Array
        (
            [message_id] => 67
            [from] => Array
                (
                    [id] => 279422532
                    [is_bot] => 0
                    [first_name] => include
                    [last_name] => encode
                    [username] => include_encode
                    [language_code] => ru-RU
                )

            [chat] => Array
                (
                    [id] => 279422532
                    [first_name] => include
                    [last_name] => encode
                    [username] => include_encode
                    [type] => private
                )

            [date] => 1536322812
            [document] => Array
                (
                    [file_name] => what_time.wav
                    [mime_type] => audio/x-wav
                    [file_id] => BQADAgADYgIAApnukEhnt_NWrX2CEgI
                    [file_size] => 376876
                )

            [raw_data] => Array
                (
                    [message_id] => 67
                    [from] => Array
                        (
                            [id] => 279422532
                            [is_bot] => 0
                            [first_name] => include
                            [last_name] => encode
                            [username] => include_encode
                            [language_code] => ru-RU
                        )

                    [chat] => Array
                        (
                            [id] => 279422532
                            [first_name] => include
                            [last_name] => encode
                            [username] => include_encode
                            [type] => private
                        )

                    [date] => 1536322812
                    [document] => Array
                        (
                            [file_name] => what_time.wav
                            [mime_type] => audio/x-wav
                            [file_id] => BQADAgADYgIAApnukEhnt_NWrX2CEgI
                            [file_size] => 376876
                        )

                )

            [bot_name] => orderto_bot
        )

)


*/



echo json_encode($return_mas);

?>