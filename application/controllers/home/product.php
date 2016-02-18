<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*@desc 商品管理Controller
*@author Alang
**/

class Product extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('product_mdl','product');
		$this->load->model('brand_mdl','brand');
		$this->load->model('category_mdl','category');
		$this->load->model('product_pic_mdl','product_pic');
		$this->load->helper('product');
	}


	public function index()
	{
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $where['where'] = array('shop_id'=>$userinfo['shop_id']);
         
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->product->get_count($where['where']);
        $data['count'] = $count;

        $pageconfig['base_url'] = base_url('index.php/home/product/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $wherelist['where'] = array('pro.shop_id'=>$userinfo['shop_id']);

        $list = $this->product->get_list_join($wherelist);
        $data['list'] = $list;

        $this->load->view('home/home_product',$data);
	
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
			$pic = $this->input->post('pic');
			$discount = $this->input->post('discount');
			$types = $this->input->post('types');
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
				$add['shop_id'] = $userinfo['shop_id'];
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
				        $picname = $upload['file_name'];
				        					//生成所略图
						$this->load->library("image_lib");//载入图像处理类库  
						$config_big_thumb=array(  
		                    'image_library' => 'gd2',//gd2图库  
		                    'source_image' => './uploads/productthumb/'.$picname,//原图  
		                    'new_image' => "./uploads/productthumb/thumb/".$picname,//大缩略图  
		                    'create_thumb' => true,//是否创建缩略图  
		                    'maintain_ratio' => true,  
		                    'width' => 197,//缩略图宽度  
		                    'height' => 197,//缩略图的高度  
		                    'thumb_marker'=>""//缩略图名字后加上 "_300_300",可以代表是一个300*300的缩略图  
	                	); 
	                	$this->image_lib->initialize($config_big_thumb);  
                		$this->image_lib->resize();//生成big缩略图 
				        $add['pic'] = 'thumb/'.$upload['file_name'];			        	           
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

			//支付方式
			$pay = array();
			$this->load->model('pay_mdl','pay');
			$pay = $this->pay->getList();
			$data['pay'] = $pay;

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
			$pic = $this->input->post('pic');
			$discount = $this->input->post('discount');
			$types = $this->input->post('types');
			$attr_id = $this->input->post('attr_id');
			$pay_id = $this->input->post('pay_id');

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
				$add['discount'] = $discount;
				$add['types'] = $types;
				$add['attr'] = json_encode($attr_id);
				if(!empty($pay_id)){
					$add['pay_id'] = implode(',', $pay_id);
				}


				if(!empty($_FILES)){
				
				    $configpic['upload_path'] = './uploads/productthumb/';
				    $configpic['allowed_types'] = '*';
				    $configpic['file_name']  =date("YmdHis");
				    $this->load->library('upload', $configpic);
				    if ( $upload = $this->upload->do_upload('userfile'))
				    {
				        $upload = $this->upload->data();
				        $picname = $upload['file_name'];
				        					//生成所略图
						$this->load->library("image_lib");//载入图像处理类库  
						$config_big_thumb=array(  
		                    'image_library' => 'gd2',//gd2图库  
		                    'source_image' => './uploads/productthumb/'.$picname,//原图  
		                    'new_image' => "./uploads/productthumb/thumb/".$picname,//大缩略图  
		                    'create_thumb' => true,//是否创建缩略图  
		                    'maintain_ratio' => true,  
		                    'width' => 197,//缩略图宽度  
		                    'height' => 197,//缩略图的高度  
		                    'thumb_marker'=>""//缩略图名字后加上 "_300_300",可以代表是一个300*300的缩略图  
	                	); 
	                	$this->image_lib->initialize($config_big_thumb);  
                		$this->image_lib->resize();//生成big缩略图 
				        $add['pic'] = 'thumb/'.$upload['file_name'];	
				            	           
				    }else{
				        echo $this->upload->display_errors();
				        exit;
				    }
				}
				
				
				$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
				$this->product->update($config,$add);
					//删除图片
				$delconfig = array('product_id'=>$id);
				$this->product_pic->del($delconfig);
		
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
				exit('信息有误');
			}
		}else{
			//产品基本信息
			$id = $this->input->get('id');
			$info = array();
			$config = array('shop_id'=>$userinfo['shop_id'],'id'=>$id);
			$info = $this->product->get_one_by_where($config);
			$data['info'] = $info;
			$category_id = $info['category_id'];
			$ids = array();
			if(!empty($info['attr'])){
				$ids = json_decode($info['attr']);
			}
			$attr_str = $this->_get_attr($category_id,$ids);
			$data['attr_str'] = $attr_str;

			//支付方式
			$pays = array();
			if(!empty($info['pay_id'])){
				$pays = explode(',', $info['pay_id']);
			}
			$data['pays'] = $pays;

			//类别拥有属性
		
			//print_r($info);
			//品牌
			$brand = array();
			$brandwhere = array('shop_id'=>$userinfo['shop_id']);
			$brand = $this->brand->getList($brandwhere);
			$data['brand'] = $brand;

			//类型
			$category = array();
			$category = $this->category->getList($brandwhere);
			$data['category'] = $category;

			//支付方式
			$pay = array();
			$this->load->model('pay_mdl','pay');
			$pay = $this->pay->getList();
			$data['pay'] = $pay;

			//图片
			$pic = array();
			$picwhere['where'] = array('product_id'=>$id);
			$pic = $this->product_pic->getList($picwhere);
			$data['pic'] = $pic;

			$this->load->view('home/home_product_edit',$data);
		}
	}


		//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$this->product->del($config);

		redirect('/home/product/index');
	}


	//ajax
	public function _get_attr($categoryid,$ids=array())
	{
		
		$this->load->model('category_mdl','category');
		$config = array('id'=>$categoryid);
		$cinfo = $this->category->get_one_by_where($config);
		if(!empty($cinfo)){
			$c_attr = $cinfo['c_attr'];

			$attrarr = explode(',', $c_attr);
			$att_content = array();

			$this->load->model('attribute_mdl','attribute');
			$attrname = array();
			$where1['where_in'] = array('key'=>'id','value'=>$attrarr);
			$attrname = $this->attribute->getList($where);

			//属性名称
			foreach($attrname as $k1 => $v1){
				$tmpname[$v1['id']] = $v1['name'];
			}

			
			$this->load->model('attribute_content_mdl','attribute_content');
			$where['where_in'] = array('key'=>'attr_id','value'=>$attrarr);
			$attr = $this->attribute_content->getList($where);
			foreach($attr as $k => $v){
				$tmp[$v['attr_id']][] = $v;
			}

			$str = '';
			if(!empty($tmp)){
				foreach($tmp as $kk => $vv){
					
					//$str .='<strong>'.$tmpname[$kk].'</strong>'.':<select name="attr_id[]" class="form-control">';
					$str .='<strong>'.$tmpname[$kk].'</strong>'.': <select data-placeholder="Choose a Country..." class="chosen-select" tabindex="2" name="attr_id[]">';
					foreach($vv as $kkk => $vvv){
						$att = $vvv['attr_id'].'_'.$vvv['id'];
						if(in_array($att,$ids)){
							$str .= '<option value="'.$vvv['attr_id'].'_'.$vvv['id'].'" selected >'.$vvv['attr_name'];
						}else{
							$str .= '<option value="'.$vvv['attr_id'].'_'.$vvv['id'].'">'.$vvv['attr_name'];
						}
						
					}
					$str .= '</select>  ';
				}
			}

			
		}


		return $str;
	}

	public function get_attr()
	{
		$categoryid = $this->input->post('categoryid');
		$str = $this->_get_attr($categoryid);

		echo $str;
	}
}