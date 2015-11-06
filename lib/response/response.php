<?php
namespace response;

abstract class response{
		private $textTpl = 	<<<'EOT'
<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[text]]></MsgType>
	<Content><![CDATA[%s]]></Content>
	<FuncFlag>0</FuncFlag>
</xml>
EOT;
	
	private $textAndPicTpl =  <<<'EOT'
<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[news]]></MsgType>
	<ArticleCount>1</ArticleCount>
	<Articles>
		<item>
			<Url><![CDATA[%s]]></Url>
		</item>
	</Articles>
</xml>
EOT;
		
	private $entity = '';
	
	public function __construct(entity $entity){
		$this->entity = $entity;
	}
	
	abstract public function __toString(){}

}