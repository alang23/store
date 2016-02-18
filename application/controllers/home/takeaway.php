<?php
/**
*@DEC 关键字过滤
*
**/

class Takeaway extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('takeaway_mdl','takeaway');
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

        $count = $this->takeaway->get_count();
        $data['count'] = $count;

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/takeaway');
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

        $list = $this->takeaway->getList($where);
        $data['list'] = $list;

		$this->load->view('home/takeaway/home_takeaway',$data);
	}

	public function add()
	{
		if(!empty($_POST)){
			$address = $this->input->post('address');
			$tel = $this->input->post('tel');
			$intro = $this->input->post('intro');
			$rank = $this->input->post('rank');

			if(!empty($tel) && !empty($tel)){
				$add['address'] = $address;
				$add['tel'] = $tel;
				$add['intro'] = $intro;
				$add['rank'] = $rank;
				if($this->takeaway->add($add)){
					redirect('/home/takeaway/index');
				}
			}
		}else{
			$this->load->view('home/takeaway/home_takeaway_add');
		}

	}

	public function update()
	{
		if(!empty($_POST)){

			$id = $this->input->post('id');
			$address = $this->input->post('address');
			$tel = $this->input->post('tel');
			$intro = $this->input->post('intro');
			$rank = $this->input->post('rank');

			if(!empty($tel) && !empty($tel)){
				$add['address'] = $address;
				$add['tel'] = $tel;
				$add['intro'] = $intro;
				$add['rank'] = $rank;
				$config = array('id'=>$id);
				$this->takeaway->update($config,$add);
				redirect('/home/takeaway/index');
				
			}
		}else{
			$id = $this->input->get('id');
			$info = array();
			$config = array('id'=>$id);
			$info = $this->takeaway->get_one_by_where($config);
			$data['info'] = $info;

			$this->load->view('home/takeaway/home_takeaway_edit',$data);
		}
		

	}

		//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$this->takeaway->del($config);

		redirect('/home/takeaway/index');
	}

}