<?php

class Testadmin extends Base_Controller
{
	

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		header("Content-type:text/html;charset=utf-8");
		//$this->load->view('home/testadmin');
		$this->load->library('diqu');
		$list = $this->diqu->get_city(1);

		print_r($list);
	}
}