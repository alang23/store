<?php
/**
*@DEC 寄售属性model
*
**/

class Consignment_mdl extends Spring_Model
{

	var $table_name = 'spring_consignment';
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
		$list = $this->db->select(
			'co.id,co.suk,co.pro_name,co.price,co.img,co.uid,co.pid,co.reviewer,co.createtime,co.status,co.tags,
			m.username as mname,a.username'
			)
					->from($this->table_name.' as co')
					->join($this->table_member.' as m','m.id=co.uid','left')
					->join($this->table_admin.' as a','a.id=co.reviewer','left')
					->get()->result_array();

		return $list;
	}

	//链表取单条信息
	public function get_one_by_join($config = array())
	{
		if(!empty($config)){
            $this->db->where($config);
        }


		$row = array();
		$row = $this->db->select('co.id,co.suk,co.pro_name,co.price,co.tel,co.img,co.uid,co.reviewer,co.createtime,co.status,co.intro,co.tags,co.reasons,m.username as mname,a.username')
					->from($this->table_name.' as co')
					->join($this->table_member.' as m','m.id=co.uid','left')
					->join($this->table_admin.' as a','a.id=co.reviewer','left')
					->get()->row_array();

		return $row;

	}
	
}