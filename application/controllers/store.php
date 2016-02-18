<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Store extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('store_mdl','store');
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

        $count = $this->store->get_count($where['where']);
        $data['count'] = $count;

        $pageconfig['base_url'] = base_url('index.php/store/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->store->getList($where);
        $data['list'] = $list;

		$this->load->view('store/store_list',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$store_name = $this->input->post('store_name');
			$store_intro = $this->input->post('store_intro');

			if(!empty($store_name)){		
			    /***添加操作***/
			    $add['store_name'] = $store_name;
			    $add['store_intro'] = $store_intro;
			  	if($this->store->add($add)){
			  		redirect('/store/index');
			  	}
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			$this->load->view('store/store_add',$data);
			
		}
	}

		//修改
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$store_name = $this->input->post('store_name');
			$id = $this->input->post('id');
			$store_intro = $this->input->post('store_intro');

			if(!empty($store_name)){
			    /***添加操作***/
			    $add['store_name'] = $store_name;
			    $add['store_intro'] = $store_intro;	
			    $updateconfig = array('id'=>$id);
			    $this->store->update($updateconfig,$add);	  	
			  	redirect('/store/index');			  	
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			$id = $this->input->get('id');
			/*****/
			$info = array();
			$config = array('id'=>$id);
			$info = $this->store->get_one_by_where($config);
			$data['info'] = $info;
			//print_r($info);
			/******/
			$this->load->view('store/store_edit',$data);
			
		}
	}




	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
	
		$updatedata = array('isdel'=>1);
		$this->store->update($config,$updatedata);

		redirect('/store/index');
	}



}