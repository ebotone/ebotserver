<?php
//===========================================
//Версия
$version = "1.1.5";
$ebot_server = "Ebot Server";

//===========================================
//Подключение к базе данных

$db_host = 'localhost';//localhost
$db_login = '';
$db_passwd = '';
$db_database = '';

//===========================================
//Таблицы в базе данных

$db_pre = "";//Префикс таблиц в базе данных. Т.е. если префикс, например "_" то таблица пользователей назовется как _ebot_users

$name_table_users = $db_pre . 'ebot_users';//Таблица для хранения пользователей
$name_table_logs = $db_pre . 'ebot_logs';//Таблица для хранения логов и диалогов
$name_table_sessions = $db_pre . 'ebot_sessions';//Таблица для сессий

$dir_project = '/all/ebot_server';

//===========================================
//Настройки хоста редактора

$HTTP = 'https';//http или https
$HTTP_HOST = 'ebot.one';//Например, ebot.one

//===========================================
//Настройки бота

$bot_type = 'telegram';//telegram или vkg (бот для групп вконтакте)

$bot_id = '';
$key_md5 = md5('');//md5 от значения BOT_EDITOR_KEY (его можно получить в настройких бота в редакторе в пункте где указан API KEY от ботфазера)
$bot_api_key = '';//API KEY от ботфазера. Нужен, в случае если вам потребуется принимать на сервере (здесь) файлы от бота, например аудио
$admin_user_id = '';//Id учетки в редакторе. Отображается на главной странице редактора в самом верху после входа в систему

//admin_chat_id - ДЛЯ БОТОВ telegram и для vkg (бот для групп вконтакте)
/*
	Для telegram - это chat_id администратора (т.е. Ваш в данном случае). Это значение можно получить от бота, написав ему getChatId. Для корректной работы всех механизмов, которые используют это значение chat_id необходимо прописать его в настройках бота в редакторе в поле Chat_id

	Для vkg - это ID Вконтакте с которого вы хотите фиксировать сообщения в лог. Для удобства - это Ваш ID Вконтакте.
	
*/

$admin_chat_id = '';//Это chat_id администратора (т.е. Ваш в данном случае). Это значение можно получить от бота, написав ему getChatId. Для корректной работы всех механизмов, которые используют это значение chat_id необходимо прописать его в настройках бота в редакторе в поле Chat_id

//ТОЛЬКО ДЛЯ БОТОВ telegram
$virtual_buttons_data = '';//IDCommand@@IDButton - где IDCommand - ID Скрытой команды в боте с названием "Виртуальные кнопки", а IDButton - ID кнопки, которая создана в этой команде. У кнопки достаточно указать имя, например, test. Пример 26948@@5245

//ТОЛЬКО ДЛЯ БОТОВ vkg (боты в группах Вконтакте)
$group_token = '';//Получается в ВАША_ГРУППА_ВКОНТАКТЕ->Управление сообществом->Работа с API->Ключи доступа
$group_id = '';//Можно найти в ВАША_ГРУППА_ВКОНТАКТЕ->Управление сообществом->Работа с API->Callback API

//===========================================

$Company = $ebot_server . ' ' . $version;//Этот текст отражается в шапке проекта и его подвале
$Registration_bot_name = 'ebot_server_bot';//Имя бота через которого будет получен код для регистрации (Ваш бот). Имя бота без знака собаки
$vk_apiId = '';//apiId можно получить тут: https://vk.com/apps?act=manage
$vk_APP_SHARED_SECRET = '';//APP_SHARED_SECRET можно получить тут: https://vk.com/apps?act=manage

$logo_src = 'http://ebot.one/images/ebot_server_logo.png';//Лого на главной (модуль main)

$yandex_key = '';//Yandex SpeechKit KEY

//===========================================
//Регистрация произвольных пользователей на сайте

$registration = false;

$registration_mas = [];//Способы рагистрации
//$registration_mas[] = 'vk';//Необходим vk_apiId и vk_APP_SHARED_SECRET
//$registration_mas[] = 'tg';//Необходим Registration_bot_name

//===========================================
//Кнопка "мне нравится" Вконтакте
$vk_like = true;//Необходим vk_apiId

//===========================================
//Ведение логов

$log_system = true;//Ведение системные
$log_users = true;//Ведение логов диалогов с ботом
$log_file_display = true;//Показывать ли путь к скрипту при логировании

//===========================================

//Языки и шрифты

$lng_default = 'rus';//Язык по умолчанию. список языков в /locale/locale_utils.php
$fonts_local = true;//Использовать локальную блиблиотеку иконок или грузить с сайта fontawesome.com (в случае если false папку fonts можно удалить)
$modules_navbar_icons = true;//Видны ли иконки разделов в навигационной панели

//===========================================
//Тип ссылок

$type_links = 'args';//args/chpu

//===========================================
//test_mode

$test_mode = 0;//Просто переменная для тестов она может пригодиться в любом проекте

//===========================================
//Модули (Разделы)

$modules = array();

	$add = array();//Стартовый модуль если юзер еще не залогинился
	$add['name'] = 'main';//Обязательный. Имя модуля. Под него должна быть папка
	$add['icon'] = 'fa-home';
	
