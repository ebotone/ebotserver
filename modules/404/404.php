<?php


function getContent($data)
{
	$locale = $data['locale'];
	$user_data = $data['user_data'];
	$lng = $data['lng'];
	
	$con = '';
	
		$about_link = getModuleLink('main');
		
		$con .= '
		
			<style>
			
				.jumbotron{margin-top:10px}
				
			</style>		

			<!-- Main jumbotron for a primary marketing message or call to action -->
			<div class="jumbotron">
			  <div class="container">
				<h1>' . $locale->getLocale('_404_title', $lng) . '</h1>
				<p>' . $locale->getLocale('_404_notice', $lng) . '</p>
				<p><a href="' . $about_link . '" class="btn btn-primary btn-lg" role="button">' .  $locale->getLocale('_go_to_home', $lng) . ' &raquo;</a></p>
			  </div>
			</div>

		';	
	
	return $con;	

}

?>