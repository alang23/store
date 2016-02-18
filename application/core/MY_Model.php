<?php
/**
*@dec 
*
**/

class Spring_Model extends CI_Model
{
	
	var $table_name;


	public function __construct()
	{
		parent::__construct();
		$this->load->database(); 
		
	}

	public function set_table_name($table_name)
	{
		$this->table_name = $table_name;
	}


	/**
	*@dec 获取列表
	*@return Array
	**/
	public function getList($config=array())
	{
		if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }

        if(!empty($config['order'])){
            $this->db->order_by($config['order']['key'],$config['order']['value']);
        }

        
        if(!empty($config['where_in'])){
            $this->db->where_in($config['where_in']['key'], $config['where_in']['value']);
           
        }

        //like
        if(!empty($config['like'])){
            $this->db->like($config['like']['key'],$config['like']['value']);
        }

        $list = array();
        $list = $this->db->get($this->table_name)->result_array();

        return $list;
	}

	/**
	*@DEC 根据条件获取单条数据
	*@return Array
	**/

	public function get_one_by_where($where = array())
	{
        $info = array();
        if(!empty($where)){
            $this->db->where($where);
        }

        $info = $this->db->get($this->table_name)->row_array();

        return $info;
	}

	public function add($data){

        return $this->db->insert($this->table_name,$data);
    }

    //修改
    public function update($where, $data){
        
        if(!empty($where)){
            $this->db->where($where);
        }

        $this->db->update($this->table_name, $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

	    //删除单条信息
    public function del($where){

        if(!empty($where)){
            $this->db->where($where);
        }

		return $this->db->delete($this->table_name);
    }


    //get data count
    public function get_count($where = array())
    {
    	if(!empty($where)){
    		$this->db->where($where);
    	}
        $count = 0;
		$count = $this->db->count_all_results($this->table_name);

        return $count;
    }

    //
    public function insert_id()
    {
        return $this->db->insert_id();
    }




}

class MY_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

}