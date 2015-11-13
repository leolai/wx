<?php
class log{
	/**
	 * 写日志
	 * @param string $msg
	 * @return void
	 */
	public static function write($msg = ''){
		file_put_contents(LOG_PATH.'log.php', date('Y-m-d H:i:s').': '.json_encode($msg, JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND);
	}
}