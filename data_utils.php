<?php

function getSelectDatetime($datetime)
{
	$datetime_mas = explode(" ", $datetime);	
	
	return $datetime_mas[0] . ' <span style="color:#000">' . $datetime_mas[1] . '</span>';
}

function getBotSettings()
{
	global $bot_id, $HTTP, $HTTP_HOST, $key_md5, $admin_user_id;
	
	if($bot_id != "" && $key_md5 != "" && $admin_user_id != "" && $HTTP != "" && $HTTP_HOST != "")
	{
		$url_settings = $HTTP . "://" . $HTTP_HOST . "/all/s_radoid/dialogs/api/methods/getBotSettings.php";

		$url_settings .= "?key_md5=" . $key_md5 . "&bot_id=" . $bot_id . "&user_id=" . $admin_user_id;

		$settings_str = file_get_contents($url_settings);

		$settings_mas = json_decode($settings_str, true);

		return $settings_mas['bot_base_settings'];
		
	}
	else
		return array();	
	
}

function getLog($chat_id, $count, $log_file = '')
{
	global $text, $name_table_logs;
	
	$data_mas = array();
	
	if($chat_id == 'system' || $chat_id == 'sys')
		$chat_id = 'system';	
	
	$source_str = " and chat_id='" . mysql_real_escape_string($chat_id) . "' ";
	
	if($chat_id == 'all')
		$source_str = "";
	
	$where = '';
	
	if($log_file != '')
		$where = " and log_file='" . mysql_real_escape_string($log_file) . "'";
	
	if($count > 0)
	{
		$query_d = "select * from " . $name_table_logs . " where id > 0 " . $source_str . " " . $where . " order by id desc LIMIT 0, " . $count;
	}
	else
	{
		$query_d = "select * from " . $name_table_logs . " where id > 0 " . $source_str . " " . $where;
	}	

		
	$res = mysql_query($query_d);
	while ($row = mysql_fetch_assoc($res)) {
	
		$data_mas[] = (array) $row;
		
	}				
	
	return $data_mas;
}

function getLogDataFromFile($path)
{	
	return implode("",file($path));

}

function setLogDataToFile($data_mas, $path = '', $set_log_data_file_name = '')
{
	global $log_data_file_path, $log_data_file_name, $log_data_to_file_add;
	
	/*
	Чтобы вызывать эту функцию необходимо чтобы были определены переменные:	
	log_data_file_path
	log_data_file_name
	log_data_to_file_add
	
	Пример настроек в demo модуле исходного пакета в /modules/demo/settings.php
	
	*/
	
	if($set_log_data_file_name != '')
		$log_data_file_name = $set_log_data_file_name;
	
	$data_str = print_r($data_mas, true);
	
	$path_save = $path . $log_data_file_path . '/' . $log_data_file_name;
	
	$type = 'w';
	
	if($log_data_to_file_add)
		$type = 'a';
	
	$fp = fopen($path_save, $type);
	$trace = fwrite($fp, $data_str); 
	fclose($fp);
	
	return $path_save;
}

function setLogByChatId($chat_id, $notice, $log_file)
{
	global $text, $name_table_logs, $log_system, $log_users;
	
	if($notice != "")
	{
		$add = false;
		
		if($chat_id == 'system' || $chat_id == 'sys')
			$chat_id = 'system';
		
		if($chat_id == 'system' && $log_system)
		{
			$add = true;
			
		}
		
		if($chat_id > 0 && $log_users)
		{
			$add = true;
			
		}	

		if($add)
		{
			
			require_once(realpath(__DIR__) . '/mysql_utils.php');
			
			$insert_data_mas = array();	
			
			$insert_data_mas[] = addData("chat_id", $chat_id);
			$insert_data_mas[] = addData("notice", $notice);
			$insert_data_mas[] = addData("log_file", $log_file);
			$insert_data_mas[] = addData("datetime", 'now()');
			
			$query_insert = getInsert($name_table_logs, $insert_data_mas);		

			$text->my_sql_query = $query_insert;
			$text->my_sql_execute();		
			
		}			
		

		
	}
	
}

function getEditorData($get, $post)
{
	global $key_md5, $admin_user_id;
	
	$data_mas = array();
	
	$url_data = $get['url_data'];
	
	if($url_data != "")
	{
		//GET
		
		if($key_md5 == '')
		{
			$data_mas['error'] = '1';
			
		}
		else
		if($admin_user_id == '')
		{
			$data_mas['error'] = '2';
			
		}				
		else
		{
			$data_str = file_get_contents($url_data . "&key_md5=" . $key_md5 . "&admin_user_id=" . $admin_user_id);
			$data_mas = json_decode($data_str, true);		

			if($data_mas['user_id'] > 0)
			{
				
			}	
			else
			{
				$data_mas['error'] = '3';
				$data_mas['error_con'] = $url_data . "&key_md5=" . $key_md5 . "&admin_user_id=" . $admin_user_id . '/'.  $data_str;
				
			}		
			
		}
	
		
	}
	else
	{
		//POST
		
		$data_mas = $post;
	}
	
	return $data_mas;
}

?>