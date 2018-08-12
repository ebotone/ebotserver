<?php

function getPageMas()
{
	$local_mas = array();
	
		$add = array();
		
		$add['abv'] = 'page_content';
		$add['rus'] = 'Контент страницы';
		$add['eng'] = "The content of the page";
		$add['deu'] = '';
		
	$local_mas[] = $add;
	
	//============================	
	return $local_mas;	

}
	
?>