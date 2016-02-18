<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*用户相关信息查看
*
**/

class Member_info extends Admin_Controller
{




	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_mdl','member');
	}


	public function index()
	{
		$userinfo = $this->userinfo;

		$id = $this->input->get('id');
		$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
		$info = $this->member->get_one_by_where($config);
		$data['info'] = $info;

		//收货地址记录
		$address = array();
		$this->load->model('user_address_mdl','user_address');
		$where['where'] = array('ar.uid'=>$id);
		$address = $this->user_address->get_list_by_join($where);
		$data['address'] = $address;
		//print_r($address);


		
		$this->load->view('home/home_member_info',$data);
	}
}