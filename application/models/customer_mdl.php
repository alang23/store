<?php
/**
*@DEC 品牌model
*
**/

class Customer_mdl extends Spring_Model
{

	var $table_name = 'st_customer';
	var $table_province = 'st_province';
	var $table_city = 'st_city';
	var $table_zone = 'st_zone';
	var $table_employee = 'st_employee';

	public function __construct()
	{
		parent::__construct();
		$this->set_table_name($this->table_name);
	}

	public function get_list_join($config = array())
	{

		if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }


		$list = array();
		$list = $this->db->select(
				'c.customer_name,c.id,c.mobile,c.createtime,prov.ProName,city.CityName,zone.ZoneName,emp.username,emp.realname'
			)
					->from($this->table_name.' as c')
					->join($this->table_province.' as prov','prov.ProSort=c.province_id','left')
					->join($this->table_city.' as city','city.CitySort=c.city_id','left')
					->join($this->table_zone.' as zone','zone.ZoneID=c.zone_id','left')
					->join($this->table_employee.' as emp','emp.id=c.sale_id','left')
					->get()->result_array();

		return $list;
	}

}