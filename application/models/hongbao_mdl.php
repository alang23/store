<?php
/**
*@DEC 红包model
*
**/

class Hongbao_mdl extends Spring_Model
{

	var $table_name = 'spring_hongbao';

	public function __construct()
	{
		parent::__construct();
		$this->set_table_name($this->table_name);
	}


	
}