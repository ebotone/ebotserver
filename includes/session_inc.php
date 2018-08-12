<?php
session_start();
header("Content-type: text/html; charset=utf-8");

//=================SID=====================
$sid = session_id();//for php5	
if($_SESSION['sid'] == "")
	$_SESSION['sid'] = $sid;//Тавтология
//=================SID=====================

?>