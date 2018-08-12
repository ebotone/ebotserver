<?php

function getProxyMas()
{
	global $dir_project;
	
	$local_mas = array();	

		$add = array();
		
		$add['abv'] = 'http_link_to_script_set_proxy';
		$add['rus'] = 'http ссылка на скрипт set_proxy.php';
		$add['eng'] = "http link to the set_proxy.php script";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'set_proxy_title';
		$add['rus'] = 'Если Вы хотите, чтобы редактор работал с Вконтакте через Ваш Ebot Server - укажите http путь к set_proxy.php в настройках бота в редакторе в поле "http путь к прокси файлу". О том зачем это может пригодиться - читайте <a href="http://ebot.one/wiki/index.php/Ebot_Server#.D0.9C.D0.BE.D0.B4.D1.83.D0.BB.D1.8C_proxy_.28.D0.B4.D0.BB.D1.8F_.D0.B1.D0.BE.D1.82.D0.BE.D0.B2_.D0.B2_.D0.B3.D1.80.D1.83.D0.BF.D0.BF.D0.B0.D1.85_.D0.92.D0.BA.D0.BE.D0.BD.D1.82.D0.B0.D0.BA.D1.82.D0.B5.29_.5B1.1.3.5D" target="_blank">тут</a>.';
		$add['eng'] = 'If You want the editor to have worked with VK through a Ebot Server, specify the http path to the set_proxy.php in bot settings in the editor in the "http path to proxy file" field". About why this may be useful - read <a href="http://ebot.one/wiki/index.php/Ebot_Server#.D0.9C.D0.BE.D0.B4.D1.83.D0.BB.D1.8C_proxy_.28.D0.B4.D0.BB.D1.8F_.D0.B1.D0.BE.D1.82.D0.BE.D0.B2_.D0.B2_.D0.B3.D1.80.D1.83.D0.BF.D0.BF.D0.B0.D1.85_.D0.92.D0.BA.D0.BE.D0.BD.D1.82.D0.B0.D0.BA.D1.82.D0.B5.29_.5B1.1.3.5D" target="_blank">here</a>.';
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
	//============================	
	return $local_mas;	

}
	
?>