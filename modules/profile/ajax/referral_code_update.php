<?php
include_once(realpath(__DIR__) . '/../../../includes/session_inc.php');
include_once(realpath(__DIR__) . '/../../../includes/time_access_inc.php');
require_once(realpath(__DIR__) . '/../../../db_connect.php');

require_once(realpath(__DIR__) . '/../../../utils.php');//Отсюда возьмем генерацию hash для добавления менеджера
require_once(realpath(__DIR__) . '/../../../user_utils.php');
require_once(realpath(__DIR__) . '/../profile_utils.php');

	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/../../../locale/locale_data.php');//Это вообще всегда подключаем - это дефолтовый словарь - без него локаль не работает впринципе	
	require_once(realpath(__DIR__) . '/../locale/locale_data.php');//Локаль базовая (слова типа "Регистрация" и т.д.)
	require_once(realpath(__DIR__) . '/../../../locale/locale_utils.php');	
		
	$locale_includes = array();
	$locale_includes[] = 'profile';

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	

	//=========== locale  ================


$lng = $_GET['lng'];	
$referral_code = $_GET['referral_code'];

$resp_mas = array();
$resp_mas['status'] = 'none';

if($ok)
{
	if($access_time_ok)
	{
		if($referral_code != "")
		{
			$user_data = getUserData($sid);
			
			$user_status = $user_data['status'];	
			$user_id = $user_data['user_id'];		
			
			if($user_id > 0)
			{
				$date = date('Y-m-d');
				
				if($user_data['referral_code_update'] == $date)
				{
					//Сегодня уже устанавливали код
					$con = $locale->getLocale('referral_code_update_error', $lng);	
				}
				else
				{
					//Может такой уже есть - не дадим несколько одинаковых ставить
					
					$referral_code_isset = getRefferalCodeIsset($user_id, $referral_code);
					
					if(!$referral_code_isset)
					{
						refferalCodeUpdate($user_id, $referral_code);
						
						$resp_mas['status'] = 'reload';
					}
					else
						$con = $locale->getLocale('referral_code_update_error_isset', $lng);	
					
					
					
					
				}				
				
				
			}
			else
				$con = $locale->getLocale('access_object_error', $lng);			
		
			
		}
		else		
			$con = $locale->getLocale('object_error', $lng);		
		
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