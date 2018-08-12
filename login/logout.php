<?php
include_once(realpath(__DIR__) . '/../includes/session_inc.php');
include_once(realpath(__DIR__) . '/../includes/time_access_inc.php');
require_once(realpath(__DIR__) . '/../db_connect.php');
require_once(realpath(__DIR__) . '/../login/login_utils.php');
require_once(realpath(__DIR__) . '/../modules/modules_utils.php');

$resp_mas = array();
$resp_mas['status'] = 'error';

if($ok)
{
	if($access_time_ok)
	{		
		logout($sid);

		$resp_mas['status'] = 'location';
		
		$con = "http://".$_SERVER['HTTP_HOST']. $dir_project . "/" .getModuleLink(getBaseModuleByStatus(''));
	}
	else
		$resp_mas['status'] = 'access_time_error';
	
	$__session = $_SESSION;
	session_write_close();	
	
	
}
else
	$con = "db connect error";

$resp_mas['con'] = $con;
echo json_encode($resp_mas);

?>