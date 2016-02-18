<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
* @access	public
* @param	string
* @return	sting	返回订单状态
*/
if ( ! function_exists('order_status'))
{
	function order_status($status = 0)
	{
		$arr = array(
			'0'=>'未付款',
			'1'=>'已付款',
			'2'=>'待发货',
			'3'=>'代签收',
			'4'=>'完成',
			'5'=>'交易失败'
			);

		return $arr[$status];
	}
}

