<?php

function getTablesInit()
{
	global $text, $name_table_users;
	
	return $text->my_sql_execute_table_exist($name_table_users);
	
}

function updatePassword($password_md5, $code)
{
	global $text, $name_table_users;
	
	if($password_md5 != "" && $code != "")
	{
		$text->my_sql_query='update ' . $name_table_users . ' set password = "' . mysql_real_escape_string($password_md5) . '", remind="" where remind = "' . mysql_real_escape_string($code) . '"';	
		$text->my_sql_execute();	

		return $text->my_sql_res_return();	
		
	}		
	
	
}

function getUserData($sid)
{
	global $text, $name_table_users, $name_table_sessions;
	
	//Получим пользователя по sid, а потом уже данные по user_id
	
	$data =  array();
	
	//===================
	//Синхронизация со старым механизмом
	
		$select = 'select *, id as user_id from ' . $name_table_users . ' where sid != "" and sid = "' . $sid . '"';			
		$text->my_sql_query = $select;
		$text->my_sql_execute();			
		$res = mysql_fetch_object($text->my_sql_res); 		
		$data = (array) $res;		
	
		if($data['user_id'] > 0)
			return $data;
	
	//===================
	
	$query_d = "select user_id from " . $name_table_sessions . " where sid='" . mysql_real_escape_string($sid) . "'";			
	$text->my_sql_query = $query_d;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$user_id = $res->user_id;	
	
	if($user_id > 0)
	{
		$select = 'select *, id as user_id from ' . $name_table_users . ' where id = "' . $user_id . '"';			
		$text->my_sql_query = $select;
		$text->my_sql_execute();			
		$res = mysql_fetch_object($text->my_sql_res); 		
		$data = (array) $res;			
		
	}	
	
	return $data;
}

function getCountUsers()
{
	global $text, $name_table_users;
	
	$select = 'select count(id) cnt from ' . $name_table_users . ' where 1';			
	$text->my_sql_query = $select;
	$text->my_sql_execute();			
	$res = mysql_fetch_object($text->my_sql_res); 		
	return $res->cnt;
		
}

function issetUserByLogin($nikname)
{
	global $text, $name_table_users;	
	
	$select = 'select count(id) cnt from ' . $name_table_users . ' where nikname = "' . $nikname . '"';	
	$text->my_sql_query = $select;
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$cnt = $res->cnt;		
	
	if($cnt > 0)
		return true;
	else
		return false;
}

function issetUserByHash($hash)
{
	global $text, $name_table_users;	
	
	//На непустой ник смотрим, т.к. при генерации ключа мы создаем запись а при добвлениии юзера просто заполняейм пароль с ником
	
	$select = 'select count(id) cnt from ' . $name_table_users . ' where nikname !="" and hash = "' . $hash . '"';	
	$text->my_sql_query = $select;
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$cnt = $res->cnt;		
	
	if($cnt > 0)
		return true;
	else
		return false;
}

function addNewUserByHash($data)
{
	global $text, $name_table_users, $lng;	
	
	$login = $data['login'];
	$password_md5 = $data['password_md5'];
	$hash = $data['hash'];
	$status = $data['status'];
	$locale = $data['locale'];
	$sid = $data['sid'];
	
	if($status == '')
		$status = 'user';
	
	$select = 'select id from ' . $name_table_users . ' where hash = "' . mysql_real_escape_string($hash) . '"';	
	$text->my_sql_query = $select;
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$id = $res->id;	
	
	if($id > 0)
	{		
		$count_users = getCountUsers();
		
		if($count_users == 1)
			$status = 'root';//Первый пользователь - админ типа root
		
		$text->my_sql_query='update ' . $name_table_users . ' set nikname = "' . mysql_real_escape_string($login) . '", password = "' . mysql_real_escape_string($password_md5) . '", status = "' . mysql_real_escape_string($status) . '", sid = "' . mysql_real_escape_string($sid) . '" where id = "' . mysql_real_escape_string($id) . '"';	
		$text->my_sql_execute();	
		
		return 'ok';
	}
	else
		return $locale->getLocale('hash_error', $lng);
	
}

