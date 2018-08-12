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

$_dialog_id = $_GET['dialog_id'];
$_BOT_EDITOR_KEY = $_GET['BOT_EDITOR_KEY'];

$log_file = realpath(__FILE__);
$log_data_dir = realpath(__DIR__);

$data = json_decode(file_get_contents('php://input'));

$data_log = array();
$data_log['datatime'] = date('Y-m-d H:i:s');
$data_log['data'] = $data;

	

if($_dialog_id != "" && $_BOT_EDITOR_KEY != "")
{
	if($bot_type == 'vkg')
	{
		if($data->type != "")
		{
			setLogByChatId('sys', 'input: data type: ' . $data->type, $log_file);	
			
			$editor_call_url = $HTTP . '://' . $HTTP_HOST . '/all/s_radoid/call_vkg.php?dialog_id=' . $_dialog_id . '&BOT_EDITOR_KEY=' . $_BOT_EDITOR_KEY;//Путь к call.vkg.php на редакторе + передадим нужные переменные, которые нам вк в GET пердал
			
			$data_mas = (array) $data;
			
			$postvars_mas = array();
			$postvars_mas['data'] = json_encode($data_mas);
			
			$postvars = http_build_query($postvars_mas, '', '&');

			$ch = curl_init();	
			curl_setopt($ch, CURLOPT_URL, $editor_call_url);
			curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; CrOS x86_64 8172.45.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.64 Safari/537.36');
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
			$con = curl_exec($ch);	
			curl_close($ch);	
			
			if($data->type == 'confirmation')
			{
				echo $con;//вернем подтверждение сервера
			}
			else
			{
				if($data->type != 'message_reply')
				{
					$editor_data = json_decode($con, true);
					
					$data_log['editor_data'] = $editor_data;
					
					$e_body = $editor_data['body'];
					$e_user_id = $editor_data['user_id'];
					$e_dialog_id = $editor_data['dialog_id'];
					$e_md5_BOT_EDITOR_KEY = $editor_data['md5_BOT_EDITOR_KEY'];	
					
					if($e_body != "" && $e_user_id != "" && $e_dialog_id != "" && $e_md5_BOT_EDITOR_KEY != "")
					{
						if($e_md5_BOT_EDITOR_KEY == $key_md5)
						{		
							if($group_token != "")
							{
								ob_start();
								
									setLogByChatId('sys', 'output editor: data OK', $log_file);	
									
									require_once(realpath(__DIR__) . "/../../../libs/phpQuery/phpQuery/phpQuery.php");	

									require_once(realpath(__DIR__) . '/proxy_dialog_vkg_resp.php');	

									$data_mas = array();
									$data_mas['body'] = $e_body;
									$data_mas['user_id'] = $e_user_id;
									$data_mas['token'] = $group_token;
									$data_mas['dialog_id'] = $e_dialog_id;
									$data_mas['icons_url'] = $HTTP . '://' . $HTTP_HOST . '/all/s_radoid/dialogs/images/icons/vk_icons.php';								

									$vk_result = go_resp_speaker($data_mas);

									if($vk_result['error']['error_msg'] != '')
									{
										$vkg_response = 'error_code: ' . $vk_result['error']['error_code'] . ' error_msg: ' . $vk_result['error']['error_msg'];						
										setLogByChatId('sys', 'output vk error: ', $vkg_response);	
									}
																

								ob_end_clean();		

							}
							else
								setLogByChatId('sys', 'output editor: group_token error', $log_file);			
						}
						else
							setLogByChatId('sys', 'output editor: md5_BOT_EDITOR_KEY error', $log_file);

					}						
					
				}			
				
				echo 'ok';
				break;				

			}	

				
			
		}
		else
		{
			setLogByChatId('sys', 'data type is empty', $log_file);	
			
		}
		
	}
	else
		setLogByChatId('sys', 'var bot_type in settings is undefined', $log_file);	
	

}
else
{
	setLogByChatId('sys', 'input: data empty', $log_file);	
	
}

if($log_data_to_file)//Переменная определена для этого модуля в конфигурационном файле settings.php (этого модуля)
	setLogDataToFile($data_log, $log_data_dir . '/../');

?>