<?php

$log_data_file_path = 'logs';
$log_data_file_name = 'log.txt';
$log_data_to_file = true;//Писать ли лог принимаемых от редактора данных в файл
$log_data_to_file_add = false;//Если true - то данные будет дописываться. Если false - храниться будут только последние полученные данные (для экономии места)

if($log_data_to_file)
{
	mkdir('../logs', 0777);
}

?>