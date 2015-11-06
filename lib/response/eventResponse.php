<?php
namespace response;

class eventResponse extends response{

	public function __toString(){
		return sprintf(
				$this->textTpl,
					$this->entity->FromUserName,
					$this->entity->ToUserName,
					time(),
					\lang\lang::$defaultReply
				);
	}
}