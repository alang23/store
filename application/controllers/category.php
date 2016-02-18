<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Category extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('category_mdl','category');
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

        $count = $this->category->get_count($where['where']);
        $data['count'] = $count;

        $pageconfig['base_url'] = base_url('index.php/category/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->category->getList($where);
        $data['list'] = $list;

		$this->load->view('category/category_list',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$c_name = $this->input->post('c_name');
			$c_intro = $this->input->post('c_intro');

			if(!empty($c_name)){
				/***判断是否有图片上传**/
				if(!empty($_FILES)){

			        $config['upload_path'] = './uploads/category/';
			        $config['allowed_types'] = '*';
			        $config['file_name']  =date("YmdHis");
			        $this->load->library('upload', $config);
			        if ( $upload = $this->upload->do_upload('userfile'))
			        {
			            $upload = $this->upload->data();
			            $add['c_pic'] =$upload['file_name'];			        	           
			        }else{
			            echo $this->upload->display_errors();
			        }
			    }else{
			        exit('file empty');
			    }
			    /***判断是否有图片上传**/

			    /***添加操作***/
			    $add['c_name'] = $c_name;
			    $add['c_intro'] = $c_intro;
			  	if($this->category->add($add)){
			  		redirect('/category/index');
			  	}
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			$this->load->view('category/category_add',$data);
			
		}
	}

		//修改
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$c_name = $this->input->post('c_name');
			$id = $this->input->post('id');
			$c_intro = $this->input->post('c_intro');

			if(!empty($c_name)){
				/***判断是否有图片上传**/
				if(!empty($_FILES)){
			        $config['upload_path'] = './uploads/category/';
			        $config['allowed_types'] = '*';
			        $config['file_name']  =date("YmdHis");

			        $this->load->library('upload', $config);
			        if ( $upload = $this->upload->do_upload('userfile'))
			        {
			            $upload = $this->upload->data();
			            $add['c_pic'] = $upload['file_name'];			        	           
			        }else{
			            echo $this->upload->display_errors();
			        }
			    }else{
			        exit('file empty');
			    }
			    /***判断是否有图片上传**/

			    /***添加操作***/
			    $add['c_name'] = $c_name;
			    $add['shop_id'] = $userinfo['shop_id'];	
			    $add['c_intro'] = $c_intro;	
			    $updateconfig = array('id'=>$id);
			    $this->category->update($updateconfig,$add);	  	
			  	redirect('/category/index');			  	
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			$id = $this->input->get('id');
			/*****/
			$info = array();
			$config = array('id'=>$id);
			$info = $this->category->get_one_by_where($config);
			$data['info'] = $info;
			//print_r($info);
			/******/
			$this->load->view('category/category_edit',$data);
			
		}
	}




	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
	
		$updatedata = array('isdel'=>1);
		$this->category->update($config,$updatedata);

		redirect('/category/index');
	}



}