<?php

function exit_script_fnc($data)
{
	global $lng, $virtual_buttons_data, $bot_id;
	
	$group_id = $data['group_id'];
	$chat_id = $data['chat_id'];
	$locale = $data['locale'];
	$list = $data['list'];
	
	$fp = fopen("7777.txt", 'a');
	$trace = fwrite($fp, "\n\n" . date("Y-m-d H:i:s") . " group_id:\n " . $group_id . "\n\n"); 
	fclose($fp);
	
	$con = '';
	
	$group_data = getGroupQuestionDataById($group_id);
	
	$sps = $group_data['sps'];
	$gname = $group_data['gname'];	
	
	if($sps == '')
		$sps = $locale->getLocale('sps', $lng);
	
	$con .= $sps;
	
	if($gname == '')
		$con .= $locale->getLocale('gname_is_empty', $lng);
	
	$count_list = count($list);
	
	if($count_list > 0)
	{
		//======================================
		
			//При необходимости вывести list
		
			$con .= "\n=================================\n";
			
			for($k = 0; $k < $count_list; $k++)
			{
				$con .= "[b]" . $list[$k]['title'] . ":[/b] " . $list[$k]['response'] . "\n";
				
			}			
			
			$con .= "==================================\n";
		
		//======================================			
		
	}

	
	if($Change_icon == '')
		$Change_icon = '\ud83d\udcf6';
	
	if($Next_icon == '')
		$Next_icon = '\u27A1';		
	
	$name = $locale->getLocale('Change', $lng);	
	$command_buttons_data = 'Change';//Такой команды нет поэтому заново будем
	$con .= '[command_button|' . $name . '|0 |' . $Change_icon . ' |command |' . $virtual_buttons_data . '@@' . $command_buttons_data . '@@' . $bot_id . '@@1]';				
	
	if($gname != '')
	{
		$name = $locale->getLocale('Go_to_payment', $lng);	
		$command_buttons_data = $gname;		
		$con .= '[command_button|' . $name . '|0 |' . $Next_icon . ' |command |' . $virtual_buttons_data . '@@' . $command_buttons_data . '@@' . $bot_id . '@@1]';		
	}
	

	
	return $con;
}

?>