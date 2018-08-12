<?php
include_once(realpath(__DIR__) . '/../../includes/session_inc.php');
include_once(realpath(__DIR__) . '/../../includes/time_access_inc.php');
require_once(realpath(__DIR__) . '/../../db_connect.php');

require_once(realpath(__DIR__) . '/../../user_utils.php');
require_once(realpath(__DIR__) . '/../modules_utils.php');
require_once(realpath(__DIR__) . '/registration_utils.php');

	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/../../locale/locale_data.php');//Это вообще всегда подключаем - это дефолтовый словарь - без него локаль не работает впринципе	
	require_once(realpath(__DIR__) . '/locale/locale_data.php');//Локаль базовая (слова типа "Регистрация" и т.д.)
	require_once(realpath(__DIR__) . '/../../locale/locale_utils.php');	
		
	$locale_includes = array();
	$locale_includes[] = 'registration';

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	

	//=========== locale  ================

$login = $_GET['login'];	
$password_md5 = $_GET['password_md5'];	
$hash = $_GET['hash'];	
$lng = $_GET['lng'];	

$resp_mas = array();
$resp_mas['status'] = 'none';

if($ok)
{
	if($access_time_ok)
	{		
		if($login != "" && $password_md5 != "" && $hash != "")
		{
			$login = mb_strtolower($login, 'UTF-8');//В нижний переводит	
			
			if(strlen($login) > 3)
			{		
				//Проверим корректность логина
					
				$result_count = preg_match_all("/[^A-Za-z0-9\.\-\_]/i", $login, $result_mas);
					
				if($result_count > 0)
				{
					//Присутствуют символы не из списка
					//В никнейме присутствуют запрещенные символы. Разрешены символы английского алфавита, цыфры от 0 до 9, точка, тире и нижнее подчеркивание
					$con = $locale->getLocale('username_char_error', $lng);
					
				}
				else
				{
					//Смотрим, может ужесть с таким hash
					
					if(issetUserByHash($hash))
					{
						//Пользователь с таким ключом уже есть в системе
						$con = $locale->getLocale('hash_isset', $lng);
					}
					else
					{
						if(issetUserByLogin($login))
						{
							//Пользователь с таким логином уже есть в системе
							$con = $locale->getLocale('user_isset', $lng);
						}
						else
						{
							$reserv = getLoginReservIsset($login);
							
							if($reserv)
								$con = $locale->getLocale('login_reserved', $lng);//Данный никнейм зарезервирован системой
							else
							{									
								$count_users = getCountUsers();
								
								if($count_users == 1)
									$status = 'root';//Первый пользователь - админ типа root и перебросим его после регистрации на админ панель
								else
									$status = 'user';							
								
								$add = array();
								$add['login'] = $login;
								$add['password_md5'] = $password_md5;
								$add['hash'] = $hash;
								$add['status'] = $status;
								$add['locale'] = $locale;
								$add['sid'] = $sid;
								
								$result = addNewUserByHash($add);

								if($result == "ok")
								{
									$resp_mas['status'] = 'location';
									
									$con = "http://".$_SERVER['HTTP_HOST']. $dir_project . "/" .getModuleLink(getBaseModuleByStatus($status));					

								}
								else
								{
									$con = $result;
								}									
								
							}							
							
							
							
							
						}
					

						
					}
					
					
							

				
				}	
			
				
			}
			else
				$con = $locale->getLocale('login_length', $lng);//Длина логина должна превышать три символа
			

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