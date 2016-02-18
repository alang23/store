<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*@DEC 属性controller
*
**/

class Attr_content extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('attribute_content_mdl','attr_content');
		$this->load->model("attribute_mdl",'attribute');
		
	}


	public function index()
	{
		
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $attr_id = $this->input->get('attr_id');
        $typeid = $this->input->get('typeid');
        $data['attr_id'] = $attr_id;
        $data['typeid'] = $typeid;

        //属性信息
        $infoconfig = array('id'=>$attr_id);
        $info = $this->attribute->get_one_by_where($infoconfig);
        $data['info'] = $info;
     
        $where['where'] = array('shop_id'=>$userinfo['shop_id'],'attr_id'=>$attr_id);
         
        $limit = 50;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->attr_content->get_count($where['where']);

        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/attr_content/index?attr_id='.$attr_id.'&typeid='.$typeid);
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config ['uri_segment'] = 7;

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

        $list = $this->attr_content->getList($where);
        $data['list'] = $list;

		$this->load->view('home/home_attr_content',$data);

		
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$attr_name = $this->input->post('attr_name');
			$attr_value = $this->input->post('attr_value');
			$attr_id = $this->input->post('attr_id');
			$typeid = $this->input->post('typeid');
			$attr_id = $this->input->post('attr_id');
			$attr_intro = $this->input->post('attr_intro');

			if(!empty($attr_name) && !empty($attr_id) && !empty($typeid)){

				$add['attr_id'] = $attr_id;
				$add['attr_name'] = $attr_name;
				$add['shop_id'] = $userinfo['shop_id'];
				$add['attr_intro'] = $attr_intro;

				if($typeid == 1){
					$add['attr_value'] = $attr_value;
				}else{

					if(!empty($_FILES)){

			            $config['upload_path'] = './uploads/attribute/'.$userinfo['shop_id'].'/';
			            $config['allowed_types'] = '*';
			            $config['file_name']  =date("YmdHis");

			            $this->load->library('upload', $config);
			            if ( $upload = $this->upload->do_upload('userfile'))
			            {
			                $upload = $this->upload->data();
			                $add['attr_pic'] = $userinfo['shop_id'].'/'.$upload['file_name'];			        	           
			            }else{
			            	 echo $this->upload->display_errors();
			            }

			        }else{
			           exit('file empty');
			        }
				}
				
				if($this->attr_content->add($add)){
					redirect('/home/attr_content/index?attr_id='.$attr_id.'&typeid='.$typeid);
				}else{
					exit('error');
				}
			}else{
				echo 'info error';
			}
		}else{

			$attr_id = $this->input->get('attr_id');
			$data['attr_id'] = $attr_id;
			//判断类型
			$this->load->model('Attribute_mdl','attribute');
			$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$attr_id);
			$info = $this->attribute->get_one_by_where($config);
			if(empty($info)){
				exit('error');
			}

			$typeid = $info['typeid'];
			$data['typeid'] = $typeid;

			if($typeid == 1){ //文字
				$this->load->view('home/home_attr_content_add_word',$data);
			}elseif($typeid == 2){
				$this->load->view('home/home_attr_content_add_img',$data);
			}else{
				exit('未知类型');
			}
			
		}
	}

	//更新
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){

			$attr_name = $this->input->post('attr_name');
			$attr_value = $this->input->post('attr_value');
			$id = $this->input->post('id');
			$typeid = $this->input->post('typeid');
			$attr_id = $this->input->post('attr_id');
			$attr_intro = $this->input->post('attr_intro');
			
			if(!empty($attr_name) && !empty($id)){
				
				$add['attr_name'] = $attr_name;
				$add['attr_intro'] = $attr_intro;

				if($typeid == 1){
					$add['attr_value'] = $attr_value;
				}else{

					if(!empty($_FILES)){

			            $config['upload_path'] = './uploads/attribute/'.$userinfo['shop_id'].'/';
			            $config['allowed_types'] = '*';
			            $config['file_name']  =date("YmdHis");

			            $this->load->library('upload', $config);
			            if ( $upload = $this->upload->do_upload('userfile'))
			            {
			                $upload = $this->upload->data();
			                $add['attr_pic'] = $userinfo['shop_id'].'/'.$upload['file_name'];			        	           
			            }else{
			            	 echo $this->upload->display_errors();
			            }

			        }else{
			           exit('file empty');
			        }
				}
				$updateconfig = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
				$this->attr_content->update($updateconfig,$add);
				redirect('/home/attr_content/index?attr_id='.$attr_id.'&typeid='.$typeid);
				
			}else{
				echo 'info error';
			}
		}else{

			$id = $this->input->get('id');
			$config = array('attrv.id'=>$id,'attrv.shop_id'=>$userinfo['shop_id']);
			
			$info = $this->attr_content->get_one_join_attribute($config);
			$data['info'] = $info;
			
			$this->load->view('home/home_attr_content_edit',$data);
			
		}
	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$attr_id = $this->input->get('attr_id');
		
		$userinfo = $this->userinfo;
		$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
		$updatedata = array('issure'=>1);
		$this->attr_content->update($config,$updatedata);

		//删除相关属性
		
		redirect('/home/attr_content/index?attr_id='.$attr_id);
		
	}


}