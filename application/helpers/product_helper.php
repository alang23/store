<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
 * 订单状态
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('product_type'))
{
	function product_type($status)
	{
		//1.普通产品，2-二手，3-周边,4-寄售
		$arr = array(
			'1'=>'普通商品',
			'2'=>'二手',
			'3'=>'周边',
			'4'=>'寄售'
			);
		$status = empty($arr[$status]) ? '未知类别' : $arr[$status];

		return $status;
	}
}

    /**
 * 订单状态
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('consignment_status'))
{
	function consignment_status($status)
	{
		//1.普通产品，2-二手，3-周边,4-寄售
		$arr = array(
			'0'=>'审核中',
			'1'=>'寄售中',
			'2'=>'已出售',
			'3'=>'审核失败',
			'4'=> '通过审核-未上架',
			);
		$status = empty($arr[$status]) ? '未知状态' : $arr[$status];

		return $status;
	}
}




