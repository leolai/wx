<?php
/**
 * 微信公众平台 PHP SDK 示例文件
 */
file_put_contents(__DIR__.'/log/log.php', $_REQUEST);
exit(1);
define('ROOT_PATH', __DIR__);//项目根目录
define('LOG_PATH', __DIR__.'/log/');//日志根目录
require('./src/Wechat.php');
log::write($GLOBALS['HTTP_RAW_POST_DATA']);
  /**
   * 微信公众平台演示类
   */
class MyWechat extends Wechat {
	private $autoRpl = '鱼鱼，我爱你哦！';
	private $guanzhu = '鱼鱼，我等你好久了哦！';
    /**
     * 用户关注时触发，回复「欢迎关注」
     *
     * @return void
     */
    protected function onSubscribe() {
      $this->responseText($this->guanzhu);
    }

    /**
     * 用户已关注时,扫描带参数二维码时触发，回复二维码的EventKey (测试帐号似乎不能触发)
     *
     * @return void
     */
    protected function onScan() {
      $this->responseText('二维码的EventKey：' . $this->getRequest('EventKey'));
    }

    /**
     * 用户取消关注时触发
     *
     * @return void
     */
    protected function onUnsubscribe() {
      // 「悄悄的我走了，正如我悄悄的来；我挥一挥衣袖，不带走一片云彩。」
    }

    /**
     * 上报地理位置时触发,回复收到的地理位置
     *
     * @return void
     */
    protected function onEventLocation() {
      $this->responseText('收到了位置推送：' . $this->getRequest('Latitude') . ',' . $this->getRequest('Longitude'));
    }

    /**
     * 收到文本消息时触发，回复收到的文本消息内容
     *
     * @return void
     */
    protected function onText() {
    	$text = $this->getRequest('content');
    	switch ($text){
    		case '':
    			$this->responseText('');
    			break;
    		default:
    			$this->responseText($this->autoRpl);
    			break;
    			
    	}
     
    }

    /**
     * 收到图片消息时触发，回复由收到的图片组成的图文消息
     *
     * @return void
     */
    protected function onImage() {
      $items = array(
        new NewsResponseItem('标题一', '描述一', $this->getRequest('picurl'), $this->getRequest('picurl')),
        new NewsResponseItem('标题二', '描述二', $this->getRequest('picurl'), $this->getRequest('picurl')),
      );

      $this->responseNews($items);
    }

    /**
     * 收到地理位置消息时触发，回复收到的地理位置
     *
     * @return void
     */
    protected function onLocation() {
      $num = 1 / 0;
      // 故意触发错误，用于演示调试功能

      $this->responseText('收到了位置消息：' . $this->getRequest('location_x') . ',' . $this->getRequest('location_y'));
    }

    /**
     * 收到链接消息时触发，回复收到的链接地址
     *
     * @return void
     */
    protected function onLink() {
      $this->responseText('收到了链接：' . $this->getRequest('url'));
    }

    /**
     * 收到语音消息时触发，回复语音识别结果(需要开通语音识别功能)
     *
     * @return void
     */
    protected function onVoice() {
      $this->responseText('收到了语音消息,识别结果为：' . $this->getRequest('Recognition'));
    }

    /**
     * 收到自定义菜单消息时触发，回复菜单的EventKey
     *
     * @return void
     */
    protected function onClick() {
      $this->responseText('你点击了菜单：' . $this->getRequest('EventKey'));
    }

    /**
     * 收到未知类型消息时触发，回复收到的消息类型
     *
     * @return void
     */
    protected function onUnknown() {
    	log::write('未知类型'. $this->getRequest('msgtype'));
    }

  }

  $wechat = new MyWechat(array(
      'token' => $token,
      'aeskey' => $encodingAesKey,
      'appid' => $appId,
      'debug' => $debugMode
  ));
  
  $wechat->run();
