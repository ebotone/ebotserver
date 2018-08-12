<?php

function getModuleLinkArgs($data_link)
{
	global $type_links;	
	
	$link = '';
	
	$count_data_link = count($data_link);
	
	for($k = 0; $k < $count_data_link; $k++)
	{
		if($type_links == 'args')		
			$link .= '&' . $data_link[$k]['key'] . '=' . $data_link[$k]['val'];
		elseif($type_links == 'chpu')
			$link .= '/' . $data_link[$k]['key'] . '/' . $data_link[$k]['val'];
		
	}
	
	return $link;
}

function getModuleLink($module)
{	
	global $type_links;	
	
	$href = getModuleHref($module);//Смотрим - может у нас модуль ведет на внешнюю ссылку
	
	if($href != "")
		return $href;
	else
	{
		if($type_links == 'args')
			return 'index.php?module=' . $module;
		elseif($type_links == 'chpu')
			return '' . $module;		
		
	}
	

		
}

function getModuleAccess($module, $user_status)
{
	global $modules_list;
	
	$access = false;
	
	$count_modules_list = count($modules_list);
	
	for($k = 0; $k < $count_modules_list; $k++)
	{		
		if($modules_list[$k]['status'] == $user_status)
		{
			$modules_access = $modules_list[$k]['modules_access'];
			
			$count_modules_access = count($modules_access);
			
			for($a = 0; $a < $count_modules_access; $a++)
			{
				if($modules_access[$a] == $module)
					return true;
				
			}
			
			
		}
	}	
	
}

function getBaseModuleByStatus($status)
{
	global $modules_list;
	
	$base_module = '';
	
	$count_modules_list = count($modules_list);
	
	for($k = 0; $k < $count_modules_list; $k++)
	{
		if($modules_list[$k]['status'] == '')
			$base_module = $modules_list[$k]['base_module'];
		
		if($modules_list[$k]['status'] == $status)
			return $modules_list[$k]['base_module'];
	}	
	
	return $base_module;//Не нашли модуля - статус какой-то непонятный
}

function getModuleHref($module)
{
	global $modules;
	
	$count_modules = count($modules);
	
	for($k = 0; $k < $count_modules; $k++)
	{
		if($modules[$k]['name'] == $module)
			return $modules[$k]['href'];
	}	


}

function getModuleIcon($module)
{
	global $modules;
	
	$count_modules = count($modules);
	
	for($k = 0; $k < $count_modules; $k++)
	{
		if($modules[$k]['name'] == $module)
			return $modules[$k]['icon'];
	}	

	return 'fa-sticky-note';	
}

function getModulesByStatus($status)
{
	global $modules_list;
	
	$count_modules_list = count($modules_list);
	
	for($k = 0; $k < $count_modules_list; $k++)
	{
		if($modules_list[$k]['status'] == $status)
			return $modules_list[$k];
	}
	
	
}

function getModuleDefaultByUser($user_status)
{
	global $modules;

	$module = $modules[0]['name'];
	
	if($user_status != "")//Мы залогинились, а значит у нас определенный статус
	{
		$count_modules = count($modules);
		
		for($k = 0; $k < $count_modules; $k++)
		{
			if($modules[$k]['base_module'] == $user_status)
				$module = $modules[$k]['name'];
		}		
		
	}
	

	
	return $module;
}

?>