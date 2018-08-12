<?php
include_once(realpath(__DIR__) . '/../../../includes/session_inc.php');//Получание сессии
require_once(realpath(__DIR__) . '/../../../db_connect.php');//Подключение к базе

	//ini_set('error_reporting', E_ALL);
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);

require_once(realpath(__DIR__) . '/../../../user_utils.php');//Функции пользователей
require_once(realpath(__DIR__) . '/../../../data_utils.php');//Получение данных с редактора и логирование системой
require_once(realpath(__DIR__) . '/../../../settings.php');//Настройки
require_once(realpath(__DIR__) . '/../../../mysql_utils.php');//Добавление в базу
	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/../../../locale/locale_data.php');//Это вообще всегда подключаем - это дефолтовый словарь - без него локаль не работает впринципе	
	require_once(realpath(__DIR__) . '/../locale/locale_data.php');//Локаль текущего скрипта (слова которе используются при выводе пользователю бота и т.д.)
	require_once(realpath(__DIR__) . '/../../../locale/locale_utils.php');	
		
	$locale_includes = array();
	$locale_includes[] = 'questions';//Сюда прописываем название текущего модуля

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	

	//=========== locale  ================	
		
	require_once(realpath(__DIR__) . '/../../../mysql_utils.php');//Добавление в базу
	
	require_once(realpath(__DIR__) . '/../settings.php');
	require_once(realpath(__DIR__) . '/../questions_utils.php');
	require_once(realpath(__DIR__) . '/../questions_act_utils.php');

$data_mas = getEditorData($_GET, $_POST);//Получаем данные от редактора. Если в настройках бота в редакторе проставлен метод получения данных GET то для корректного получения данных потребуется в файле settings.php прописать значения полей key_md5 и admin_user_id

$HTTP_HOST = $data_mas['HTTP_HOST']; //Хост редактора. На момент написания этого демо скрипта это ebot.one
$chat_id = $data_mas['user_id'];//ID пользователя в телеграме
$body = $data_mas['body'];//Текст полученный ботом от пользователя
$username = $data_mas['username'];
$first_name = $data_mas['first_name'];
$last_name = $data_mas['last_name'];
$phone_number = $data_mas['phone_number'];
$language_code = $data_mas['language_code'];

$group_id = $_GET['group_id'];

// http://r911236z.bget.ru/all/ebot_server/modules/questions/scripts/group1_start.php

$return_mas = array();
$return_mas['status'] = 0;

$log_file = realpath(__FILE__);

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

	//=================================================================
	//Тут тело скрипта
	
	if($group_id > 0)
	{
		$session_questions_isset = getIssetSessionQuestion($group_id, $chat_id);
		
		if($session_questions_isset)
		{
			//Сессия уже открыта
			//Значит мы сейчас должны получить ответ. Если ответа нет - пеерспросим
			
			if($body != '')
			{
				//Ответ есть - запишем и следующий вопрос активируем
				
				setResponseToQuestion($group_id, $chat_id, $body);
				
				$question_data = getQuestionAct($group_id, $chat_id, 'next');			
				$act = $question_data['act'];
				$name = $question_data['name'];
				
				if($act == 'close')
				{
	
					//Покажем все данные и 2 кнопки
					//изменить и далее
					
					$group_data = getGroupQuestionDataById($group_id);
					
					$php_end = $group_data['php_end'];					
					
					if($php_end == '')
						$php_end = 'index.php';
					
					require_once(realpath(__DIR__) . '/../exit_script/' . $php_end);
					
					$data = array();
					$data['group_id'] = $group_id; 
					$data['chat_id'] = $chat_id; 
					$data['locale'] = $locale; 
					$data['list'] = getQuestionsResultList($group_id, $chat_id); 
					
					$close_text = exit_script_fnc($data);			
					
					$name = $close_text;						
					
				}			
				
				$con = $name;	
				
			}
			else
			{
				//Ответа нет - переспросим
				
				$question_data = getQuestionAct($group_id, $chat_id, '');
				$name = $question_data['name'];
				$con = $locale->getLocale('Response_is_empty', $lng) . " " . $name;				
				
			}
		}
		else
		{
			//Сессия еще не открыта. Не важно что нам прислали в теле body - нужно открывать сессию и задавать первый вопрос
			
			$question_data = getQuestionAct($group_id, $chat_id, 'next');
			$name = $question_data['name'];
			$con = $name;		
			
		}	
	}
	else
		$con .= $locale->getLocale('group_id_error', $lng);//group_id не получен
	
	
	
	//=================================================================
	
	$return_mas['body'] = $con;
	
	setLogByChatId($chat_id, 'input: ' . $body, $log_file);	
	setLogByChatId($chat_id, 'outnput: ' . $con, $log_file);
	
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