<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*@DEC支付管理
*
*
**/
class Pay extends Admin_Controller
{
	

	public function __construct()
	{

		parent::__construct();
		$this->load->model('pay_mdl','pay');
	}


	public function index()
	{
		$list = array();
		$list = $this->pay->getList();
		$data['list'] = $list;

		$this->load->view('home/home_pay',$data);
	}
}