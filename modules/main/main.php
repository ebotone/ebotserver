<?php

//require_once(realpath(__DIR__) . '/../manager_el/manager_el_utils.php');

function getContent($data)
{
	global $dir_project, $type_links, $test_mode, $registration, $logo_src, $tables_init_ok, $bot_type, $ebot_server, $version, $db_pre, $dir_project, $bot_type;
	
	$locale = $data['locale'];
	$user_data = $data['user_data'];
	$lng = $data['lng'];
	
	$user_id = $user_data['user_id'];
	$user_status = $user_data['status'];	
	
	$con = '';	
	
	$help_link = getModuleLink('help');
	
	$con .= '

		<style>
		
			@media all and (min-width: 766px) and (max-width: 1199px) {

				.jumbotron{margin-top:50px}
			
			}

			@media all and (min-width: 1200)  {

				.jumbotron{margin-top:10px}
			

			}	
			
			.main_text{margin:10px 0px 10px 0px;}
			#tables_init_status{color:#0000ff}
			
			.btn-lg{width:150px}
			.span_title{margin-left:10px}
			
		</style>
	
		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
		  <div class="container">
			<h1>' .  $locale->getLocale('init_title', $lng) . ' </h1>';
			
			$progect_name = $ebot_server . ' ' . $version;
			
			if($lng == 'rus')
				$con .= '<p>' .  $locale->getLocale('init_notice', $lng) . ' ' . $progect_name . '</p>';
			else
				$con .= '<p>' . $progect_name . ' ' .  $locale->getLocale('init_notice', $lng) . '</p>';
			
			if($user_id != "")
			{
				
			}
			else
			{
				if($tables_init_ok && $registration)
				{
					$registration_link = getModuleLink('registration');
					
					$con .= '
					<p><a href="' . $registration_link . '" class="btn btn-primary btn-lg" role="button" style="width:250px"><i class="fa fa-user-plus" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('init_go_registration', $lng) . ' &raquo;</a></p>';
					
				}
				
				
			}		
			
					$con .= '	
					
					<img src="' . $logo_src . '" style="width:100%; max-width:300px">
				';


			if($user_id != "")
			{
				$con .= '
				<p style="margin-top:15px"><a href="' . $help_link . '" class="btn btn-primary btn-lg" role="button" target="_blank"><i class="fa fa-question" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('help', $lng) . '</a></p>';	
				
				$demo_link = getModuleLink('demo');	
				$demo2_link = getModuleLink('demo2');	
				$demo3_link = getModuleLink('demo3');	
				
				if($user_status == 'admin' || $user_status == 'root')
				{
					$con .= '<div style="border-top:1px solid #808080">';
					
						$con .= '
						<p style="margin-top:10px"><a href="' . $demo_link . '" class="btn btn-primary btn-lg" role="button" target="_blank"><i class="fa fa-meh" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('demo', $lng) . '</a> <span class="span_title">' .  $locale->getLocale('demo_title', $lng) . '</span></p>';	
				
						$con .= '
						<p style="margin-top:10px"><a href="' . $demo2_link . '" class="btn btn-primary btn-lg" role="button" target="_blank"><i class="fa fa-meh" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('demo2', $lng) . '</a> <span class="span_title">' .  $locale->getLocale('demo2_title', $lng) . '</span></p>';		

						$con .= '
						<p style="margin-top:10px"><a href="' . $demo3_link . '" class="btn btn-primary btn-lg" role="button" target="_blank"><i class="fa fa-meh" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('demo3', $lng) . '</a> <span class="span_title">' .  $locale->getLocale('demo3_title', $lng) . '</span></p>';							
					
					$con .= '</div>';
					
						if($bot_type == 'vkg')
						{
							$con .= '<div style="border-top:1px solid #808080">';
							
								$proxy_link = getModuleLink('proxy');
								
								$con .= '
								<p style="margin-top:10px"><a href="' . $proxy_link . '" class="btn btn-primary btn-lg" role="button" target="_blank"><i class="fa fa-plug" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('proxy', $lng) . '</a> <span class="span_title">' .  $locale->getLocale('proxy_title', $lng) . '</span></p>';	
							
							$con .= '</div>';
							
						}
					
					
					
				}
				
			
			}
			else
			{
				$con .= "<p class='main_text' style='color:#428bca'><b>" . $locale->getLocale('main_text', $lng) . "</b></p>";
				
				$con .= '
				<p><a href="' . $help_link . '" class="btn btn-primary btn-lg" role="button" target="_blank"><i class="fa fa-question" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('detailed', $lng) . ' &raquo;</a></p>';	

				if($tables_init_ok)
				{
					//Таблицы (системные) созданы
					
					$con .= "<p class='main_text' style='margin-top:30px; color:#4cae4c; font-size:13px; border-top:1px solid #808080; padding-top:20px; text-align:center'><b>" . $locale->getLocale('system_init_true', $lng) . "</b></p>";
				}					
				else
				{
					$con .= "<p class='main_text' style='margin-top:30px; color:#808080; font-size:13px; border-top:1px solid #808080; padding-top:10px'><b>" . $locale->getLocale('tables_init_false', $lng) . "</b></p>";
					
					$con .= '
					<p><span class="btn btn-primary btn-lg" role="button" id="tables_init" style="width:200px"><i class="fa fa-play" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('tables_init', $lng) . '</span></p>
					
					<div id="tables_init_status"></div>
					
					<p>' .  $locale->getLocale('db_pre', $lng) . ': ' . $db_pre . '</p>
					<p>' .  $locale->getLocale('dir_project', $lng) . ': ' . $dir_project . '</p>
					<p>' .  $locale->getLocale('bot_type_title', $lng) . ': ' . $locale->getLocale($bot_type, $lng) . '</p>
					';						
					
					$con .= '
					
					<script>				
					
						var init_scripts = new Array();
					
							var add = new Array();
							
							add["script"] = "tables_init.php";
							add["tables_init_status"] = "' . $locale->getLocale('init_tables', $lng) . '";
					
						init_scripts.push(add);
						
							var add = new Array();
							
							add["script"] = "admin_init.php";
							add["tables_init_status"] = "' . $locale->getLocale('init_users', $lng) . '";
					
						init_scripts.push(add);		

							var add = new Array();
							
							add["script"] = "questions_init.php";
							add["tables_init_status"] = "' . $locale->getLocale('questions_init', $lng) . '";
					
						init_scripts.push(add);	

						function init_go(init_number)
						{						
							$("#tables_init_status").html(init_scripts[init_number]["tables_init_status"] + "...");
						
							var data = "init=1";
								  
							$.ajax({						
							type: "GET",
							url: "' . $dir_project . '/modules/main/ajax/" + init_scripts[init_number]["script"] + "?lng=' . $lng . '",
							data: data,
							success: function(msg){							
							
								msg = JSON.parse(msg);
								
								if(msg.status == "reload")
								{
									init_number++;
									
									if(init_number == init_scripts.length)
										location.reload();
									else
										init_go(init_number);
									
								}	
								else
									$("#tables_init_status").html(msg.con);									
								
									
									
							}});							
							
						}	
					
					
						$(document).ready(function(){								

							
							$("#tables_init").bind("click");					
							$("#tables_init").click(function(){
								
								init_go(0);

								return false;
								
							});
							
						});
					
					</script>							
					
					';								
					
				}
				
			}				
				
						
				
				
			$con .= '
			  </div>
			</div>';	
			
			
		if($user_status == 'admin' || $user_status == 'root')
		{
			
			
		}	
		else
		{	
			
			
			
		}			
			

	
	return $con;	

}

?>