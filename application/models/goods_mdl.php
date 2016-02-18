<?php
/**
*@DEC 品牌model
*
**/

class Goods_mdl extends Spring_Model
{

	var $table_name = 'st_goods';
	var $table_category = 'st_category';
	var $table_brand = 'st_brand';
	var $table_store = 'st_store';
	var $table_buyer = 'st_buyer';
	var $table_color = 'st_color';




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

		$list = array();
		$list = $this->db->select(
				'goods.goods_no,goods.goods_name,goods.id,goods.price_market,goods.goods_year,goods.goods_size,goods.goods_caizhi,goods.price_cost,
				category.c_name,brand.b_name,brand.b_name_en,color.color_name,buyer.nickname,buyer.realname,store.store_name,category.c_name
				'
			)
					->from($this->table_name.' as goods')
					->join($this->table_category.' as category','category.id=goods.category_id','left')
					->join($this->table_brand.' as brand','brand.id=goods.brand_id','left')
					->join($this->table_store.' as store','store.id=goods.store_id','left')
					->join($this->table_color.' as color','color.id=goods.goods_color','left')
					->join($this->table_buyer.' as buyer','buyer.id=goods.buyer_id','left')
					//->where('goods.id',14)
					->get()->row_array();

		return $list;
	}

}