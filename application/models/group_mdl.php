<?php
/**
*@DEC 品牌model
*
**/

class Group_mdl extends Spring_Model
{

	var $table_name = 'st_group';

	public function __construct()
	{
		parent::__construct();
		$this->set_table_name($this->table_name);
	}

}