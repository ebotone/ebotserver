<?php
include_once(realpath(__DIR__) . '/../includes/session_inc.php');
include_once(realpath(__DIR__) . '/../includes/time_access_inc.php');
require_once(realpath(__DIR__) . '/../db_connect.php');
require_once(realpath(__DIR__) . '/../login/login_utils.php');
require_once(realpath(__DIR__) . '/../modules/modules_utils.php');
require_once(realpath(__DIR__) . '/settings.php');

require_once(realpath(__DIR__) . '/../mysql_utils.php');//Добавление в базу (для таблицы сессий)

	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/../locale/locale_data.php');//Это вообще всегда подключаем - это дефолтовый словарь - без него локаль не работает впринципе	
	require_once(realpath(__DIR__) . '/../locale/locale_utils.php');	
		
	$locale_includes = array();

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	

	//=========== locale  ================

$hash = $_GET['hash'];
$password_md5 = $_GET['password_md5'];

$resp_mas = array();
$resp_mas['status'] = 'error';

if($ok)
{
	if($access_time_ok)
	{		
		if($hash != "" && $password_md5 != "")
		{
			//=======================
			
				//Если логин и пароль не пусты и совпадают с админским в файле - то не важно что в базе - получим и зарегим админа
				//это на случай если чел поменял пароль в админке и забыл
				
				if($admin_login_new != "" && $admin_password_new != "")
				{
					if($hash == $admin_login_new && $password_md5 == md5($admin_password_new))
					{
						$data_root = getDataRoot();
						
						$hash = $data_root['login'];
						$password_md5 = $data_root['password'];
						
						
					}
					
				}
			
			//=======================
			
			$status = login($hash, $password_md5, $sid);

			if($status != "")
			{
				$resp_mas['status'] = 'location';
				
				$con = "http://".$_SERVER['HTTP_HOST']. $dir_project . "/" .getModuleLink(getBaseModuleByStatus($status));					

			}
			else
			{
				$con = $locale->getLocale('login_error', $lng);
			}
		
			
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