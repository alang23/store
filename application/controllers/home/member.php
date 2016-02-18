<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*@DEC 会员Controller
*
**/


class Member extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_mdl','member');
	}


	public function index()
	{
		$list = array();
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        
        $where['where'] = array('shop_id'=>$userinfo['shop_id'],'issure'=>1);
         
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->member->get_count($where['where']);
        $data['count'] = $count;

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/member/index?');
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config ['uri_segment'] = 4;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->member->getList($where);
        $data['list'] = $list;

		$this->load->view('home/home_member',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$username = $this->input->post('username');
			$phone = $this->input->post('phone');
			$realname = $this->input->post('realname');
			$gender = $this->input->post('gender');
			$address = $this->input->post('address');
			$enabled = $this->input->post('enabled');
			$email = $this->input->post('email');
			$pawd = $this->input->post('pawd');

			/****判断手机是否已经存在****/
				$checkphone = $this->check_phone($phone);
				if(!$checkphone){
					exit('该手机号已经存在');
				}
			/*******/

			if(!empty($phone) && !empty($pawd)){
				/***判断是否有图片上传**/
				if(!empty($_FILES)){

			        $config['upload_path'] = './uploads/member/';
			        $config['allowed_types'] = '*';
			        $config['file_name']  =date("YmdHis").'_'.$userinfo['id'];

			        $this->load->library('upload', $config);
			        if ( $upload = $this->upload->do_upload('userfile'))
			        {
			            $upload = $this->upload->data();
			            $add['photo'] = $upload['file_name'];			        	           
			        }else{
			            echo $this->upload->display_errors();
			        }
			    }else{
			        exit('file empty');
			    }
			    /***判断是否有图片上传**/

			    /***添加操作***/
			    $add['username'] = $username;
			    $add['phone'] = $phone;
			    $add['realname'] = $realname;
			    $add['shop_id'] = $userinfo['shop_id'];
			    $add['address'] = $address;
			    $add['enabled'] = $enabled;
			    $add['gender'] = $gender;
			    $add['email'] = $email;
			    $add['createtime'] = time();
			    $add['pawd'] = md5($pawd);

			  	if($this->member->add($add)){
			  		redirect('/home/member/index');
			  	}
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			$this->load->view('home/home_member_add');
			
		}
	}

		//修改
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$username = $this->input->post('username');
			$realname = $this->input->post('realname');
			$gender = $this->input->post('gender');
			$address = $this->input->post('address');
			$enabled = $this->input->post('enabled');
			$email = $this->input->post('email');
			$id = $this->input->post('id');

				/***判断是否有图片上传**/
				if(!empty($_FILES)){

			        $config['upload_path'] = './uploads/member/';
			        $config['allowed_types'] = '*';
			        $config['file_name']  =date("YmdHis").'_'.$userinfo['id'];

			        $this->load->library('upload', $config);
			        if ( $upload = $this->upload->do_upload('userfile'))
			        {
			            $upload = $this->upload->data();
			            $add['photo'] = $upload['file_name'];			        	           
			        }else{
			            echo $this->upload->display_errors();
			        }
			    }else{
			        exit('file empty');
			    }
			    /***判断是否有图片上传**/

			   /***修改操作***/
			   $add['username'] = $username;
			   $add['realname'] = $realname;
			   $add['address'] = $address;
			   $add['enabled'] = $enabled;
			   $add['gender'] = $gender;
			   $add['email'] = $email;
			  
			 $config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
			 $this->member->update($config,$add);
			 redirect('/home/member/index');			
			 /***修改操作***/
			
		}else{
			$id = $this->input->get('id');
			$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
			$info = $this->member->get_one_by_where($config);
			if(empty($info)){
				exit('数据不存在');
			}
			$data['info'] = $info;
			$this->load->view('home/home_member_edit',$data);
			
		}
	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id,'shop_id'=>$userinfo['shop_id']);
		$data['issure'] = 0;
		$this->member->update($config,$data);

		redirect('/home/member/index');
	}

	public function check_phone($phone)
	{
		if(empty($phone)){
			return false;
		}
		$config = array('phone'=>$phone);
		$info = $this->member->get_one_by_where($config);
		if(!empty($info)){
			return false;
		}

		return true;
	}


}