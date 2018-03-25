<?php

class ADMIN_INDEX extends CI_Controller{
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

		//fid,sid,create_date
		//获取该证券经纪商所有的账户信息
		$result=$this->admin_model->getAllaccounts($data['agid']);
		if($result->num_rows()>0){
			//有匹配信息
			$this->load->library('table');
			//获取匹配信息
			foreach ($result->result() as $row){
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
				$aim='/StockTrading/fund/fund_search?src=home&searchaim='.$row->fid;
				$this->table->add_row('<a href='.$aim.'><h5>'.str_pad($row->fid,16,0,STR_PAD_LEFT).'</h5></a>','<h5>'.$row->sid.'</h5>','<h5>'.$row->create_date.'</h5>','<h5>'.$data['status'].'</h5>');
			}
			$tb=$this->table->generate();
			preg_match_all('/<tr>[\s\S]+<\/tr>/i',$tb,$tb_res);
			$data['tb']=$tb_res[0][0];
			$data['ck']='1';
			//将信息加载到显示页面
			$this->load->view('s2/admin_index',$data);
		}
		else{
			//没有匹配信息，则不输出table
			$data['ck']='0';
			$this->load->view('s2/admin_index',$data);
		}
	}
}
?>
