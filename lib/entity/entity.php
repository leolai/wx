<?php
namespace entity;

abstract class entity{
	public $ToUserName = '';
	public $FromUserName = '';
	public $CreateTime = '';
	public $MsgType = '';

	public function __construct(\SimpleXMLElement $xml){
		foreach ($xml as $key => $value){
			$this->{$key} = $value;
		}
	}
}