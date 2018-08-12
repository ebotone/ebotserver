<?php
include_once(realpath(__DIR__) . '/../../../includes/session_inc.php');//Получание сессии
require_once(realpath(__DIR__) . '/../../../db_connect.php');//Подключение к базе

	//ini_set('error_reporting', E_ALL);
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);

require_once(realpath(__DIR__) . '/../../../user_utils.php');//Функции пользователей
require_once(realpath(__DIR__) . '/../../../data_utils.php');//Получение данных с редактора и логирование системой
require_once(realpath(__DIR__) . '/../../../settings.php');//Настройки

	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/../../../locale/locale_data.php');//Это вообще всегда подключаем - это дефолтовый словарь - без него локаль не работает впринципе	
	require_once(realpath(__DIR__) . '/../locale/locale_data.php');//Локаль текущего скрипта (слова которе используются при выводе пользователю бота и т.д.)
	require_once(realpath(__DIR__) . '/../../../locale/locale_utils.php');	
		
	$locale_includes = array();
	$locale_includes[] = 'proxy';//Сюда прописываем название текущего модуля (название папки в modules)

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	

	//=========== locale  ================	

	require_once(realpath(__DIR__) . '/../settings.php');//Настройки (локальные, для этого модуля)	

$_dialog_id = $_GET['dialog_id'];//В GET параметрах curl
$_key_md5 = $_GET['key_md5'];//В GET параметрах curl


$to_user_id = $_POST['to_user_id'];
$group_token_md5 = $_POST['group_token_md5'];
$sends_mas = json_decode($_POST['sends_mas'], true);

$count_sends_mas = count($sends_mas);

$return_mas = array();
$return_mas['status'] = 0;	

if($_dialog_id != "" && $_key_md5 != "")
{
	if($bot_type == 'vkg')
	{			
		if($_key_md5 == $key_md5)
		{
			if($_dialog_id == $bot_id)
			{
				if($group_token != "" && md5($group_token) == $group_token_md5)
				{
					$return_mas['status'] = 1;
					
					require_once(realpath(__DIR__) . "/../../../libs/phpQuery/phpQuery/phpQuery.php");	

					require_once(realpath(__DIR__) . '/proxy_dialog_vkg_resp.php');	
					
							$vk_result = array();
							
								$send_mas = array();
							
							for($k = 0; $k < $count_sends_mas; $k++)
							{	
								$notice = urldecode($sends_mas[$k]['text']);
								
								//$notice = iconv('utf-8', 'cp1251', $notice);//кодируем из Рѕ_РЅР°СЃ в 	
								
								$data_mas = array();
								$data_mas['body'] = $notice;
								$data_mas['user_id'] = $to_user_id;
								$data_mas['token'] = $group_token;
								$data_mas['dialog_id'] = $bot_id;	
								$data_mas['icons_url'] = $HTTP . '://' . $HTTP_HOST . '/all/s_radoid/dialogs/images/icons/vk_icons.php';
								
								$send_mas[] = $data_mas;
								$vk_result[] = go_resp_speaker($data_mas);

							}					
							
							$return_mas['vk_result'] = $vk_result;						
							$return_mas['send_mas'] = $send_mas;
				}
				else
					$return_mas['error'] = 'group_token is not correct';			
			
				
			}
			else
				$return_mas['error'] = 'bot_id is not correct';

		}
		else
			$return_mas['error'] = 'BOT_EDITOR_KEY is not correct';

		
	}
	else
		$return_mas['error'] = 'var bot_type in settings is undefined';	

}
else
{
	$return_mas['error'] = 'data empty';
	
}

echo json_encode($return_mas);

?>