$modules[] = $add;	

	$add = array();//Модуль если название модуля передали, но молуль не нашли
	$add['name'] = '404';
	$add['icon'] = 'fa-bell';
	
$modules[] = $add;	

	$add = array();//Модуль если ошибка доступа к модулю
	$add['name'] = '401';
	$add['icon'] = 'fa-bell';
	
$modules[] = $add;	

if($registration)
{
		$add = array();
		$add['name'] = 'registration';
		$add['icon'] = 'fa-user-plus';
		
	$modules[] = $add;	
	
		$add = array();
		$add['name'] = 'remind';
		$add['icon'] = 'fa-bell';
		
	$modules[] = $add;		
	
}

	$add = array();
	$add['name'] = 'admin';//Обязательный.
	$add['icon'] = 'fa-cog';
	
$modules[] = $add;	
	

	$add = array();
	$add['name'] = 'demo';
	$add['icon'] = 'fa-meh';
	
$modules[] = $add;		


	$add = array();
	$add['name'] = 'demo2';
	$add['icon'] = 'fa-meh';
	
$modules[] = $add;	

	$add = array();
	$add['name'] = 'demo3';
	$add['icon'] = 'fa-meh';
	
$modules[] = $add;		

	$add = array();
	$add['name'] = 'questions';
	$add['icon'] = 'fa-list';
	
$modules[] = $add;	

	$add = array();
	$add['name'] = 'help';
	$add['icon'] = 'fa-question';
	$add['href'] = 'http://ebot.one/wiki/index.php/Ebot_Server';
	
$modules[] = $add;	

	$add = array();
	$add['name'] = 'profile';
	$add['icon'] = 'fa-cogs';
	
$modules[] = $add;		

	$add = array();
	$add['name'] = 'page';
	$add['icon'] = 'fa-meh';
	
$modules[] = $add;	

	$add = array();
	$add['name'] = 'proxy';
	$add['icon'] = 'fa-meh';
	
$modules[] = $add;	

//===========================================
//Пользовательские модули (можете начинать складывать сюда (в папку scripts) скрипты для ваших url_resp):

//Первый пользовательский модуль:
	$add = array();
	$add['name'] = 'url_resp';
	$add['icon'] = 'fa-meh';
	
$modules[] = $add;		
	
//Второй пользовательский модуль:

	//Добавь свой :)

//===========================================
//Статусы пользователей и кому какие модули (Разделы) видны и доступны

$modules_list = array();

	$add = array();
	$add['status'] = '';//Все кто пришел на сайт (незарегистрированные)
	$add['modules_access'] = array("main", "404", "401", "help");//array("main", "404");//Список разделов которые можно при данном статусе открыть (вручную, например или по ссылке). 
	$add['modules_view'] = array("help");//Список разделов которые видно в меню. 
	$add['base_module'] = 'main';//Стартовый модуль для незалогиненого пользователя
	
	if($registration)
	{
		$add['modules_access'][] = 'registration';
		$add['modules_access'][] = 'remind';
		
		$add['modules_view'][] = 'registration';
		$add['modules_view'][] = 'remind';		
		
	}
	
$modules_list[] = $add;

	$add = array();
	$add['status'] = 'root';
	$add['modules_access'] = getModulesList();//Доступны все модули
	$add['modules_view'] = getModulesList(array("main", "registration", "remind", "404", "401", "demo", "demo2", "page", "proxy"));//Видны все модули кроме перечисленных в аргументе
	$add['base_module'] = 'admin';//Стартовый модуль для администратора типа root и admin
	
$modules_list[] = $add;

	$add = array();
	$add['status'] = 'admin';
	$add['modules_access'] = getModulesList();//Доступны все модули
	$add['modules_view'] = getModulesList(array("main", "registration", "remind", "404", "401", "demo", "demo2", "page", "proxy"));//Видны все модули кроме перечисленных в аргументе
	$add['base_module'] = 'admin';//Стартовый модуль для администратора типа root и admin
	
$modules_list[] = $add;

	$add = array();
	$add['status'] = 'user';
	$add['modules_access'] = array("main", "404", "401", "profile", "help");
	$add['modules_view'] = array("profile", "help");
	$add['base_module'] = 'main';//Стартовый модуль для пользователей
	
$modules_list[] = $add;

	$add = array();
	$add['status'] = 'tester';//Этого статуса нет, но вы можете его добавить. как и любой другой статус. Это всего лишь значение в поле status таблицы пользователей
	$add['modules_access'] = array("main", "404", "401", "demo");
	$add['modules_view'] = array("main");
	$add['base_module'] = 'main';//Стартовый модуль для теста
	
$modules_list[] = $add;


function getModulesList($exeptions = array())
{
	global $modules;	
	
	$return_list = array();
	
	$count_exeptions = count($exeptions);
	
	$count_modules = count($modules);
	
	for($k = 0; $k < $count_modules; $k++)
	{
		$add = true;
		
		for($e = 0; $e < $count_exeptions; $e++)
		{
			if($modules[$k]['name'] == $exeptions[$e])
				$add = false;
			
		}
		
		if($add)
			$return_list[] = $modules[$k]['name'];
		
	}	

	
	return $return_list;
}	
	
//===========================================
?>
