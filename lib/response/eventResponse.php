<?php
namespace response;

class eventResponse extends response{

	public function __toString(){
        switch($this->entity->Event){
            case 'subscribe':
                $str = \lang\lang::$subscribe;
                break;
            case 'unsubscribe':
                $str = \lang\lang::$unsubscribe;
                break;
        }
		return sprintf(
				    $this->textTpl,
					$this->entity->FromUserName,
					$this->entity->ToUserName,
					time(),
					$str
				);
	}
}