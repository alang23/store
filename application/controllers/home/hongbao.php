<?php
/**
*
*@dec 红包
*
**/
class Hongbao extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('hongbao_mdl','hongbao');
	}


	public function index()
	{

		$userinfo = $this->userinfo;
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
      
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->hongbao->get_count();
        $data['count'] = $count;
        
        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/hongbao/index?');
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

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;

        $list = $this->hongbao->getList($wherelist);
        $data['list'] = $list;

        $this->load->view('home/yingxiao/home_hongbao',$data);
	
	}

	//添加红包
	public function add()
	{
		$num = $this->input->post('num');
		$ex = $this->input->post('ex');
		$amount = $this->input->post('amount');

		if(!empty($num) && !empty($amount)){

		}

	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$config = array('id'=>$id);
		$this->hongbao->del($config);

		redirect('/home/hongbao/index');
	}
}