<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*@desc 寄售管理Controller
*@author Alang
**/

class Consignment_shenhe extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('consignment_shenhe_mdl','consignment_shenhe');
		$this->load->model('product_mdl','product');
		$this->load->model('product_pic_mdl','product_pic');
	}


	public function index()
	{
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
  
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';
        //$where = array('enabled'=>1);
        $where['where'] = array();

        $count = $this->consignment_shenhe->get_count($where);
        $data['count'] = $count;
        
        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/consignment_shenhe/index?');
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config['per_page'] = $limit;
        //$config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config ['uri_segment'] = 4;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $wherelist['where'] = array('co.enabled'=>1);
     
        $list = $this->consignment_shenhe->get_list_join($wherelist);
        $data['list'] = $list;

        $this->load->view('home/consignment/home_consignment_shenhe',$data);
	
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;

		if(!empty($_POST)){
			$p_name = $this->input->post('p_name');
			$category_id = $this->input->post("category_id");
			$brand_id = $this->input->post('brand_id');
			$intro = $this->input->post('intro');
			$content = $this->input->post('newsContent');
			$total = $this->input->post('total');
			$price = $this->input->post('price');
			$enabled = $this->input->post('enabled');
			/**生产产品序列号***/
			$suk = 'sp'.time();
			/**生产产品序列号***/

			if(!empty($p_name) && !empty($suk)){
				$add['p_name'] = $p_name;
				$add['category_id'] = $category_id;
				$add['brand_id'] = $brand_id;
				$add['intro'] = $intro;
				$add['content'] = $content;
				$add['price'] = $price;
				$add['total'] = intval($total);
				$add['createtime'] = time();
				$add['suk'] = $suk;
				$add['shop_id'] = $userinfo['shop_id'];
				$add['enabled'] = $enabled;

				if($this->product->add($add)){
					redirect('/home/product/index');
				}else{
					echo mysql_error();
				}
			}else{
				exit('信息有误');
			}
		}else{

			//品牌
			$brand = array();
			$brandwhere = array('shop_id'=>$userinfo['shop_id']);
			$brand = $this->brand->getList($brandwhere);
			$data['brand'] = $brand;

			//类型
			$category = array();
			$category = $this->category->getList($brandwhere);
			$data['category'] = $category;

			$this->load->view('home/home_product_add',$data);
		}
	}

	//修改
	public function update()
	{
		$userinfo = $this->userinfo;

		if(!empty($_POST)){
			$p_name = $this->input->post('p_name');
			$category_id = $this->input->post("category_id");
			$brand_id = $this->input->post('brand_id');
			$intro = $this->input->post('intro');
			$content = $this->input->post('newsContent');
			$total = $this->input->post('total');
			$price = $this->input->post('price');
			$id = $this->input->post('id');
			$enabled = $this->input->post('enabled');

			/**生产产品序列号***/
			//$suk = 'sp'.time();
			/**生产产品序列号***/

			if(!empty($p_name) && !empty($id)){
				$add['p_name'] = $p_name;
				$add['category_id'] = $category_id;
				$add['brand_id'] = $brand_id;
				$add['intro'] = $intro;
				$add['content'] = $content;
				$add['price'] = $price;
				$add['total'] = intval($total);
				$add['enabled'] = $enabled;
				//$add['suk'] = $suk;
				$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
				if($this->product->update($config,$add)){
					redirect('/home/product/index');
				}else{
					echo mysql_error();
				}
			}else{
				exit('信息有误');
			}
		}else{
			//产品基本信息
			$id = $this->input->get('id');
			$info = array();
			$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
			$info = $this->product->get_one_by_where($config);
			$data['info'] = $info;
			
			//品牌
			$brand = array();
			$brandwhere = array('shop_id'=>$userinfo['shop_id']);
			$brand = $this->brand->getList($brandwhere);
			$data['brand'] = $brand;

			//类型
			$category = array();
			$category = $this->category->getList($brandwhere);
			$data['category'] = $category;

			$this->load->view('home/home_product_edit',$data);
		}
	}


		//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id,'shop_id'=>$userinfo['shop_id']);
		$this->brand->del($config);

		redirect('/home/brand/index');
	}
}