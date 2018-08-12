<?php

function getAdminMas()
{
	$local_mas = array();	

		$add = array();
		
		$add['abv'] = 'recent_users';
		$add['rus'] = 'Последние пользователи';
		$add['eng'] = "Recent users";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'number_of_users';
		$add['rus'] = 'Количество пользователей';
		$add['eng'] = "Number of users";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
	//============================	
	return $local_mas;	

}
	
?>