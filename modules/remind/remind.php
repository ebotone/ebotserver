<?php

function getContent($data)
{
	global $Registration_bot_name, $dir_project;
	
	$locale = $data['locale'];
	$user_data = $data['user_data'];
	$lng = $data['lng'];
	
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
			.form-signin input[type="password"] {
			  margin-bottom: 10px;
			  border-top-left-radius: 0;
			  border-top-right-radius: 0;
			}		
			
			.received_code{margin-bottom:10px}
			
			#remind_go_status{color:#ff0000; margin-top:5px}
		
		</style>
	
		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">			
		  
			<div class="container">

			  <form class="form-signin" role="form">
				<h2 class="form-signin-heading">' .  $locale->getLocale('remind_title', $lng) . '</h2>
				<input type="password" id="reg_password" class="form-control" placeholder="' .  $locale->getLocale('password', $lng) . '" required>
				<input type="password" id="reg_password2" class="form-control" placeholder="' .  $locale->getLocale('password2', $lng) . '" required>				
				
				<div class="received_code">' .  $locale->getLocale('Received_code_title', $lng) . ' <a href="tg://resolve?domain=' . $Registration_bot_name . '" target="_blank">@' . $Registration_bot_name . '</a></div>
				
				<input type="text" id="code" class="form-control" placeholder="' .  $locale->getLocale('code_to_reset', $lng) . '" required autofocus>
				<button class="btn btn-lg btn-primary btn-block" type="submit" id="remind_go"><i class="fa fa-save" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('remind_go', $lng) . '</button>
				
				<div id="remind_go_status"></div>
				
			  </form>

			</div> <!-- /container -->			  

		  
			<script>				
			
				$(document).ready(function(){
					
					$("#remind_go").bind("click");					
					$("#remind_go").click(function(){
						
						$("#remind_go_status").html("' . $locale->getLocale('save', $lng) . '...");
							
						var reg_password = $("#reg_password").val().trim();
						var reg_password2 = $("#reg_password2").val().trim();
						var code = $("#code").val().trim();
						
						if(reg_password != "" && code != "")
						{			
							if(reg_password == reg_password2)
							{
								var password_md5 = $.md5(reg_password);
								
								var data = "password_md5=" + password_md5 + "&code=" + code;
									  
								$.ajax({						
								type: "GET",
								url: "' . $dir_project . '/modules/remind/remind_go.php?lng=' . $lng . '",
								data: data,
								success: function(msg){							
								
									msg = JSON.parse(msg);
									
									if(msg.status == "reload")
										location.reload();
									else
										$("#remind_go_status").html(msg.con);									
									
										
										
								}});								
							}
							else
								$("#remind_go_status").html("' . $locale->getLocale('password_error_1', $lng) . '");
					

							
						}
						else
							$("#remind_go_status").html("' . $locale->getLocale('fields_need', $lng) . '");
						
						return false;
						
					});
					
				});
			
			</script>		  
		  
		  
		</div>

	';	
	
	return $con;	

}

?>