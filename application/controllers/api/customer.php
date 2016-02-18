<?php
/**
*@DEC 客户端用户注册
*@author alang
**/


class Customer extends Api_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('customer_mdl','customer');
	}

	public function index()
	{
		$data = $this->requestData();
		$mobile = $data['data']['mobile'];
		$username = $data['data']['username'];
		$realname = $data['data']['realname'];
		$frm = $data['data']['frm'];
		/*
		$mobile = '13800138007';
		$username = 'test';
		$realname = 'testrealname';
		$frm = 1;
		*/
		if(!empty($mobile) && !empty($username) && !empty($realname)){

			$config = array('mobile'=>$mobile);
			$check_info = array();
			$check_info = $this->customer->get_one_by_where($config);
			if(!empty($check_info)){
				$responseData = array(
					'errcode'=>'-3',
					'msg'=>'用户已经存在',
					
				);
				$this->responseData($responseData);	
			}

			//判断是否已经存在
			$add['customer_name'] = $realname;
			$add['mobile'] = $mobile;
			$add['username'] = $username;
			$add['frm'] = $frm;
			$add['createtime'] = time();
					
			if($this->customer->add($add)){
				$responseData = array(
					'errcode'=>0,
					'msg'=>'ok',
					
				);
			}else{
				$responseData = array(
					'errcode'=>-1,
					'msg'=>'添加失败，请重试',
					
				);
			}
		}else{

				$responseData = array(
					'errcode'=>-2,
					'msg'=>'信息不完整',
					
				);
		}
		$this->responseData($responseData);	
	}


}