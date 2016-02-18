<?php
/**
*@DEC 收货Controller
*
**/


class Takegoods extends Admin_Controller
{





	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->load->view('takegoods');
	}

	public function add()
	{
		$this->load->view('takegoods/take_goods_add');
	}

}
