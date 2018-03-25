<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	class Lhome extends CI_Controller{
		function Lhome()
		{
			parent::__construct();
			$this->output->set_header("Content-Type:text/html;charset=utf-8");
			$this->load->library('session');
		}
		function index()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this -> load -> model('s1/login_model');
    		if ($this->login_model->check_login()==false)//判定是否为管理员登陆模式
    		{
       			echo'<script type="text/javascript">alert("管理员未登录，请先进行管理员登录！");</script>';//错误信息提示
       			$this -> load->view('s1/navigation_home');
            	$this -> load->view('s1/login_view');//进入管理员登陆界面
       		}
    		else {
            		$this -> load->view('s1/navigation_lost');
            		$this -> load->view('s1/guashibuban_view');//进入挂失补办界面
    		}
		}
		function manage_loss(){
			session_start();
			$this->load->model('s1/Lmodel','MOD');
			$kind=$this->input->post('lagency');
			$id=$this->input->post('lid');
			if($kind==1)//自然人挂失
			{
				if(!$this->MOD->check_pid($id))
				{
					echo'<script type="text/javascript">alert("该自然人账户不存在,请确认后重新输入");history.back();</script>';//挂失失败
				}
				else
				{
					$personal_result=$this->MOD->detail_pid($id);
            		foreach ($personal_result as $row)
            		{
            			$stocknum=$row->股票账户号码;
            		}
            		if($this->MOD->check_bid($id))
					{
						echo'<script type="text/javascript">alert("该账户已挂失！");history.back();</script>';
					}
					elseif(!$this->MOD->lock_fund($stocknum))
					{
						echo'<script type="text/javascript">alert("该账户资金账户异常，暂时无法挂失！");history.back();</script>';
					}
					else//检查该用户是否存在于自然人证券账户表中
					{
						$this->MOD->insert_lid($id);//将该用户插入到挂失表中
						$this->MOD->lupdate_pid($id);//将自然人证券账户表中该用户的状态标记为挂失
            			$this->MOD->lock_fund($stocknum);//资金账户中锁住
						echo'<script type="text/javascript">alert("该自然人账户挂失成功！");history.back();</script>';//挂失成功
					}
				}		
			}
			elseif($kind==0)//法人挂失
			{
				if(!$this->MOD->check_fid($id))
				{
					echo'<script type="text/javascript">alert("该法人账户不存在,请确认后重新输入");history.back();</script>';//挂失失败
				}
				else
				{
					$register_result=$this->MOD->detail_fid($id);
            		foreach ($register_result as $row)
            		{
            			$stocknum=$row->股票账户号码;
            		}
            		if($this->MOD->check_bid($id))
					{
						echo'<script type="text/javascript">alert("该账户已挂失！");history.back();</script>';//挂失成功
					}
					elseif(!$this->MOD->lock_fund($stocknum))
					{
						echo'<script type="text/javascript">alert("该账户资金账户异常，暂时无法挂失！");history.back();</script>';
					}
					else//检查该用户是否存在于法人证券账户表中
					{
						$this->MOD->insert_lid($id);//将该用户插入到挂失表中
						$this->MOD->lupdate_fid($id);//将法人证券账户表中该用户的状态标记为挂失
            			$this->MOD->lock_fund($stocknum);//锁住
						echo'<script type="text/javascript">alert("该法人账户挂失成功！");history.back();</script>';//挂失成功
					}
				}				
			}
					
			elseif($kind==-1)//取消挂失
			{
				if(!$this->MOD->check_bid($id))
				{
					echo'<script type="text/javascript">alert("该账户未曾挂失,请确认后重新输入");history.back();</script>';
				}
				elseif($this->MOD->check_pid($id))//检测该用户是否为自然人
				{
					$this->MOD->cancel_ploss($id);//取消挂失
					$personal_result=$this->MOD->detail_pid($id);
            		foreach ($personal_result as $row)
            		{
            			$stocknum=$row->股票账户号码;
            		}
            		$this->MOD->unlock_fund($stocknum);//解锁
					echo'<script type="text/javascript">alert("该账户取消挂失成功！");history.back();</script>';
				}
				elseif($this->MOD->check_fid($id))
				{
					$this->MOD->cancel_floss($id);//取消挂失
					$register_result=$this->MOD->detail_fid($id);
            		foreach ($register_result as $row)
            		{
            			$stocknum=$row->股票账户号码;
            		}
            		$this->MOD->unlock_fund($stocknum);//解锁
					echo'<script type="text/javascript">alert("该账户取消挂失成功！");history.back();</script>';
				}	
			}
		}		
	}
?>
			