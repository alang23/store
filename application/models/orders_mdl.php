<?php
/**
*@DEC 品牌model
*
**/

class Orders_mdl extends Spring_Model
{

	var $table_name = 'st_orders';
	var $table_employee = 'st_employee';
	var $table_goods = 'st_goods';
	var $table_customer = 'st_customer';




	public function __construct()
	{
		parent::__construct();
		$this->set_table_name($this->table_name);
	}


	public function get_list_by_join($config = array())
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
				'orders.*,customer.customer_name,goods.goods_name,sale.username,sale.realname,goods.price_market'
			)
					->from($this->table_name.' as orders')
					->join($this->table_customer.' as customer','customer.id=orders.customer_id','left')
					->join($this->table_goods.' as goods','goods.id=orders.goods_id','left')
					->join($this->table_employee.' as sale','sale.id=orders.sale_id','left')		
					->get()->result_array();

		return $list;
	}

		public function get_one_by_join($config = array())
	{
		if(!empty($config)){
            $this->db->where($config);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }

		$list = array();
		$list = $this->db->select(
				'orders.*,customer.customer_name,goods.goods_name,sale.username,sale.realname,goods.price_market'
			)
					->from($this->table_name.' as orders')
					->join($this->table_customer.' as customer','customer.id=orders.customer_id','left')
					->join($this->table_goods.' as goods','goods.id=orders.goods_id','left')
					->join($this->table_employee.' as sale','sale.id=orders.sale_id','left')		
					->get()->row_array();

		return $list;
	}

}