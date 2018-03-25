<?php

class ADMIN_REQN extends CI_Controller{
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
       	 //查询该经纪商未处理的信息
		$result=$this->admin_model->getAllrequests_nd($data['agid']);
		if($result->num_rows()>0){
			//如果查询结果不为空
			//动态生成table
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
				//将请求流水号链接到明细
				$aim='/StockTrading/fund/fund_detailreq?src=home&reqaim='.$row->rid;
				$this->table->add_row('<h5>'.$data['type'].'</h5>','<h5>'.str_pad($row->fid,16,0,STR_PAD_LEFT).'</h5>','<h5>'.$row->senddates.'</h5>','<a href='.$aim.'><h5>'.str_pad($row->rid,10,0,STR_PAD_LEFT).'</h5>');
			}
			$tb=$this->table->generate();
			preg_match_all('/<tr>[\s\S]+<\/tr>/i',$tb,$tb_res);
			$data['tb']=$tb_res[0][0];
			$data['ck']='1';
			//将生成的表格动态加载到页面
			$this->load->view('s2/admin_reqn',$data);
		}
		else{
			//查询结果为空，则不显示表格
			$data['ck']='0';
			$this->load->view('s2/admin_reqn',$data);
		}
	}
}
?>
