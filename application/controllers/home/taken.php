<?php
/**
*@DEC 街拍
*
**/
class Taken extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('taken_mdl','taken');
	}


	public function index()
	{
		$list = array();
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->taken->get_count();
        $data['count'] = $count;

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/taken/index?');
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config ['uri_segment'] = 2;
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li  class="active"><a>';
		//“当前页”链接的打开标签。
		$config['cur_tag_close'] = '</a></li>';
		//“当前页”链接的关闭标签。

		$config['next_link'] = '&gt;';
		//你希望在分页中显示“下一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
		$config['next_tag_open'] = '<li>';
		//“下一页”链接的打开标签。
		$config['next_tag_close'] = '</li>';
		//“下一页”链接的关闭标签。

		$config['prev_link'] = '&lt;';

		//你希望在分页中显示“上一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
		$config['prev_tag_open'] = '<li>';
		//“上一页”链接的打开标签。
		$config['prev_tag_close'] = '</li>';
		//“上一页”链接的关闭标签。
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->taken->get_list_by_join($where);
        $data['list'] = $list;

		$this->load->view('home/home_taken',$data);
	}


	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$title = $this->input->post('title');
			$uid = $this->input->post('uid');
			$intro = $this->input->post('intro');
			$rank = $this->input->post('rank');

			if(!empty($title)){

				$add['title'] = $title;
				$add['uid'] = $uid;
				$add['intro'] = $intro;
				$add['rank'] = $rank;

				if(!empty($_FILES)){

			        $config['upload_path'] = './uploads/taken/';
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

			    }else{
			    	exit('file empty');
			    }
				
				if($this->taken->add($add)){
					redirect('/home/taken/index');
				}else{
					exit('error');
				}
			}else{
				echo 'info error';
			}
		}else{
			//用户
			$member = array();
			$this->load->model('member_mdl','member');
			$member = $this->member->getList();
			$data['member'] = $member;
			$this->load->view('home/home_taken_add',$data);		
		}
	}

	//更新
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$title = $this->input->post('title');
			$uid = $this->input->post('uid');
			$intro = $this->input->post('intro');
			$id = $this->input->post('id');
			$rank = $this->input->post('rank');

			if(!empty($title)){

				$add['title'] = $title;
				$add['intro'] = $intro;
				$add['rank'] = $rank;

				if(!empty($_FILES)){

			        $config['upload_path'] = './uploads/taken/';
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
				
				$updateconfig = array('id'=>$id);
				$this->taken->update($updateconfig,$add);
				redirect('/home/taken/index');
				
			}else{
				echo 'info error';
			}
		}else{
			//用户
			$member = array();
			$this->load->model('member_mdl','member');
			$member = $this->member->getList();
			$data['member'] = $member;

			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = array();
			$info = $this->taken->get_one_by_where($config);
			$data['info'] = $info;

			$this->load->view('home/home_taken_edit',$data);		
		}
	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');	
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$this->taken->del($config);
		redirect('/home/taken/index');
		
	}
}