<?php

//=========== time ================

$access_time_max = 1;
$access_time_ok = true;
$basename_file = basename(__FILE__);

if($basename_file != '' && $_SESSION[$basename_file] > 0)	
	if(($_SESSION[$basename_file] + $access_time_max) > time())
		$access_time_ok = false;	

$_SESSION[$basename_file] = time();

//=========== time ================

?>