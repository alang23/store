<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class School extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('school_mdl','school');
		$this->load->model('school_lists_mdl','school_lists');
		
	}


	public function index()
	{
		
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
    
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->school->get_count();

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/school/index?');
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

        $list = $this->school->get_list_by_join($where);
        $data['list'] = $list;

		$this->load->view('home/home_school',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$title = $this->input->post('title');
			
			$add['rank'] = $this->input->post('rank');
			$add['title'] = $title;
			
			if(!empty($_FILES)){

			    $config['upload_path'] = './uploads/school/';
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
				if($this->school->add($add)){
					redirect('/home/school/index');
				}else{
					exit('添加有误');
				}
			}else{
				exit('info error');
			}

			
		}else{
			

			$this->load->view('home/home_school_add');
			
		}
	}

	//更新
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){	
			$add['rank'] = $this->input->post('rank');
			$add['title'] = $this->input->post('title');

			$id = $this->input->post('id');
			if(!empty($_FILES)){
			    $config['upload_path'] = './uploads/school/';
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
			$this->school->update($updateconfig,$add);
			redirect('/home/school/index');
						
		}else{
			$id = $this->input->get('id');

			$info = array();
			$config = array('id'=>$id);
			$info = $this->school->get_one_by_where($config);
			$data['info'] = $info;
			
			$this->load->view('home/home_school_edit',$data);
			
		}
	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');

		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$this->school->del($config);
		redirect('/home/school/index');
		
	}


	public function lists()
	{
		

		$userinfo = $this->userinfo;
	
		$sid = $this->input->get('id');
		$data['sid'] = $sid;

		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
    
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $where = array('isdel'=>0);
        $count = $this->school_lists->get_count();

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/school/lists?sid='.$sid);
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config['per_page'] = $limit;

        $config['page_query_string'] = TRUE;
        $config ['uri_segment'] = 4;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $wherelist['where'] = array('isdel'=>0);
        $wherelist['order'] = array('key'=>'rank','value'=>'ASC');

        $list = $this->school_lists->getList($wherelist);
        $data['list'] = $list;

		$this->load->view('home/home_school_lists',$data);

	}


	public function listsadd()
	{
		if(!empty($_POST)){
			$title = $this->input->post('title');
			$author = $this->input->post('author');
			$captions = $this->input->post('captions');
			$sid = $this->input->post('sid');
			$intro = $this->input->post('intro');
			$content = $this->input->post('newsContent');
			$rank = $this->input->post('rank');
			if(!empty($_FILES)){
			    $config['upload_path'] = './uploads/school_lists/';
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
			}
			$add['title'] = $title;
			$add['author'] = $author;
			$add['captions'] = $captions;
			$add['intro'] = $intro;
			$add['content'] = $content;
			$add['createtime'] = time();
			$add['sid'] = 0;
			$add['rank'] = $rank;
			if($this->school_lists->add($add)){
				redirect('/home/school/lists');
			}else{
				exit('error');
			}

		}else{

			$sid = isset($_GET['sid']) ? $this->input->get('sid') : 0;
			$data['sid'] = $sid;

			$list = array();
			
			$list = $this->school->getList();
			$data['list'] = $list;


			$this->load->view('home/home_school_lists_add',$data);
		}

	}

	//修改
	public function listsupdate()
	{
		if(!empty($_POST)){
			$title = $this->input->post('title');
			$author = $this->input->post('author');
			$captions = $this->input->post('captions');
			$sid = $this->input->post('sid');
			$intro = $this->input->post('intro');
			$content = $this->input->post('newsContent');
			$id = $this->input->post('id');
			$rank = $this->input->post('rank');
			if(!empty($_FILES)){
			    $config['upload_path'] = './uploads/school_lists/';
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
			}

			$add['title'] = $title;
			$add['captions'] = $captions;
			$add['author'] = $author;
			$add['intro'] = $intro;
			$add['content'] = $content;
			$add['createtime'] = time();
			$add['sid'] = 0;
			$add['rank'] = $rank;
			$updateconfig = array('id'=>$id);
			$this->school_lists->update($updateconfig,$add);
			redirect('/home/school/lists');
			

		}else{

			$id = isset($_GET['id']) ? $this->input->get('id') : 0;

			$list = array();	
			$list = $this->school->getList();
			$data['list'] = $list;

			//单条信息
			$config = array('id'=>$id);
			$info = $this->school_lists->Get_one_by_where($config);
			$data['info'] = $info;


			$this->load->view('home/home_school_lists_edit',$data);
		}

	}

		//删除
	public function listsdel()
	{
		$id = $this->input->get('id');
	
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$updatedata = array('isdel'=>1);
		$this->school_lists->update($config,$updatedata);
		redirect('/home/school/lists');
		
	}


}