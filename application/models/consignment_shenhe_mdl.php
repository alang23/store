<?php
/**
*@DEC 寄售审核model
*
**/

class Consignment_shenhe_mdl extends Spring_Model
{

	var $table_name = 'spring_consignment_shenhe';
	var $table_member = 'spring_member';
	var $table_admin = 'spring_admin';

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
		$list = $this->db->select('co.id,co.suk,co.createtime,co.status,co.intro,m.username as mname')
					->from($this->table_name.' as co')
					->join($this->table_member.' as m','m.id=co.uid','left')
					->get()->result_array();

		return $list;
	}
	
}