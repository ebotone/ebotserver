<?php

function getInsert($table, $insert_data_mas)
{
	global $conn;
	
	$query_add = "";	
	$fields_str = "";
	$values_str = "";
	
	$count_insert_data_mas = count($insert_data_mas);
	
	for($k = 0; $k < $count_insert_data_mas; $k++)
	{
		if($k > 0)
		{
			$fields_str .= ", ";
			$values_str .= ", ";
		}
				
		$fields_str .= $insert_data_mas[$k]['f'];
		
		$insert_data_mas[$k]['v'] = $insert_data_mas[$k]['v'] . '';
		
		if($insert_data_mas[$k]['v'] == 'now()')
			$values_str .= "now()";
		else		
			$values_str .= "'" . mysql_real_escape_string($insert_data_mas[$k]['v']) . "'";
		
	}
	
	$query_add .= "insert into " . $table . " (";
	
		$query_add .= $fields_str;
	
	$query_add .= ") values (";
	
		$query_add .= $values_str;
	
	$query_add .= ");";
	
	
	
	return $query_add;
	
}

function addData($f, $k)
{
	$add = array();
	$add['f'] = $f;
	$add['v'] = $k;			
	return $add;
}

?>