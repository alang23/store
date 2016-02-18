<?php
/**
*@dec 意见反馈
*@author alang
**/

class Feedback extends Admin_Controller
{




	public function __construct()
	{
		parent::__construct();
		$this->load->model('feedback_mdl','feedback');
	}


	public function index()
	{
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 

        $count = $this->feedback->get_count();
       
        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/feedback/index?');
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
        $list = $this->feedback->get_list_by_join($wherelist);
        $data['list'] = $list;


	   $this->load->view('home/feedback/home_feedback',$data);
	}

    public function add()
    {
        if(!empty($_POST)){
           
            $data['content'] = $this->input->post('content');
         

            $id = isset($_POST['id']) ? $this->input->post('id') : '0';


            if($id){
                $config = array('id'=>$id);
                $this->feedback->update($config,$data);
            }else{
               
                $this->feedback->add($data);
            }

            redirect('d=home&c=feedback');
        }else{ 


            $this->load->view('home/feedback/home_feedback_add');
        }
    }

    /**
    *修改
    */
    public function update()
    {
        $id = $this->input->get('id');
        $where = array('id'=>$id);
        $info =  $this->feedback->get_one_by_where($where);
        $data['info'] = $info;

        $this->load->view('home/feedback/home_feedback_update',$data);

    }

                //delete
    public function del()
    {
        $id = $this->input->get('id');
        $where['id'] = $id;
        $this->feedback->del($where);
        redirect('d=home&c=feedback');
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
            $this->feedback->update($config,$data);
        }

        redirect('d=home&c=feedback');
    }







}