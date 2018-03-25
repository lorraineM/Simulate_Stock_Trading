<?php

class ADMIN_LOG extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('s2/admin_model');
		$this->load->library('session');
	}

	public function index(){
		//检查session，看是否在登陆状态
        if($this->session->userdata('login')!='2R93R872@~~~~$ASA'){
        //session不在登陆状态，直接定向到主页
            redirect('/fund/');
        }else{
        //session在登陆状态记录登陆ID
        //记录登陆时间
            $agid=$this->session->userdata('agid');
            $logintime=$this->session->userdata('logintime');
            $data['agid']=$agid;
            $data['logintime']=$logintime;
        }

        //获得管理员ID
		$agid=$data['agid'];
		//调用函数获得该管理员所有日志
		$result=$this->admin_model->getAlllog($agid);
		if($result->num_rows()>0){
			//若查询结果存在
			$this->load->library('table');
			//动态生成带有css的table
			foreach ($result->result() as $row){
				$this->table->add_row('<h5>'.$row->lgid.'</h5>','<h5>'.$row->content.'</h5>','<h5>'.$row->dates.'</h5>');
			}
			$tb=$this->table->generate();
			preg_match_all('/<tr>[\s\S]+<\/tr>/i',$tb,$tb_res);
			$data['tb']=$tb_res[0][0];
			$data['ck']='1';
			//将table送到view显示
			$this->load->view('s2/admin_log',$data);
		}
		else{
			//若查询结果不存在
			$data['ck']='0';
			$this->load->view('s2/admin_log',$data);
		}
	}
}
?>
