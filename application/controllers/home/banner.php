<?php

class Banner extends Admin_Controller{


	public function __construct(){
		parent::__construct();
		$this->load->model('banner_mdl','banner');

	}

	public function index(){

		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $where['where'] = array('issure'=>0);
        $count = $this->banner->get_count($where['where']);
        $data['count'] = $count;

        $pageconfig['base_url'] = base_url('index.php/home/banner/index?');
        $pageconfig['count'] = $count;
        $pageconfig['limit'] = $limit;
        $data['page'] = home_page($pageconfig);

        $list = $this->banner->getList($where);
        $data['list'] = $list;
       
        $this->load->view('home/banner/home_banner',$data);

	}

	public function add(){

		if(!empty($_POST)){
			$weizhi = $this->input->post('url');
            $rank = $this->input->post('rank');

			//================= upload ====================
            /**图片上传**/
            if(!empty($_FILES['userfile']['name'])){

                $config['upload_path'] = FCPATH.'/uploads/banner/';
                //echo $config[upload_path];
                //exit;
                $config['allowed_types'] = '*';
                $config['file_name']  =date("YmdHis");

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile')){
                    $error = array('error' => $this->upload->display_errors());
                    echo json_encode($error);
                }else{
                    $data = array('upload_data' => $this->upload->data());
                    $picname = $data['upload_data']['orig_name'];
                    $dataarr['pic'] = $picname;
                    $dataarr['url'] = $weizhi;
                    $dataarr['rank'] = $rank;
                    $dataarr['createtime'] = time();

                    $this->banner->add($dataarr);
                    redirect('/home/banner');

                }

            }

            echo $picname;
            //================= upload ====================
		}else{
			$this->load->view('home/banner/home_banner_add');
		}
	}


	public function del(){
        $id = intval($_GET['id']);
        $config['id'] = $id;
        $updateconfig = array('id'=>$id);
        $updatedata = array('issure'=>1);
        $this->banner->del($config);
        redirect('d=home&c=banner');

    }
}