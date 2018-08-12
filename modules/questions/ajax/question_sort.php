<?php
include_once(realpath(__DIR__) . '/../../../includes/session_inc.php');
include_once(realpath(__DIR__) . '/../../../includes/time_access_inc.php');
require_once(realpath(__DIR__) . '/../../../db_connect.php');

require_once(realpath(__DIR__) . '/../settings.php');
require_once(realpath(__DIR__) . '/../../../user_utils.php');
require_once(realpath(__DIR__) . '/../../modules_utils.php');
require_once(realpath(__DIR__) . '/../../../mysql_utils.php');//Добавление в базу

require_once(realpath(__DIR__) . '/../questions_utils.php');

	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/../../../locale/locale_data.php');//Это вообще всегда подключаем - это дефолтовый словарь - без него локаль не работает впринципе	
	require_once(realpath(__DIR__) . '/../locale/locale_data.php');//Локаль базовая (слова типа "Регистрация" и т.д.)
	require_once(realpath(__DIR__) . '/../../../locale/locale_utils.php');	
		
	$locale_includes = array();
	$locale_includes[] = 'questions';

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	

	//=========== locale  ================


$lng = $_GET['lng'];	
$sort_data_str = $_GET['sort_data_str'];// 6_0@3_1@2_2@7_3@1_4@

$resp_mas = array();
$resp_mas['status'] = 'none';

if($ok)
{
	if($access_time_ok)
	{		
		$user_data = getUserData($sid);
		
		$user_status = $user_data['status'];	
		$user_id = $user_data['user_id'];	
		
		$access = false;		
		
		if($user_status == "root" || $user_status == "admin")
			$access = true;
		
		if($access && $sort_data_str != "")
		{
			elsSort($sort_data_str);
			
			$resp_mas['status'] = 'reload';	
			
			$con = $locale->getLocale('Saved', $lng);	
			
		}
		
	}
	else
		$con = $locale->getLocale('access_time_error', $lng);
	
	$__session = $_SESSION;
	session_write_close();	
	
	
}
else
	$con = $locale->getLocale('db_connect_error', $lng);

$resp_mas['con'] = $con;
echo json_encode($resp_mas);



?>

	