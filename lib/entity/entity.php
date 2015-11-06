<?php
namespace entity;

abstract class entity{
	protected $ToUserName = '';
	protected $FromUserName = '';
	protected $CreateTime = '';
	protected $MsgType = '';

	public function __construct(Object $xml){
		foreach ($xml as $key => $value){
			$this->{$key} = $value;
		}
	}
}