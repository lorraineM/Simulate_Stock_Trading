<?php
	class ADMIN_CHECKREQ extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model('s2/admin_model');
			$this->load->model('s2/interest_model');
			$this->load->library('session');
			//$this->output->enable_profiler(TRUE);
		}

		//type=0 agree type=1 disagree

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

        	//获取一些必要信息
			$agree=$this->input->post('ag');
			$reason=$this->input->post('reason');
			$type=$this->input->post('type');
			$fid=$this->input->post('fid');
			$rid=$this->input->post('rid');

			$agid=$data['agid'];

			if($agree=='批准'){
				switch($type){
					case '开户':$this->admin_model->adCheckcreate($rid,$agid,0,$fid,$reason);break;
					case '挂失':$this->admin_model->adCheckloss($rid,$agid,0,$fid,$reason);break;
					case '补办':$this->admin_model->adCheckmakeup($rid,$agid,0,$fid,$reason);break;
					case '销户':$this->admin_model->adCheckcancel($rid,$agid,0,$fid,$reason);break;
					default:;
				}
				//调用结息计算函数
				$this->interest_model->cal_interest($fid);
				//重定向到未处理请求
				redirect('/fund/fund_reqn');
			}else{
				//未批准
				switch($type){
					case '开户':$this->admin_model->adCheckcreate($rid,$agid,1,$fid,$reason);break;
					case '挂失':$this->admin_model->adCheckloss($rid,$agid,1,$fid,$reason);break;
					case '补办':$this->admin_model->adCheckmakeup($rid,$agid,1,$fid,$reason);break;
					case '销户':$this->admin_model->adCheckcancel($rid,$agid,1,$fid,$reason);break;
					default:;
				}
				redirect('/fund/fund_reqn');
			}
		}
	}
?>
