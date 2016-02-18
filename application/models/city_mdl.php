<?php


class City_mdl extends Spring_Model
{
	
	var $table_name = 'st_city';

	public function __construct()
	{
		parent::__construct();
		$this->set_table_name($this->table_name);
	}

	
}