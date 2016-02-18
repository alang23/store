<?php
/**
*@desc 商品管理
*@author Alang
**/

class Goods extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('goods_mdl','goods');
	}

	//产品列表
	public function index()
	{
		$list = array();
		$userinfo = $this->userinfo;

		$goods_no = isset($_GET['goods_no']) ? $_GET['goods_no'] : '';
		$goods_name = isset($_GET['goods_name']) ? $_GET['goods_name'] : '';
		$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '0';
		$buyer_id = isset($_GET['buyer_id']) ? $_GET['buyer_id'] : '0';
		$goods_color = isset($_GET['goods_color']) ? $_GET['goods_color'] : '0';
		$data['goods_no'] = $goods_no;
		$data['goods_name'] = $goods_name;
		$data['category_id'] = $category_id;
		$data['buyer_id'] = $buyer_id;
		$data['goods_color'] = $goods_color;
		
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $wherelist = array();
  		
  		 if(!empty($goods_name)){
  			 $where['like']['key'] = 'goods_name'; 
  			 $where['like']['value'] = $goods_name;

  			 $wherelist['like']['key'] = 'goods_name';
  			 $wherelist['like']['value'] = $goods_name; 
  		}

  		if(!empty($goods_no)){
  			 $where['where']['goods_no'] = $goods_no; 
  			 $wherelist['where']['goods_no'] = $goods_no; 
  		}
  		
  		 if(!empty($category_id)){
  		 	
  			 $where['where']['category_id'] = $category_id; 
  			 $wherelist['where']['category_id'] = $category_id; 
  		}
  		if(!empty($goods_color)){
  			 $where['where']['goods_color'] = $goods_color;
  			 $wherelist['where']['goods_color'] = $goods_color;  
  		}

  		if(!empty($buyer_id)){
  			 $where['where']['buyer_id'] = $buyer_id; 
  			 $wherelist['where']['buyer_id'] = $buyer_id; 
  		}
  		
  		
        $where['where']['isdel'] = 0;      
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->goods->get_count($where['where']);
        $data['count'] = $count;

        $pageconfig['base_url'] = base_url('index.php/goods/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $wherelist['where']['isdel'] = 0;
        
        $list = $this->goods->getList($wherelist);
        $data['list'] = $list;

        $config_where['where'] = array('isdel'=>0);
        				//color
		$this->load->model('color_mdl','color');
		$colors = array();
		$colors = $this->color->getList($config_where);
		$data['colors'] = $colors;

					//
		$this->load->model('category_mdl','category');
		$categorys = array();
		$categorys = $this->category->getList($config_where);
		$data['categorys'] = $categorys;

		$this->load->model('buyer_mdl','buyer');
		$buyers = array();
		$buyers = $this->buyer->getList($config_where);
		$data['buyers'] = $buyers;
		//print_r($buyers);
        
		$this->load->view('goods/goods_list',$data);
	}


	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){
			$goods_name = $this->input->post('goods_name');
			$buyer_id = $this->input->post('buyer_id');
			$brand_id = $this->input->post('brand_id');
			$category_id = $this->input->post('category_id');
			$goods_year = $this->input->post('goods_year');
			$goods_size = $this->input->post('goods_size');
			$goods_color = $this->input->post('goods_color');
			$goods_caizhi = $this->input->post('goods_caizhi');
			$price_market = $this->input->post('price_market');
			$price_cost = $this->input->post('price_cost');
			$remark = $this->input->post('remark');
			$check_id = $this->input->post('check_id');
			$store_id = $this->input->post('store_id');

			if(!empty($goods_name)){
				$add['goods_no'] = mt_rand(1000,9999).time();
				$add['goods_name'] = $goods_name;
				$add['buyer_id'] = $buyer_id;
				$add['brand_id'] = $brand_id;
				$add['category_id'] = $category_id;
				$add['goods_year'] = $goods_year;
				$add['goods_size'] = $goods_size;
				$add['goods_color'] = $goods_color;
				$add['createtime'] = time();
				$add['price_market'] = $price_market;
				$add['price_cost'] = $price_cost;
				$add['goods_caizhi'] = $goods_caizhi;
				$add['remark'] = $remark;
				$add['store_id'] = $store_id;

				if($this->goods->add($add)){
					$this->load->model('goods_check_user_mdl','goods_check_user');
					$goods_id = $this->goods->insert_id();
					if(count($check_id)){
						$count = count($check_id);
						for($i=0;$i<$count;$i++){
							$tmp['goods_id'] = $goods_id;
							$tmp['uid'] = $check_id[$i];
							$tmp['createtime'] = time();
							$this->goods_check_user->add($tmp);
						}
					}
					redirect('/goods/index');
				}else{
					exit('info error');
				}
			}

		}else{
			//
			$this->load->model('buyer_mdl','buyer');
			$buys = array();
			$buys = $this->buyer->getList();
			$data['buys'] = $buys;
			
			//
			$this->load->model('category_mdl','category');
			$categorys = array();
			$categorys = $this->category->getList();
			$data['categorys'] = $categorys;

			//brand
			$this->load->model('brand_mdl','brand');
			$brands = array();
			$brands = $this->brand->getList();
			$data['brands'] = $brands;

			//store
			$this->load->model('store_mdl','store');
			$stores = array();
			$stores = $this->store->getList();
			$data['stores'] = $stores;

			//color
			$this->load->model('color_mdl','color');
			$colors = array();
			$colors = $this->color->getList();
			$data['colors'] = $colors;

			//审核人员
			$employee = array();
			$this->load->model('employee_mdl','employee');
			$employee = $this->get_employee();
			$data['employee'] = $employee;

			$this->load->view('goods/goods_add',$data);
		}
	}

	public function update()
	{
		if(empty($_POST)){
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = array();
			$info = $this->goods->get_one_by_where($config);
			$data['info'] = $info;
			
			$this->load->model('buyer_mdl','buyer');
			$buys = array();
			$buys = $this->buyer->getList();
			$data['buys'] = $buys;				
			//
			$this->load->model('category_mdl','category');
			$categorys = array();
			$categorys = $this->category->getList();
			$data['categorys'] = $categorys;

			//brand
			$this->load->model('brand_mdl','brand');
			$brands = array();
			$brands = $this->brand->getList();
			$data['brands'] = $brands;

				//store
			$this->load->model('store_mdl','store');
			$stores = array();
			$stores = $this->store->getList();
			$data['stores'] = $stores;

				//color
			$this->load->model('color_mdl','color');
			$colors = array();
			$colors = $this->color->getList();
			$data['colors'] = $colors;

				//审核人员
			$employee = array();
			$employee = $this->get_employee();
			$data['employee'] = $employee;

			//审核人
			$check_user = array();
			$this->load->model('goods_check_user_mdl','goods_check_user');
			$check_user_where['where'] = array('goods_id'=>$info['id']);
			$check_user = $this->goods_check_user->getList($check_user_where);
			$cuid = array();
			if(count($check_user)){
				foreach($check_user as $ck => $cv){
					$cuid[] = $cv['uid'];
				}
			}
			$data['cuid'] = $cuid;

			$this->load->view('goods/goods_update',$data);
		}else{
			$goods_name = $this->input->post('goods_name');
			$buyer_id = $this->input->post('buyer_id');
			$brand_id = $this->input->post('brand_id');
			$category_id = $this->input->post('category_id');
			$goods_year = $this->input->post('goods_year');
			$goods_size = $this->input->post('goods_size');
			$goods_color = $this->input->post('goods_color');
			$goods_caizhi = $this->input->post('goods_caizhi');
			$price_market = $this->input->post('price_market');
			$price_cost = $this->input->post('price_cost');
			$remark = $this->input->post('remark');
			$check_id = $this->input->post('check_id');
			$store_id = $this->input->post('store_id');
			$id = $this->input->post('id');

			if(!empty($goods_name)){
				$add['goods_name'] = $goods_name;
				$add['buyer_id'] = $buyer_id;
				$add['brand_id'] = $brand_id;
				$add['category_id'] = $category_id;
				$add['goods_year'] = $goods_year;
				$add['goods_size'] = $goods_size;
				$add['goods_color'] = $goods_color;
				$add['price_market'] = $price_market;
				$add['price_cost'] = $price_cost;
				$add['goods_caizhi'] = $goods_caizhi;
				$add['remark'] = $remark;
				$add['store_id'] = $store_id;
				$update_config = array('id'=>$id);
				//if($this->goods->add($add)){
				$this->goods->update($update_config,$add);
				$this->load->model('goods_check_user_mdl','goods_check_user');

				if(count($check_id)){
					$del_config = array('goods_id'=>$id);
					$this->goods_check_user->del($del_config);
					$count = count($check_id);
					for($i=0;$i<$count;$i++){
						$tmp['goods_id'] = $id;
						$tmp['uid'] = $check_id[$i];
						$tmp['createtime'] = time();
						$this->goods_check_user->add($tmp);
					}
				}
					redirect('/goods/index');
			}else{
					exit('info error');
			}

		}

	}

	public function del(){
		$id = $this->input->get('id');
		$config = array('id'=>$id);
		$update_data = array('isdel'=>1);
		$this->goods->update($config,$update_data);

		redirect('/goods/index');
	}

	//产品详情
	public function show()
	{
		$id = $this->input->get('id');
		$config = array('goods.id'=>$id);
		$info = array();
		$info = $this->goods->get_one_by_join($config);

		$data['info'] = $info;
		
		//审核人
		$this->load->model('goods_check_user_mdl','goods_check_user');
		$check_user = array();
		$where['where'] = array('gc.goods_id'=>$id);
		$check_user = $this->goods_check_user->get_list_join($where);
		$check_user_name = '';
		if(count($check_user)){
			foreach($check_user as $k => $v){
				$check_user_name .= $v['username'].'('.$v['realname'].')';
			}
		}
		$data['check_user_name'] = $check_user_name;
		$data['check_user'] = $check_user;
		
		$this->load->view('goods/goods_show',$data);
	}

	//销售
	public function sales()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$goods_id = $this->input->post('goods_id');
			$deal_cost = $this->input->post('deal_cost');
			$done_cost = $this->input->post('done_cost');
			$customer_id = $this->input->post('customer_id');
			$exp_type = $this->input->post('exp_type');
			$address = $this->input->post('address');
			$pays_id = $this->input->post('pays_id');
			$act_id = $userinfo['id'];
			$remark = $this->input->post('remark');
			$sale_id = $this->input->post('sale_id');

			if(!empty($goods_id) && !empty($deal_cost)){
				//产品信息
				$goods_info = array();
				$goods_info_config = array('id'=>$goods_id);
				$goods_info = $this->goods->get_one_by_where($goods_info_config);
				$order_no = 'BG'.mt_rand(10,99).time();
				$add['order_no'] = $order_no;
				$add['goods_id'] = $goods_id;
				$add['deal_cost'] = $deal_cost;
				$add['done_cost'] = $done_cost;
				$add['customer_id'] = $customer_id;
				$add['sale_id'] = $sale_id;
				$add['exp_type'] = $exp_type;
				$add['address'] = $address;
				$add['act_id'] = $userinfo['id'];
				$add['remark'] = $remark;
				$add['pays_id'] = $pays_id;
				$add['status'] = $deal_cost == $done_cost ? 0 : 1;
				$add['createtime'] = time();

				$this->load->model('orders_mdl','orders');
				if($this->orders->add($add)){
					$order_id = $this->orders->insert_id();
					//添加支付记录
					$this->load->model('pays_log_mdl','pays_log');
					$pays_log['order_id'] = $order_id;
					$pays_log['goods_id'] = $goods_id;
					$pays_log['pays_id'] = $pays_id;
					$pays_log['pays_cost'] = $done_cost;
					$pays_log['createtime'] = time();
					$this->pays_log->add($pays_log);

					//change goods status
					$update_goods_status_config = array('id'=>$goods_id);
					$update_goods_status_data = array('status'=>3);
					
					$this->goods->update($update_goods_status_config,$update_goods_status_data);

					//通知app
					$this->load->helper('common');
					//$remote_server = 'http://bossbuy.sp/index.php/goodsapi/goodsinfo/change_goods_status';
					$remote_server = $this->config->item('api_url');
					$remote_server .= 'goodsinfo/change_goods_status';
					$post_arr = array(
						'tag'=>'goods_info',
						'data'=>array('act'=>'off','id'=>$goods_id)
						);
					
					$post_string = json_encode($post_arr);
					$json_list = request_by_curl($remote_server, $post_string);
					
					echo $json_list;
					exit;
					//通知app
					redirect('/goods/index');

				}	




			}else{
				exit('info error');
			}

		}else{
			//商品
			$goods = array();
			$wheregoods['where'] = array('isdel'=>0,'status'=>0);
			$this->load->model('goods_mdl','goods');
			$goods = $this->goods->getList($wheregoods);
			$data['goods'] = $goods;

			$where['where'] = array('isdel'=>0);
			//客户
			$customer = array();
			$this->load->model('customer_mdl','customer');
			$customer = $this->customer->getList($where);
			$data['customer'] = $customer;

			//支付
			$pays= array();
			$this->load->model('pays_mdl','pays');
			$pays = $this->pays->getList($where);
			$data['pays'] = $pays;

			//商品信息
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$goods_info = array();
			$goods_info = $this->goods->get_one_by_where($config);
			$data['goods_info'] = $goods_info;

			//销售人员
			$sales = array();
			$this->load->model('employee_mdl','employee');
			$sales = $this->employee->getList($where);
			$data['sales'] = $sales;

			$this->load->view('goods/goods_sales',$data);
		}
	}

	//员工
	private function get_employee()
	{
		$this->load->model('employee_mdl','employee');
		$list = array();
		$list = $this->employee->getList();

		return $list;
	}
}