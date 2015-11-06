<?php
namespace response;

use entity\entity;
use entity\userSendMsgEntity;
use entity\userEventEntity;
class responseFactory{
	public static function generate(entity $entity){
		//用户发送消息
		if($entity instanceof userSendMsgEntity){
			return new normalTextResponse($entity);
		}
		//响应用户事件
		if($entity instanceof userEventEntity){
			return new eventResponse($entity);
		}
	}

}