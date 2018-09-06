<?php

function addSession($data_mas)
{
	global $text, $name_table_sessions;	
	
	$user_id = $data_mas['user_id'];
	$sid = $data_mas['sid'];
	
	$query_d = "select id as id_session from " . $name_table_sessions . " where user_id='" . mysql_real_escape_string($user_id) . "' and sid='" . mysql_real_escape_string($sid) . "'";			
	$text->my_sql_query = $query_d;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$id_session = $res->id_session;		
	
	if($id_session > 0)
	{
		//Такая сессия с этим юзером есть - ничего не делаем	
		
	}
	else
	{
		//Сессии нет, добавляем
		
		$insert_data_mas = array();	
		
		$insert_data_mas[] = addData("user_id", $user_id);
		$insert_data_mas[] = addData("sid", $sid);
		$insert_data_mas[] = addData("datetime", 'now()');
		
		$query_insert = getInsert($name_table_sessions, $insert_data_mas);		

		$text->my_sql_query = $query_insert;
		$text->my_sql_execute();	
		
	}	
	

	
}

function getDataRoot()
{
	global $text, $name_table_users;
	
	$select = 'select nikname as login, password from ' . $name_table_users . ' where status = "root"';	
	$text->my_sql_query = $select;
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	return (array) $res;		
	
}

function login_vk($vk_id, $sid)
{
	global $text, $name_table_users, $name_table_sessions;	
	
	//Если нет такого - добавляем и авторизуемся
	//Если есть - просто авторизуемся, если еще не авторизованы пож этой сессией	
	
	$query_d = "select id, status from " . $name_table_users . " where vk_id='" . mysql_real_escape_string($vk_id) . "' and vk_id!=''";			
	$text->my_sql_query = $query_d;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$id = $res->id;
	$status = $res->status;	
	
	if(!($id > 0))
	{
		//Такого нет, добавим
		
		$insert_data_mas = array();	
		
		$insert_data_mas[] = addData("vk_id", $vk_id);
		$insert_data_mas[] = addData("nikname", $vk_id);
		$insert_data_mas[] = addData("status", 'user');
		$insert_data_mas[] = addData("sid", $sid);
		$insert_data_mas[] = addData("datetime", 'now()');
		
		$query_insert = getInsert($name_table_users, $insert_data_mas);		

		$text->my_sql_query = $query_insert;
		$text->my_sql_execute();		
		
	}
	
	$query_d = "select id, status from " . $name_table_users . " where vk_id='" . mysql_real_escape_string($vk_id) . "' and vk_id!=''";			
	$text->my_sql_query = $query_d;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$id = $res->id;
	$status = $res->status;		
	
	if($id > 0)
	{
		//Нашли юзера
		//Если есть в таблице сессий - обновим, если нет - добавим
		
		$data_mas = array();
		$data_mas['user_id'] = $id;
		$data_mas['sid'] = $sid;
		
		addSession($data_mas);	
		
		
	}	
	
	if($status != "")
		return $status;		
	
}

function login($hash, $password_md5, $sid)
{
	global $text, $name_table_users;
	
	$text->my_sql_query='update ' . $name_table_users . ' set sid = "' . mysql_real_escape_string($sid) . '" where hash = "' . mysql_real_escape_string($hash) . '" and password = "' . mysql_real_escape_string($password_md5) . '"';	
	$text->my_sql_execute();		
	
	$select = 'select id, status from ' . $name_table_users . ' where sid = "' . mysql_real_escape_string($sid) . '"';	
	$text->my_sql_query = $select;
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$id = $res->id;
	$status = $res->status;		
	
	if($id > 0)
	{
		//Нашли
	}
	else
	{
		//Нет такого походу - наверное у нас логин а не hash	
		
		$text->my_sql_query='update ' . $name_table_users . ' set sid = "' . mysql_real_escape_string($sid) . '" where nikname = "' . mysql_real_escape_string($hash) . '" and password = "' . mysql_real_escape_string($password_md5) . '"';	
		$text->my_sql_execute();		
		
		$select = 'select id, status from ' . $name_table_users . ' where sid = "' . mysql_real_escape_string($sid) . '"';	
		$text->my_sql_query = $select;
		$text->my_sql_execute();
		$res = mysql_fetch_object($text->my_sql_res);
		$id = $res->id;
		$status = $res->status;			
		
	}
	
	if($id > 0)
	{
		//Нашли юзера
		//Если есть в таблице сессий - обновим, если нет - добавим
		
		$data_mas = array();
		$data_mas['user_id'] = $id;
		$data_mas['sid'] = $sid;
		
		addSession($data_mas);	
		
		
	}
	else
	{
		//Не нашли

	}	
	
	
	return $status;	
}

function logout($sid)
{
	global $text, $name_table_users;
	
	if($sid != '')
	{
		$text->my_sql_query='update ' . $name_table_users . ' set sid = "" where sid = "' . mysql_real_escape_string($sid) . '"';	
		$text->my_sql_execute();			
		
	}

}

?>