<?php


class Color_mdl extends Spring_Model
{
	
	var $table_name = 'st_color';

	public function __construct()
	{
		parent::__construct();
		$this->set_table_name($this->table_name);
	}

	
}