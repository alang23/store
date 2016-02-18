<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
 * 订单状态
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('order_status'))
{
	function order_status($status)
	{
		$arr = array(
			'0'=>'未付款',
			'1'=>'待发货',
			'2'=>'待签收',
			'3'=>'完成',
			'4'=>'交易失败'
			);
		$status = empty($arr[$status]) ? '未知状态' : $arr[$status];

		return $arr[$status];
	}
}

//配送方式
if(! function_exists('exp_type'))
{
	function exp_type($type)
	{
		$arr = array(
				'0'=>'未知',
				'1'=>'快递',
				'2'=>'自取',
				'3'=>'送货'
			);

		return $arr[$type];
	}
}

//发票
if(! function_exists('invoice_type'))
{
	function invoice_type($type)
	{
		$arr = array(
				'0'=>'不开发票',
				'1'=>'个人发票',
				'2'=>'单位发票'
			);


		return $arr[$type];
	}

}
