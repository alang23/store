<?php


class Databases extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->dbutil();
	}


	public function index()
	{
		$dbs = $this->dbutil->list_databases();

		foreach ($dbs as $db)
		{
		    echo $db;
		    echo '<br/>';
		}
	}
}