<?php

function getQuestionsResultList($group_id, $chat_id)
{
	global $text, $name_table_users;
	
	$resilt_list = array();
	
	$questions_list = getQuestionsListByGroupId($group_id);
	
	$count_questions_list = count($questions_list);
	
	for($k = 0; $k < $count_questions_list; $k++)
	{
		$field = $questions_list[$k]['field'];
		$response = '-';
		
		if($field != '')
		{
			$select = "select " . mysql_real_escape_string($field) . " from " . $name_table_users . " where chat_id='" . mysql_real_escape_string($chat_id) . "'";	
			$text->my_sql_query = $select;		
			$text->my_sql_execute();
			$res = mysql_fetch_object($text->my_sql_res);
			$response = $res->$field;				
			
		}
		
		$add = array();
		$add['title'] = $questions_list[$k]['title'];	
		$add['response'] = $response;	
		
		$resilt_list[] = $add;
	}	
	
	return $resilt_list;
}

function setResponseToQuestion($group_id, $chat_id, $body)
{
	global $text, $name_table_act_questions, $name_table_questions, $name_table_users;
	
	$select = "select question_id from " . $name_table_act_questions . " where chat_id='" . mysql_real_escape_string($chat_id) . "' and group_id='" . mysql_real_escape_string($group_id) . "'";	
	$text->my_sql_query = $select;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$question_id = $res->question_id;	
	
	if($question_id > 0)
	{
		$select = "select field from " . $name_table_questions . " where id='" . mysql_real_escape_string($question_id) . "'";	
		$text->my_sql_query = $select;		
		$text->my_sql_execute();
		$res = mysql_fetch_object($text->my_sql_res);
		$field = $res->field;	
		
		if($field != '')
		{			
			//$body = iconv('utf-8', 'cp1251', $body);//кодируем из Рѕ_РЅР°СЃ в о_нас	
			
			$update = "update " . $name_table_users . " set " . mysql_real_escape_string($field) . "='" . mysql_real_escape_string($body) . "' where chat_id=" . mysql_real_escape_string($chat_id);
			$text->my_sql_query = $update;
			$text->my_sql_execute();
			
		}		
		
	}


	
}

function setNextCommandEnd($chat_id, $group_data)
{
	global $HTTP, $HTTP_HOST, $key_md5, $bot_id, $admin_chat_id;
	//Следующий вопрос будет последним - возможно нужно заранее переключить редактор
	
	if($group_data['command_id_end'] > 0)
	{
		//Есть куда переключать
		
		$url = $HTTP . "://" . $HTTP_HOST . "/all/s_radoid/dialogs/api/methods/setCommandProps.php?key_md5=" . $key_md5 . "&bot_id=" . $bot_id . "&chat_id=" . $chat_id . "&chat_admin_id=" . $admin_chat_id . "&set_command_go_to=" . $group_data['command_id_end'];
				
		//$res = file_get_contents($url);
		
		//$fp = fopen("5555.txt", 'a');
		//$trace = fwrite($fp, "\n\n" . date("Y-m-d H:i:s") . " url=" . $url . " res=" . $res . "\n\n"); 
		//fclose($fp);		
		
	}
	
	
}

function getIssetSessionQuestion($group_id, $chat_id)
{
	global $text, $name_table_act_questions;
	
	$select = "select question_id from " . $name_table_act_questions . " where chat_id='" . mysql_real_escape_string($chat_id) . "' and group_id='" . mysql_real_escape_string($group_id) . "'";	
	$text->my_sql_query = $select;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$question_id = $res->question_id + 0;		
	
	if($question_id > 0)
		return true;
	else
		return false;
	
}

