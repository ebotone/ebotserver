<?php

require_once(realpath(__DIR__) . '/../../data_utils.php');
require_once(realpath(__DIR__) . '/admin_utils.php');

function getContent($data)
{
	global $text;
	
	$locale = $data['locale'];
	$user_data = $data['user_data'];
	$lng = $data['lng'];
	
	$chat_id = $_GET['chat_id'];
	
	$con = '';
	
	$admin_link = getModuleLink('admin');
	
	$con .= '

		
		<style>
		
			.jumbotron{margin-top:10px}
			.data_class{color:#808080}
			.last_entry{margin:10px 0px 5px 0px}
			
		</style>	
		
	
		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
		  <div class="container">';
		  
		  if($chat_id > 0)
		  {
			$count = 12;
			  
			$con .= '
				<h3>' .  $chat_id . ' (' . $count . ')</h3>';
				
			$dialogs_data = getLog($chat_id, $count, '');
			
			$count_dialogs_data = count($dialogs_data);
			
			for($k = 0; $k < $count_dialogs_data; $k++)
			{
				$con .= '<div><span class="data_class">' . $dialogs_data[$k]['datetime'] . '</span>: ' . $dialogs_data[$k]['notice'] . '</div>';
				
			}
			  
		  }
		  else
		  {
			  $con .= '
				<h3>' .  $locale->getLocale('number_of_users', $lng) . '</h3>
				<p>' .  getUsersCount() . '</p>
				
				';
				
				$count_users_get = 10;
				
				$con .= '
				
				<h3>' .  $locale->getLocale('recent_users', $lng) . ' (' . $count_users_get . ')</h3>
				<p>';
				
					$users_data = getUsersData($count_users_get);
				
					$count_users_data = count($users_data);
					
					for($u = 0; $u < $count_users_data; $u++)
					{
						if($users_data[$u]['chat_id'] != "")
						{
							$data_link = array();
							
								$add = array();
								$add['key'] = 'chat_id';
								$add['val'] = $users_data[$u]['chat_id'];
								
							$data_link[] = $add;	
							
							$chat_id_id_link = getModuleLinkArgs($data_link);	
						
							$con .= '<div><span class="data_class">' . $users_data[$u]['datetime'] . '</span>: <a href="' . $admin_link . $chat_id_id_link . '">' . $users_data[$u]['chat_id'] . '</a></div>';							
							
						}

						
					}

				$con .=	'</p>';			  
			  
		  }
		  

			
			$con .= '
			
		  </div>
		</div>

	';
	
	return $con;	

}

?>