<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Color extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('color_mdl','color');
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

        $count = $this->color->get_count($where['where']);
        $data['count'] = $count;

        $pageconfig['base_url'] = base_url('index.php/color/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->color->getList($where);
        $data['list'] = $list;

		$this->load->view('color/color_list',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){
			$color_name = $this->input->post('color_name');
			$color_intro = $this->input->post('color_intro');

			if(!empty($color_name)){
				/***判断是否有图片上传**/
				if(!empty($_FILES)){

			        $config['upload_path'] = './uploads/color/';
			        $config['allowed_types'] = '*';
			        $config['file_name']  =date("YmdHis");
			        $this->load->library('upload', $config);
			        if ( $upload = $this->upload->do_upload('userfile'))
			        {
			            $upload = $this->upload->data();
			            $add['img'] =$upload['file_name'];			        	           
			        }else{
			            echo $this->upload->display_errors();
			        }
			    }else{
			        exit('file empty');
			    }
			    /***判断是否有图片上传**/


			  	/***添加操作***/
			}else{
					echo 'info error';
			}
			/***添加操作***/
			$add['color_name'] = $color_name;
			$add['color_intro'] = $color_intro;
			if($this->color->add($add)){
			  	redirect('/color/index');
			}
		}else{

			$this->load->view('color/color_add',$data);
			
		}
	}

		//修改
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$color_name = $this->input->post('color_name');
			$id = $this->input->post('id');
			$color_intro = $this->input->post('color_intro');

			if(!empty($color_name)){
				/***判断是否有图片上传**/
				if(!empty($_FILES)){
			        $config['upload_path'] = './uploads/color/';
			        $config['allowed_types'] = '*';
			        $config['file_name']  =date("YmdHis");

			        $this->load->library('upload', $config);
			        if ( $upload = $this->upload->do_upload('userfile'))
			        {
			            $upload = $this->upload->data();
			            $add['img'] = $upload['file_name'];			        	           
			        }else{
			            echo $this->upload->display_errors();
			        }
			    }else{
			        exit('file empty');
			    }
			    /***判断是否有图片上传**/

			    /***添加操作***/
			    $add['color_name'] = $color_name;
			    $add['color_intro'] = $color_intro;	
			    $updateconfig = array('id'=>$id);
			    $this->color->update($updateconfig,$add);	  	
			  	redirect('/color/index');			  	
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			$id = $this->input->get('id');
			/*****/
			$info = array();
			$config = array('id'=>$id);
			$info = $this->color->get_one_by_where($config);
			$data['info'] = $info;
			//print_r($info);
			/******/
			$this->load->view('color/color_edit',$data);
			
		}
	}




	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
	
		$updatedata = array('isdel'=>1);
		$this->color->update($config,$updatedata);

		redirect('/category/index');
	}



}