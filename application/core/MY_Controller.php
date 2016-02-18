<?php
/**
*@DEC 后台管理主控制器
*
**/


class Admin_Controller extends CI_Controller
{
	var $userinfo = array();

	public function __construct()
	{
		parent::__construct();
		$this->check_login();
		$this->Widget('widget');
        $this->load->helper('page');
        $this->load->library('logs');
		
	}

	public function check_login()
	{
		$cookie_name = $this->config->item('admin_cookie_name');
		$token = $this->session->userdata($cookie_name);
   
        if(empty($token)){
            redirect('/home/login');
        }

        $this->userinfo = $token;
	}

	protected function Widget($name = '')
    {


        if (isset($name) && $name != '')
        {

           require_once APPPATH.'widgets/'.$name.EXT;
        	
        }


    }


}


class Base_Controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->Widget('widget');
	}

	protected function Widget($name = '')
    {


        if (isset($name) && $name != '')
        {

            require_once APPPATH.'widgets/'.$name.EXT;

        }


    }
}


//api基类控制器
class Api_Controller extends CI_Controller
{
	

	public function __construct()
	{
		parent::__construct();
        //加载日志library
        $this->load->library('logs');
	}

    public function check_Login()
    {
        $islogin = 0;
        $data = $this->requestData();
        $uid = $data['data']['uid'];
        $token = $data['data']['token'];
        if(!empty($uid) && !empty($token)){
            //校验
            $config = array('id'=>$uid);
            $this->load->model('member_mdl','member');
            $check_info = $this->member->get_one_by_where($config);
            if(empty($check_info)){
                $responseData = array(
                    'errcode'=>"10001",
                    'msg'=>'登陆失败',
                    'data'=>array()
                    );
                $this->responseData($responseData);
            }elseif($check_info['token'] != $token){
                $responseData = array(
                    'errcode'=>"10001",
                    'msg'=>'登陆失败',
                    'data'=>array()
                    );
                $this->responseData($responseData);
            }
        }else{
                $responseData = array(
                    'errcode'=>"10001",
                    'msg'=>'登陆失败',
                    'data'=>array()
                    );
                $this->responseData($responseData);
        }

    }


	//取得前端post过来的数据
    public function requestData()
    {
    	$data = file_get_contents('php://input');
     
   		$jsonObject = json_decode($data,true);

   		/*
   		$fp = fopen('log.txt','a+');
   		fwrite($fp,$data);
   		fclose($fp);
   		*/
   	    return $jsonObject;
    }



    //统一返回

    public function responseData($data)
    {
       //$data = str_replace("null", "", $data);
    	$repdate = str_replace("null","\"\"",json_encode($data));
        echo $repdate;

        exit;
    }

}

class Test_Controller extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
	}
}