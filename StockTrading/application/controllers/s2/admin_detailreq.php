<?php

class ADMIN_DETAILREQ extends CI_Controller{
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

		//types,fid,idc,senddates,rid
		//0正常，1申请开户中，2申请挂失中 3申请补办中 4 申请销户中 5 已挂失 6 已销户 7 被锁住
		$req=$this->input->get('reqaim');
		//获取与流水号对应的详细信息
		$result=$this->admin_model->getDetailreq($req);
		if($result->num_rows()>0){
			//如果详细信息存在
			foreach ($result->result() as $row){
				$data['rid'] = $row->rid;
				$data['fid'] = $row->fid;
				$data['idc'] = $row->idc;
				switch ($row->types) {
					case '0':
						$data['types']='开户';break;
					case '1':
						$data['types']='挂失';break;
					case '2':
						$data['types']='补办';break;
					case '3':
						$data['types']='销户';break;
				}
				$data['cdate'] = $row->senddates;
			}
			$data['ck']='1';
			//将详细信息显示到页面
			$this->load->view('s2/admin_detailreq',$data);
		}
		else{
			//详细信息不存在，变量为0，不显示
			$data['ck']='0';
			$this->load->view('s2/admin_detailreq',$data);
		}

	}
}
?>

