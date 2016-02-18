<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Attribute extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('attribute_mdl','attribute');
		
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

        $count = $this->attribute->get_count($where['where']);

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/attribute/index?');
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config['per_page'] = $limit;
        //$config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config ['uri_segment'] = 4;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->attribute->getList($where);
        $data['list'] = $list;
       
		$this->load->view('home/home_attribute',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		$name = $this->input->post('name');
		$typeid= $this->input->post('typeid');

		if(empty($name) || empty($typeid)){
			$msg = array('errcode'=>-1,'属性名称不能为空');
			echo json_encode($msg);
			exit;
		}

		$add['name'] = $name;
		$add['shop_id'] = $userinfo['shop_id'];
		$add['typeid'] = $typeid;
		$res = $this->attribute->add($add);
		if($res){
			$msg = array('errcode'=>0,'msg'=>'添加成功');
		}else{
			$msg = array('errcode'=>-2,'msg'=>'添加有误，请重试');
		}

		echo json_encode($msg);
		exit;
	}

	//编辑
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){
			$name = $this->input->post('name');
			$id = $this->input->post('id');
			if(!empty($name)){
				$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
				$add['name'] = $name;
				$this->attribute->update($config,$add);
				redirect('/home/attribute/index');
			}
		}else{
			$id = $this->input->get('id');
			$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
			$info = array();
			$info = $this->attribute->get_one_by_where($config);
			$data['info'] = $info;

			$this->load->view('home/home_attribute_edit',$data);
		}
	
		

	}




	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id,'shop_id'=>$userinfo['shop_id']);
		$updatedata = array('issure'=>1);
		//$this->attribute->del($config);
		$this->attribute->update($config,$updatedata);

		//删除相关属性
		$this->load->model('attribute_content_mdl','attribute_content');
		$attr_config = array('attr_id'=>$id);
		//$this->attribute_content->del($attr_config);
		$attr_data = array('issure'=>1);
		$this->attribute_content->update($attr_config,$attr_data);

		redirect('/home/attribute/index');
	}


}