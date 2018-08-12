<?php


function getContent($data)
{
	global $dir_project, $module; 
		
	require_once(realpath(__DIR__) . '/' . $module . '_utils.php');
	
	$locale = $data['locale'];
	$user_data = $data['user_data'];
	$lng = $data['lng'];
	
	$con = '';
	
	$user_id = $user_data['user_id'];
	$user_status = $user_data['status'];	
	
	$con .= '
	
		<style>
		
			@media all and (min-width: 766px) and (max-width: 1199px) {

				.jumbotron{margin-top:50px}
			
			}

			@media all and (min-width: 1200)  {

				.jumbotron{margin-top:10px}
			

			}
			
		</style>	

		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
		  <div class="container">
						

			  ' .  $locale->getLocale('page_content', $lng) . '			
				
				
			
			
		</div>
		</div>	
			
	';		
	
	return $con;	

}

?>