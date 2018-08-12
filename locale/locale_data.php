<?php

function getDefaultMas()
{
	$local_mas = array();		
	
	//=========== modules (разделы) ================
	
		$add = array();
		
		$add['abv'] = 'main';//Имя модуля в массиве $modules
		$add['rus'] = 'Ebot Server';//Что будет в title
		$add['eng'] = "Ebot Server";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = '404';
		$add['rus'] = 'Страница не найдена - 404';
		$add['eng'] = "Page not found 404";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add['abv'] = '401';
		$add['rus'] = 'Доступ запрещен';
		$add['eng'] = "Access denied";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'admin';
		$add['rus'] = 'Админ панель';
		$add['eng'] = "Admin panel";
		$add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'registration';
		$add['rus'] = 'Регистрация';
		$add['eng'] = "Registration";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'demo';
		$add['rus'] = 'Демо 1';
		$add['eng'] = "Demo 1";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'demo2';
		$add['rus'] = 'Демо 2';
		$add['eng'] = "Demo 2";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'questions';
		$add['rus'] = 'Вопросы';
		$add['eng'] = "Questions";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'remind';
		$add['rus'] = 'Забыл пароль?';
		$add['eng'] = "Password recovery";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
			
		$add = array();
		
		$add['abv'] = 'tariffs';
		$add['rus'] = 'Тарифы';
		$add['eng'] = "tariffs";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'help';
		$add['rus'] = 'Справка';
		$add['eng'] = "help";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'profile';
		$add['rus'] = 'Профиль';
		$add['eng'] = "profile";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'page';
		$add['rus'] = 'Страница';
		$add['eng'] = "Page";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'proxy';
		$add['rus'] = 'Прокси';
		$add['eng'] = "Proxy";
		$add['deu'] = '';
		
	$local_mas[] = $add;

	//=========== modules Пользовательские (разделы) ================		
		
		$add = array();
		
		$add['abv'] = 'url_resp';
		$add['rus'] = 'url_resp';
		$add['eng'] = "url_resp";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
		
	
	//=========== modules (разделы) ================	
	
		$add = array();
		
		$add['abv'] = 'Login';
		$add['rus'] = 'Войти';
		$add['eng'] = "Login";
		$add['deu'] = '';
		
	$local_mas[] = $add;
	
		$add = array();
		
		$add['abv'] = 'Logout';
		$add['rus'] = 'Выйти';
		$add['eng'] = "Logout";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Login_proccess';
		$add['rus'] = 'Авторизация';
		$add['eng'] = "Login";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'login_error';
		$add['rus'] = 'Ошибка авторизации';
		$add['eng'] = "Authorization error";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'access_time_error';
		$add['rus'] = 'Попробуйте позже';
		$add['eng'] = "Please try again later";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'access_object_error';
		$add['rus'] = 'Ошибка доступа к объекту';
		$add['eng'] = "Access error to the object";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'object_error';
		$add['rus'] = 'Ошибка объекта';
		$add['eng'] = "Object error";
		$add['deu'] = '';
		
	$local_mas[] = $add;		

		$add = array();
		
		$add['abv'] = 'db_connect_error';
		$add['rus'] = 'Ошибка подключения к базе данных';
		$add['eng'] = "Database connection error";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'Logout_proccess';
		$add['rus'] = 'Выход';
		$add['eng'] = "Logout";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'fields_need';
		$add['rus'] = 'Заполните все поля';
		$add['eng'] = "Fill in all the fields";
		$add['deu'] = '';
		
	$local_mas[] = $add;
	
		$add = array();
		
		$add['abv'] = 'login_error';
		$add['rus'] = 'Ошибка авторизации';
		$add['eng'] = "Authorization error";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = '_404_title';
		$add['rus'] = '404';
		$add['eng'] = "404";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = '_404_notice';
		$add['rus'] = 'Страница не найдена - 404';
		$add['eng'] = "Page not found 404";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = '_go_to_home';
		$add['rus'] = 'На главную';
		$add['eng'] = "Go home";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'task_title';
		$add['rus'] = 'Задачи';
		$add['eng'] = "Tasks";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'managers';
		$add['rus'] = 'Менеджеры';
		$add['eng'] = "Managers";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'save';
		$add['rus'] = 'Сохранение';
		$add['eng'] = "Save";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'saved';
		$add['rus'] = 'Сохранено';
		$add['eng'] = "Saved";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'to_save';
		$add['rus'] = 'Сохранить';
		$add['eng'] = "Save";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'admin_notice';
		$add['rus'] = 'Задача организации, в особенности же реализация намеченного плана развития напрямую зависит от системы масштабного изменения ряда параметров! Соображения высшего порядка, а также курс на социально-ориентированный национальный проект играет важную роль в формировании позиций, занимаемых участниками в отношении поставленных задач? Значимость этих проблем настолько очевидна, что консультация с профессионалами из IT обеспечивает широкому кругу специалистов участие в формировании модели развития! С другой стороны повышение уровня гражданского сознания требует от нас системного анализа соответствующих условий активизации!';
		$add['eng'] = "The task of the organization, especially the implementation of the planned development plan depends on the system of large-scale changes in a number of parameters! Do higher-order considerations, as well as the focus on a socially oriented national project, play an important role in shaping the positions of the participants in relation to the tasks set? The importance of these problems is so obvious that consultation with professionals from IT provides a wide range of specialists to participate in the formation of the development model! On the other hand, raising the level of civic consciousness requires a systematic analysis of the relevant conditions of activation!";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'managers_notice';
		$add['rus'] = 'С другой стороны начало повседневной работы по формированию позиции требует от нас анализа дальнейших направлений развития проекта! Соображения высшего порядка, а также социально-экономическое развитие способствует повышению актуальности соответствующих условий активизации. С другой стороны начало повседневной работы по формированию позиции требует от нас анализа дальнейших направлений развития проекта. Дорогие друзья, консультация с профессионалами из IT напрямую зависит от дальнейших направлений развития проекта.';
		$add['eng'] = "On the other hand, the beginning of the daily work on the formation of the position requires us to analyze further directions of the project! Higher-order considerations, as well as socio-economic development, contribute to enhancing the relevance of the respective activation conditions. On the other hand, the beginning of the daily work on the formation of the position requires us to analyze further directions of the project. Dear friends, consultation with professionals from IT directly depends on the further development of the project.";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'add_element_proccess';
		$add['rus'] = 'Добавление элемента';
		$add['eng'] = "Add items";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'nikname';
		$add['rus'] = 'Логин';
		$add['eng'] = "Логин";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'detailed';
		$add['rus'] = 'Подробнее';
		$add['eng'] = "Detailed";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'operations';
		$add['rus'] = 'Операции';
		$add['eng'] = "Operations";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'Lng_proccess';
		$add['rus'] = 'Смена языка';
		$add['eng'] = "Change of language";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'need_correct_type_links_code';
		$add['rus'] = 'Код требует корректировки для получения данных указанным типом ссылок';
		$add['eng'] = "The code requires an adjustment to get the data for the specified reference type";
		$add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'The_list_is_empty';
		$add['rus'] = 'Список пуст';
		$add['eng'] = "The list is empty";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'type';
		$add['rus'] = 'Тип';
		$add['eng'] = "Type";
		$add['deu'] = '';
		
	$local_mas[] = $add;
	
		$add = array();
		
		$add['abv'] = 'You_can_add';
		$add['rus'] = 'Вы можете добавить еще';
		$add['eng'] = "You can add";
		$add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'objects';
		$add['rus'] = 'объектов';
		$add['eng'] = "objects";
		$add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'login';
		$add['rus'] = 'Логин';
		$add['eng'] = "Login";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'password';
		$add['rus'] = 'Пароль';
		$add['eng'] = "Password";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'password_saved';
		$add['rus'] = 'Пароль сохранен';
		$add['eng'] = "Password saved";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'condition';
		$add['rus'] = 'Состояние';
		$add['eng'] = "Condition";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'active';
		$add['rus'] = 'Активен';
		$add['eng'] = "Active";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'ban';
		$add['rus'] = 'Забанен';
		$add['eng'] = "Ban";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'sort_error';
		$add['rus'] = 'Ошибка сортировки';
		$add['eng'] = "Sort error";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'sort_remove';
		$add['rus'] = 'Переместить в левую колонку?';
		$add['eng'] = "Move to the left column?";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'sort_add';
		$add['rus'] = 'Переместить в правую колонку?';
		$add['eng'] = "Move to the right column?";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'sort_proccess';
		$add['rus'] = 'Перемещение';
		$add['eng'] = "Movement";
		$add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'sort_ok';
		$add['rus'] = 'Перемещено';
		$add['eng'] = "Displaced";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'delete';
		$add['rus'] = 'Удалить';
		$add['eng'] = "Delete";
		$add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'deleting';
		$add['rus'] = 'Удаление';
		$add['eng'] = "Deleting";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Activity';
		$add['rus'] = 'Активность';
		$add['eng'] = "Activity";
		$add['deu'] = '';

	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'login_isset';
		$add['rus'] = 'Пользователь с таким именем существует';
		$add['eng'] = "A user with this name exists";
		$add['deu'] = '';

	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'add';
		$add['rus'] = 'Добавить';
		$add['eng'] = "Add";
		$add['deu'] = '';

	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'link';
		$add['rus'] = 'Ссылка';
		$add['eng'] = "link";
		$add['deu'] = '';

	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'Comment';
		$add['rus'] = 'Комментарий';
		$add['eng'] = "Comment";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'rub_r';
		$add['rus'] = 'рублей';
		$add['eng'] = "rubles";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'date';
		$add['rus'] = 'Дата';
		$add['eng'] = "Date";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'delete_ask';
		$add['rus'] = 'Удалить';
		$add['eng'] = "Remove";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'name';
		$add['rus'] = 'Имя';
		$add['eng'] = "Name";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'must_define';
		$add['rus'] = 'Для работы механизма необходимо в конфигурационном файле <b>settings.php</b> в корне проекта определить переменную';
		$add['eng'] = "The mechanism operation is required in the configuration file <b>settings.php</b> in the root of the project to define a variable";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

	//============================
	//логи

		$add = array();
		
		$add['abv'] = 'count_log_data_0';
		$add['rus'] = 'Записей нет';
		$add['eng'] = "No entries";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'log_data_system';
		$add['rus'] = 'Лог обращений к @@script@@';
		$add['eng'] = 'Access log to @@script@@';
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'last_entry';
		$add['rus'] = 'Последние записи с admin_chat_id';
		$add['eng'] = "The last record with admin_chat_id";
		$add['deu'] = '';
		
	$local_mas[] = $add;
	
		$add = array();
		
		$add['abv'] = 'last_entry_all';
		$add['rus'] = 'Последние записи';
		$add['eng'] = "The last record";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'last_entry_system';
		$add['rus'] = 'Последние системные записи';
		$add['eng'] = "The last system record";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'log_data_from_file';
		$add['rus'] = 'Лог принимаемых с редактора данных';
		$add['eng'] = "Log of data received from the editor";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
	//============================	
	
		$add = array();
		
		$add['abv'] = 'demo_title';
		$add['rus'] = 'Получение данных от редактора и простой ответ пользователю';
		$add['eng'] = "Getting data from the editor and a simple answer to the user";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'demo2_title';
		$add['rus'] = 'Отправка асинхронного сообщения пользователю';
		$add['eng'] = "Sending an asynchronous message to a user";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'proxy_title';
		$add['rus'] = 'Подключение к редактору через Ebot Server';
		$add['eng'] = "Connecting to the editor via Ebot Server";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'must_define_vars';
		$add['rus'] = 'Для работы необходимо чтобы были определены следующие переменные';
		$add['eng'] = "The following variables must be defined to work";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'on';
		$add['rus'] = 'Подключено';
		$add['eng'] = "Connected";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'off';
		$add['rus'] = 'Отключено';
		$add['eng'] = "Disabled";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'dispatch';
		$add['rus'] = 'Рассылочный механизм';
		$add['eng'] = "Mailing mechanism";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'services_link';
		$add['rus'] = '<a href="http://ebot.one/all/s_radoid/dialogs/profile.php?lng=rus&page=services" target="_blank">Подробнее</a>';
		$add['eng'] = '<a href="http://ebot.one/all/s_radoid/dialogs/profile.php?lng=eng&page=services" target="_blank">More detailed</a>';
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'http_link_to_script';
		$add['rus'] = 'Ссылка внешнего скрипта. Она прописывается в URL RESP команды бота';
		$add['eng'] = "External script reference. It is registered in the URL RESP bot command";
		$add['deu'] = '';
		
	$local_mas[] = $add;
	
		$add = array();
		
		$add['abv'] = 'hello';
		$add['rus'] = 'Привет';
		$add['eng'] = "Hello";
		$add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'bot_type_title';
		$add['rus'] = 'Тип бота';
		$add['eng'] = "Type of bot";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'telegram';
		$add['rus'] = 'Телеграм';
		$add['eng'] = "telegram";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'vkg';
		$add['rus'] = 'Бот в группу Вконтакте';
		$add['eng'] = "Bot in group Vkontakte";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
	return $local_mas;	

}
	
?>