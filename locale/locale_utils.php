<?php
		
function set_lng($user_id, $lng)
{
	global $text, $lng_default, $name_table_users;
	
	$text->my_sql_query='update ' . $name_table_users . ' set lng = "' . mysql_real_escape_string($lng) . '" where id = "' . mysql_real_escape_string($user_id) . '"';	
	$text->my_sql_execute();			
	
}		
		
function getLngByUser($user_id)
{
	global $text, $lng_default, $name_table_users;
	
	$text->my_sql_query="select lng from " . $name_table_users . " where id='" . mysql_real_escape_string($user_id) . "'";
	$text->my_sql_execute();
	$res = mysql_fetch_object($text->my_sql_res);
	$lng = $res->lng;	
	
	if($lng == '')
		$lng = $lng_default;	
	
	return $lng;
	
}		
		
class _locale 
{	
	private $local_mas = array();
	private $includes = array();
	private $lng_default = '';
	
    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }		
		$this->initLocale();
    }
	
	public function initLocale()
	{		
		$local_mas = array();	
		
		$includes = array();
		$includes[] = 'default';
		
		$includes = array_merge($includes, $this->includes);		
		$includes = array_unique($includes);
		sort($includes);
		
		$count_includes = count($includes);		
		
		for($i = 0; $i < $count_includes; $i++)
		{
			
			$add_local_mas = call_user_func("get" . ucfirst($includes[$i]) . "Mas");	
			
			$local_mas = array_merge($add_local_mas, $local_mas);
	
		}
		
		$this->local_mas = $local_mas;		
	
	}
	
	public function getLocale($abv, $set_lng = '')
	{
		if($set_lng != "")
			$lng = $set_lng;
		
		if($lng == '')
			$lng = $this->lng_default;		
		
		$count_local_mas = count($this->local_mas);
		
		for($k = 0; $k < $count_local_mas; $k++)
			if($this->local_mas[$k]['abv'] == $abv)
				return $this->local_mas[$k][$lng];	
				
		return 'undefined';			
		
	}

	public function getLangs()
	{
		$lngs = array();		
		$lngs[] = 'rus';
		$lngs[] = 'eng';
		//$lngs[] = 'deu';

		return $lngs;
	}	

}	



?>