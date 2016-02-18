<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*@dec 款式Controller
*
**/

class Style extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('style_mdl','style');
		
	}


	public function index()
	{
		
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
    
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->style->get_count();

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/style/index?');
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
        $where['order'] = array('key'=>'s.rank','value'=>'asc');

        $list = $this->style->get_list_by_join($where);
        $data['list'] = $list;

		$this->load->view('home/home_style',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){
			$rank = $this->input->post('rank');
			$category_id = $this->input->post('category_id');
		
			$add['rank'] = $this->input->post('rank');
			$add['category_id'] = $category_id;
			if(!empty($_FILES)){

			    $config['upload_path'] = './uploads/banner/';
			    $config['allowed_types'] = '*';

			    $this->load->library('upload', $config);
			    if ( $upload = $this->upload->do_upload('userfile'))
			    {
			        $upload = $this->upload->data();
			        $add['img'] = $upload['file_name'];			        	           
			    }else{
			        echo $this->upload->display_errors();
			    }
			}

			if(!empty($add['img'])){
				if($this->style->add($add)){
					redirect('/home/style/index');
				}else{
					exit('添加有误');
				}
			}else{
				exit('info error');
			}

			
		}else{
			//分类
			$this->load->model('category_mdl','category');
			$where['where'] = array('shop_id'=>$userinfo['shop_id']);
			$list = array();
			$list = $this->category->getList($where);
			$data['list'] = $list;

			$this->load->view('home/home_style_add',$data);
			
		}
	}

	//更新
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){	
			$add['rank'] = $this->input->post('rank');
			$add['category_id'] = $this->input->post('category_id');
			$id = $this->input->post('id');
			if(!empty($_FILES)){
			    $config['upload_path'] = './uploads/banner/';
			    $config['allowed_types'] = '*';

			    $this->load->library('upload', $config);
			    if ( $upload = $this->upload->do_upload('userfile'))
			    {
			        $upload = $this->upload->data();
			        $add['img'] = $upload['file_name'];			        	           
			    }else{
			        echo $this->upload->display_errors();
			    }
			}

			$updateconfig = array('id'=>$id);
			$this->style->update($updateconfig,$add);
			redirect('/home/style/index');
						
		}else{
			$id = $this->input->get('id');
			//品牌
			$this->load->model('category_mdl','brand');
			$where['where'] = array('shop_id'=>$userinfo['shop_id']);
			$list = array();
			$list = $this->brand->getList($where);
			$data['list'] = $list;

			$info = array();
			$config = array('id'=>$id);
			$info = $this->style->get_one_by_where($config);
			$data['info'] = $info;
			//print_R($info);
			$this->load->view('home/home_style_edit',$data);
			
		}
	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');

		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$this->style->del($config);
		redirect('/home/style/index');
		
	}


}