<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*@desc 商品品牌Controller
*@author Alang
**/

class Brand extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('brand_mdl','brand');
	}


	public function index()
	{
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $where['where'] = array('shop_id'=>$userinfo['shop_id']);
         
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->brand->get_count($where['where']);
        $data['count'] = $count;
        
        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/brand/index?');
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

        $list = $this->brand->getList($where);
        $data['list'] = $list;

        $this->load->view('home/home_brand',$data);
	
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;

		if(!empty($_POST)){
			$b_name = $this->input->post('b_name');
			$b_story = $this->input->post("newsContent");
			if(!empty($_FILES)){
			    $config['upload_path'] = './uploads/brand/'.$userinfo['shop_id'].'/';
			    $config['allowed_types'] = '*';
			    $configpic['file_name']  =date("YmdHis");
			    $this->load->library('upload', $config);
			    if ( $upload = $this->upload->do_upload('userfile'))
			    {
			        $upload = $this->upload->data();
			        $add['b_pic'] = $userinfo['shop_id'].'/'.$upload['file_name'];			        	           
			    }else{
			        echo $this->upload->display_errors();
			    }

			}else{
			    exit('file empty');
			}

			if(!empty($b_name)){
				$add['b_name'] = $b_name;
				$add['shop_id'] = $userinfo['shop_id'];
				$add['b_story'] = $b_story;
				if($this->brand->add($add)){
					redirect('/home/brand/index');
				}
			}else{
				exit('信息有误');
			}
		}else{
			$this->load->view('home/home_brand_add');
		}
	}

	//修改
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){
			$b_name = $this->input->post('b_name');
			$id = $this->input->post('id');
			$b_story = $this->input->post("newsContent");
			if(!empty($_FILES)){
			    $config['upload_path'] = './uploads/brand/'.$userinfo['shop_id'].'/';
			    $config['allowed_types'] = '*';
			    $config['file_name']  =date("YmdHis")."_".$id;
			    $this->load->library('upload', $config);
			    if ( $upload = $this->upload->do_upload('userfile'))
			    {
			        $upload = $this->upload->data();
			        $add['b_pic'] = $userinfo['shop_id'].'/'.$upload['file_name'];			        	           
			    }else{
			        echo $this->upload->display_errors();
			    }

			}else{
			    exit('file empty');
			}

			if(!empty($b_name)){
				$add['b_name'] = $b_name;
				$add['b_story'] = $b_story;
				$updateconfig = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
				$this->brand->update($updateconfig,$add);
				redirect('/home/brand/index');
				
			}else{
				exit('信息有误');
			}

		}else{
			$id = $this->input->get('id');
			$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
			$info = $this->brand->get_one_by_where($config);
			if(empty($info)){
				exit('内容不存在');
			}
			$data['info'] = $info;
			$this->load->view('home/home_brand_edit',$data);
		}
	}


		//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id,'shop_id'=>$userinfo['shop_id']);
		$this->brand->del($config);

		redirect('/home/brand/index');
	}
}