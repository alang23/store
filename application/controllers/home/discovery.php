<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Discovery extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('discovery_mdl','discovery');
		
	}


	public function index()
	{
		
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
    
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';


        $count = $this->discovery->get_count();

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/discovery/index?');
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

        $list = $this->discovery->get_list_by_join($where);
        $data['list'] = $list;

        //
        $keys = $this->_keys();
        $data['keys'] = $keys;

		$this->load->view('home/home_discovery',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){
			$rank = $this->input->post('rank');
			$title = $this->input->post('title');
			$d_key = $this->input->post('d_key');
		
			$add['rank'] = $this->input->post('rank');
			$add['title'] = $title;
			$add['d_key'] = $d_key;

			if(!empty($_FILES)){

			    $config['upload_path'] = './uploads/discovery/';
			    $config['allowed_types'] = '*';
			    $configpic['file_name']  =date("YmdHis");

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
				if($this->discovery->add($add)){
					redirect('/home/discovery/index');
				}else{
					exit('添加有误');
				}
			}else{
				exit('info error');
			}

			
		}else{

			$this->load->view('home/home_discovery_add');
			
		}
	}

	//更新
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){	
			$add['rank'] = $this->input->post('rank');
			$add['title'] = $this->input->post('title');
			$add['d_key'] = $this->input->post('d_key');
			$id = $this->input->post('id');
			if(!empty($_FILES)){
			    $config['upload_path'] = './uploads/discovery/';
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
			$this->discovery->update($updateconfig,$add);
			redirect('/home/discovery/index');
						
		}else{
			$id = $this->input->get('id');

			$info = array();
			$config = array('id'=>$id);
			$info = $this->discovery->get_one_by_where($config);
			$data['info'] = $info;
			
			$this->load->view('home/home_discovery_edit',$data);
			
		}
	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');

		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$this->discovery->del($config);
		redirect('/home/discovery/index');
		
	}

	private function _keys()
	{
		return array(
			'1'=>'品牌学堂',
			'2'=>'颜色',
			'3'=>'皮质',
			'4'=>'金属'
			);
	}


}