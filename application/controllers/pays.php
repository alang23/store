<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pays extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('pays_mdl','pays');
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

        $count = $this->pays->get_count($where['where']);
        $data['count'] = $count;

        $pageconfig['base_url'] = base_url('index.php/pays/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->pays->getList($where);
        $data['list'] = $list;

		$this->load->view('pays/pays_list',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$pay_name = $this->input->post('pay_name');
			$pay_intro = $this->input->post('pay_intro');

			if(!empty($pay_name)){		
			    /***添加操作***/
			    $add['pay_name'] = $pay_name;
			    $add['pay_intro'] = $pay_intro;
			  	if($this->pays->add($add)){
			  		redirect('/pays/index');
			  	}
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			$this->load->view('pays/pays_add',$data);
			
		}
	}

		//修改
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$id = $this->input->post('id');
			$pay_name = $this->input->post('pay_name');
			$pay_intro = $this->input->post('pay_intro');

			if(!empty($pay_name)){
			    /***添加操作***/
			    $add['pay_name'] = $pay_name;
			    $add['pay_intro'] = $pay_intro;
			    $updateconfig = array('id'=>$id);
			    $this->pays->update($updateconfig,$add);	  	
			  	redirect('/pays/index');			  	
			  	/***添加操作***/
			}else{
					echo 'info error';
			}

		}else{

			$id = $this->input->get('id');
			/*****/
			$info = array();
			$config = array('id'=>$id);
			$info = $this->pays->get_one_by_where($config);
			$data['info'] = $info;
			//print_r($info);
			/******/
			$this->load->view('pays/pays_edit',$data);
			
		}
	}




	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
	
		$updatedata = array('isdel'=>1);
		$this->pays->update($config,$updatedata);

		redirect('/pays/index');
	}



}