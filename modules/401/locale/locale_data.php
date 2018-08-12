<?php

function get401Mas()
{
	$local_mas = array();		
	
		$add = array();
		
		$add['abv'] = '_401_title';
		$add['rus'] = 'Доступ запрещен';
		$add['eng'] = "Access denied";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = '_401_notice';
		$add['rus'] = 'Не могу отобразить содержимое, сорян';
		$add['eng'] = "Can't display the content.";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
	//============================	
	return $local_mas;	

}
	
?>