<?php
include_once(realpath(__DIR__) . '/../../../includes/session_inc.php');
include_once(realpath(__DIR__) . '/../../../includes/time_access_inc.php');
require_once(realpath(__DIR__) . '/../../../db_connect.php');

require_once(realpath(__DIR__) . '/../../../user_utils.php');
require_once(realpath(__DIR__) . '/../../modules_utils.php');
require_once(realpath(__DIR__) . '/../../../settings.php');
require_once(realpath(__DIR__) . '/../settings.php');
require_once(realpath(__DIR__) . '/../../../mysql_utils.php');//Добавление в базу

	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/../../../locale/locale_data.php');//Это вообще всегда подключаем - это дефолтовый словарь - без него локаль не работает впринципе	
	require_once(realpath(__DIR__) . '/../locale/locale_data.php');//Локаль базовая (слова типа "Регистрация" и т.д.)
	require_once(realpath(__DIR__) . '/../../../locale/locale_utils.php');	
		
	$locale_includes = array();
	$locale_includes[] = 'main';

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	

	//=========== locale  ================

$lng = $_GET['lng'];	

$resp_mas = array();
$resp_mas['status'] = 'none';

	//ini_set('error_reporting', E_ALL);
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);

if($ok)
{	
	
	$insert_data_mas = array();	
	
	$insert_data_mas[] = addData("username", $admin_login);
	$insert_data_mas[] = addData("nikname", $admin_login);
	$insert_data_mas[] = addData("password", md5($admin_password));
	$insert_data_mas[] = addData("status", 'root');
	$insert_data_mas[] = addData("datetime", 'now()');
	
	$query_insert = getInsert($name_table_users, $insert_data_mas);		

	$text->my_sql_query = $query_insert;
	$text->my_sql_execute();		

	//===================================================

	sleep(1);
	
	$resp_mas['status'] = 'reload';		

	
	$__session = $_SESSION;
	session_write_close();	
	
	
}
else
	$con = $locale->getLocale('db_connect_error', $lng);

$resp_mas['con'] = $con;
echo json_encode($resp_mas);



?>