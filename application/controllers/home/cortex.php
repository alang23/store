<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cortex  extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('cortex_mdl','cortex');
		
	}


	public function index()
	{
		
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
    
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';


        $count = $this->cortex->get_count();

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/cortex/index?');
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

        $list = $this->cortex->get_list_by_join($where);
        $data['list'] = $list;

		$this->load->view('home/home_cortex',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){
			$rank = $this->input->post('rank');
			$title = $this->input->post('title');
		
			$add['rank'] = $this->input->post('rank');
			$add['title'] = $title;
			if(!empty($_FILES)){

			    $config['upload_path'] = './uploads/cortex/';
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
				if($this->cortex->add($add)){
					redirect('/home/cortex/index');
				}else{
					exit('添加有误');
				}
			}else{
				exit('info error');
			}			
		}else{

			$this->load->view('home/home_cortex_add');
			
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
			    $config['upload_path'] = './uploads/cortex/';
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
			$this->cortex->update($updateconfig,$add);
			redirect('/home/cortex/index');
						
		}else{
			$id = $this->input->get('id');

			$info = array();
			$config = array('id'=>$id);
			$info = $this->cortex->get_one_by_where($config);
			$data['info'] = $info;
			
			$this->load->view('home/home_cortex_edit',$data);
			
		}
	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');

		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$this->cortex->del($config);
		redirect('/home/cortex/index');
		
	}

	//颜色分类关联
	public function relation()
	{
		$this->load->model('color_relation_mdl','color_relation');
		$this->load->model('attribute_content_mdl','attr_content');
		
		if(!empty($_POST)){
			$id = $this->input->post('id');
			$ids = $this->input->post('ids');
			//先删除
			$delconfig = array('color_id'=>$id,'tags'=>'cortex');
			$this->color_relation->del($delconfig);
			if(!empty($ids)){
				$len = count($ids);
				for($i=0;$i<$len;$i++){
					$add['color_id'] = $id;
					$add['attr_id'] = $ids[$i];
					$add['tags'] = 'cortex';
					$this->color_relation->add($add);
				}
			}

			redirect('/home/cortex/relation?id='.$id);
		}else{
			//皮质
			$attr_id = 19;
			
			$where['where'] = array('attr_id'=>$attr_id);
			$attr = array();
			$attr = $this->attr_content->getList($where);
			$data['list'] = $attr;			
			//归属
			$id = $this->input->get('id');
			$data['id'] = $id;
			$wherec['where'] = array('color_id'=>$id,'tags'=>'cortex');
			$color = array();
			$color = $this->color_relation->getList($wherec);
			$ids = array();
			if(!empty($color)){
				foreach($color as $k => $v){
					$ids[] = $v['attr_id'];
				}
			}
			$data['ids'] = $ids;

			$this->load->view('home/home_cortex_relation',$data);
		}

		
		
	}


}