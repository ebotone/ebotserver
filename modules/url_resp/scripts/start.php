<?php
include_once(realpath(__DIR__) . '/../../../includes/session_inc.php');//Получание сессии
require_once(realpath(__DIR__) . '/../../../db_connect.php');//Подключение к базе

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
	$locale_includes[] = 'url_resp';//Сюда прописываем название текущего модуля (название папки в modules)

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

// Ссылку на срипт вы можете подсмотреть в админке на странице 
//http://ebot.one/all/vk_bot_group/modules/url_resp/scripts/start.php

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
	
	if($bot_type == 'vkg')//Это прописано в главном конфигурационном файле settings.php
	{
		if($group_id  == '')
			$group_id = '138913624';
		
		if($body == 'Начать' || $body == 'начать' || $body == 'Меню' || $body == 'меню' || $body == 'Menu' || $body == 'menu' || $body == '/menu' || $body == 'Start' || $body == 'start' || $body == '/start')
		{
			//Проверку на кнопку Начать имеет смысл делать только если этот внешний скрипт указан в стартовой команде. В этом случае бот будет молчать, если ему написали что-то отличное от старта и ждать пока вместо него ответит оператор сообщества.
			
			$con .= "
			
			Привет, {first_name}!

			Давай посмотрим чем я могу тебе помочь [icon|D83DDE42]
			Выбери раздел.

			Если ты не видишь кнопок - перейди по https://vk.com/im?sel=-" . $group_id . "
			(это режим диалога с сообществом) и напиши боту:

			Начать
			
			*Примечание: Кнопки поддерживаются официальным приложением Вконтакте и десктоп версией. Приложения стронних разработчиков типа Kate Mobile и т.д. могут не поддерживать кнопок.
			
			";		

			
			
		}
		
		
	}
	else
	{
		//telegram по умолчанию
		//Пример выноса текстов в локализацию (многоезыковой вариант)
		
		$con = ' [title|' . $locale->getLocale('demo_script_title', $lng) . ']';//Вернем заголовок		
		$con .= "[img_telegram|https://ebot.one/images/ebot_server_logo.png]";//Вернем картинку	
		
		$con .= $locale->getLocale('hello', $lng) . ", {first_name}! \n\n";//Привет, ИМЯ_ПОЛЬЗОВАТЕЛЯ
		
		$con .= $locale->getLocale('you_are_welcomed_by_the_system', $lng) . ": " . $ebot_server . " " . $locale->getLocale('version', $lng) . " " . $version . "\n\n";
		
		$con .= $locale->getLocale('the_text_generated_by_the_script', $lng) . ": " . $log_file . "\n\n";		
		
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
		setLogByChatId('sys', $locale->getLocale('getEditorData_error_3', $lng), $log_file);	// . $data_mas['error_con']	
	
}


echo json_encode($return_mas);

?>