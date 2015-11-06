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
		$map = [
				'今天'=>'today',
				'全部'=>'alls',
				'最新'=>'lasthour',
		];
		
		return sprintf(
				$this->textAndPicTpl,
				$this->entity->FromUserName,
				$this->entity->ToUserName,
				time(),
				'http://laijim.com:8001/'. $map[$this->entity->Content]
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