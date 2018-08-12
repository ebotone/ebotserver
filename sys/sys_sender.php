<?php

class senderQueue
{
	protected $version = "1.1.4";	
	protected $bot_id = "";	
	protected $user_id = "";	
	protected $key_md5 = "";	
	protected $chat_id = "";	
	protected $sends_mas = array();
	protected $data_mas = array();
	protected $HTTP_HOST = "";	
	protected $user_name = "";	
	protected $bot_type = "";	
	
	public function __construct($data_mas)
    {
        $this->bot_id = $data_mas['bot_id'];
		$this->user_id = $data_mas['user_id'];
		$this->key_md5 = $data_mas['key_md5'];
		$this->chat_id = $data_mas['chat_id'];
		$this->sends_mas = $data_mas['sends_mas'];		
		$this->bot_id = $data_mas['bot_id'];		
		$this->HTTP_HOST = $data_mas['HTTP_HOST'];
		$this->user_name = $data_mas['user_name'];
		$this->bot_type = $data_mas['bot_type'];
		
		$this->data_mas = $data_mas;
		
		//print_r($this->data_mas);
    } 
	
	public function getDataMas()
	{		
		return $this->data_mas;
	}
	
	public function getHTTP_HOST()
	{		
		return $this->HTTP_HOST;
	}	
	
	public function getBotId()
	{		
		return $this->bot_id;
	}	

	public function getUserId()
	{		
		return $this->user_id;
	}	
	
	public function getBotType()
	{		
		return $this->bot_type;
	}	

	public function getVersion()
	{		
		return $this->version;
	}	
	
	public function sendToUserBySender()
	{
		//Сюда не чаще чем раз в секунду ломиться можно
		
		$sender_data_str = json_encode($this->getDataMas());	
		$HTTP_HOST = $this->getHTTP_HOST();
		$bot_id = $this->getBotId();
		$user_id = $this->getUserId();
		$bot_type = $this->getBotType();
		
		$postvars = array();
		$postvars['data'] = $sender_data_str;
		
		//====================================================
		//====================================================		
			
		if($bot_type == 'vkg')
		{
			$ch = curl_init();	
			curl_setopt($ch, CURLOPT_URL, 'http://' . $HTTP_HOST . '/all/s_radoid/dialogs/api/methods/setSenderVkg.php');
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
			curl_setopt($ch, CURLOPT_POST, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
			$resp_con = curl_exec($ch);	
			curl_close($ch);	

			$resp_con_mas = json_decode($resp_con, true);	
		}	
		else
		{
			$ch = curl_init();	
			curl_setopt($ch, CURLOPT_URL, 'http://' . $HTTP_HOST . '/all/s_radoid/dialogs/api/methods/setSenderQueue.php');
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
			curl_setopt($ch, CURLOPT_POST, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
			$resp_con = curl_exec($ch);	
			curl_close($ch);	

			$resp_con_mas = json_decode($resp_con, true);
			
			if($resp_con_mas['insert_count'] > 0)
			{
				
				$send_url = 'http://' . $HTTP_HOST . '/all/s_radoid/dialogs/api/methods/goSender.php?bot_id=' . $bot_id . '&user_id=' . $user_id . '&host=http://' . $HTTP_HOST; 
				
				$getSenders_str = file_get_contents($send_url);	

				$getSenders = json_decode($getSenders_str, true);		

				$resp_con_mas['goSender.php'] = $getSenders;
				
			}				
			
		}			
			


		
		
		return $resp_con_mas;	
		
		
	}
	
}


		
?>
