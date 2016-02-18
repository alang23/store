<?php
/**
*@DEC 品牌model
*
**/

class Pays_log_mdl extends Spring_Model
{

	var $table_name = 'st_pays_log';
	var $table_orders = 'st_orders';
	var $table_goods = 'st_goods';
	var $table_pays = 'st_pays';

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
				'pl.*,orders.order_no,orders.deal_cost,done_cost,goods.goods_name,goods.goods_no,goods.price_market,pays.pay_name'
			)
					->from($this->table_name.' as pl')
					->join($this->table_orders.' as orders','orders.id=pl.order_id','left')
					->join($this->table_goods.' as goods','goods.id=pl.goods_id','left')		
					->join($this->table_pays.' as pays','pays.id=pl.pays_id','left')	
					->get()->result_array();

		return $list;
	}

}