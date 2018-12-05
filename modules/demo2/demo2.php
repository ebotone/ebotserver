<?php

require_once(realpath(__DIR__) . '/settings.php');
require_once(realpath(__DIR__) . '/../../data_utils.php');

function getContent($data)
{
	global $text, $module, $log_file_display, $bot_id, $HTTP, $HTTP_HOST, $key_md5, $admin_user_id, $admin_chat_id, $log_data_to_file, $log_data_file_path, $log_data_file_name;
	
	$locale = $data['locale'];
	$user_data = $data['user_data'];
	$lng = $data['lng'];
	
	$con = '';
	
	$user_id = $user_data['user_id'];
	$user_status = $user_data['status'];
	
	$main_link = getModuleLink('main');
	
	$last_entry_count = 10;
	$script_path = realpath(__DIR__) . '/scripts/get_demo2.php';
	
	$con .= '

		<style>
			
			@media all and (min-width: 766px) and (max-width: 1199px) {

				.jumbotron{margin-top:50px}
			
			}

			@media all and (min-width: 1200)  {

				.jumbotron{margin-top:10px}
			

			}	
			
			.data_class{color:#808080}
			.last_entry{margin:0px 0px 5px 0px; border-top:1px solid #c0c0c0; padding-top:5px}
			.http_link_to_script{margin:0px 0px 5px 0px; border-bottom:1px solid #c0c0c0; padding-bottom:5px; }
			.log_file{color:#0000ff}
			.count_log_data{color:#0000ff}
			.log_data_from_file{margin:0px 0px 5px 0px; border-top:1px solid #c0c0c0; padding-top:5px}
			
		</style>
	
		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
		  <div class="container" style="padding-top:20px">';
		  
		  //========================================================
		  //Проверка на подключение рассылочных механимов
		  
			$settings_mas = getBotSettings();
		  
			if($settings_mas['bot_id'] > 0)
			{
				if($settings_mas['dispatch']  == 1)
				{
					$con .= '<div class="alert alert-success"><b>' .  $locale->getLocale('dispatch', $lng) . '</b> - ' .  $locale->getLocale('on', $lng) . '</div>';	
					
				}
				else
					$con .= '<div class="alert alert-danger"><b>' .  $locale->getLocale('dispatch', $lng) . '</b> - ' .  $locale->getLocale('off', $lng) . ' ' .  $locale->getLocale('services_link', $lng) . '</div>';	
				
			}
			else
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define_vars', $lng) . ':</div>';	
	  
		  //========================================================
		
			if($bot_id == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>bot_id</b></div>';		
		
			if($key_md5 == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>key_md5</b></div>';
			
			if($bot_api_key == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>bot_api_key</b></div>';	
			
			if($admin_user_id == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>admin_user_id</b></div>';

			if($HTTP == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>HTTP</b></div>';				
			
			if($HTTP_HOST == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>HTTP_HOST</b></div>';	
			
			if($admin_chat_id == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>admin_chat_id (Для тестов)</b></div>';					
		
		
		$con .= '<div class="http_link_to_script"><b>' . $locale->getLocale('http_link_to_script', $lng) . "</b>: <span style='color:#0000ff'>http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) . '/modules/' . $module . '/scripts/get_demo2.php</span></div>';
			
		
		$log_data_system = $locale->getLocale('log_data_system', $lng);		 
		$log_data_system = str_replace('@@script@@', $script_path, $log_data_system);	
		$con .= '<h3 style="margin-top:0px">' .  $log_data_system . '</h3>';
		
	
		$con .= '<div class="last_entry"><b>' .  $locale->getLocale('last_entry', $lng) . ' (' . $last_entry_count . '):</b></div>';
				
		if($admin_chat_id != "")
		{
			$log_data = getLog($admin_chat_id, $last_entry_count, $script_path);	
			
			$count_log_data = count($log_data);
			
			for($l = 0; $l < $count_log_data; $l++)
			{
				if($log_file_display)
					$log_file = '<span class="log_file">' . $log_data[$l]['log_file'] . '</span>: ';
				
				if($l == 0)
					$con .= '<div><span class="data_class">' . getSelectDatetime($log_data[$l]['datetime']) . '</span>: ' . $log_file . $log_data[$l]['notice'] . '</div>';
				else
					$con .= '<div><span class="data_class">' . $log_data[$l]['datetime'] . '</span>: ' . $log_file . $log_data[$l]['notice'] . '</div>';
				
			}	
			
			if($count_log_data == 0)
				$con .= '<span class="count_log_data">' . $locale->getLocale('count_log_data_0', $lng) . '</span>';		
					
		}	
			
		if($log_data_to_file)
		{
			$con .= '<div class="log_data_from_file">';
			
				$path_file_log = realpath(__DIR__) . '/' . $log_data_file_path . '/' . $log_data_file_name;
				
				$con .= '<div><b>' . $locale->getLocale('log_data_from_file', $lng) . '</b>: ' . $path_file_log . ':</div>';
				$con .= '<pre>' . getLogDataFromFile($path_file_log) . '</pre>';	
			
			$con .= '</div>';
			
		}
			
		$con .= '	

		  </div>
		</div>

	';	
	
	return $con;	

}

?>