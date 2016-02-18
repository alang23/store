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

        
        $where['where'] = array('shop_id'=>$userinfo['shop_id'],'issure'=>0);
         
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->category->get_count($where['where']);
        $data['count'] = $count;
        /*
        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/category/index?');
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config ['uri_segment'] = 4;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();
        */

        $pageconfig['base_url'] = base_url('index.php/home/category/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->category->getList($where);
        $data['list'] = $list;

		$this->load->view('home/home_category',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$c_name = $this->input->post('c_name');
			$c_attr = $this->input->post('c_attr');
			$c_intro = $this->input->post('c_intro');
			if(!empty($c_attr)){
				$c_attr_str = implode(',', $c_attr);
			}
			if(!empty($c_name)){
				/***判断是否有图片上传**/
				if(!empty($_FILES)){

			        $config['upload_path'] = './uploads/category/'.$userinfo['shop_id'].'/';
			        $config['allowed_types'] = '*';
			        $config['file_name']  =date("YmdHis");
			        $this->load->library('upload', $config);
			        if ( $upload = $this->upload->do_upload('userfile'))
			        {
			            $upload = $this->upload->data();
			            $add['c_pic'] = $userinfo['shop_id'].'/'.$upload['file_name'];			        	           
			        }else{
			            echo $this->upload->display_errors();
			        }
			    }else{
			        exit('file empty');
			    }
			    /***判断是否有图片上传**/

			    /***添加操作***/
			    $add['c_name'] = $c_name;
			    $add['c_attr'] = $c_attr_str;
			    $add['shop_id'] = $userinfo['shop_id'];
			    $add['c_intro'] = $c_intro;
			  	if($this->category->add($add)){
			  		redirect('/home/category/index');
			  	}
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			//属性
			$attr = array();
			$attr = $this->get_attr();
			$data['attr'] = $attr;

			$this->load->view('home/home_category_add',$data);
			
		}
	}

		//修改
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$c_name = $this->input->post('c_name');
			$c_attr = $this->input->post('c_attr');
			$id = $this->input->post('id');
			$c_intro = $this->input->post('c_intro');

			if(!empty($c_attr)){
				$c_attr_str = implode(',', $c_attr);
			}
			if(!empty($c_name)){
				/***判断是否有图片上传**/
				if(!empty($_FILES)){
			        $config['upload_path'] = './uploads/category/'.$userinfo['shop_id'].'/';
			        $config['allowed_types'] = '*';
			        $config['file_name']  =date("YmdHis");

			        $this->load->library('upload', $config);
			        if ( $upload = $this->upload->do_upload('userfile'))
			        {
			            $upload = $this->upload->data();
			            $add['c_pic'] = $userinfo['shop_id'].'/'.$upload['file_name'];			        	           
			        }else{
			            echo $this->upload->display_errors();
			        }
			    }else{
			        exit('file empty');
			    }
			    /***判断是否有图片上传**/

			    /***添加操作***/
			    $add['c_name'] = $c_name;
			    $add['c_attr'] = $c_attr_str;
			    $add['shop_id'] = $userinfo['shop_id'];	
			    $add['c_intro'] = $c_intro;	
			    $updateconfig = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
			    $this->category->update($updateconfig,$add);	  	
			  	redirect('/home/category/index');			  	
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			$id = $this->input->get('id');
			//属性
			$attr = array();
			$attr = $this->get_attr();
			$data['attr'] = $attr;
			/*****/
			$info = array();
			$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
			$info = $this->category->get_one_by_where($config);
			$data['info'] = $info;
			//print_r($info);
			/******/
			$this->load->view('home/home_category_edit',$data);
			
		}
	}




	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id,'shop_id'=>$userinfo['shop_id']);
		//$this->category->del($config);
		$updatedata = array('issure'=>1);
		$this->category->update($config,$updatedata);

		redirect('/home/category/index');
	}

	//取属性
	private function get_attr()
	{
		$userinfo = $this->userinfo;
		//属性
		$attr = array();
		$this->load->model('Attribute_mdl','attribute');
		$attr = array();
		$where['where'] = array('shop_id'=>$userinfo['shop_id']);
		$attr = $this->attribute->getList($where);

		return $attr;
	}


}