<?php


require_once(realpath(__DIR__) . '/../../settings.php');
require_once(realpath(__DIR__) . '/profile_utils.php');

function getContent($data)
{
	global $dir_project;
	
	$locale = $data['locale'];
	$user_data = $data['user_data'];
	$lng = $data['lng'];
	
	$con = '';
	
	$user_id = $user_data['user_id'];
	$user_status = $user_data['status'];
	
	//$main_link = getModuleLink('main');
	
	$con .= '

		<style>

			.form-signin {
			  max-width: 330px;
			  padding: 15px;
			  margin: 0 auto;
			}
			.form-signin .form-signin-heading,
			.form-signin .checkbox {
			  margin-bottom: 10px;
			}
			.form-signin .checkbox {
			  font-weight: normal;
			}
			.form-signin .form-control {
			  position: relative;
			  height: auto;
			  -webkit-box-sizing: border-box;
				 -moz-box-sizing: border-box;
					  box-sizing: border-box;
			  padding: 10px;
			  font-size: 16px;
			}
			.form-signin .form-control:focus {
			  z-index: 2;
			}
			.form-signin input[type="text"] {
			  margin-bottom: 10px;
			  border-bottom-right-radius: 0;
			  border-bottom-left-radius: 0;
			}
			.form-signin input[type="number"] {
			  margin-bottom: 10px;
			  border-bottom-right-radius: 0;
			  border-bottom-left-radius: 0;
			}					
			.form-signin input[type="password"] {
			  margin-bottom: 10px;
			  border-top-left-radius: 0;
			  border-top-right-radius: 0;
			}		
			
			.received_code{margin-bottom:10px}
			
			#referral_code_save_status{color:#ff0000; margin-top:5px}
			
			.sender-form-div{margin-bottom:5px}
			
			.bootstrap-select{}
		
		</style>		';
		

		$data_user_from = getUserDataByRefferalCode($user_data['referral_code']);		
		
		$tariff = $data_user_from['tariff'];
		
		if($tariff > 0)
		{
			
			
		}
		else
			$tariff = 1;
		
		$sender_ebot = false;
		
		if($user_status == 'sender')
		{
			if($user_data['user_parent_id'] == 3)
				$sender_ebot = true;
		}
		
		$con .= '
	
		<style>
		
			.jumbotron{margin-top:20px}
			
		</style>	
	
		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
		  <div class="container">
							

			<form class="form-signin" role="form">';
			
			if($user_status == 'root')
			{				
					
					$con .= '
				
					<div class="sender-form-div"><b>' . $locale->getLocale('password', $lng) . ': </b></div>
					
					<input type="text" id="password" class="form-control" placeholder="' .  $locale->getLocale('password', $lng) . '" value="" required>
					
					<button class="btn btn-lg btn-primary btn-block" id="password_save" el_id="' . $el . '"><i class="fa fa-save" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('to_save', $lng) . '</button>
					
					<div id="password_save_status"></div>	

					<div class="sender-form-div" style="margin-top:20px">' . $locale->getLocale('password_admin_remind', $lng) . '</div>
					
					<script>				
					
						$(document).ready(function(){

						
							$("#password_save").bind("click");					
							$("#password_save").click(function(){
								
								$("#password_save_status").html("' . $locale->getLocale('save', $lng) . '...");
									
								var password = $("#password").val();								
						
								if(password != "")
								{
									var password_md5 = $.md5(password);
									
									if(password_md5 != "")
									{
										var data = "password_md5=" + password_md5;									 								  
											  
										$.ajax({						
										type: "GET",
										url: "' . $dir_project . '/modules/profile/ajax/admin_login_update.php?lng=' . $lng . '",
										data: data,
										success: function(msg){							
							
											msg = JSON.parse(msg);
											
											if(msg.status == "reload")
												location.reload();
											else
												$("#password_save_status").html(msg.con);									
											
												
												
										}});										
										
									}
									else
										$("#password_save_status").html("' . $locale->getLocale('fields_need', $lng) . '");				

									
								}
								else
									$("#password_save_status").html("' . $locale->getLocale('fields_need', $lng) . '");
								
								return false;
								
							});		

						});

					</script>	
';
								
				
			}
			


				
				
			$con .= '	
			</form>	
			
		  </div>
		</div>

	';	
	
	return $con;	

}

?>