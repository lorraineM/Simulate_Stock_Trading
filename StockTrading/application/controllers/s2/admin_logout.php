<?php

class ADMIN_LOGOUT extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('s2/admin_model');
        //下面一行输出调试信息
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

        //登出，销毁session
        $this->session->sess_destroy();
        //登出在管理员日志中插入登出记录
        $this->admin_model->adLogout($data['agid']);
        //登出定向到主页
        redirect('/fund/','refresh');
    }
}
