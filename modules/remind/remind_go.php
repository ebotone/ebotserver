<?php
include_once(realpath(__DIR__) . '/../../includes/session_inc.php');
include_once(realpath(__DIR__) . '/../../includes/time_access_inc.php');
require_once(realpath(__DIR__) . '/../../db_connect.php');

require_once(realpath(__DIR__) . '/../../user_utils.php');
require_once(realpath(__DIR__) . '/../modules_utils.php');

	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/../../locale/locale_data.php');//Это вообще всегда подключаем - это дефолтовый словарь - без него локаль не работает впринципе	
	require_once(realpath(__DIR__) . '/locale/locale_data.php');//Локаль базовая (слова типа "Регистрация" и т.д.)
	require_once(realpath(__DIR__) . '/../../locale/locale_utils.php');	
		
	$locale_includes = array();
	$locale_includes[] = 'remind';

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	

	//=========== locale  ================

$password_md5 = $_GET['password_md5'];	
$code = $_GET['code'];	
$lng = $_GET['lng'];	

$resp_mas = array();
$resp_mas['status'] = 'none';

if($ok)
{
	if($access_time_ok)
	{		
		if($password_md5 != "" && $code != "")
		{
			$update = updatePassword($password_md5, $code);
			
			$resp_mas['status'] = 'reload';

		}
		else
			$con = $locale->getLocale('fields_need', $lng);//Заполните поля
		
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