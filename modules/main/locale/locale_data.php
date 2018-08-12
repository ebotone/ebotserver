<?php

function getMainMas()
{
	$local_mas = array();
	
		$add = array();
		
		$add['abv'] = 'init_title';
		$add['rus'] = 'Добро пожаловать!';
		$add['eng'] = "Welcome!";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'init_notice';
		$add['rus'] = 'Вас приветствует';
		$add['eng'] = "welcomes you";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'init_go_registration';
		$add['rus'] = 'Создать учетную запись';
		$add['eng'] = "Create new account";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'main_text';
		$add['rus'] = 'Ebot Server - Серверный фреймворк для разработки ботов на платформе Ebot Studio 2018';
		$add['eng'] = 'About Server - server framework for developing bots on the About Studio 2018 platform';
		$add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'tables_init_false';
		$add['rus'] = 'Системные таблицы не инициализированы. Для инициализации нажмите кнопку "Создать таблицы"';
		$add['eng'] = 'System tables are not initialized. To initialize, click the Create tables button"';
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'tables_init';
		$add['rus'] = 'Создать таблицы';
		$add['eng'] = "Create tables";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'init_tables';
		$add['rus'] = 'Инициализация таблиц';
		$add['eng'] = "Initialization tables'";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'init_users';
		$add['rus'] = 'Инициализация пользователей';
		$add['eng'] = "Initialization users'";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'questions_init';
		$add['rus'] = 'Инициализация Модуля вопросов';
		$add['eng'] = "Initializing the questions Module";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'system_init_true';
		$add['rus'] = 'Система готова к работе, Вы можете зайти под своим login.';
		$add['eng'] = "The system is ready to work, you can go under your login.";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'db_pre';
		$add['rus'] = 'Префикс таблиц в базе данных';
		$add['eng'] = "The table prefix in the database";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'dir_project';
		$add['rus'] = 'Путь к файлам проекта';
		$add['eng'] = "The path to the project files";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
	//============================	
	return $local_mas;	

}
	
?>