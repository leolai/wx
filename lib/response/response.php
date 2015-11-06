<?php
namespace response;

abstract class response{
	public $textTpl = 	<<<'EOT'
<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[text]]></MsgType>
	<Content><![CDATA[%s]]></Content>
	<FuncFlag>0</FuncFlag>
</xml>
EOT;
	
	public $textAndPicTpl =  <<<'EOT'
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
		
	public $entity = '';
	
	public function __construct(\entity\entity $entity){
		$this->entity = $entity;
	}
	

}