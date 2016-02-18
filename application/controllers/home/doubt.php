<?php
/**
*@dec 疑问帮助
*@author alang
**/

class Doubt extends Admin_Controller
{




	public function __construct()
	{
		parent::__construct();
		$this->load->model('doubt_mdl','doubt');
        $this->load->model('doubt_type_mdl','doubt_type');
	}


	public function index()
	{
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $tid = isset($_GET['tid']) ? $_GET['tid'] : 0;

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 

        $where = array();
        if(!empty($tid)){
            $where = array('tid'=>$tid);
        }
        $count = $this->doubt->get_count($where);
       
       /*
        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/doubt/index?tid='.$tid);
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
        */

        $pageconfig['base_url'] = base_url('index.php/home/doubt/index?tid='.$tid);
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        if(!empty($tid)){
            $wherelist['where'] = array('d.tid'=>$tid);
        }
        $list = $this->doubt->get_list_by_join($wherelist);
        $data['list'] = $list;


	   $this->load->view('home/doubt/home_doubt',$data);
	}

    //添加
    public function add()
    {
        if(!empty($_POST)){
           
            $data['question'] = $this->input->post('question');
            $data['answer'] = $this->input->post('answer');
            $data['tid'] = $this->input->post('tid');
            $data['rank'] = $this->input->post('rank');
            if(!empty($data['tid'])){
                if($this->doubt->add($data)){
                    redirect('/home/doubt/index?tid='.$tid);
                }
            }else{
                exit('info error');
            }

        }else{ 
            $tid = isset($_GET['tid']) ? $_GET['tid'] : 0;
            $data['tid'] = $tid;
            //类型
            $types = array();
            $types = $this->doubt_type->getList();
            $data['types'] = $types;

            $this->load->view('home/doubt/home_doubt_add',$data);
        }
    }

    /**
    *修改
    */
    public function update()
    {
        if(!empty($_POST)){
            $data['question'] = $this->input->post('question');
            $data['answer'] = $this->input->post('answer');
            $data['tid'] = $this->input->post('tid');
            $data['rank'] = $this->input->post('rank');
            $id = $this->input->post('id');
            if(!empty($data['tid']) && !empty($id)){
                $config = array('id'=>$id);
                $this->doubt->update($config,$data);
                redirect('/home/doubt/index?tid='.$tid);    
            }else{
                exit('info error');
            }
        }else{

            $id = $this->input->get('id');
            $where = array('id'=>$id);
            $info =  $this->doubt->get_one_by_where($where);
            $data['info'] = $info;

            //类型
            $types = array();
            $types = $this->doubt_type->getList();
            $data['types'] = $types;

            $this->load->view('home/doubt/home_doubt_update',$data);

        }


    }

                //delete
    public function del()
    {
        $id = $this->input->get('id');
        $where['id'] = $id;
        $this->doubt->del($where);
        redirect('/home/doubt/index');
    }

    //修改排序
    public function rank()
    {
        $rank = $this->input->post('rank');
        $id = $this->input->post('id');
        $len = count($id);
        for($i=0;$i<$len;$i++){
            $config = array('id'=>$id[$i]);
            $data['rank'] = $rank[$i];
            $this->doubt->update($config,$data);
        }

        redirect('/home/doubt/index');
    }







}