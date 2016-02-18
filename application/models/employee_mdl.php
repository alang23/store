<?php
/**
*@DEC 品牌model
*
**/

class Employee_mdl extends Spring_Model
{

	var $table_name = 'st_employee';

	public function __construct()
	{
		parent::__construct();
		$this->set_table_name($this->table_name);
	}

}