<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*@desc 寄售管理Controller
*@author Alang
**/

class Consignment extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('consignment_mdl','consignment');
		$this->load->model('consignment_pic_mdl','consignment_pic');
		$this->load->model('brand_mdl','brand');
		$this->load->model('category_mdl','category');

		$this->load->model('product_mdl','product');
		$this->load->model('product_pic_mdl','product_pic');
	}


	public function index()
	{
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $where['where'] = array('issure'=>0);
         
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->consignment->get_count($where['where']);
        $data['count'] = $count;

		$pageconfig['base_url'] = base_url('index.php/home/consignment/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $wherelist['where'] = array('co.issure'=>0);

        $list = $this->consignment->get_list_join($wherelist);
        $data['list'] = $list;

        $this->load->view('home/consignment/home_consignment',$data);
	
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
			//审核状态
			//1.更新审核状态
			//
			$reasons = $this->input->post('reasons');
			$status = $this->input->post('status');
			$id = $this->input->post('id');
			if($status > 0){
				$updatedata['status'] = $status;
				$updatedata['reasons'] = $reasons;
				$updateconfig = array('id'=>$id);
				$this->consignment->update($updateconfig,$updatedata);
			}

			//审核通过处理-添加到产品库
			if($status == 1){
				$p_name = $this->input->post('p_name');
				$category_id = $this->input->post("category_id");
				$brand_id = $this->input->post('brand_id');
				$intro = $this->input->post('intro');
				$content = $this->input->post('newsContent');
				$total = $this->input->post('total');
				$price = $this->input->post('price');
				$enabled = $this->input->post('enabled');
				$pic = $this->input->post('pic');
				$discount = $this->input->post('discount');
				$types = 4;
				$attr_id = $this->input->post('attr_id');
				$pay_id = $this->input->post('pay_id');
				
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
					$add['shop_id'] = 1;
					$add['enabled'] = $enabled;
					$add['discount'] = $discount;
					$add['types'] = $types;
					$add['attr'] = json_encode($attr_id);
					if(!empty($pay_id)){
						$add['pay_id'] = implode(',', $pay_id);
					}

					if(!empty($_FILES)){

					    $config['upload_path'] = './uploads/productthumb/';
					    $config['allowed_types'] = '*';
					    $config['file_name']  =date("YmdHis");
					    
					    $this->load->library('upload', $config);
					    if ( $upload = $this->upload->do_upload('userfile'))
					    {
					        $upload = $this->upload->data();
					        $add['pic'] = $upload['file_name'];			        	           
					    }else{
					        echo $this->upload->display_errors();
					    }
					}
					
					if($this->product->add($add)){
						$id = $this->product->insert_id();
						/*****添加产品图****/
						if(!empty($pic)){
							$len = count($pic);
							if($len > 0){
								for($i=0;$i<$len;$i++){								
									$picadd['product_id'] = $id;
									$picadd['filename'] = $pic[$i];
									$this->product_pic->add($picadd);
								}
							}
						}
						/*****添加产品图****/
						redirect('/home/product/index');
					}else{
						echo mysql_error();
					}
				}else{
					exit('信息有误');
				}
			}

			redirect('/home/consignment/index');


		}else{
			//产品基本信息
			$id = $this->input->get('id');
			$info = array();
			$config = array('co.id'=>$id);
			$info = $this->consignment->get_one_by_join($config);
			$data['info'] = $info;
			
			//支付方式
			$pays = array();
			if(!empty($info['pay_id'])){
				$pays = explode(',', $info['pay_id']);
			}
			$data['pays'] = $pays;
			
			//品牌
			$brand = array();
			$brandwhere = array('shop_id'=>$userinfo['shop_id']);
			$brand = $this->brand->getList($brandwhere);
			$data['brand'] = $brand;

						//支付方式
			$pay = array();
			$this->load->model('pay_mdl','pay');
			$pay = $this->pay->getList();
			$data['pay'] = $pay;

			//类型
			$category = array();
			$category = $this->category->getList($brandwhere);
			$data['category'] = $category;

						//图片
			$pic = array();
			$picwhere['where'] = array('conid'=>$id);
			$pic = $this->consignment_pic->getList($picwhere);
			$data['pic'] = $pic;

			$this->load->view('home/consignment/home_consignment_edit',$data);
		}
	}

	public function shenhe()
	{

		$userinfo = $this->userinfo;
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$reasons = $this->input->post('reasons');
		$reviewer = $userinfo['id'];
		$config = array('id'=>$id);
		$info = array();
		$info = $this->consignment->get_one_by_where($config);
		if(empty($info)){
			$msg = array('errcode'=>-1,'msg'=>'寄售产品不存在');
			echo json_encode($msg);
			exit;
		}
		$updatedata = array('reasons'=>$reasons,'status'=>$status,'reviewer'=>$reviewer);
		$this->consignment->update($config,$updatedata);
		$msg = array('errcode'=>0,'msg'=>'审核成功');

		//添加日志
		if($status == '4'){
			$log['act_info'] = '审核通过';
		}elseif($status == '3'){
			$log['act_info'] = '审核不通过';
		}else{
			$log['act_info'] = '未知操作';
		}
		
		$log['cid'] = $id;
		$log['uid'] = $info['uid'];
		$log['pid'] = 0;
		$log['act'] = 'update-consignment';
		$log['createtime'] = time();
		$this->logs->write_log('consignment',$log);
		//添加日志

		echo json_encode($msg);
	}

	//寄售产品信息
	public function views()
	{
		$this->load->helper('product');
		$id = $this->input->get('id');
		$info = array();
		$config = array('co.id'=>$id);
		$info = $this->consignment->get_one_by_join($config);
		$data['info'] = $info;

		//图片
		$pic = array();
		$picwhere['where'] = array('conid'=>$id);
		$pic = $this->consignment_pic->getList($picwhere);
		$data['pic'] = $pic;

		$this->load->view('home/consignment/home_consignment_views',$data);

	}



		//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$updatedata = array('issure'=>1);
		$this->consignment->update($config,$updatedata);
		//$this->brand->del($config);

		redirect('/home/consignment/index');
	}
}