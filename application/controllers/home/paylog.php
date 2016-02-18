<?php
/**
*@DEC支付返回信息日志
*
**/

class Paylog extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pay_log_mdl','pay_log');
	}


	public function index()
	{
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $where['where'] = array('issure'=>0);
         
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->pay_log->get_count($where['where']);
        $data['count'] = $count;

		$pageconfig['base_url'] = base_url('index.php/home/paylog/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $wherelist['where'] = array('issure'=>0);

        $list = $this->pay_log->getList($wherelist);
        $data['list'] = $list;

        $this->load->view('home/paylog/home_pay_log',$data);

	}

	public function del()
	{
		$id = $this->input->get('id');
		$updateconfig = array('id'=>$id);
		$updatedata = array('issure'=>1);

		$this->pay_log->update($updateconfig,$updatedata);

		redirect('/home/paylog/index');
	}


}