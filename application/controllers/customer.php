<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*@desc 客户管理Controller
*@author Alang
**/

class Customer extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('customer_mdl','customer');
	}


	public function index()
	{
		$list = array();
		$userinfo = $this->userinfo;
	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
  
        $where['where'] = array('isdel'=>0);      
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->customer->get_count($where['where']);
        $data['count'] = $count;

        $pageconfig['base_url'] = base_url('index.php/customer/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $wherelist['where'] = array('c.isdel'=>0);

        $list = $this->customer->get_list_join($wherelist);
        $data['list'] = $list;
        //print_r($list);
		$this->load->view('customer/customer_list',$data);
	
	}

	//添加
	public function add()
	{
		$userinfo = $this->userinfo;

		if(!empty($_POST)){
			$customer_name = $this->input->post('customer_name');
			$mobile = $this->input->post('mobile');
			$remark = $this->input->post("remark");

			$address = $this->input->post("address");
			$province_id = $this->input->post('province_id');
			$city_id = $this->input->post('city_id');
			$zone_id = $this->input->post('zone_id');

			$sale_id = $this->input->post('sale_id');

			if(!empty($customer_name)){
				$add['customer_name'] = $customer_name;
				$add['remark'] = $remark;
				$add['mobile'] = $mobile;
				$add['address'] = $address;
				$add['province_id'] = $province_id;
				$add['city_id'] = $city_id;
				$add['zone_id'] = $zone_id;
				$add['sale_id'] = $sale_id;
				$add['createtime'] = time();

				if($this->customer->add($add)){
					redirect('/customer/index');
				}
			}else{
				exit('信息有误');
			}
		}else{
			$this->load->library('diqu');
			$province =  $this->diqu->get_province();
			$data['province'] = $province;

			//客服专员
			$employee = array();
			$employee = $this->get_employee();
			$data['employee'] = $employee;

			$this->load->view('customer/customer_add',$data);
		}
	}

	//修改
	public function update()
	{
		$userinfo = $this->userinfo;
		if(!empty($_POST)){
			$customer_name = $this->input->post('customer_name');
			$mobile = $this->input->post('mobile');
			$remark = $this->input->post("remark");

			$address = $this->input->post("address");
			$province_id = $this->input->post('province_id');
			$city_id = $this->input->post('city_id');
			$zone_id = $this->input->post('zone_id');

			$sale_id = $this->input->post('sale_id');
			$id = $this->input->post('id');

			if(!empty($customer_name)){
				$add['customer_name'] = $customer_name;
				$add['remark'] = $remark;
				$add['mobile'] = $mobile;
				$add['address'] = $address;
				$add['province_id'] = $province_id;
				$add['city_id'] = $city_id;
				$add['zone_id'] = $zone_id;
				$add['sale_id'] = $sale_id;
				$add['createtime'] = time();

				$updateconfig = array('id'=>$id);
				$this->customer->update($updateconfig,$add);
				redirect('/customer/index');
				
			}else{
				exit('信息有误');
			}

		}else{
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = $this->customer->get_one_by_where($config);
			if(empty($info)){
				exit('内容不存在');
			}

			$this->load->library('diqu');
			$province =  $this->diqu->get_province();
			$data['province'] = $province;

			//客服专员
			$employee = array();
			$employee = $this->get_employee();
			$data['employee'] = $employee;
			$data['info'] = $info;
			$this->load->view('customer/customer_edit',$data);
		}
	}

	//删除
	public function del()
	{
		$id = $this->input->get('id');
		$userinfo = $this->userinfo;
		$config = array('id'=>$id);
		$update_data = array('isdel'=>1);
		$this->customer->update($config,$update_data);

		redirect('/customer/index');
	}

	//客服专员
	public function get_employee()
	{
		$this->load->model('employee_mdl','employee');
		$list = array();
		$list = $this->employee->getList();

		return $list;
	}


	public function get_address_info()
	{
		$type = $this->input->post('type');
		$id = $this->input->post('id');

		$this->load->library('diqu');
		$list = array();
		if($type == 'city'){
			$list = $this->diqu->get_city($id);
			$optin_arr = '<select name="city_id" onchange="get_address_info(\'zone\',this.value);">';
			if(!empty($list)){
				foreach($list as $k => $v){
					$optin_arr .= '<option value="'.$v['CitySort'].'">'.$v['CityName'].'</option>';
				}
			}
		}elseif($type == 'zone'){
			$list = $this->diqu->get_zone($id);
			$optin_arr = '<select name="zone_id"';
			if(!empty($list)){
				foreach($list as $k => $v){
					$optin_arr .= '<option value="'.$v['ZoneID'].'">'.$v['ZoneName'].'</option>';
				}
			}
		}else{

		}
		
		$optin_arr .= '</option>';

		echo $optin_arr;
	}
}