<?php
header("Content-type: text/html; charset=utf-8");

	//ini_set('error_reporting', E_ALL);
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);

include '../conf.php';
include '../db.php';

include '../user_fnc.php';
//include '../sys/sys_sender.php';

include 'manager_utils.php';


require_once(realpath(__DIR__) . '/../locale_data.php');
require_once(realpath(__DIR__) . '/../locale_utils.php');


$url_data = $_GET['url_data'];
$data_str = file_get_contents($url_data . "&key_md5=" . $key_md5 . "&admin_user_id=" . $admin_user_id);
$data_mas = json_decode($data_str, true);

$HTTP_HOST = $data_mas['HTTP_HOST']; //ebot.one
$user_id = $data_mas['user_id'];
$username = $data_mas['username'];
$first_name = $data_mas['first_name'];
$last_name = $data_mas['last_name'];
$phone_number = $data_mas['phone_number'];
$language_code = $data_mas['language_code'];

$locale_includes = array();
$locale_includes[] = 'default';

$locale_data = array();
$locale_data['lng_default'] = $lng_default;
$locale_data['includes'] = $locale_includes;

$locale = new _locale($locale_data);

// http://r911236z.bget.ru/all/bots/source_script/77639817/SendManagerBot/scripts/get_hash.php

$return_mas = array();
$return_mas['status'] = 0;

	//$fp = fopen("5555.txt", 'a');
	//$trace = fwrite($fp, "\n\n" . date("Y-m-d H:i:s") . "data_mas=" . print_r($data_mas, true) . " _GET=" . print_r($_GET, true) . " _POST=" . print_r($_POST, true) . "\n\n"); 
	//fclose($fp);


if($user_id > 0)
{
	$return_mas['status'] = 1;	
			
	$user_data = array();
	$user_data['user_id'] = $user_id;
	$user_data['username'] = $username;
	$user_data['first_name'] = $first_name;
	$user_data['last_name'] = $last_name;
	$user_data['phone_number'] = $phone_number;
	$user_data['language_code'] = $language_code;	
	$user_data['user_name'] = $user_name;
	$user_data['name_table_users'] = $name_table_users;
	
	userUpdate($user_data);		
	
	$lng = getLngByUser($user_id);

	$con = '';
	
	$con .= $locale->getLocale('Your_code', $lng) . ': ' . getHash($user_id);	
	
	$return_mas['body'] = $con;
	
}


echo json_encode($return_mas);



?>