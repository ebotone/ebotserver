<?php

function getUserDataSenderByReferralCode($referral_code)
{
	global $text, $name_table_users;
	
	$select = 'select id, user_parent_id from ' . $name_table_users . ' where referral_code = "' . mysql_real_escape_string($referral_code) . '"';	
	$text->my_sql_query = $select;
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	return (array) $res;		
	
}

function getUserDataByRefferalCode($referral_code)
{	
	if($referral_code != "")
	{
		$data_str = file_get_contents("https://ebot.one/all/s_radoid/dialogs/api/sendmanager/getDataUser.php?referral_code=" . $referral_code);
		
		return json_decode($data_str, true);
		
	}

}

function refferalCodeUpdate($user_id, $referral_code)
{
	global $text, $name_table_users;
	
	$date = date('Y-m-d');
	
	$text->my_sql_query="update " . $name_table_users . " set referral_code='" . mysql_real_escape_string($referral_code) . "', referral_code_update='" . mysql_real_escape_string($date) . "' where id='" . mysql_real_escape_string($user_id) . "'";
	$text->my_sql_execute();	
	
}

function getRefferalCodeIsset($user_id, $referral_code)
{
	global $text, $name_table_users;
	
	$select = 'select id from ' . $name_table_users . ' where referral_code = "' . mysql_real_escape_string($referral_code) . '" and id!="' . mysql_real_escape_string($user_id) . '"';	
	$text->my_sql_query = $select;
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$id = $res->id;		
	
	if($id > 0)
		return true;
	else
		return false;
}

?>