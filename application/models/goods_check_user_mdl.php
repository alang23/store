<?php
/**
*@DEC 品牌model
*
**/

class Goods_check_user_mdl extends Spring_Model
{

	var $table_name = 'st_goods_check_user';
	var $table_employee = 'st_employee';

	public function __construct()
	{
		parent::__construct();
		$this->set_table_name($this->table_name);
	}


	//链表查询
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
				'gc.createtime,gc.result,gc.isdel,emp.username,emp.realname'
			)
					->from($this->table_name.' as gc')
					->join($this->table_employee.' as emp','emp.id=gc.uid','left')
					->get()->result_array();

		return $list;
	}

}