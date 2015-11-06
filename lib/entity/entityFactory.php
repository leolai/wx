<?php
namespace entity;

class entityFactory{
	public function __construct(\stdClass $xml){
		foreach ($xml as $key => $value){
			$this->$key = $value;
		}
	}
	
	public static function generate($str = ''){
		if(!$str) return false;
		$xml = simplexml_load_string(stripslashes($str));
		
		if(!$xml){
			\log\log::write('xml parse error!');
			\log\log::write($str);
			\log\log::write($xml);
		}
		
		
		switch ($xml->MsgType) {
			case 'text'://简单文本信息
				return new userSendMsgEntity($xml);
				break;
			case 'event'://用户事件
				return new userEventEntity($xml);
				break;
			default:
				return new \stdClass();
				break;
		}
		
	}
	
}