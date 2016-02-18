<?php

/**
 * 地区操作控制器
 */
class Region extends Admin_Controller
{
	public function __construct(){

		parent::__construct();  

		$this->load->model('region_mdl','region');


	}

	/**
 	 * [get_region 获取地区信息]
 	 * @return [type] [description]
 	 */
	public function get_region(){ 
		$parent_id = $this->input->post('pid');
		$data['list'] = $this->region->getList(array('page'=>false,'parent_id'=>$parent_id));
		echo json_encode($data);
	}



	public function index()
	{

		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1; 
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
        $where = array('region_type'=>1);

        //搜索    
        $count = $this->region->get_count($where);    
      
      /*
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php/home/region?';
        $config['total_rows'] = $count;
        $config['uri_segment'] = 2;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
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
        */
        $pageconfig['base_url'] = base_url().'index.php/home/region?';
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $wherelist['like'] = isset($where['like']) ?   $where['like'] : array();
        $wherelist['where'] = $where;
        $list = $this->region->getList($wherelist);
        $data['list'] = $list;

        $this->load->view('home/home_region',$data);


	}


	//城市列表
	public function city()
	{
		$id = $this->input->get('id');

		$page = isset($_GET['page']) ? $_GET['page'] : 0;
                $page = ($page && is_numeric($page)) ? intval($page) : 1; 
                $limit = 40;
                $offset = ($page - 1) * $limit;
                $pagination = ''; 
                $where = array('parent_id'=>$id);
         
                $count = $this->region->get_count($where);     
                $this->load->library('pagination');
                $config['base_url'] = base_url().'index.php?d=home&c=region&m=city&id='.$id;
                $config['total_rows'] = $count;
                $config['uri_segment'] = 4;
                $config['per_page'] = $limit;
                $config['use_page_numbers'] = TRUE;
                $config['query_string_segment'] = 'page';
                $this->pagination->initialize($config);
                $data['page'] = $this->pagination->create_links();

                $list = array();
                $wherelist['page'] = true;
                $wherelist['limit'] = $limit;
                $wherelist['offset'] = $offset;
                $wherelist['like'] = isset($where['like']) ?   $where['like'] : array();
                $wherelist['where'] = $where;
                $list = $this->region->getList($wherelist);
                $data['list'] = $list;

                $this->load->view('home/home_city',$data);

	}

    //显示省份城市
    public function changestatus()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $config = array('region_id'=>$id);
        $data = array('enabled'=>$status);
        $this->region->update($config,$data);

        $result = array('err'=>0,'msg'=>'修改成功');
        echo json_encode($result);
    }

    //热门城市推荐
    public function changetop()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $config = array('region_id'=>$id);
        $data = array('is_top'=>$status);
        $this->region->update($config,$data);

        $result = array('err'=>0,'msg'=>'修改成功');
        echo json_encode($result);
    }
}