function getQuestionAct($group_id, $chat_id, $act)
{
	global $text, $name_table_act_questions, $name_table_group_questions;
	
	$question_data = array();

	$select = "select question_id from " . $name_table_act_questions . " where chat_id='" . mysql_real_escape_string($chat_id) . "' and group_id='" . mysql_real_escape_string($group_id) . "'";	
	$text->my_sql_query = $select;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$question_id = $res->question_id + 0;	
	
	if($question_id == 0)
	{
		$question_id = getFirstQuestion($group_id);		
		
		if($question_id > 0)
		{
			$data = getQuestionDataById($question_id);
			
			//$fp = fopen("7777.txt", 'a');
			//$trace = fwrite($fp, "\n\n" . date("Y-m-d H:i:s") . " question_id=" . $question_id . " ззз=" . print_r($data, true) . " "); 
			//fclose($fp);			
			
			$name = $data['name'];
			
			if($name != '')
			{
				$insert_data_mas = array();
				
				$insert_data_mas[] = addData("chat_id", $chat_id);
				$insert_data_mas[] = addData("group_id", $group_id);
				$insert_data_mas[] = addData("question_id", $question_id);
				$insert_data_mas[] = addData("datetime", 'now()');
				
				$query_insert = getInsert($name_table_act_questions, $insert_data_mas);		

				$text->my_sql_query = $query_insert;
				$text->my_sql_execute();
				
				$question_data['name'] = $name;
				$question_data['act'] = 'init';
				
				$next_question_id = getNextQuestion($group_id, $question_id);
				
				if($next_question_id == 0)
				{
					$group_data = getGroupQuestionDataById($group_id);
					
					setNextCommandEnd($chat_id, $group_data);
				}
					
				
			}
			else
				$question_data['name'] = 'first question name error (group_id=' . $group_id . ')';
			
		}
		else
			$question_data['name'] = 'first question error (group_id=' . $group_id . ')';
		
	}
	else
	{
		if($act == 'next')
		{
			$question_id = getNextQuestion($group_id, $question_id);
			
			if($question_id > 0)
			{
				$data = getQuestionDataById($question_id);				
				$name = $data['name'];
				
				if($name != '')
				{
					$update = "update " . $name_table_act_questions . " set question_id='" . $question_id . "' where chat_id='" . mysql_real_escape_string($chat_id) . "' and group_id='" . mysql_real_escape_string($group_id) . "'";	
					$text->my_sql_query = $update;
					$text->my_sql_execute();
					
					$question_data['name'] = $name;
					$question_data['act'] = 'name';
					
					$next_question_id = getNextQuestion($group_id, $question_id);
					
					if($next_question_id == 0)
					{
						$group_data = getGroupQuestionDataById($group_id);
						
						setNextCommandEnd($chat_id, $group_data);
					}					
				}
				else
					$question_data['name'] = 'first question name error';
				
			}
			else
			{
				//Не важно что там случилось - закрываем сессию вопросов
				
				sessionQuestionsClose($group_id, $chat_id);
				
				//$question_data['name'] = 'test';
				$question_data['act'] = 'close';
				
			}			
			
		}
		else
		{
			//Вернем текущие данные
			
			$data = getQuestionDataById($question_id);				
			$name = $data['name'];

			$question_data['name'] = $name;
			$question_data['act'] = 'repeat';			
			
		}

					
		
	}
	
	return $question_data;
	
}

function sessionQuestionsClose($group_id, $chat_id)
{
	global $text, $name_table_act_questions;
	
	$update = "delete from " . $name_table_act_questions . " where chat_id='" . mysql_real_escape_string($chat_id) . "' and group_id='" . mysql_real_escape_string($group_id) . "'";	
	$text->my_sql_query = $update;
	$text->my_sql_execute();
	
}

function getFirstQuestion($group_id)
{
	global $text, $name_table_questions;	
	
	$select = "select MIN(number) number from " . $name_table_questions . " where group_id='" . mysql_real_escape_string($group_id) . "'";	
	$text->my_sql_query = $select;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$number = $res->number;	
	
	$select = "select id from " . $name_table_questions . " where number='" . mysql_real_escape_string($number) . "' and group_id='" . mysql_real_escape_string($group_id) . "'";	
	$text->my_sql_query = $select;		
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	return $res->id;			
	
}

function getNextQuestion($group_id, $question_id)
{
	global $text, $name_table_questions;
	
	$data = getQuestionDataById($question_id);
	
	$question_id = $data['id'];
	
	if($question_id > 0)
	{
		$select = "select MIN(number) number, id from " . $name_table_questions . " where group_id='" . mysql_real_escape_string($group_id) . "' and number > '" . $data['number'] . "'";	
		$text->my_sql_query = $select;		
		$text->my_sql_execute();
		$res = mysql_fetch_object($text->my_sql_res);
		$number = $res->number;	
		$id = $res->id;		

		if($id > 0 && $id != $question_id)
			return $id;
		else
		{
			//Ничего не получили - вероятно мы в конце - закрываем вопрос
			return 0;
		}
		
	}
	else
		return 0;
	

	
}

?>
