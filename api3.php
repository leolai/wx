<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT_PATH', __DIR__.'/');//项目根目录
define('LOG_PATH', ROOT_PATH.'log/');//日志根目录
define('SRC_PATH', ROOT_PATH.'src/');//资源根目录

require_once './src/log.php';

$weixin = new weixin();
$weixin->exec();

class weixin{
	public $rawPostStr = '';//微信传过来的原始信息
	public $postStr = '';//微信传过来的信息
	public $fromUsername = '';//发送消息过来的USER
	public $toUsername = '';
	public $keyword = '';
	public $config = [];
	
	protected $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
	
	public function __construct(){
		$this->config = include_once SRC_PATH.'config.php';//加载配置文件
		$this->rawPostStr = trim(file_get_contents('php://input'));//加载微信post过来的数据源
		$this->postStr = simplexml_load_string(stripslashes($this->rawPostStr));//解析
		if($this->config['debug']){
			log::write($this->rawPostStr);
		}
	}
	
	/**
	 * 入口
	 */
	public function exec(){
		if($this->postStr){
			$ret = $this->allocate();
			$this->outPut($ret);
		}else{
			$this->outPut(-1);
		}
	}
	
	public function event(){
		$fromUsername 	= (string)$this->postStr->FromUserName;
		$toUsername 	= (string)$this->postStr->ToUserName;
		switch ($this->postStr->Event) {
			case 'subscribe'://关注
				return sprintf($this->textTpl, $fromUsername, $toUsername, time(), 'text', $this->config['subscribe']);
			break;
			
			case 'unsubscribe'://关注
				return sprintf($this->textTpl, $fromUsername, $toUsername, time(), 'text', $this->config['subscribe']);
			break;
			
			default:
				;
			break;
		}
	}
	
	/**
	 * 根据消息类型分配处理方法
	 */
	public function allocate(){
		if(!$this->postStr || !$this->postStr->MsgType) return '-2';
		switch ($this->postStr->MsgType) {
			case 'text':
				return $this->userAsk();
			break;
			case 'event':
				return $this->event();
			break;
			default:
				return '-3';
			break;
		}
	}
	
	/**
	 * 响应用户主动发起请求
	 *  ToUserName 	开发者微信号
		FromUserName 	发送方帐号（一个OpenID）
		CreateTime 	消息创建时间 （整型）
		MsgType 	text
		Content 	文本消息内容
		MsgId 	消息id，64位整型 
	 */
	public function userAsk(){
		$fromUsername 	= (string)$this->postStr->FromUserName;
		$toUsername 	= (string)$this->postStr->ToUserName;
		$Content 		= (string)trim($this->postStr->Content);
		
		return $this->responseAsk($fromUsername, $toUsername, $Content);
	}
	
	
	public function outPut($str){
		echo $str;
		exit();
	}
	
	/**
	 * 响应用户主动发起会话
	 * @param string $fromUsername
	 * @param string $toUsername
	 * @param string $Content 用户在微信输入的内容
	 */
	public function responseAsk($fromUsername, $toUsername, $Content){
		if(in_array($Content, ['今天','全部','最新'])){
			return $this->ask($fromUsername, $toUsername, $Content);
		}else{
			return sprintf($this->textTpl, $fromUsername, $toUsername, time(), 'text', $this->config['default']);
		}

		
	}
	
	/**
	 * 查询链接
	 */
	public function ask($fromUsername, $toUsername, $str){
		$tpl = <<<'EOT'
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
		$map = [
				'今天'=>'today',
				'全部'=>'alls',
				'最新'=>'lasthour',
		];
		$repl = 'http://laijim.com:8001/'.$map[$str];
		return sprintf($tpl, $fromUsername, $toUsername, time(), $repl);
	}
}












