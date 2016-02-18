<?php
/**
*@DEC日志类
*@author alang
**/


class Diqu{

	public static $_ci;
	/**
	*@parant $type  日志类型
	*@parant $arr   日志内容
	**/

	public function __construct()
	{
		self::$_ci = & get_instance();//php 5.3中self改为static
		self::$_ci->load->model('province_mdl','province');
		self::$_ci->load->model('city_mdl','city');
		self::$_ci->load->model('zone_mdl','zone');
	}

	//省份
	public function get_province($id=0)
	{
		$where['where'] = array();
		if(!empty($id)){
			$where['where'] = array('ProSort'=>$id);
		}
		$list = array();
		$list = self::$_ci->province->getList($where);

		return $list;
	}

		//城市
	public function get_city($province_id)
	{
		$where['where'] = array();
		if(!empty($province_id)){
			$where['where'] = array('ProID'=>$province_id);
		}
		
		$list = array();
		$list = self::$_ci->city->getList($where);

		return $list;
	}

	//城市
	public function get_zone($city_id)
	{
		$where['where'] = array();
		if(!empty($city_id)){
			$where['where'] = array('CityID'=>$city_id);
		}
		$list = array();
		$list = self::$_ci->zone->getList($where);

		return $list;
	}


}