<?php
/**
*@DEC 订单管理
*
**/

class Orders extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('orders_mdl','orders');
		$this->load->model('orders_items_mdl','orders_items');
		$this->load->helper('orders');
	}


	public function index()
	{
		$userinfo = $this->userinfo;
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
      
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->orders->get_count();
        $data['count'] = $count;
        
        /*
        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/orders/index?');
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config ['uri_segment'] = 2;

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li  class="active"><a>';
		//“当前页”链接的打开标签。
		$config['cur_tag_close'] = '</a></li>';
		//“当前页”链接的关闭标签。

		$config['next_link'] = '&gt;';
		//你希望在分页中显示“下一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
		$config['next_tag_open'] = '<li>';
		//“下一页”链接的打开标签。
		$config['next_tag_close'] = '</li>';
		//“下一页”链接的关闭标签。

		$config['prev_link'] = '&lt;';

		//你希望在分页中显示“上一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
		$config['prev_tag_open'] = '<li>';
		//“上一页”链接的打开标签。
		$config['prev_tag_close'] = '</li>';
		//“上一页”链接的关闭标签。

        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();
        */
        $pageconfig['base_url'] = base_url('index.php/home/orders/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;

        $list = $this->orders->get_list_by_join($wherelist);
        $data['list'] = $list;


		$this->load->view('home/orders/home_orders',$data);


	}

	//订单详情
	public function detail()
	{

		//订单基本信息
		$id = $this->input->get('id');
		$config = array('id'=>$id);
		$order_info = $this->orders->get_one_by_where($config);
		$data['order_info'] = $order_info;

		//订单商品详情
		$list = array();
		$where['where'] = array('oi.order_id'=>$id);
		$list = $this->orders_items->get_list_by_join($where);
		$data['list'] = $list;

		//配送方式 1-快递,2-自取,3-送货
		if($order_info['exp'] == 1){
			
		}

		$this->load->view('home/orders/home_orders_detail',$data);

	}


	//订单产品详情
	public function items()
	{
		$id = $this->input->get('id');
		$where['where'] = array('order_id'=>$id);
		$list = array();

		$list = $this->orders_items->getList($where);
		$data['list'] = $list;

		$this->load->view('home/orders/home_orders_items',$data);
	}
}