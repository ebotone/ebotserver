<?php

function getDataRoot()
{
	global $text, $name_table_users;
	
	$select = 'select nikname as login, password from ' . $name_table_users . ' where status = "root"';	
	$text->my_sql_query = $select;
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	return (array) $res;		
	
}

function login($hash, $password_md5, $sid)
{
	global $text, $name_table_users;
	
	$text->my_sql_query='update ' . $name_table_users . ' set sid = "' . mysql_real_escape_string($sid) . '" where hash = "' . mysql_real_escape_string($hash) . '" and password = "' . mysql_real_escape_string($password_md5) . '"';	
	$text->my_sql_execute();		
	
	$select = 'select status from ' . $name_table_users . ' where sid = "' . mysql_real_escape_string($sid) . '"';	
	$text->my_sql_query = $select;
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$status = $res->status;		
	
	if($status != "")
		return $status;
	else
	{
		//Нет такого походу - наверное у нас логин а не hash	
		
		$text->my_sql_query='update ' . $name_table_users . ' set sid = "' . mysql_real_escape_string($sid) . '" where nikname = "' . mysql_real_escape_string($hash) . '" and password = "' . mysql_real_escape_string($password_md5) . '"';	
		$text->my_sql_execute();		
		
		$select = 'select status from ' . $name_table_users . ' where sid = "' . mysql_real_escape_string($sid) . '"';	
		$text->my_sql_query = $select;
		$text->my_sql_execute();
		$res = mysql_fetch_object($text->my_sql_res);
		return $res->status;			
		
	}
	
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