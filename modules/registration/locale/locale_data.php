<?php

function getRegistrationMas()
{
	$local_mas = array();	
	
		$add = array();
		
		$add['abv'] = 'registration_title';
		$add['rus'] = 'Новый пользователь';
		$add['eng'] = "New user";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'nikname';
		$add['rus'] = 'User name';
		$add['eng'] = "User name";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'password';
		$add['rus'] = 'Password';
		$add['eng'] = "Password";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'password2';
		$add['rus'] = 'Password';
		$add['eng'] = "Password";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'Received_code_title';
		$add['rus'] = 'Получите код у нашего бота в telegram';
		$add['eng'] = "Received code";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'code';
		$add['rus'] = 'Код';
		$add['eng'] = "Code";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'registration_go';
		$add['rus'] = 'Зарегистрироваться';
		$add['eng'] = "Registration";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'fields_need';
		$add['rus'] = 'Заполните все поля';
		$add['eng'] = "Fill in all the fields";
		$add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'password_error_1';
		$add['rus'] = 'Пароли не совпадают';
		$add['eng'] = "Passwords do not match";
		$add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'user_added';
		$add['rus'] = 'Пользователь добавлен';
		$add['eng'] = "The user has been added";
		$add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'hash_error';
		$add['rus'] = 'Неверный код';
		$add['eng'] = "Wrong code";
		$add['deu'] = '';
		
	$local_mas[] = $add;
	
		$add = array();
		
		$add['abv'] = 'user_isset';
		$add['rus'] = 'Пользователь с таким логином уже есть в системе';
		$add['eng'] = "A user with such login already exists in the system";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'username_char_error';
		$add['rus'] = 'В никнейме присутствуют запрещенные символы. Разрешены символы английского алфавита, цыфры от 0 до 9, точка, тире и нижнее подчеркивание';
		$add['eng'] = "In a nickname there are illegal characters. English letters, digits 0 to 9, period, dash and underscore are allowed";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'hash_isset';
		$add['rus'] = 'Пользователь с таким ключом уже есть в системе';
		$add['eng'] = "A user with this key already exists in the system";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'login_length';
		$add['rus'] = 'Длина логина должна превышать три символа';
		$add['eng'] = "Login length should exceed three characters";
		$add['deu'] = '';
		
	$local_mas[] = $add;
	
		$add = array();
		
		$add['abv'] = 'login_reserved';
		$add['rus'] = 'Данный никнейм зарезервирован системой';
		$add['eng'] = "This nickname is reserved by the system";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'Your_code';
		$add['rus'] = 'Ваш код';
		$add['eng'] = "Your code";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
	//============================	
	return $local_mas;	

}
	
?>