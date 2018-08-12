<?php

function groupQuestionAdd($locale, $lng)
{
	global $text, $name_table_group_questions;
	
	$insert_data_mas = array();	
	
	$group_name = $locale->getLocale('New_group', $lng);

	$insert_data_mas[] = addData("group_name", $group_name);
	$insert_data_mas[] = addData("datetime", 'now()');
	
	$query_insert = getInsert($name_table_group_questions, $insert_data_mas);		

	$text->my_sql_query = $query_insert;
	$text->my_sql_execute();		
	

	
}

function groupElDel($el_id)
{
	global $text, $name_table_group_questions;
	
	if($el_id > 0)
	{
		$select = 'delete from ' . $name_table_group_questions . ' where id = "' . mysql_real_escape_string($el_id) . '"';
		$text->my_sql_query = $select;
		$text->my_sql_execute();			
		
	}	
	
}

function elDel($el_id)
{
	global $text, $name_table_questions, $name_table_users;
	
	if($el_id > 0)
	{
		$select = "select field from " . $name_table_questions . " where id='" . mysql_real_escape_string($el_id) . "'";	
		$text->my_sql_query = $select;		
		$text->my_sql_execute();
		$res = mysql_fetch_object($text->my_sql_res);
		$field = $res->field;			
		
		$select = 'delete from ' . $name_table_questions . ' where id = "' . mysql_real_escape_string($el_id) . '"';
		$text->my_sql_query = $select;
		$text->my_sql_execute();	

		if($field != "")
		{
			$text->my_sql_query = "ALTER TABLE " . $name_table_users . " DROP COLUMN " . $field . ";";
			$text->my_sql_execute();				
			
		}
	
		
	}	
	
}

function elsSort($sort_data_str)
{	
	global $text, $name_table_questions;
	
	$sort_el_mas = explode('@', $sort_data_str);
	
	$count_sort_el_mas = count($sort_el_mas);
	
	for($k = 0; $k < $count_sort_el_mas; $k++)
	{
		if($sort_el_mas[$k] != "")
		{
			$sort_data_el_mas = explode('_', $sort_el_mas[$k]);
			
			if(count($sort_data_el_mas) == 2)
			{
				$el_id = $sort_data_el_mas[0];
				$el_number = $sort_data_el_mas[1];
			
				$update = "update " . $name_table_questions . " set number='" . mysql_real_escape_string($el_number) . "' where id=" . mysql_real_escape_string($el_id);
				$text->my_sql_query = $update;
				$text->my_sql_execute();			
			
			//echo $update;
			}	
		
		}
		
	}
}

function questionAdd($group_id, $locale, $lng)
{
	global $text, $name_table_questions, $name_table_users;
	
	$insert_data_mas = array();	
	
	$name = $locale->getLocale('New_question', $lng);
	
	$select = "select MAX(number) number from " . $name_table_questions . " where group_id='" . mysql_real_escape_string($group_id) . "'";	
	$text->my_sql_query = $select;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$number = $res->number + 0;
	
	$number++;

	$insert_data_mas[] = addData("group_id", $group_id);
	$insert_data_mas[] = addData("name", $name);
	$insert_data_mas[] = addData("_type", 'string');
	$insert_data_mas[] = addData("number", $number);
	$insert_data_mas[] = addData("datetime", 'now()');
	
	$query_insert = getInsert($name_table_questions, $insert_data_mas);		

	$text->my_sql_query = $query_insert;
	$text->my_sql_execute();	
	
	$insert_id = $text->my_sql_insert_id();
	
	$field = "field_" . $insert_id;
	
	$update = "update " . $name_table_questions . " set field='" . $field . "' where id=" . mysql_real_escape_string($insert_id);
	$text->my_sql_query = $update;
	$text->my_sql_execute();

	$text->my_sql_query = "ALTER TABLE " . $name_table_users . " ADD " . $field . " VARCHAR(500) NOT NULL;";
	$text->my_sql_execute();		
	
}

function groupQuestionSave($data)
{
	global $text, $name_table_group_questions;
	
	$name = $data['name'];
	$php_start = $data['php_start'];
	$php_end = $data['php_end'];
	$sps = $data['sps'];
	$gname = $data['gname'];
	
	if($name != '')
	{
		$update = "update " . $name_table_group_questions . " set group_name='" . mysql_real_escape_string($name) . "', php_start='" . mysql_real_escape_string($php_start) . "', php_end='" . mysql_real_escape_string($php_end) . "', sps='" . mysql_real_escape_string($sps) . "', gname='" . mysql_real_escape_string($gname) . "' where id=" . mysql_real_escape_string($data['id']);
		$text->my_sql_query = $update;
		$text->my_sql_execute();			

	}

	
}

function questionSave($data)
{
	global $text, $name_table_questions;
	
	$title = $data['title'];
	$name = $data['name'];
	
	if($name != '')
	{
		$update = "update " . $name_table_questions . " set title='" . mysql_real_escape_string($title) . "', name='" . mysql_real_escape_string($name) . "', _type='" . mysql_real_escape_string($data['type']) . "' where id=" . mysql_real_escape_string($data['id']);
		$text->my_sql_query = $update;
		$text->my_sql_execute();			
		
	}

	
}

function getGroupQuestionDataById($group_id)
{
	global $text, $name_table_group_questions;
	
	$select = "select * from " . $name_table_group_questions . " where id='" . mysql_real_escape_string($group_id) . "'";	
	$text->my_sql_query = $select;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	return (array) $res;		
	
}

function getQuestionDataById($el_id)
{
	global $text, $name_table_questions;
	
	$select = "select * from " . $name_table_questions . " where id='" . mysql_real_escape_string($el_id) . "'";	
	$text->my_sql_query = $select;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	return (array) $res;		
	
}

function getFirstElByQuestionsGroupsId($group_id)
{
	global $text, $name_table_questions;
	
	$select = "select MAX(id) id from " . $name_table_questions . " where group_id='" . mysql_real_escape_string($group_id) . "'";	
	$text->my_sql_query = $select;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	return $res->id + 0;	
	
	
}

function getQuestionsListByGroupId($group_id)
{
	global $text, $name_table_questions;
	
	$data_mas = array();
	
    $select = 'select * from ' . $name_table_questions . ' where group_id="' . mysql_real_escape_string($group_id) . '" order by number desc';
	$text->my_sql_query = $select;
	$text->my_sql_execute();			
	while ($res = mysql_fetch_object($text->my_sql_res)) 
	{
		$data_mas[] = (array) $res;	
    }

    return $data_mas;		
	
}

function getQuestionsGroupsList()
{
	global $text, $name_table_group_questions;
	
	$data_mas = array();
	
    $select = 'select * from ' . $name_table_group_questions . ' where 1 order by id desc';
	$text->my_sql_query = $select;
	$text->my_sql_execute();			
	while ($res = mysql_fetch_object($text->my_sql_res)) 
	{
		$data_mas[] = (array) $res;	
    }

    return $data_mas;	
	
}

?>
