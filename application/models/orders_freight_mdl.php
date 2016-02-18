<?php
/**
*@DEC 品牌model
*
**/

class Orders_freight_mdl extends Spring_Model
{

	var $table_name = 'st_orders_freight';
	var $table_customer = 'st_customer';
	var $table_goods = 'st_goods';

	public function __construct()
	{
		parent::__construct();
		$this->set_table_name($this->table_name);
	}

	public function get_one_by_join($config = array())
	{
		if(!empty($config)){
            $this->db->where($config);
        }



		return $list;
	}

}