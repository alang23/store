<?php

class Userupload extends Base_Controller
{
	

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('test');
	}


	public function upload()
	{
		 /**
		* 上传登记证
		*/ 
		$dir = $this->input->post('dir');


 		if(!empty($_FILES['uploadify']['name'])){ 
	            	$config['upload_path'] = FCPATH.'/uploads/'.$dir;
	            	if(!is_dir($config['upload_path'])){
	            		mkdir($config['upload_path']);
	            	}
	            	$config['allowed_types'] = '*';
	            	
	            	$config['file_name']  =date("YmdHis");
	           
	            	
	            	$this->load->library('upload', $config); 
	            	if ( ! $this->upload->do_upload('uploadify')){
	                	$error = array('error' => $this->upload->display_errors());
	                  	echo json_encode($error);
	            	}else{ 
	                	$updata = array('upload_data' => $this->upload->data());
	                	$picname = $updata['upload_data']['orig_name']; 
	                	echo $picname;          	
	            	}
	    } 
	}


	
}