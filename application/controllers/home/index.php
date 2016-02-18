<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Admin_Controller
{


	public function __construct()
	{
		parent::__construct();
		
	}


	public function index()
	{
		$data['userinfo'] = $this->userinfo;
		$this->load->view('home/home_index',$data);
	}
}