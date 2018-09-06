<?php
include_once(realpath(__DIR__) . '/../../../includes/session_inc.php');
include_once(realpath(__DIR__) . '/../../../includes/time_access_inc.php');
require_once(realpath(__DIR__) . '/../../../db_connect.php');

require_once(realpath(__DIR__) . '/../../../user_utils.php');
require_once(realpath(__DIR__) . '/../../modules_utils.php');
require_once(realpath(__DIR__) . '/../../../settings.php');

//Настройки модулей:
require_once(realpath(__DIR__) . '/../../../modules/questions/settings.php');

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
	if($access_time_ok)
	{		
		//===================================================
		
		$query_create_table_users = implode("",file("../sql/query_create_table_users.sql"));
		
		$query_create_table_users = str_replace("@@name_table_users@@", $name_table_users, $query_create_table_users);
		$query_create_table_users = str_replace("@@name_table_logs@@", $name_table_logs, $query_create_table_users);
		
		$query_create_table_users = str_replace("@@name_table_questions@@", $name_table_questions, $query_create_table_users);
		$query_create_table_users = str_replace("@@name_table_group_questions@@", $name_table_group_questions, $query_create_table_users);
		$query_create_table_users = str_replace("@@name_table_act_questions@@", $name_table_act_questions, $query_create_table_users);
		
		$query_create_table_users = str_replace("@@name_table_sessions@@", $name_table_sessions, $query_create_table_users);

		$queries = explode (";", $query_create_table_users); 
		foreach ($queries as $q) { 
		
			$text->my_sql_query = $q;
			$text->my_sql_execute();	
		} 		

		sleep(1);		

		
		$resp_mas['status'] = 'reload';
		
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