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
			
			#registration_go_status{color:#ff0000; margin-top:5px}
			.reg_var{border:1px solid #808080; padding:10px}	
			
		</style>
	
		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">			
		  
			<div class="container">

			  <form class="form-signin" role="form">
				<h2 class="form-signin-heading">' .  $locale->getLocale('registration_title', $lng) . '</h2>';
				
				
				$count_registration_mas = count($registration_mas);
				
				for($k = 0; $k < $count_registration_mas; $k++)
				{
					if($count_registration_mas > 1)
						$con .= '<div class="reg_var">';
					
					if($registration_mas[$k] == 'vk')
					{
						
						$con .= '<div align="center"><img class="vk_login_btn" src="' . $dir_project . '/images/vk.png" width="50px"></div>';
						
					}				
					
					
					if($registration_mas[$k] == 'tg')
					{
						$con .= '	
						
							<input type="text" id="nikname" class="form-control" placeholder="' .  $locale->getLocale('nikname', $lng) . '" required autofocus>
							<input type="password" id="reg_password" class="form-control" placeholder="' .  $locale->getLocale('password', $lng) . '" required>
							<input type="password" id="reg_password2" class="form-control" placeholder="' .  $locale->getLocale('password2', $lng) . '" required>				
				
							<div class="received_code">' .  $locale->getLocale('Received_code_title', $lng) . ' <a href="tg://resolve?domain=' . $Registration_bot_name . '" target="_blank">@' . $Registration_bot_name . '</a></div>
				
							<input type="text" id="code" class="form-control" placeholder="' .  $locale->getLocale('code', $lng) . '" required>
							<button class="btn btn-lg btn-primary btn-block" type="submit" id="registration_go"><i class="fa fa-sign-in" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('registration_go', $lng) . '</button>	
							';						
						
					}
					
					if($count_registration_mas > 1)
						$con .= '</div>';
					
					if(($k + 1) < $count_registration_mas)
						$con .= "<div align='center'><b>ИЛИ</b></div>";
				}
								
				
				
				$con .= '			
				
				<div id="registration_go_status"></div>
				
			  </form>

			</div> <!-- /container -->		  
		  
			<br><br><br><br><br><br><br><br><br>
		  
			<script>
			
				
			
				$(document).ready(function(){
					
					$("#registration_go").bind("click");					
					$("#registration_go").click(function(){
						
						$("#registration_go_status").html("' . $locale->getLocale('registration', $lng) . '...");
						
						var nikname = $("#nikname").val().trim();
						var reg_password = $("#reg_password").val().trim();
						var reg_password2 = $("#reg_password2").val().trim();
						var code = $("#code").val().trim();
						
						if(nikname != "" && reg_password != "" && code != "")
						{			
							if(reg_password == reg_password2)
							{
								var password_md5 = $.md5(reg_password);
								
								var data = "login=" + nikname + "&password_md5=" + password_md5 + "&hash=" + code;
									  
								$.ajax({						
								type: "GET",
								url: "' . $dir_project . '/modules/registration/registration_go.php?lng=' . $lng . '",
								data: data,
								success: function(msg){

									msg = JSON.parse(msg);
									
									if(msg.status == "location")
										document.location.href = msg.con;
									else
										$("#registration_go_status").html(msg.con);									
									
										
										
								}});								
							}
							else
								$("#registration_go_status").html("' . $locale->getLocale('password_error_1', $lng) . '");
					

							
						}
						else
							$("#registration_go_status").html("' . $locale->getLocale('fields_need', $lng) . '");
						
						return false;
						
					});
					
				});
			
			</script>		  
		  
		  
		</div>

	';	
	
	return $con;	

}

?>