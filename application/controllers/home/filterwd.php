<?php
/**
*@DEC 关键字过滤
*
**/

class filterwd extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('filterwd_mdl','filterwd');
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

        $count = $this->filterwd->get_count();
        $data['count'] = $count;

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/member/filterwd?');
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

        $list = $this->filterwd->getList($where);
        $data['list'] = $list;

		$this->load->view('home/home_filterwd',$data);
	}

	public function add()
	{
		$kw = $this->input->post('kw');
		$arr = array();
		if(!empty($kw)){
			$add['word'] = $kw;
			if($this->filterwd->add($add)){
				$arr = array(
					'errcode'=>0,
					'msg'=>'ok'
					);
				
			}else{
				$arr = array(
					'errcode'=>-1,
					'msg'=>'系统错误，请重试'
					);
			}
			
		}else{
			$arr = array(
					'errcode'=>-1,
					'msg'=>'关键字不能为空'
					);
		}
		echo json_encode($arr);
	}

		//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$data['issure'] = 0;
		$this->filterwd->del($config);

		redirect('/home/filterwd/index');
	}

}