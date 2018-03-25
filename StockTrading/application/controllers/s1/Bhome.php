<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	class Bhome extends CI_Controller{
		function Bhome()
		{
			parent::__construct();
			$this->output->set_header("Content-Type:text/html;charset=utf-8");
			$this->load->library('session');
		}
/*		function index()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->view('s1/bview');
		}*/
		function manage_bban(){
			session_start();
			$this->load->model('s1/Lmodel','MOD');
			$kind=$this->input->post('bagency');
			$id=$this->input->post('bid');
			if($kind==1)//自然人补办
			{
				if(!$this->MOD->check_pid($id))
				{
					echo'<script type="text/javascript">alert("该自然人账户不存在,请确认后重新输入");history.back();</script>';
				}
				elseif(!$this->MOD->check_bid($id))
				{
					echo'<script type="text/javascript">alert("该自然人账户未曾挂失");history.back();</script>';
				}
				elseif($this->MOD->check_pid($id)&&$this->MOD->check_bid($id))//检测该用户是否已经挂失
				{
					if($this->MOD->check_btime($id))//检测挂失时间是否已经超过10天
					{
						$this->MOD->bupdate_pid($id);//更新用户的信息，将状态改为补办
						//echo'<script type="text/javascript">alert("该自然人账户补办成功！");</script>';
						$t = gmdate("Y-m-d H:i:s", mktime() + 8 * 3600); //获取当前时间
						$stocknum=$this->MOD->randStr(10);  //调用model的函数产生10位字符串
            			$check_stocknum=$this->MOD->check_stocknum_person($stocknum); //检查是否存在该字符串的证券账户
            			while ($check_stocknum!=FALSE)
            			{  //如果存在，就继续生成下一个
                			$stocknum=$this->MOD->randStr(9);
                			$check_stocknum=$this->MOD->check_stocknum_person($stocknum); 
            			}
            			$personal_result=$this->MOD->detail_pid($id);
            			foreach ($personal_result as $row)
            			{
            				$old_stock=$row->股票账户号码;
            				$name=$row->姓名;
            				$sex=$row->性别;
            				$address=$row->家庭地址;
            				$profession=$row->职业;
            				$edu=$row->学历;
            				$work=$row->工作单位;
            				$tel=$row->联系电话;
            				$ifagen=$row->是否代办;
            				$aname=$row->代办人姓名;
            				$aid=$row->代办人身份证号码;
            			}
            			$this->MOD->unlock_fund($old_stock);
            			$this->MOD->update_fund($old_stock,$stocknum);
            			$this->MOD->cancel_pid($id);//将改用户的状态改为正常
            			$this->MOD->insert_account_person($stocknum,$t,$name,$sex,$id,$address,$profession,$edu,$work,$tel,$ifagen,$aname,$aid);//插入法人账户
            			echo'<script type="text/javascript">alert("成功补办");history.back();</script>';//补办成功
					}
					else//补办失败
						echo'<script type="text/javascript">alert("该自然人账挂失时间不足10天,请确认后重新输入");history.back();</script>';
				}

			}
			else//法人补办
			{
				if(!$this->MOD->check_fid($id))
				{
					echo'<script type="text/javascript">alert("该法人账户不存在,请确认后重新输入");history.back();</script>';
				}
				elseif(!$this->MOD->check_bid($id))
				{
					echo'<script type="text/javascript">alert("该法人账户未曾挂失");history.back();</script>';
				}
				elseif($this->MOD->check_fid($id)&&$this->MOD->check_bid($id))//检测该法人是否已经挂失
				{
					if($this->MOD->check_btime($id))//检测挂失时间是否已经超过10天
					{
						$this->MOD->bupdate_fid($id);//更新法人证券账户信息中的状态为补办
						//echo'<script type="text/javascript">alert("该法人账户补办成功！");history.back();</script>';
						$t = gmdate("Y-m-d H:i:s", mktime() + 8 * 3600); //获取当前时间
						$stocknum=$this->MOD->randStr(10);  //调用model的函数产生10位字符串
            			$check_stocknum=$this->MOD->check_stocknum_company($stocknum); //检查是否存在该字符串的证券账户
            			while ($check_stocknum!=FALSE){  //如果存在，就继续生成下一个
                			$stocknum=$this->MOD->randStr(9);
                			$check_stocknum=$this->MOD->check_stocknum_company($stocknum); 
            			}
            			$register_result=$this->MOD->detail_fid($id);
            			foreach ($register_result as $row)
            			{
            				$old_fstock=$row->股票账户号码;
            				$regisnum=$row->法人注册登记号码;
            				$bus_license=$row->营业执照号码;
            				$aname=$row->法人姓名;
            				$atel=$row->法人联系电话;
            				$address=$row->法人联系地址;
            				$ename=$row->授权执行人姓名;
            				$gid=$row->授权人身份证号码;
            				$gtel=$row->授权人联系电话;
            				$gaddress=$row->授权人地址;
            			}
            			$this->MOD->unlock_fund($old_fstock);
            			$this->MOD->update_fund($old_fstock,$stocknum);
            			$this->MOD->cancel_fid($id);//将法人信息的状态改为正常
            			$this->MOD->insert_account_company($stocknum,$regisnum,$bus_license,$id,$aname,$atel,$address,$ename,$gid,$gtel,$gaddress);//插入法人账户
            			echo'<script type="text/javascript">alert("成功补办");history.back();</script>';//补办成功
					}
					else//补办失败
						echo'<script type="text/javascript">alert("该法人账户挂失时间不足10天,请确认后重新输入");history.back();</script>';
				}
			}
		}
		
	}
?>
			