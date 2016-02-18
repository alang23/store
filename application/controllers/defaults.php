<?php


class Defaults extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$list = array();
		$data['list'] = $list;

		$this->load->view('defaults',$data);
	}
}