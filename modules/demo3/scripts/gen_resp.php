<?php



function genResp($words)
{
	$return = [];
	
	$audio_ex = new ebotAudio(array());	
	
	$args = [];
	$args['words'] = $words;
	$args['proc'] = 90;//Насколько может быть похоже, чтобы считать за найденное
	
		$search = [];//Варианты
		$search[] = 'сколько времени';
		$search[] = 'сколько время';
		
	$args['search'] = $search;
				
	
	if($audio_ex->findPhrase($args))//Поиск совпадения
	{
		$resp = "сейчас " . date("H:i:s");
	}
	else
		$resp = "не распознала";
	
	$return['resp'] = $resp;
	$return['cash'] = 0;//Сохранить результат для дальнейшего использования или сгенерировать временный ответ, чтобы не занимать место на сервере
	
	return $return;
}

?>