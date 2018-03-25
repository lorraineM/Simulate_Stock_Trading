<?php

class ADMIN_SINGLELOG extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('s2/admin_model');
		$this->load->library('session');
		//$this->output->enable_profiler(TRUE);
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

		//fid,senddates,rid
		//0:开户 1：挂失  2：补办 3：销户
		//获取要显示的账户的号码
		$fid=$_GET['searchaim'];
		$data['fid']=$fid;
		//调用函数获取该账户的操作日志
		$result=$this->admin_model->getSinglelog($fid);
		if($result->num_rows()>0){
			$this->load->library('table');
			foreach ($result->result() as $row){
				$this->table->add_row('<h5>'.$row->lgid.'</h5>','<h5>'.$row->content.'</h5>','<h5>'.$row->dates.'</h5>');

			}
			$tb=$this->table->generate();
			preg_match_all('/<tr>[\s\S]+<\/tr>/i',$tb,$tb_res);
			$data['tb']=$tb_res[0][0];
			$data['ck']='1';
			//将显示信息加载到页面
			$this->load->view('s2/admin_singlelog',$data);
		}
		else{
			$data['ck']='0';
			$this->load->view('s2/admin_singlelog',$data);
		}
	}
}
?>
