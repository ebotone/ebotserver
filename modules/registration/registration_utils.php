<?php

function generate_code($number)
{
    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9');
    // Генерируем пароль
    $pass = "";
    for($i = 0; $i < $number; $i++)
    {
      // Вычисляем случайный индекс массива
      $index = rand(0, count($arr) - 1);
      $pass .= $arr[$index];
    }
    return $pass;
}

function genRemind($user_id)
{
	global $text, $name_table_users;

	$code = generate_code(15);
	
	$text->my_sql_query="update " . $name_table_users . " set remind='" . mysql_real_escape_string($code) . "' where chat_id='" . mysql_real_escape_string($user_id) . "'";
	$text->my_sql_execute();

	return $code;
}

function getHash($user_id)
{
	global $text, $name_table_users;

	$text->my_sql_query="select hash from " . $name_table_users . " where chat_id='" . mysql_real_escape_string($user_id) . "'";
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	return $res->hash;	

}

function getLoginReservIsset($nikname)
{
	$isset = false;
	
	$data_mas = array();
	$data_mas[] = 'admin';
	$data_mas[] = 'administrator';
	$data_mas[] = 'support';
	$data_mas[] = 'login';
	$data_mas[] = 'password';
	$data_mas[] = 'system';
	$data_mas[] = 'test';
	$data_mas[] = 'tester';
	$data_mas[] = 'root';
	$data_mas[] = 'var_null';
	$data_mas[] = 'profile';
	$data_mas[] = 'skybot.space';
	$data_mas[] = 'skybot';
	$data_mas[] = 'ebot';
	$data_mas[] = 'ebot.one';
	$data_mas[] = 'ebotone';	
	
	$count_data_mas = count($data_mas);
	
	for($k = 0; $k < $count_data_mas; $k++)
	{
		if($nikname == $data_mas[$k])
			$isset = true;
	}
	
	return $isset;
}

?>