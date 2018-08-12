<?php

function getDemo2Mas()
{
	global $dir_project;
	
	$local_mas = array();	

		$add = array();
		
		$add['abv'] = 'getEditorData_error_1';
		$add['rus'] = 'Данные с редактора не могут быть получены. Укажите в файле settings.php значение для поля key_md5';
		$add['eng'] = "Data from the editor cannot be retrieved. Specify settings in the file.php value for key_md5 field";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'getEditorData_error_2';
		$add['rus'] = 'Данные с редактора не могут быть получены. Укажите в файле settings.php значение для поля admin_user_id';
		$add['eng'] = "Data from the editor cannot be retrieved. Specify settings in settings.php value for admin_user_id field";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'getEditorData_error_3';
		$add['rus'] = 'Данные с редактора не получены. Одно из значений key_md5 или admin_user_id в файле settings.php неправильны. Перепроверьте их корректность.';
		$add['eng'] = "No data was received from the editor. One of the key_md5 or admin_user_id values in the settings.php is wrong. Verify their correctness.";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'demo_script_title';
		$add['rus'] = 'Заголовок';
		$add['eng'] = "Header";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'demo_script_notice';
		$add['rus'] = 'Вас приветствует Ebot Server. Это сообщение сгенерировано демо сктиптом get_demo2.php а этот текст можно отредактировать в массиве файла locale_data.php по пути к текущему демо модулю /modules/demo2/locale/locale_data.php';
		$add['eng'] = "Welcome to Reboot Server. This message was generated by the demo script get_demo2.php and this text can be edited in the file array locale_data.php on the path to the current demo module /modules/demo2/locale/locale_data.php";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'hello';
		$add['rus'] = 'Привет';
		$add['eng'] = "Hello";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
	//============================	
	return $local_mas;	

}
	
?>