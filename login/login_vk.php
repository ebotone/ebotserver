<?php
include_once(realpath(__DIR__) . '/../includes/session_inc.php');
include_once(realpath(__DIR__) . '/../includes/time_access_inc.php');
require_once(realpath(__DIR__) . '/../db_connect.php');
require_once(realpath(__DIR__) . '/../login/login_utils.php');
require_once(realpath(__DIR__) . '/../user_utils.php');
require_once(realpath(__DIR__) . '/../modules/modules_utils.php');

require_once(realpath(__DIR__) . '/../mysql_utils.php');//Добавление в базу (для таблицы сессий)
require_once(realpath(__DIR__) . '/../modules/registration/registration_utils.php');

	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/../locale/locale_data.php');//Это вообще всегда подключаем - это дефолтовый словарь - без него локаль не работает впринципе	
	require_once(realpath(__DIR__) . '/../locale/locale_utils.php');	
		
	$locale_includes = array();

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	

	//=========== locale  ================
	


	//ini_set('error_reporting', E_ALL);
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);


$expire = $_POST['expire'];	

if($ok)
{
	if($access_time_ok)
	{
			
		$user_data = getUserData($sid);
		$user_id = $user_data['user_id'];
		
		if(!($user_id > 0))
		{
			$member = authOpenAPIMember(); 
			
			if($member !== FALSE) { 
			  //echo "Пользователь авторизован в Open API";
			  
			  //Сохраним в базу
			  
				if($ok && $expire !='')
				{
					//Регимся в системе
					$vk_id = $member['id'];
					
					if($vk_id > 0)
					{
						//Если нет такого - добавляем и авторизуемся
						//Если есть - просто авторизуемся, если еще не авторизованы пож этой сессией
						
						login_vk($vk_id, $sid);
						
						$con = 'reload';					
						
						
					}
					
				
							
							
				}   
			  
			  
			} else { 
			  //echo "Пользователь не авторизован в Open API";
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

echo $con;


?>