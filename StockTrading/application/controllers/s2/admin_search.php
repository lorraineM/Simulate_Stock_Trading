<?php

class ADMIN_SEARCH extends CI_Controller{
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

		//fid,sid,idc,agid,fa_status,create_date
		//0正常，1申请开户中，2申请挂失中 3申请补办中 4 申请销户中 5 已挂失 6 已销户 7 被锁住
		//$account=$_GET['searchaim'];
       	//获取要显示的账户的号码
		$account=$this->input->get('searchaim');
		$data['fid']=$account;
		//利用函数查询账户明细
		$result=$this->admin_model->getDetailaccount($account,$data['agid']);
		if($result->num_rows()>0){
			foreach ($result->result() as $row){
				$data['fid'] = $row->fid;
				$data['sid'] = $row->sid;
				$data['idc'] = $row->idc;
				$data['agid'] = $this->admin_model->getAgentname($row->agid);
				if($data['agid']==false) $data['agid']='';
				//将账户状态翻译
				switch ($row->fa_status) {
					case '0':$data['status']='正常';break;
					case '1':$data['status']='申请开户中';break;
					case '2':$data['status']='申请挂失中';break;
					case '3':$data['status']='申请补办中';break;
					case '4':$data['status']='申请销户中';break;
					case '5':$data['status']='已挂失';break;
					case '6':$data['status']='已销户';break;
					case '7':$data['status']='冻结中';break;
				}
				$data['cdate'] = $row->create_date;
				//查询账户资金信息情况
				$currency=$this->admin_model->getCurrencyDetail($account);
				if($currency==false){
					//账户刚刚开户还未进行过资金操作
					$data['currency']=false;
					$data['curr']='账户未进行过资金操作';
				}else{
					//账户进行过资金操作，有资金信息
					$data['currency']=true;
					foreach ($currency->result() as $row) {
						//资金显示格式为币种 可用金额 冻结金额 余额
						$data['d1'.$row->types]='可用:'.round($row->available,2);
						$data['d2'.$row->types]='冻结:'.round($row->frozen,2);
						$data['d3'.$row->types]='共计:'.round($row->amount,2);
						//币种将在view里固定显示
					}
				}
			}
			$data['ck']='1';
			//将显示信息加载到页面
			$this->load->view('s2/admin_search',$data);
		}
		else{
			$data['ck']='0';
			$this->load->view('s2/admin_search',$data);
		}

	}
}
?>

