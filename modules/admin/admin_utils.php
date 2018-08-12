<?php

function getUsersCount()
{
	global $text, $name_table_users;
	
	$query_d = "select count(id) cnt from " . $name_table_users . " where 1";			
	$text->my_sql_query = $query_d;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	return $res->cnt;		
	
}

function getUsersData($count)
{
	global $text, $name_table_users;
	
	$data_mas = array();
	
	if($count > 0)
	{
		$query_d = "select * from " . $name_table_users . " where 1 order by id desc LIMIT 0, " . $count;
	}
	else
	{
		$query_d = "select * from " . $name_table_logs . "";
	}
				
	$res = mysql_query($query_d);
	while ($row = mysql_fetch_assoc($res)) {
	
		$data_mas[] = (array) $row;
		
	}				
	
	return $data_mas;	
	
}

?>