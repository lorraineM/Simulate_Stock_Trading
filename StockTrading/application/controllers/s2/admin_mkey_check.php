<?php
	class ADMIN_MKEY_CHECK extends CI_Controller{
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

       	 	//定义表格项检查规则
			$this->load->library('form_validation');
			$this->form_validation->set_rules('agid','ID','trim|required');
			$this->form_validation->set_rules('oldpwd','PASSWD','trim|required|min_length[6]');
			$this->form_validation->set_rules('newpwd','REPASSWD','required|min_length[6]|matches[newpwdconf]');
			$this->form_validation->set_rules('newpwdconf','PASSWDCONF','required');

			//重定义错误输出规则
			$this->form_validation->set_message('required', '请确认表单该项不为空');
			$this->form_validation->set_message('min_length', '密码位数必须大于6位');
			$this->form_validation->set_message('max_length', '密码位数必须小于15位');
			$this->form_validation->set_message('matches', '两次输入的密码不一致');

			if($this->form_validation->run()==FALSE){
				//有错则输出错误,正确则不输出

				//检查管理员账号是否输入正确
				$error_agid=form_error('agid');
				if($error_agid!=''){
					preg_match_all('/<p>([\s\S]+)<\/p>/i',$error_agid,$res);
					$data['agid_error']=$res[1][0];
				}else $data['agid_error']='';

				//检查管理员原密码是否输入正确
				$error_opwd=form_error('oldpwd');
				if($error_opwd!=''){
					preg_match_all('/<p>([\s\S]+)<\/p>/i',$error_opwd,$res);
					$data['oldpwd_error']=$res[1][0];
				}else $data['oldpwd_error']='';

				//检查管理员新密码是否输入正确，且与重新输入的新密码匹配
				$error_npwd=form_error('newpwd');
				if($error_npwd!=''){
					preg_match_all('/<p>([\s\S]+)<\/p>/i',$error_npwd,$res);
					$data['newpwd_error']=$res[1][0];
				}else $data['newpwd_error']='';

				//检查管理员重新输入的新密码是否正确
				$error_npwdconf=form_error('newpwdconf');
				if($error_npwdconf!=''){
					preg_match_all('/<p>([\s\S]+)<\/p>/i',$error_npwd,$res);
					$data['newpwdconf_error']=$res[1][0];
				}else $data['newpwdconf_error']='';
				$data['result']='';

				//将错误信息加载到页面
				$this->load->view('s2/admin_mkey',$data);
			}else{
				//如果没有错误，错误信息全部清空
				$data['agid_error']='';
				$data['oldpwd_error']='';
				$data['newpwd_error']='';
				$data['newpwdconf_error']='';
				$agid=$this->input->post('agid');
				$key=$this->input->post('newpwd');
				$oldkey=$this->input->post('oldpwd');
				$rres=$this->admin_model->modKey($agid,$oldkey,$key);
				$data['result']=$rres['sql_error'];
				//将错误信息加载到页面
				$this->load->view('s2/admin_mkey',$data);
			}
		}
	}
?>
