<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*@后台登陆controller
*
**/


class Login extends Base_Controller
{


	public function __construct()
	{
		parent::__construct();
		
	}


	public function index()
	{
		$this->load->view('login');
	}

	//登陆处理
	public function do_login()
	{
	
		if(!empty($_POST)){
			$username = $this->input->post('username');
			$pawd = $this->input->post('pawd');
	
			//用户名或密码为空
			if(empty($username) || empty($pawd)){
				$msg = array('errcode'=>-1,'msg'=>'请完整填写登陆信息');
				echo json_encode($msg);
				exit;
			}
			//验证账户
			$this->load->model('admin_mdl','admin');
			
			$config = array('username'=>$username);
			$info = $this->admin->get_one_by_where($config);
			if(empty($info)){
				$msg = array('errcode'=>-2,'msg'=>'账户不存在');
				echo json_encode($msg);
				exit;
			}
			
			//验证密码
			if($info['pawd'] != md5($pawd)){
				$msg = array('errcode'=>-3,'msg'=>'密码有误');
				echo json_encode($msg);
				exit;
			}

			//写session;
			unset($info['pawd']);
	
			$cookie_name = $this->config->item('admin_cookie_name');
		
			$this->session->set_userdata($cookie_name,$info);

			$msg = array('errcode'=>0,'msg'=>'登陆成功');
			echo json_encode($msg);


		}else{
			$msg = array('errcode'=>-4,'msg'=>'未知请求');
			echo json_encode($msg);
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('token');
        redirect('login');
	}





} 