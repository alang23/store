<?php
/*
*@DEC用户收藏列表
*
*
**/
class Fav extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('fav_mdl','fav');
	}


	public function index()
	{
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 

        $where = array('enabled'=>1);
        $count = $this->fav->get_count($where);
       
        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/fav/index?');
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
        $wherelist['where'] = array('fav.enabled'=>1);
        $list = $this->fav->get_list_by_join($wherelist);
        $data['list'] = $list;

        $this->load->view('home/fav/home_fav',$data);
	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');

		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$updatedata = array('enabled'=>2);
		$this->fav->update($config,$updatedata);
		redirect('/home/fav/index');
		
	}
}