<?php
/**
*@DEC日志类
*@author alang
**/


class Logs{

	public static $_ci;
	/**
	*@parant $type  日志类型
	*@parant $arr   日志内容
	**/

	public function __construct()
	{
		self::$_ci = & get_instance();//php 5.3中self改为static
	}
	public function write_log($type='',$arr=array())
	{
		switch($type){
			case 'consignment':
				self::$_ci->load->model('consignment_log_mdl','consignment_log');
				self::$_ci->consignment_log->add($arr);
				break;
			case 'product':
				break;
			default:
				break;
		}
		//self::$_ci->load->model('consignment_log_mdl','consignment_log');
		//self::$_ci->consignment_log->add($arr);
	}
}