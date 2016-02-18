<?php
/**
*@DEC订单管理
*@author Alang
**/


class Orders extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('orders_mdl','orders');
	}

	//订单列表
	public function index()
	{
		$list = array();
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
          
        $where['where'] = array('isdel'=>0);      
        $limit = 10;
        $offset = ($page - 1) * $limit;
                $pagination = '';

                $count = $this->orders->get_count($where['where']);
                $data['count'] = $count;

                $pageconfig['base_url'] = base_url('index.php/orders/index?');
                $pageconfig['count'] = $count;
                $pageconfig['limit'] = $limit;
                $data['page'] = home_page($pageconfig);

                $list = array();
                $wherelist['page'] = true;
                $wherelist['limit'] = $limit;
                $wherelist['offset'] = $offset;
                $wherelist['where'] = array('orders.isdel'=>0);

                $list = $this->orders->get_list_by_join($wherelist);
                $data['list'] = $list;
       
		$this->load->view('orders/orders_list',$data);
	}

        //配送
        public function freight()
        {
            $userinfo = $this->userinfo;
            if(!empty($_POST)){

                $id = $this->input->post('id');
                $code = $this->input->post('code');
                if(!empty($code)){
                    $order_info = array();
                    $config = array('id'=>$id);
                    $order_info = $this->orders->get_one_by_where($config);
                    $add['goods_id'] = $order_info['goods_id'];
                    $add['order_id'] = $id;
                    $add['code'] = $code;
                    $add['act_id'] = $userinfo['id'];
                    $add['createtime'] = time();
                    $this->load->model('orders_freight_mdl','orders_freight');
                    if($this->orders_freight->add($add)){
                        //修改订单状态
                        $update_order_status_data = array('exp'=>1);
                        $update_order_status_config = array('id'=>$id);
                        $this->orders->update($update_order_status_config,$update_order_status_data);

                        redirect('/orders/index');
                    }
                }
            }else{
                $id = $this->input->get('id');
                $order_info = array();
                $config = array('orders.id'=>$id);
                $order_info = $this->orders->get_one_by_join($config);
                $data['order_info'] = $order_info;
                $this->load->view('orders/orders_freight',$data);
            }

        }

        //收款
        public function pays()
        {
            $userinfo = $this->userinfo;
            if(!empty($_POST)){

                $id = $this->input->post('id');
                $total = $this->input->post('total');
                $pays_cost = $this->input->post('pays_cost');
                $pays_id = $this->input->post('pays_id');
                if(!empty($id)){
                    $order_info = array();
                    $config = array('id'=>$id);
                    $order_info = $this->orders->get_one_by_where($config);
                    //修改订单信息

                    //添加支付记录
                    $this->load->model('pays_log_mdl','pays_log');
                    $pays_log['order_id'] = $order_info['id'];
                    $pays_log['goods_id'] = $order_info['goods_id'];
                    $pays_log['pays_id'] = $pays_id;
                    $pays_log['pays_cost'] = $pays_cost;
                    $pays_log['createtime'] = time();
                    if($this->pays_log->add($pays_log)){
                        //总价和交易价一支，改变订单状态
                        if(($order_info['done_cost']+$pays_cost) == $order_info['deal_cost']){
                            $update_orders_config = array('id'=>$id);
                            $update_orders_data = array('status'=>0,'done_cost'=>($order_info['done_cost']+$pays_cost));
                            $this->orders->update($update_orders_config,$update_orders_data);
                        }
                    }
                    
                redirect('/orders/index');
                    
                }
            }else{
                $id = $this->input->get('id');
                $order_info = array();
                $config = array('orders.id'=>$id);
                $order_info = $this->orders->get_one_by_join($config);
                $data['order_info'] = $order_info;

                //支付方式
                $pays = array();
                $this->load->model('pays_mdl','pays');
                $pays = $this->pays->getList();
                $data['pays'] = $pays;
                $this->load->view('orders/orders_pays',$data);
            }
        }

        public function del()
        {
            $id = $this->input->get('id');
            $update_config = array('id'=>$id);
            $update_data = array('isdel'=>1);
            $this->load->orders->update($update_config,$update_data);

            redirect('/orders/index');
        }
}