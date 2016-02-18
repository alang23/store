<?php


class Payslog extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pays_log_mdl','pays_log');
		$this->load->model('orders_mdl','orders');
	}


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
       
		$this->load->view('payslog/payslog_list',$data);
	}

	//订单支付记录
	public function logs()
	{
		$id = $this->input->get('id');
		$where['where'] = array('pl.order_id'=>$id,'pl.isdel'=>0);
		$list = array();
		$list = $this->pays_log->get_list_by_join($where);
		$data['list'] = $list;

		$this->load->view('payslog/payslog_logs',$data);
	}
}