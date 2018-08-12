<?php

require_once(realpath(__DIR__) . '/../../data_utils.php');
require_once(realpath(__DIR__) . '/settings.php');
require_once(realpath(__DIR__) . '/questions_utils.php');

function getContent($data)
{
	global $dir_project, $questions_type_mas, $HTTP, $HTTP_HOST, $key_md5, $bot_id, $admin_chat_id, $virtual_buttons_data;
	
	$locale = $data['locale'];
	$user_data = $data['user_data'];
	$lng = $data['lng'];
	
	$group_id = $_GET['group_id'];
	$el_id = $_GET['el_id'];
	
	$con = '';
	
	$questions_link = getModuleLink('questions');
	
	$con .= '

		<script type="text/javascript" src="https://ebot.one/js/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
		
		<style>
		
			.jumbotron{margin-top:10px}
			#group_question_add_status{color:#ff0000}
			#group_question_add{margin-top:10px}
			.els_table{min-width:300px; margin-bottom:5px}
			
			.alert{margin-top:0px}
			
		</style>	
		
	
		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
		  <div class="container" style="padding-top:20px">
			
			';			
			
			if($HTTP == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>HTTP</b></div>';
			
			if($HTTP_HOST == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>HTTP_HOST</b></div>';

			if($key_md5 == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>key_md5</b></div>';

			if($bot_id == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>bot_id</b></div>';

			if($admin_chat_id == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>admin_chat_id</b></div>';	

			if($virtual_buttons_data == '')			
				$con .= '<div class="alert alert-danger">' .  $locale->getLocale('must_define', $lng) . ' <b>virtual_buttons_data</b></div>';				
			
			$con .= '<div class="panel panel-info">
			  <!-- Default panel contents -->
			  <div class="panel-heading">' .  $locale->getLocale('Questions_group', $lng) . '</div>
			  <div class="panel-body">
				';				
				
				$con .= '	
							<p align="right"><span class="btn btn-primary btn-lg" role="button" id="group_question_add"><i class="fa fa-plus" aria-hidden="true"></i> ' .  $locale->getLocale('group_question_add', $lng) . '</span></p>
							' . $count_objects_is_available . '
							<span id="group_question_add_status"></span>
						';					

			$group_list = getQuestionsGroupsList();

			$count_group_list = count($group_list);	
			
			if($count_group_list > 0)			
				$con .= "<div style='border-top:1px solid #808080; margin:10px 0px 10px 0px'></div>";				
			
			for($k = 0; $k < $count_group_list; $k++)
			{
				$group_name = $group_list[$k]['group_name'];
					
				$con .= '<table class="els_table">';	
				$con .= '<tr><td>';	
					
					if($group_id > 0 && $group_id == $group_list[$k]['id'])	
					{
						$con .= '<div style="padding:2px">' . $group_name . '</div>';	
						
						$group_act_name = $group_name;
					}
					else
					{		
						$question_id_first = getFirstElByQuestionsGroupsId($group_list[$k]['id']);
						
						$data_link = array();
						
							$add = array();
							$add['key'] = 'group_id';
							$add['val'] = $group_list[$k]['id'];
							
						$data_link[] = $add;

							$add = array();
							$add['key'] = 'el_id';
							$add['val'] = $question_id_first;
							
						$data_link[] = $add;						
						
						$group_id_link = getModuleLinkArgs($data_link);							
						
						$con .= '<div style="padding:2px"><a href="' . $questions_link . $group_id_link . '" style="color:#6998C6">' . $group_name . '</a></div>';	
					}				
						
					$con .= '</td>';					

					$con .= '<td width="50px" align="right"><button class="btn btn-lg btn-warning btn-block group_question_del" el_name="' . $group_name . '" el_id="' . $group_list[$k]['id'] . '"><i class="fa fa-trash" aria-hidden="true" style="font-size:15px"></i> ' .  $locale->getLocale('delete', $lng) . '</button></td>';	
					

				$con .= '</table>';			
				
			}	
			
			


					
		
		$con .= '	
		  </div>
		</div>  ';	
		
		
		if($group_act_name != "")
		{			
			$group_data = getGroupQuestionDataById($group_id);
			
			$php_start = $group_data['php_start'];
			$php_end = $group_data['php_end'];
			$sps = $group_data['sps'];
			$gname = $group_data['gname'];
			
			$con .= '<div class="panel panel-info" style="margin-top:20px">
			  <!-- Default panel contents -->
			  <div class="panel-heading">' .  $group_act_name . '</div>
			  <div class="panel-body">
				';				
			
			$edit_box = '';
			
			$edit_box .= "
			
			<div class='edit_box'>			
				
				<div><b>ID:</b> " . $group_id . "</div>";
				
				$edit_box .= "					
					<div>
						" . $locale->getLocale('Group_title', $lng) . ":<br>
						<input type='text' name='group_name' id='group_name' value='" . $group_act_name . "'>
					</div>
					<div>
						" . $locale->getLocale('Group_php_start_title', $lng) . ":<br>
						<input type='text' name='php_start' id='php_start' value='" . $php_start . "'>
					</div>						
					<div>
						" . $locale->getLocale('Group_php_end_title', $lng) . ":<br>
						<input type='text' name='php_end' id='php_end' value='" . $php_end . "'>
					</div>		
					<div>
						" . $locale->getLocale('Group_sps_title', $lng) . ":<br>
						<input type='text' name='sps' id='sps' value='" . $sps . "'>
					</div>					
					<div>
						" . $locale->getLocale('Group_gname_title', $lng) . ":<br>
						<input type='text' name='gname' id='gname' value='" . $gname . "'>
					</div>";					
				
			$edit_box .= "</div>";
			
	
			
			$edit_box .= '
				<div align="right" style="margin-top:10px">
					<span class="btn btn-primary btn-lg" role="button" id="btn_group_save" group_id="' . $group_id . '"><i class="fa fa-save" aria-hidden="true"></i> <b>' . $locale->getLocale('Save', $lng) . '</b></span>
				</div>	
				
				<div id="group_save_status" style="color:#ff0000"></div>
				
					';	
			
				
			$con .= $edit_box;	
			
			$con .= '	
			  </div>
			</div>  ';				
			
		}		

		//=====================================================

		if($group_act_name != "")
		{
			
			$con .= '<div class="panel panel-info" style="margin-top:20px">
			  <!-- Default panel contents -->
			  <div class="panel-heading">' .  $locale->getLocale('Questions', $lng) . ' "' . $group_act_name . '"</div>
			  <div class="panel-body">
				';				
			

				$con .= '
					<div align="right" style="margin-top:10px">
						<span class="btn btn-primary btn-lg" role="button" id="question_add" group_id="' . $group_id . '"><i class="fa fa-plus" aria-hidden="true"></i> <b>' . $locale->getLocale('Add_question', $lng) . '</b></span>
					</div>	
					
					<div id="question_add_status" style="color:#ff0000"></div>
					
						';	

			
			
			$els_list = getQuestionsListByGroupId($group_id);

			$count_els_list = count($els_list);
			
			if($count_els_list > 0)			
				$con .= "<div style='border-top:1px solid #808080; margin:10px 0px 10px 0px'></div>";	
			
			$con .= '<ul id="sortable" style="width:100%; list-style-type:none; padding-left:0px">';

			for($k = 0; $k < $count_els_list; $k++)
			{
				$con .= '<li class="sortable_el" el_id="' . $els_list[$k]['id'] . '">';
				
					$con .= '<table class="els_table" border=0>';						
						$con .= '<tr><td>';
						
							$name = $els_list[$k]['name'];
								
							if($el_id > 0 && $el_id == $els_list[$k]['id'])	
							{
								$con .= '<div style="padding:2px">' . $name . '</div>';	
								
								$questions_act_name = $name;
							}
							else
							{		
								$question_id_first = 0;
								
								$data_link = array();
								
									$add = array();
									$add['key'] = 'group_id';
									$add['val'] = $group_id;
									
								$data_link[] = $add;

									$add = array();
									$add['key'] = 'el_id';
									$add['val'] = $els_list[$k]['id'];
									
								$data_link[] = $add;						
								
								$id_link = getModuleLinkArgs($data_link);										
								
								$con .= '<div style="padding:2px"><a href="' . $questions_link . $id_link . '" style="color:#6998C6">' . $name . '</a></div>';	
							}		
						
						$con .= '</td>';					

						$con .= '<td width="50px" style="color:#ff0000" align="right"><span class="btn btn-warning btn-lg question_del" role="button" question_name="' . $name . '" el_id="' . $els_list[$k]['id'] . '"><i class="fa fa-trash" aria-hidden="true"></i> ' .  $locale->getLocale('delete', $lng) . '</span></td>';					

					$con .= '</table>';
					
				$con .= '</li>';			
				
			}		

			$con .= '</ul>';
			
			$con .= '	
			  </div>
			</div>  ';				
			
		}
		
		//=========================================
		
		if($questions_act_name != "")
		{
			$con .= '<div class="panel panel-info" style="margin-top:20px">
			  <!-- Default panel contents -->
			  <div class="panel-heading">' .  $questions_act_name . '</div>
			  <div class="panel-body">
				';				
			
			$el_con = '';
			
			$el_data = getQuestionDataById($el_id);
			
			$el_con .= "
			
			<div class='edit_box'>			
					
				";		
				
				$title = $el_data['title'];
				
				$el_con .= "					
					<div>
						" . $locale->getLocale('Question_title', $lng) . ":<br>
						<input type='text' name='question_title' id='question_title' value='" . $title . "'>
					</div>					
					<div>
						" . $locale->getLocale('Question_name', $lng) . ":<br>
						<input type='text' name='question_name' id='question_name' value='" . $questions_act_name . "'>
					</div>";
					
				$field = $el_data['field'];
					
				$el_con .= "					
					<div>
						" . $locale->getLocale('Question_field', $lng) . ":<br>
						<input class='readonly' type='text' value='" . $field . "' readonly>
					</div>";
					
				$el_con .= "					
					<div>
						" . $locale->getLocale('The_type_of_response', $lng) . ":<br>
						<select id='questions_type_select'>
						";					
					
						$count_type_mas = count($questions_type_mas);
						
						for($t = 0; $t < $count_type_mas; $t++)
						{
							$selected = '';
							
							if($el_data['_type'] == $questions_type_mas[$t])
								$selected = ' selected="selected" ';
							
							
							$el_con .= '<option ' . $selected . ' value=' . $questions_type_mas[$t] . '>' . $locale->getLocale($questions_type_mas[$t], $lng) . '</otpion>';						
							
						}					
						
						
				$el_con .= "
						</select>
					</div>";
						
					
				
		
			$el_con .= "</div>";	
			
			$con .= $el_con;	
			
			$con .= '<div style="margin-top:10px; padding-right:3px" align="right">			
					
				<span class="btn btn-primary btn-lg" role="button" id="btn_el_save" el_id="' . $el_id . '"><i class="fa fa-save" aria-hidden="true"></i> <b>' . $locale->getLocale('Save', $lng) . '</b></span>
		
			</div>	';
			
			$con .= '	
			  </div>
			</div>  ';	
			
			
		}		
		
		//=========================================	

		if($php_start != "")
		{
			$last_entry_count = 10;
			$log_script_path = realpath(__DIR__) . '/scripts/' . $php_start;	

			$con .= '

				<style>
					
					.data_class{color:#808080}
					.last_entry{margin:0px 0px 5px 0px; border-top:1px solid #c0c0c0; padding-top:5px}
					.log_file{color:#0000ff}
					.count_log_data{color:#0000ff}
					
				</style>
			
';				
				
				$log_data_system = $locale->getLocale('log_data_system', $lng);		 
				$log_data_system = str_replace('@@script@@', $log_script_path, $log_data_system);	
				$con .= '<h3 style="margin-top:0px">' .  $log_data_system . '</h3>';
				
			
				$con .= '<div class="last_entry"><b>' .  $locale->getLocale('last_entry', $lng) . ' (' . $last_entry_count . '):</b></div>';
						
					
				$log_data = getLog($admin_chat_id, $last_entry_count, $log_script_path);	
				
				$count_log_data = count($log_data);
				
				for($l = 0; $l < $count_log_data; $l++)
				{
					if($log_file_display)
						$log_file = '<span class="log_file">' . $log_data[$l]['log_file'] . '</span>: ';
					
					$con .= '<div><span class="data_class">' . $log_data[$l]['datetime'] . '</span>: ' . $log_file . $log_data[$l]['notice'] . '</div>';
					
				}	
				
				if($count_log_data == 0)
					$con .= '<span class="count_log_data">' . $locale->getLocale('count_log_data_0', $lng) . '</span>';		
			
				$con .= '<div class="last_entry"><b>' .  $locale->getLocale('last_entry_system', $lng) . ' (' . $last_entry_count . '):</b></div>';
					
				$log_data = getLog('sys', $last_entry_count, $log_script_path);	
				
				$count_log_data = count($log_data);
				
				for($l = 0; $l < $count_log_data; $l++)
				{
					if($log_file_display)
						$log_file = '<span class="log_file">' . $log_data[$l]['log_file'] . '</span>: ';
					
					$con .= '<div><span class="data_class">' . $log_data[$l]['datetime'] . '</span>: ' . $log_file . $log_data[$l]['notice'] . '</div>';
					
				}
				
				if($count_log_data == 0)
					$con .= '<span class="count_log_data">' . $locale->getLocale('count_log_data_0', $lng) . '</span>';		
					
			
			
		}
		
	
		
		
		//=========================================	
			
		$con .= '	
		  </div>
		</div>

	';
	
	$con .= '
	
		<script>
			
			function getDataSort(class_sort, name_id, _type_sort)
			{
				var sort_data_str = "";
				var el_id = 0;
				
				if(_type_sort == "01")
				{
					//Сортировка от 0
					
					var number = 0;
					
					$("." + class_sort).each(function(){
					
						var el_id = $(this).attr(name_id);
						
						sort_data_str += el_id + "_" + number + "@";
						
						number++;
						
					});						
					
				}
				else
				{
					//Обратная сортировка					
					
					var number = $("." + class_sort).length;
					
					$("." + class_sort).each(function(){
					
						var el_id = $(this).attr(name_id);
						
						sort_data_str += el_id + "_" + number + "@";
						
						number--;
						
					});							
					
				}
				
				return sort_data_str;
			}
		
			function updateButtonSort(item_id)
			{		
				var sort_data_str = getDataSort("sortable_el", "el_id", "10");
						
				if(sort_data_str != "")
				{
				
					
					var data = "sort_data_str=" + sort_data_str;
											
					$.ajax({						
					type: "GET",
					url: "' . $dir_project . '/modules/questions/ajax/question_sort.php?lng=' . $lng . '",
					data: data,
					success: function(msg){

						msg = JSON.parse(msg);
						
						$("#question_add_status").html(msg.con);	
						
						if(msg.status == "reload")
							location.reload();
							
					}});		
				
				}				
			
			}			
		
			$(document).ready(function(){
				
				
				$("#group_question_add").bind("click");
				
				$("#group_question_add").click(function(){
				
					$("#group_question_add_status").html("' . $locale->getLocale('Adding', $lng) . '...");
					
					$.ajax({						
					type: "GET",
					url: "' . $dir_project . '/modules/questions/ajax/group_question_add.php?lng=' . $lng . '",
					data: "a=1",
					success: function(msg){

						msg = JSON.parse(msg);
						
						$("#group_question_add_status").html(msg.con);	
						
						if(msg.status == "reload")
							location.reload();

							
					}});
					
					
				});		
				
				$(".group_question_del").bind("click");
				
				$(".group_question_del").click(function(){

					var el_id = $(this).attr("el_id");
					var el_name = $(this).attr("el_name");
											
					if(confirm("' . $locale->getLocale('Delete_go', $lng) . ' " + el_name + "?...") && el_id > 0)
					{
						$("#group_question_add_status").html("' . $locale->getLocale('Deleting', $lng) . '...");
					
						$.ajax({						
						type: "GET",
						url: "' . $dir_project . '/modules/questions/ajax/group_question_del.php?lng=' . $lng . '",
						data: "el_id=" + el_id,
						success: function(msg){

							msg = JSON.parse(msg);
							
							$("#group_question_add_status").html(msg.con);	
							
							if(msg.status == "reload")
								location.reload();						

								
						}});							
						
					}

					
					
				});	
				
				$("#question_add").bind("click");
				
				$("#question_add").click(function(){

					var group_id = $(this).attr("group_id");
				
					$("#question_add_status").html("' . $locale->getLocale('Adding', $lng) . '...");
					
					$.ajax({						
					type: "GET",
					url: "' . $dir_project . '/modules/questions/ajax/question_add.php?lng=' . $lng . '",
					data: "group_id=" + group_id,
					success: function(msg){
										
						msg = JSON.parse(msg);
						
						$("#question_add_status").html(msg.con);	
						
						if(msg.status == "reload")
							location.reload();	
							
					}});
					
					
				});	
				
				$(".question_del").bind("click");
				
				$(".question_del").click(function(){

					var el_id = $(this).attr("el_id");					
					var question_name = $(this).attr("question_name");
											
					if(confirm("' . $locale->getLocale('Delete_go', $lng) . ' " + question_name + "?...") && el_id > 0)
					{
						$("#question_add_status").html("' . $locale->getLocale('Deleting', $lng) . '...");
					
						$.ajax({						
						type: "GET",
						url: "' . $dir_project . '/modules/questions/ajax/question_del.php?lng=' . $lng . '",
						data: "el_id=" + el_id,
						success: function(msg){

						msg = JSON.parse(msg);
						
						$("#question_add_status").html(msg.con);	
						
						if(msg.status == "reload")
							location.reload();	
								
						}});							
						
					}

					
					
				});						
				
				$("#btn_group_save").bind("click");
				
				$("#btn_group_save").click(function(){		

					var el_id = $(this).attr("group_id");
					
					var group_name = encodeURIComponent($("#group_name").val() + ""); 					
					var php_start = encodeURIComponent($("#php_start").val() + ""); 
					var php_end = encodeURIComponent($("#php_end").val() + ""); 
					var sps = encodeURIComponent($("#sps").val() + ""); 
					var gname = encodeURIComponent($("#gname").val() + ""); 
					
					$("#group_save_status").html("' . $locale->getLocale('Saving', $lng) . '...");
					
					var data = "";						
					data += "el_id=" + el_id;
					
					data += "&name=" + group_name;
					data += "&php_start=" + php_start;
					data += "&php_end=" + php_end;
					data += "&sps=" + sps;
					data += "&gname=" + gname;
					
					if(group_name != "")
					{
						$.ajax({						
						type: "GET",
						url: "' . $dir_project . '/modules/questions/ajax/group_question_save.php?lng=' . $lng . '",
						data: data,
						success: function(msg){
							
							msg = JSON.parse(msg);
							
							$("#group_save_status").html(msg.con);	
							
							if(msg.status == "reload")
								location.reload();								
								
						}});							
						
					}
					else
						$("#group_save_status").html("' . $locale->getLocale('Name_is_empty', $lng) . '");					
				
				});	
				
				
				$("#btn_el_save").bind("click");
				
				$("#btn_el_save").click(function(){

					var el_id = $(this).attr("el_id");
					
					var question_title = encodeURIComponent($("#question_title").val() + ""); 
					var question_name = encodeURIComponent($("#question_name").val() + ""); 
					var questions_type_select = encodeURIComponent($("#questions_type_select").val() + ""); 

					
					$("#el_save_status").html("' . $locale->getLocale('Saving', $lng) . '...");
					
					var data = "";						
					data += "el_id=" + el_id;
				
					
					data += "&title=" + question_title;
					data += "&name=" + question_name;
					data += "&type=" + questions_type_select;

					
					if(question_name != "")
					{
						$.ajax({						
						type: "GET",
						url: "' . $dir_project . '/modules/questions/ajax/question_save.php?lng=' . $lng . '",
						data: data,
						success: function(msg){

							msg = JSON.parse(msg);
							
							$("#el_save_status").html(msg.con);	
							
							if(msg.status == "reload")
								location.reload();	
								
						}});							
						
					}
					else
						$("#el_save_status").html("' . $locale->getLocale('Name_is_empty', $lng) . '");
					
					
				});						

			  $(function() {
				$( "#sortable" ).sortable({
				  update: function( event, ui ) {
				  
					var item_id = $(ui["item"]).attr("el_id");
									  
					updateButtonSort(item_id);
				  
				  }
				});
				$( "#sortable" ).disableSelection();
			  });						
				
			});

		</script>	
		
		';
	
	return $con;	

}

?>