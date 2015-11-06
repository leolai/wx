<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
date_default_timezone_set('Asia/Shanghai');

define('ROOT_PATH', __DIR__.'/');
define('LIB_PATH', ROOT_PATH.'lib/');
define('LOG_PATH', ROOT_PATH.'log/');

spl_autoload_register(function($classname){
	$classname = rtrim($classname, '\\');
	$classname = str_replace('\\', '/', $classname);
	include_once LIB_PATH.$classname.'.php';
});

class api{
	public $config = [];
	
	public function __construct(){
		$this->config = include ROOT_PATH.'config/config.php';
	}
	
	public function exec(){
		$input = file_get_contents('php://input');
		if(!$input) echo -1;
		
		if($this->config['debug']) log\log::write($input);
		
		$entity = entity\entityFactory::generate($input);
		echo response\responseFactory::generate($entity);
	}
}

$api = new api();
$api->exec();