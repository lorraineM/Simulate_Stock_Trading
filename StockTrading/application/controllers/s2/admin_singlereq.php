<?php

class ADMIN_SINGLEREQ extends CI_Controller{
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
		//调用函数获取该账户的请求
		$result=$this->admin_model->getSinglereq($fid);
		if($result->num_rows()>0){
			$this->load->library('table');
			foreach ($result->result() as $row){
				switch ($row->types) {
					case '0':
						$data['type'] = '开户';break;
					case '1':
						$data['type'] = '挂失';break;
					case '2':
						$data['type'] = '补办';break;
					case '3':
						$data['type'] = '销户';break;
				}
				$aim='/StockTrading/fund/fund_detailreq?src=home&reqaim='.$row->rid;

				$this->table->add_row('<h5>'.$data['type'].'</h5>','<h5>'.str_pad($row->fid,16,0,STR_PAD_LEFT).'</h5>','<h5>'.$row->senddates.'</h5>','<a href='.$aim.'><h5>'.str_pad($row->rid,10,0,STR_PAD_LEFT).'</h5>');
			}
			$tb=$this->table->generate();
			preg_match_all('/<tr>[\s\S]+<\/tr>/i',$tb,$tb_res);
			$data['tb']=$tb_res[0][0];
			$data['ck']='1';
			//将显示信息加载到页面
			$this->load->view('s2/admin_singlereq',$data);
		}
		else{
			$data['ck']='0';
			$this->load->view('s2/admin_singlereq',$data);
		}
	}
}
?>
