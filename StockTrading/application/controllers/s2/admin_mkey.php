<?php
	class ADMIN_MKEY extends CI_Controller{
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
				$data['agid_error']='';
				$data['oldpwd_error']='';
				$data['newpwd_error']='';
				$data['newpwdconf_error']='';
				$data['result']='';
			}

			$this->load->view('s2/admin_mkey',$data);
		}
	}
?>
