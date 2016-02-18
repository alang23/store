<?php
/**
*系统帮助类型
*
**/
class Doubttype extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('doubt_type_mdl','doubt_type');
	}

	public function index()
	{
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 

        $where = array('isdel'=>0);
        $count = $this->doubt_type->get_count($where);
       
        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/doubttype/index?');
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
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $wherelist['where'] = array('isdel'=>0);
        $wherelist['order'] = array('key'=>'rank','value'=>'ASC');
        $list = $this->doubt_type->getList($wherelist);
        $data['list'] = $list;

		$this->load->view('home/doubt/home_doubt_type',$data);
	}

	//添加
	public function add()
	{
		if(!empty($_POST)){
			$name = $this->input->post('name');
			$rank = $this->input->post('rank');
			if(!empty($name)){
				$add['name'] = $name;
				if($this->doubt_type->add($add)){
					redirect('/home/doubttype/index');
				}else{
					exit('insert fail');
				}
			}else{
				exit('name is null');
			}
		}else{
			$this->load->view('home/doubt/home_doubt_type_add');
		}
	}

	//修改
	public function update()
	{
		if(!empty($_POST)){
			$name = $this->input->post('name');
			$rank = $this->input->post('rank');
			$id = $this->input->post('id');
			if(!empty($name) && !empty($id)){
				$config = array('id'=>$id);
				$updatedata = array('name'=>$name,'rank'=>$rank);
				$this->doubt_type->update($config,$updatedata);
				redirect('/home/doubttype/index');
			}else{
				exit('info error');
			}
		}else{
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = array();
			$info = $this->doubt_type->get_one_by_where($config);
			$data['info'] = $info;

			$this->load->view('home/doubt/home_doubt_type_edit',$data);
		}
	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$config = array('id'=>$id);
		$updatedata = array('isdel'=>1);
		$this->doubt_type->update($config,$updatedata);

		redirect('/home/doubttype/index');
	}



}