<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*@desc 商品品牌Controller
*@author Alang
**/

class Buyer extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('buyer_mdl','buyer');
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

        $count = $this->buyer->get_count($where['where']);
        $data['count'] = $count;

        $pageconfig['base_url'] = base_url('index.php/buyer/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->buyer->getList($where);
        $data['list'] = $list;

		$this->load->view('buyer/buyer_list',$data);
	
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;

		if(!empty($_POST)){
			$nickname = $this->input->post('nickname');
			$realname = $this->input->post('realname');
			$mobile = $this->input->post("mobile");
			$email = $this->input->post("email");
			if(!empty($_FILES)){
			    $config['upload_path'] = './uploads/buyer/';
			    $config['allowed_types'] = '*';
			    $configpic['file_name']  =date("YmdHis");
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

			if(!empty($nickname)){
				$add['nickname'] = $nickname;
				$add['realname'] = $realname;
				$add['mobile'] = $mobile;
				$add['email'] = $email;
				if($this->buyer->add($add)){
					redirect('/buyer/index');
				}
			}else{
				exit('信息有误');
			}
		}else{
			$this->load->view('buyer/buyer_add');
		}
	}

	//修改
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){
			$nickname = $this->input->post('nickname');
			$realname = $this->input->post('realname');
			$mobile = $this->input->post("mobile");
			$email = $this->input->post("email");
			$id = $this->input->post('id');

			if(!empty($_FILES)){
			    $config['upload_path'] = './uploads/buyer/';
			    $config['allowed_types'] = '*';
			    $configpic['file_name']  =date("YmdHis");
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

			if(!empty($nickname)){
				$add['nickname'] = $nickname;
				$add['realname'] = $realname;
				$add['mobile'] = $mobile;
				$add['email'] = $email;
				
				$update_config = array('id'=>$id);
				$this->buyer->update($update_config,$add);

				redirect('/buyer/index');
				
			}else{
				exit('信息有误');
			}

		}else{
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = $this->buyer->get_one_by_where($config);
			if(empty($info)){
				exit('内容不存在');
			}
			$data['info'] = $info;
			$this->load->view('buyer/buyer_edit',$data);
		}
	}


		//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$update_data = array('isdel'=>1);
		$this->buyer->update($config,$update_data);

		redirect('/buyer/index');
	}
}