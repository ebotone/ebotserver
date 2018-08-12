<?php

function getQuestionsMas()
{
	global $dir_project;
	
	$local_mas = array();	
	
		$add = array();
		
		$add['abv'] = 'group_question_add';
		$add['rus'] = 'Добавить группу вопросов';
		$add['eng'] = 'To add a question group';
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'Questions';
		$add['rus'] = 'Вопросы группы';
		$add['eng'] = "Group issues";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
	
		$add = array();
		
		$add['abv'] = 'Questions_group';
		$add['rus'] = 'Группы вопросов';
		$add['eng'] = "Group of questions";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'The_type_of_response';
		$add['rus'] = 'Тип ответа';
		$add['eng'] = "The type of response";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Question_title';
		$add['rus'] = 'Название вопроса';
		$add['eng'] = "Question title";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Question_name';
		$add['rus'] = 'Вопрос';
		$add['eng'] = "Question";
		$add['deu'] = '';
		
	$local_mas[] = $add;		

		$add = array();
		
		$add['abv'] = 'Save';
		$add['rus'] = 'Сохранить';
		$add['eng'] = "Save";
		$add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'string';
		$add['rus'] = 'Строка';
		$add['eng'] = "String";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'int';
		$add['rus'] = 'Число';
		$add['eng'] = "Int";
		$add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'reg';
		$add['rus'] = 'Регулярное выражение';
		$add['eng'] = "Regular expression";
		$add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'Saving';
		$add['rus'] = 'Сохранение';
		$add['eng'] = "Save";
        $add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Data_is_incorrect';
		$add['rus'] = 'Данные не корректны';
		$add['eng'] = "Data is incorrect";
        $add['deu'] = '';
		
	$local_mas[] = $add;
	
		$add = array();
		
		$add['abv'] = 'Or_no_access_to_change';
		$add['rus'] = 'Или нет доступа на изменение';
		$add['eng'] = "Or no access to change";
        $add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'Name_is_empty';
		$add['rus'] = 'Поле Название вопроса не должно быть пустым';
		$add['eng'] = "Question title is empty";
        $add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'Saved';
		$add['rus'] = 'Сохранено';
		$add['eng'] = "Saved";
        $add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'Add_question';
		$add['rus'] = 'Добавить вопрос';
		$add['eng'] = "Add question";
        $add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Add_group';
		$add['rus'] = 'Добавить группу';
		$add['eng'] = "Add group";
        $add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'Adding';
		$add['rus'] = 'Добавление';
		$add['eng'] = "Adding";
        $add['deu'] = '';
		
	$local_mas[] = $add;

		$add = array();
		
		$add['abv'] = 'Question_added';
		$add['rus'] = 'Вопрос добавлен';
		$add['eng'] = "Question added";
        $add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Group_added';
		$add['rus'] = 'Группа добавлена';
		$add['eng'] = "Group added";
        $add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'New_question';
		$add['rus'] = 'Новый вопрос';
		$add['eng'] = "New question";
        $add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'Delete_go';
		$add['rus'] = 'Вы уверены, что хотите удалить элемент';
		$add['eng'] = "Are you sure you want to remove the element";
        $add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Deleted';
		$add['rus'] = 'Удалено';
		$add['eng'] = "Deleted";
        $add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'New_group';
		$add['rus'] = 'Новая группа';
		$add['eng'] = "New group";
        $add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'Question_field';
		$add['rus'] = 'Имя поля';
		$add['eng'] = "Field name";
        $add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'Group_title';
		$add['rus'] = 'Имя группы';
		$add['eng'] = "Group title";
        $add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'Response_is_empty';
		$add['rus'] = 'Вы не ответили.';
		$add['eng'] = "Response is empty";
        $add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Group_php_start_title';
		$add['rus'] = 'Имя скрпта входа (например, <b>group1_start.php</b> в папке <b>modules/questions/scripts</b>) (под каждую группу вопросов свой скрипт. На него вы будете сслаться в редакторе в поле <b>Url Resp</b>)';
		$add['eng'] = "The name of the login script (for example <b>group1_start.php</b> in your <b>modules/questions/scripts</b>) (for each group of issues your script. You will refer to it in the editor In the <b>Url Resp</b> field)";
        $add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Group_php_end_title';
		$add['rus'] = 'Имя скрпта выхода (например, <b>group1_end.php</b> в папке <b>modules/questions/exit_script</b>) (для каждой группы вопросов свой конечный файл)';
		$add['eng'] = "Name of the exit script (for example, <b>group1_end.php</b> in the <b>modules/questions/exit_script</b> folder (each group of questions has its own final file)";
        $add['deu'] = '';
		
	$local_mas[] = $add;
	
		$add = array();
		
		$add['abv'] = 'Group_sps_title';
		$add['rus'] = 'Текст в конце опроса';
		$add['eng'] = "Text at the end of the survey";
        $add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Group_gname_title';
		$add['rus'] = 'Глобальная команда выхода. Например: <b>/my_command</b>';
		$add['eng'] = "Global output command. For example: <b>/my_command</b>";
        $add['deu'] = '';
		
	$local_mas[] = $add;
	
		$add = array();
		
		$add['abv'] = 'Change';
		$add['rus'] = 'Изменить';
		$add['eng'] = "Change";
        $add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'Go_to_payment';
		$add['rus'] = 'Далее';
		$add['eng'] = "Next";
        $add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'sps';
		$add['rus'] = 'Спасибо за ответы!';
		$add['eng'] = "Thanks for the replies!";
        $add['deu'] = '';
		
	$local_mas[] = $add;	
	
		$add = array();
		
		$add['abv'] = 'gname_is_empty';
		$add['rus'] = 'Глобальная каманда для выхода пуста!';
		$add['eng'] = "Global command output is empty!";
        $add['deu'] = '';
		
	$local_mas[] = $add;		
	
	//============================	
	//Отдел для заказов, т.к. в другом месте подключить locale не удобно
	
		$add = array();
		
		$add['abv'] = 'Price_for';
		$add['rus'] = 'Цена за';
		$add['eng'] = "Price for";
        $add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'Name';
		$add['rus'] = 'Наименование';
		$add['eng'] = "Name";
        $add['deu'] = '';
		
	$local_mas[] = $add;		
	
		$add = array();
		
		$add['abv'] = 'Count';
		$add['rus'] = 'Количество';
		$add['eng'] = "Count";
        $add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'units';
		$add['rus'] = 'единиц товара';
		$add['eng'] = "units";
        $add['deu'] = '';
		
	$local_mas[] = $add;	

		$add = array();
		
		$add['abv'] = 'The_final_cost';
		$add['rus'] = 'Итоговая стоимость';
		$add['eng'] = "The final cost";
        $add['deu'] = '';
		
	$local_mas[] = $add;			
	
		$add = array();
		
		$add['abv'] = 'group_id_error';
		$add['rus'] = 'group_id не получен';
		$add['eng'] = "group_id is not received";
        $add['deu'] = '';
		
	$local_mas[] = $add;		
	
	//============================	
	return $local_mas;	

}
	
?>