function userUpdate($user_data)
{
	global $text, $name_table_users;
	
	$user_name = $user_data['user_name'];
	$user_id = $user_data['user_id'];
	$username = $user_data['username'];
	$first_name = $user_data['first_name'];
	$last_name = $user_data['last_name'];
	$phone_number = $user_data['phone_number'];
	$language_code = $user_data['language_code'];
	$init = $user_data['init'];
	
	$username_1251 = iconv('utf-8', 'cp1251', $username);//кодируем из Рѕ_РЅР°СЃ в о_нас	
	$first_name_1251 = iconv('utf-8', 'cp1251', $first_name);//кодируем из Рѕ_РЅР°СЃ в о_нас	
	$last_name_1251 = iconv('utf-8', 'cp1251', $last_name);//кодируем из Рѕ_РЅР°СЃ в о_нас	


	$text->my_sql_query="select * from " . $name_table_users . " where chat_id='" . mysql_real_escape_string($user_id) . "' LIMIT 1";
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$chat_id_db = $res->chat_id;
	$username_db = $res->username;
	$first_name_db = $res->first_name;
	$last_name_db = $res->last_name;
	$phone_number_db = $res->phone_number;
	$language_code_db = $res->language_code;

	if($chat_id_db > 0)
	{
		//UPDATE
		
		if($username_db == "" && $username_1251 != "")
		{
			$text->my_sql_query="update " . $name_table_users . " set username='" . mysql_real_escape_string($username_1251) . "' where chat_id='" . mysql_real_escape_string($user_id) . "'";
			$text->my_sql_execute();
		
		}
		
		if($first_name_db == "" && $first_name_1251 != "")
		{
			$text->my_sql_query="update " . $name_table_users . " set first_name='" . mysql_real_escape_string($first_name_1251) . "' where chat_id='" . mysql_real_escape_string($user_id) . "'";
			$text->my_sql_execute();
		
		}

		if($last_name_db == "" && $last_name_1251 != "")
		{
			$text->my_sql_query="update " . $name_table_users . " set last_name='" . mysql_real_escape_string($last_name_1251) . "' where chat_id='" . mysql_real_escape_string($user_id) . "'";
			$text->my_sql_execute();
		
		}

		if($phone_number_db == "" && $phone_number != "")
		{
			$text->my_sql_query="update " . $name_table_users . " set phone_number='" . mysql_real_escape_string($phone_number) . "' where chat_id='" . mysql_real_escape_string($user_id) . "'";
			$text->my_sql_execute();
		
		}


		if($init == 1)
		{
			//$text->my_sql_query="update " . $name_table_users . " set phone_number='' where chat_id='" . mysql_real_escape_string($user_id) . "'";
			//$text->my_sql_execute();

		}	
		
	
	}
	else
	{
		//ADD
		
		$hash = md5(md5(date("Y-m-d H:i:s") . time() . rand(10, 10000)));
		
		$query_insert = "";
		$query_insert .= "insert into " . $name_table_users . " ";
		$query_insert .= "(chat_id, username, first_name, last_name, phone_number, language_code, hash, datetime) values ";
		$query_insert .= "(";
		$query_insert .= "'" . mysql_real_escape_string($user_id) . "'";
		$query_insert .= ",'" . mysql_real_escape_string($username_1251) . "'";
		$query_insert .= ",'" . mysql_real_escape_string($first_name_1251) . "'";
		$query_insert .= ",'" . mysql_real_escape_string($last_name_1251) . "'";
		$query_insert .= ",'" . mysql_real_escape_string($phone_number) . "'";
		$query_insert .= ",'" . mysql_real_escape_string($language_code) . "'";
		$query_insert .= ",'" . mysql_real_escape_string($hash) . "'";
		$query_insert .= ", now()";
		
			//$fp = fopen("5555.txt", 'a');
			//$trace = fwrite($fp, "\n\n" . time() . " query_insert=" . $query_insert); 
			//fclose($fp);		
		
		$query_insert .= ");";	
		$text->my_sql_query = $query_insert;
		$text->my_sql_execute();		
	
	}
	

}

?>