<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Group extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('group_mdl','group');
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

        $count = $this->group->get_count($where['where']);
        $data['count'] = $count;

        $pageconfig['base_url'] = base_url('index.php/group/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->group->getList($where);
        $data['list'] = $list;

		$this->load->view('group/group_list',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$g_name = $this->input->post('g_name');
			$g_intro = $this->input->post('g_intro');

			if(!empty($g_name)){		
			    /***添加操作***/
			    $add['g_name'] = $g_name;
			    $add['g_intro'] = $g_intro;
			  	if($this->group->add($add)){
			  		redirect('/group/index');
			  	}
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			$this->load->view('group/group_add',$data);
			
		}
	}

		//修改
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$g_name = $this->input->post('g_name');
			$g_intro = $this->input->post('g_intro');
			$id = $this->input->post('id');
			
			if(!empty($g_name)){
			    /***添加操作***/
			    $add['g_name'] = $g_name;
			    $add['g_intro'] = $g_intro;	
			    $updateconfig = array('id'=>$id);
			    $this->group->update($updateconfig,$add);	  	
			  	redirect('/group/index');			  	
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			$id = $this->input->get('id');
			/*****/
			$info = array();
			$config = array('id'=>$id);
			$info = $this->group->get_one_by_where($config);
			$data['info'] = $info;
			
			/******/
			$this->load->view('group/group_edit',$data);
			
		}
	}




	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
	
		$updatedata = array('isdel'=>1);
		$this->group->update($config,$updatedata);

		redirect('/group/index');
	}



}