<?php
include_once(realpath(__DIR__) . '/../includes/session_inc.php');
include_once(realpath(__DIR__) . '/../includes/time_access_inc.php');
require_once(realpath(__DIR__) . '/../db_connect.php');
require_once(realpath(__DIR__) . '/../login/login_utils.php');
require_once(realpath(__DIR__) . '/../user_utils.php');

	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/locale_data.php');//Это вообще всегда подключаем - это дефолтовый словарь - без него локаль не работает впринципе	
	require_once(realpath(__DIR__) . '/locale_utils.php');	
		
	$locale_includes = array();

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	

	//=========== locale  ================

$lng = $_GET['lng'];

$resp_mas = array();
$resp_mas['status'] = 'error';

if($ok)
{
	if($access_time_ok)
	{		
		$user_data = getUserData($sid);

		$user_id = $user_data['user_id'];	

		if($user_id > 0)
			set_lng($user_id, $lng);
		
		$_SESSION['lng'] = $lng;
		
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