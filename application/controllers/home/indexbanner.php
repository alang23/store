<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Indexbanner extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('indexbanner_mdl','indexbanner');
		
	}


	public function index()
	{
		
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $attr_id = $this->input->get('attr_id');
        $typeid = $this->input->get('typeid');
        $data['attr_id'] = $attr_id;
        $data['typeid'] = $typeid;
   
        
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->indexbanner->get_count();

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/indexbanner/index?');
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
        $where['order'] = array('key'=>'rank','value'=>'ASC');

        $list = $this->indexbanner->getList($where);
        $data['list'] = $list;

		$this->load->view('home/home_indexbanner',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$banner_name = $this->input->post('banner_name');
			$banner_intro = $this->input->post('banner_intro');
			$banner_key = $this->input->post('banner_key');
			$rank = $this->input->post('rank');

			if(!empty($banner_name) && !empty($banner_key)){
				$add['banner_name'] = $banner_name;
				$add['banner_key'] = $banner_key;
				$add['banner_intro'] = $banner_intro;
				$add['rank'] = $this->input->post('rank');
	
				if(!empty($_FILES)){

			        $config['upload_path'] = './uploads/indexbanner/';
			        $config['allowed_types'] = '*';
			        $config['file_name']  =date("YmdHis");

			        $this->load->library('upload', $config);
			        if ( $upload = $this->upload->do_upload('userfile'))
			        {
			            $upload = $this->upload->data();
			            $add['banner_pic'] = $upload['file_name'];			        	           
			        }else{
			             echo $this->upload->display_errors();
			        }
			    }

				if($this->indexbanner->add($add)){
					redirect('/home/indexbanner/index');
				}
			}else{
				echo 'info error';
			}
		}else{

			$this->load->view('home/home_indexbanner_add');
			
		}
	}

	//更新
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$banner_name = $this->input->post('banner_name');
			$banner_intro = $this->input->post('banner_intro');
			$banner_key = $this->input->post('banner_key');
			$rank = $this->input->post('rank');
			$id = $this->input->post('id');

			if(!empty($banner_name) && !empty($banner_key)){
				$add['banner_name'] = $banner_name;
				$add['banner_key'] = $banner_key;
				$add['banner_intro'] = $banner_intro;
				$add['rank'] = $this->input->post('rank');
	
				if(!empty($_FILES)){

			        $config['upload_path'] = './uploads/indexbanner/';
			        $config['allowed_types'] = '*';
			        $config['file_name']  =date("YmdHis");

			        $this->load->library('upload', $config);
			        if ( $upload = $this->upload->do_upload('userfile'))
			        {
			            $upload = $this->upload->data();
			            $add['banner_pic'] = $upload['file_name'];			        	           
			        }else{
			             echo $this->upload->display_errors();
			        }
			    }
			    $updateconfig = array('id'=>$id);
				$this->indexbanner->update($updateconfig,$add);
				redirect('/home/indexbanner/index');
				
			}else{
				echo 'info error';
			}
		}else{
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = $this->indexbanner->get_one_by_where($config);
			$data['info'] = $info;
			$this->load->view('home/home_indexbanner_edit',$data);
			
		}
	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');

		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$this->indexbanner->del($config);
		redirect('/home/indexbanner/index');
		
	}


}