<?php
namespace response;

class normalTextResponse extends response{
    
	public function __toString(){
		if(in_array($this->entity->Content, ['今天','全部','最新'])){//这三种回复链接
			return $this->replyJob();
		}else{
			return $this->replyNormal();
		}
	}
	
	private function replyJob(){
        switch(trim($this->entity->Content)){
            case '今天':
                $param = 'today';
                break;
            case '全部':
                $param = 'alls';
                break;
            case '最新':
                $param = 'lasthour';
                break;
        }
		return sprintf(
				$this->textAndPicTpl,
				$this->entity->FromUserName,
				$this->entity->ToUserName,
				time(),
				'http://laijim.com:8001/'. $param
		);
	}
	
	private function replyNormal(){
		return sprintf(
				$this->textTpl,
					$this->entity->FromUserName,
					$this->entity->ToUserName,
					time(),
					\lang\lang::$defaultReply
				);
	}
}