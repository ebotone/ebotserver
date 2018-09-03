<?php
include_once(realpath(__DIR__) . '/includes/session_inc.php');
require_once(realpath(__DIR__) . '/db_connect.php');
require_once(realpath(__DIR__) . '/login/login_utils.php');
require_once(realpath(__DIR__) . '/user_utils.php');
require_once(realpath(__DIR__) . '/settings.php');

$module = $_GET['module'];
$lng = $_GET['lng'];

require_once(realpath(__DIR__) . '/modules/modules_utils.php');

if($ok)
{	
	//ini_set('error_reporting', E_ALL);
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	
	$tables_init_ok = getTablesInit();//Проверяем наличие основных таблиц в базе (одной достаточно - проверим наличие таблицы пользователей)
	
	if($tables_init_ok)
		$user_data = getUserData($sid);
	
	$user_status = $user_data['status'];	
	$user_id = $user_data['user_id'];		
	
	//=========== lng ================
	
	if($lng == '')	
		$lng = $_SESSION['lng'];
	
	if($lng == '' && $user_id > 0)	
		$lng = $user_data['lng'];	
	
	if($lng == '')
		$lng = $lng_default;	
	//=========== lng ================

	$__session = $_SESSION;
	session_write_close();	
	
	
	//=========== module ================	
	
	$module_default = getModuleDefaultByUser($user_status);//В зависимости от того кто по статусу юзер - у него и модуль загрузится или админский или нет
	
	if($module == '')//только зашли
	{
		$module = $module_default;
	}	
	
	if(file_exists(realpath(__DIR__) . '/modules/' . $module . '/' . $module . '.php'))
	{
		//Все впоряде
	}
	else
		$module = '404';
	
	//А может доступ закрыт?
	
	if(!getModuleAccess($module, $user_status))
		$module = '401';	
	
	//=========== module ================		
		
	//=========== locale ================
		
	require_once(realpath(__DIR__) . '/locale/locale_data.php');//Локаль базовая (слова типа "Регистрация" и т.д.)
	
	if(file_exists(realpath(__DIR__) . '/modules/' . $module . '/locale/locale_data.php'))
		require_once(realpath(__DIR__) . '/modules/' . $module . '/locale/locale_data.php');

	require_once(realpath(__DIR__) . '/locale/locale_utils.php');	
		
	$locale_includes = array();
	$locale_includes[] = 'default';

	if($module != '')
		$locale_includes[] = $module;

	$locale_data = array();
	$locale_data['lng_default'] = $lng_default;
	$locale_data['includes'] = $locale_includes;

	$locale = new _locale($locale_data);	
	
	//=========== locale  ================
	
	//=========== navbar ================		
		
	$title = $locale->getLocale($module, $lng);
	$Page_this_name = $locale->getLocale($module, $lng);	
	
	$project_name = '<a class="navbar-brand" style="color:#428bca" href="' . getModuleLink('main') . '">' . $Company . '</a>';    
	
	$navbar = "";
	
	//echo $user_status;
	
	$user_data_modules = getModulesByStatus($user_status);
	
	$user_modules_view = $user_data_modules['modules_view'];	
	
	$count_user_modules_view = count($user_modules_view);
	
	for($k = 0; $k < $count_user_modules_view; $k++)
	{
		$add_el_menu = true;
		
		if(!$tables_init_ok)
		{
			if($user_modules_view[$k] == 'registration' || $user_modules_view[$k] == 'remind')
			{
				$add_el_menu = false;//Мы еще не инициализированы. Даже если регистрация включена - эти кнопки не покажем
				
			}
			
		}
		
		if($add_el_menu)
		{
			$link_module = getModuleLink($user_modules_view[$k]);
			
			if($modules_navbar_icons)
			{
			
				$icon = '<i class="fa ' . getModuleIcon($user_modules_view[$k]) . '" aria-hidden="true" style="font-size:15px"></i> ';
				
			}	
			
			if($user_modules_view[$k] == $module)
				$navbar .= '<li class="active"><a href="' . $link_module . '">' . $icon . $locale->getLocale($user_modules_view[$k], $lng) . '</a></li>';
			else
			{
				$href = getModuleHref($user_modules_view[$k]);
				
				if($href != "")
					$navbar .= '<li><a href="' . $href . '" target="_blank">' . $icon . $locale->getLocale($user_modules_view[$k], $lng) . '</a></li>';
				else
					$navbar .= '<li><a href="' . $link_module . '">' . $icon . $locale->getLocale($user_modules_view[$k], $lng) . '</a></li>';
			}			
			
		}
		
		

			
	}

	// Array ( [status] => admin [modules_access] => Array ( [0] => main [1] => 404 [2] => admin [3] => tasks ) [modules_view] => Array ( [0] => main [1] => 404 [2] => admin [3] => tasks ) [base_module] => admin )
		
	//=========== navbar ================	
	
	include (realpath(__DIR__) . '/modules/' . $module . '/' . $module . '.php');
	
	
	
	if($fonts_local)
	{
		$fonts = '
		
			<script defer src="' . $dir_project . '/fonts/fontawesome-free-5.0.6/svg-with-js/js/fa-brands.min.js"></script>	
			<script defer src="' . $dir_project . '/fonts/fontawesome-free-5.0.6/svg-with-js/js/fa-regular.min.js"></script>	
			<script defer src="' . $dir_project . '/fonts/fontawesome-free-5.0.6/svg-with-js/js/fa-solid.min.js"></script>	
			<script defer src="' . $dir_project . '/fonts/fontawesome-free-5.0.6/svg-with-js/js/fa-v4-shims.min.js"></script>	
			<script defer src="' . $dir_project . '/fonts/fontawesome-free-5.0.6/svg-with-js/js/fontawesome-all.min.js"></script>		
		
		';
		
		
	}
	else
	{
		$fonts = '
		
			<script src="https://use.fontawesome.com/6e4e294dc6.js"></script>
		
		';
		
	}
	
	$icon_href = "http://ebot.one/images/eb_icon.png";
	
	$con = '		

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<link rel="shortcut icon" href="' . $icon_href . '">
	<meta property="twitter:image" content="' . $icon_href . '" />  
	<meta property="og:image" content="' . $icon_href . '" />  
	<link rel="image_src" href="' . $icon_href . '"/> 	

    <title>' . $title . '</title>
	
	' . $fonts . '

    <!-- Bootstrap core CSS -->
    <link href="' . $dir_project . '/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="' . $dir_project . '/bootstrap/css/bootstrap-select.css" rel="stylesheet">
	
	<meta name="keywords" content="рассылка, рассылка Вконтакте, холодные звонки, привлечение клиентов, поиск клиентов" > 
	<meta name="description" content="SendManager - виртуальный офис. Администрирование холодных сообщений." >
	<meta property="og:title" content="SendManager - виртуальный офис. Администрирование холодных сообщений."/>
	<meta property="og:description" content="SendManager - виртуальный офис. Администрирование холодных сообщений."/>	
	
    <!-- Custom styles for this template -->
    <style>
	
		html{
			position:relative; padding: 0px; margin:0px; height:100%
		}
	
		body {
			padding: 0px; margin: 0px; position:relative; border:1px solid #000;
		}
		

		#login_status{display:inline-block; color:#ff0000; margin-right:10px}
		#logout_status{display:inline-block; color:#ff0000; margin-right:10px}
		#nikname_title{display:inline-block; text-align:right; margin:15px 15px 0px 0px; }
		
		
		#footer {
			position: absolute;
			bottom: 0;
			width: 100%;
			/* Set the fixed height of the footer here */
			height: 50px;	
			padding-top:15px;

		}
		
		.lng_div_act{ width:34px; margin-left:10px; }
		.lng_div{ cursor:pointer;width:34px; margin-left:10px; opacity:.3}
		.lng_img{width:34px}
		
	
	</style>

    <!-- Just for debugging purposes. Dont actually copy this line! -->
    <!--[if lt IE 9]><script src="' . $dir_project . '/js/assets/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="' . $dir_project . '/js/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="' . $dir_project . '/js/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
    <script src="' . $dir_project . '/js/jquery_1_11_0.min.js"></script>
    <script src="' . $dir_project . '/bootstrap/js/bootstrap.min.js"></script>	
	
	<script type="text/javascript" src="' . $dir_project . '/js/jquery.md5.js"></script>	
	
	<script src="' . $dir_project . '/bootstrap/js/bootstrap-select.js"></script>	
  </head>

  <body style="position:relative; min-height:100%;">  

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
      <div class="container" >
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  
		  ' . $project_name . '

        </div>
		
        <div class="navbar-collapse collapse" >
			<ul class="nav navbar-nav">			
		
		' . $navbar . '
		
            </ul>
            <ul class="nav navbar-nav navbar-right">		
		
		';
		
		if($user_id > 0)
		{
			//Ещем в базе
			
			if($user_status == 'sender')
				$name = $user_data['username'];
			else
				$name = $user_data['nikname'];
			
			$con .= '
			<li>

				<span id="logout_status"></span>

				<div class="text-primary" id="nikname_title">' . $name . '</div>
				<button type="submit" id="logout_go" class="btn btn-success"><i class="fa fa-sign-out" aria-hidden="true" style="font-size:15px;"></i> ' . $locale->getLocale('Logout', $lng) . '</button>
			</li>	
			
			<script>
			
				$(document).ready(function(){
					
					$("#logout_go").bind("click");					
					$("#logout_go").click(function(){						
						
						$("#logout_status").html("' . $locale->getLocale('Logout_proccess', $lng) . '...");
						
						var data = "a=1";
							  
						$.ajax({						
						type: "GET",
						url: "' . $dir_project . '/login/logout.php?lng=' . $lng . '",
						data: data,
						success: function(msg){

							msg = JSON.parse(msg);
							
							if(msg.status == "location")
								document.location.href = msg.con;
							else
								$("#logout_status").html(msg.con);	
								
						}});						
						
						
					});
					
				});
			
			</script>			
			
				';
			
		}
		else
		{
			if($tables_init_ok)
			{
				$con .= '
				<li>
				  <form class="navbar-form navbar-right" role="form">
					<div class="form-group">
						<span id="login_status"></span>
					</div>
					<div class="form-group">
					  <input type="text" placeholder="Login or Hash" id="hash" class="form-control" style="width:170px" value="' . $hash . '">
					</div>
					<div class="form-group">
					  <input type="password" id="password" placeholder="Password" class="form-control" style="width:170px">
					</div>
					<button type="submit" id="login_go" class="btn btn-success"><i class="fa fa-sign-in" aria-hidden="true" style="font-size:15px"></i> ' . $locale->getLocale('Login', $lng) . '</button>
				  </form>
				</li>
				
					
				
				<script>
				
					$(document).ready(function(){
						
						$("#login_go").bind("click");					
						$("#login_go").click(function(){
							
							$("#login_status").html("' . $locale->getLocale('Login_proccess', $lng) . '...");
							
							var hash = $("#hash").val().trim();
							var password = $("#password").val().trim();
							
							var password_md5 = $.md5(password);
							
							if(hash != "" && password_md5 != "")
							{				
						
								var data = "hash=" + hash + "&password_md5=" + password_md5;
									  
								$.ajax({						
								type: "GET",
								url: "' . $dir_project . '/login/login.php?lng=' . $lng . '",
								data: data,
								success: function(msg){

									msg = JSON.parse(msg);
									
									if(msg.status == "location")
										document.location.href = msg.con;
									else
										$("#login_status").html(msg.con);	
										
										
								}});
								
							}
							else
								$("#login_status").html("' . $locale->getLocale('fields_need', $lng) . '");
							
							return false;
							
						});
						
					});
				
				</script>
				
				';				
				
			}

		}			
		
		$con .= '
		
			</ul>
		
		</div>
      </div>
    </div>
	

	
	';
	
	//=========== content =============================================================================	
	
	$data = array();
	$data['user_data'] = $user_data;		
	$data['locale'] = $locale;
	$data['lng'] = $lng;
	
	$con .= '<div style="padding-top:0px;">';
	
		$con .= getContent($data);	
	
	$con .= '</div>';
	
	//=========== content =============================================================================		
			
	if(!($user_id > 0) && in_array('vk', $registration_mas))
	{
		require_once(realpath(__DIR__) . '/modules/registration/registration_utils.php');
		
		$con .= getDialogVKlogin();
		
	}
	
	$con .= '
	
	<div id="footer" class="navbar-inverse">
	  <div class="container">      
		
		
		<ul class="nav nav-pills pull-right">';
		
		if($vk_like)
		{
			$con .= '<li>
			
				<!-- Put this script tag to the <head> of your page -->
				<script type="text/javascript" src="https://vk.com/js/api/openapi.js?157"></script>

				<script type="text/javascript">
				  VK.init({apiId: ' . $vk_apiId . ', onlyWidgets: true});
				</script>

				<!-- Put this div tag to the place, where the Like block will be -->
				<div id="vk_like"></div>
				<script type="text/javascript">
				VK.Widgets.Like("vk_like", {type: "button"});
				</script>			
			
			</li>';			
			
		}		
		
		$lng_list = $locale->getLangs();
		
		$count_lng_list = count($lng_list);
		
		for($l = 0; $l < $count_lng_list; $l++)
		{
			if($lng_list[$l] == $lng)
				$con .= '<li class="active"><div class="lng_div_act" lng="' . $lng_list[$l] . '"><img class="lng_img" src="' . $dir_project . '/images/' . $lng_list[$l] . '.png"></div></li>';
			else
				$con .= '<li><div class="lng_div" lng="' . $lng_list[$l] . '"><img class="lng_img" src="' . $dir_project . '/images/' . $lng_list[$l] . '.png"></div></li>';
		}
		
		/*
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>		
		*/
		
		$con .= '
        </ul>
		<p class="text-muted">&copy; Created by <a href="http://ebot.one/@' . $lng . '" target="_blank">Ebot.one</a> 2018</p> 
	  </div>
	</div>	

	<script>
	
		$(document).ready(function(){
			
			$(".lng_div").bind("click");					
			$(".lng_div").click(function(){
				
				$("#login_status").html("' . $locale->getLocale('Lng_proccess', $lng) . '...");
				
				var lng = $(this).attr("lng");		
			
					var data = "lng=" + lng;
						  
					$.ajax({						
					type: "GET",
					url: "' . $dir_project . '/locale/set_lng.php?lng=' . $lng . '",
					data: data,
					success: function(msg){

						location.reload();
							
							
					}});
				
				return false;
				
			});
			
		});
	
	</script>	
	
  </body>
</html>		

';

echo $con;		
	
}
else
	echo "Отсутствует подключение к базе данных. Проверьте настройки в файле settings.php<br><br>There is no connection to the database. Check the settings in the settings file.php";

?>