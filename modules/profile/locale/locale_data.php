<?php

function getProfileMas()
{
	$local_mas = array();
	
		$add = array();
		
		$add['abv'] = 'referral_code';
		$add['rus'] = 'Реферальный код';
		$add['eng'] = "Referral code";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'your_balance_1';
		$add['rus'] = 'Ваш тарифный баланс';
		$add['eng'] = "Your account balance";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'your_balance_2';
		$add['rus'] = 'Ваш реферальный баланс';
		$add['eng'] = "Your referral balance";
		$add['deu'] = '';
		
	$local_mas[] = $add;		

		$add = array();
		
		$add['abv'] = 'referral_code_update_error';
		$add['rus'] = 'Сегодня вы уже установили реферальный код. Дупускается менять его не чаще чем раз в сутки.';
		$add['eng'] = "Today you have already installed a referral code. It is allowed to change it no more than once a day.";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'referral_code_update_error_isset';
		$add['rus'] = 'Такой реферальный код уже существует в системе';
		$add['eng'] = "Such referral code already exists in the system";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'tariff';
		$add['rus'] = 'Тариф';
		$add['eng'] = "Tariff";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'your_balance_1_title';
		$add['rus'] = 'Тарифный баланс предназначет исключительно для списания <a href="http://sendmanager.ru/index.php?module=tariffs" target="_blank">тарифными</a> планами - вывести эти средства из системы нельзя.';
		$add['eng'] = 'Tariff balance is intended solely for write - off of <a href="http://sendmanager.ru/index.php?module=tariffs" target="_blank">tariff</a> plans-these funds cannot be withdrawn from the system.';
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'your_balance_2_title';
		$add['rus'] = 'Реферальный баланс - это баланс, который можно вывести через систему киви на проекте <a href="https://ebot.one" target="_blank">ebot.one</a>';
		$add['eng'] = 'Referral balance is a balance that can be withdrawn through the kiwi system on the project <a href="https://ebot.one" target="_blank">ebot.one</a>';
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'password_admin_remind';
		$add['rus'] = 'Если Вы смените здесь и вдруг забудите потом пароль - Вы можете прописать логин супер администратора и его пароль в файле settings.php по пути /login/settings.php и зайти в учетную запись с указанными там Вами реквизитами.';
		$add['eng'] = 'If You change here and suddenly forget the password - you can register the super administrator login and password in the settings.php on the path /login/settings.php and log in to your account with the details you specified there.';
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
	
	//============================	
	return $local_mas;	

}
	
?>