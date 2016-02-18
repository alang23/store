<?php
/**
*@DECS 商品api
*@author alang
**/

class Goods extends Api_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('goods_mdl','goods');
	}

	//商品列表-
	public function index()
	{
		$data = $this->requestData();
		$status = $data['data']['status'];
		$goods = array();
			
		$where['where'] = array('status'=>$status);
		$goods = $this->goods->getList($where);
		$responseData = array(
			'errcode'=>0,
			'msg'=>'ok',
			'data'=>array(
				'items'=>$goods
				)
		);
	
		$this->responseData($responseData);		
	}


	//详情
	public function detail()
	{
		$data = $this->requestData();
		$id = $data['data']['id'];
		$config = array('id'=>$id);
		$info = array();
		$info = $this->goods->get_one_by_where($config);
		$responseData = array(
			'errcode'=>0,
			'msg'=>'ok',
			'data'=>$info
		);

		$this->responseData($responseData);	
	}

	//线上销售请求
	public function sales()
	{
		$data = $this->requestData();
		$items = $data['data']['items'];

		if(count($items) > 0){
			$this->load->model('orders_mdl','orders');
			foreach($items as $k => $v){
				//$add['mobile'] = $v['mobile'];
				$add['order_no'] = mt_rand(1000,9999);
				$add['goods_id'] = $v['goods_id'];
				$add['deal_cost'] = $v['deal_cost'];
				$add['done_cost'] = $v['done_cost'];
				$add['address'] = $v['address'];
				$add['createtime'] = time();
				//添加订单
				if($this->orders->add($add)){
					$order_id = $this->orders->insert_id();				
					//修改商品状态
					$update_goods_config = array('id'=>$add['goods_id']);
					$update_goods_data = array('status'=>'3');
					$this->goods->update($update_goods_config,$update_goods_data);
					//添加支付日志
					$pays_log['order_id'] = $order_id;
					$pays_log['goods_id'] = $add['goods_id'];
					$pays_log['pays_cost'] = $add['done_cost'];
					$pays_log['pays_id'] = 6;
					$pays_log['createtime'] = time();
					$this->load->model('pays_log_mdl','pays_log');
					$this->pays_log->add($pays_log);
				}				
			}
		}

		$responseData = array(
			'errcode'=>0,
			'msg'=>'ok',
		);

		$this->responseData($responseData);

	}

	//线上卖出
	/**
	*@parant goods_id  id
	*@parant done_cost 已付金额
	*@parant deal_cost 该付金额
	*/
	public function change_goods_status()
	{

	}
}