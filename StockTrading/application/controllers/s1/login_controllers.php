<?php
class login_controllers extends CI_Controller {  
   
function login_controllers(){  
    parent::__construct();
	$this->output->set_header("Content-Type: text/html; charset=utf-8");
} 

function index()
{
	$this -> load -> helper('form');
    $this -> load -> library('form_validation'); 

    $this -> load -> model('s1/login_model');
    $this -> load-> view('s1/navigation_home');
    if ($this->login_model->check_login()==false)//判断用户舍否登录，显示不同的页面
    	$this -> load-> view('s1/login_view');
    else $this -> load-> view('s1/welcome_view');
}

function login()
{
	$this -> load -> helper('form');  
    $this -> load -> library('form_validation'); 
	
	$this -> form_validation -> set_rules('id','用户名','required');//用户名是必须存在的
	$this -> form_validation -> set_rules('pass','密码','required|min_length[6]');//密码长度最小为6
	
	if ($this->form_validation->run() == false)//若验证不通过，则报错
	{
		echo'<script type="text/javascript">alert("用户名或密码长度不符合要求！");history.back();</script>';
	}
	else{//若验证通过则进行下一步验证
		$id=$this -> input -> post('id');//获取用户名
		$pass=$this -> input -> post ('pass');//获取密码

		$this -> load -> model('s1/cancel_model');
		
		if ($this->cancel_model->search_2("管理员账户","用户名",$id,"密码",$pass)==true)//验证用户名和密码是否存在
		{
			$this -> load -> model('s1/login_model');
    		if ($this->login_model->check_login()==true)//判断该用户名和密码是否已登录
    		{
        		echo'<script type="text/javascript">alert("管理员已登录，请先退出！");history.back();</script>';
        		return;
        	}

			$this->load->library('session');
			
			$data=array('id' => $id);//若未登录，则将登陆信息存入session
			$this->session->set_userdata($data);
			
			echo'<script type="text/javascript">alert("登录成功！");</script>';
			redirect("acco_home");//登录成功后跳转
			//redirect("account_cancel");
		}
		else {//若用户名密码错误，则报错
			echo '<script type="text/javascript">alert("用户名或密码错误！");history.back();</script>';
		}
	}
}

function login_out(){//退出登录
	$this -> load -> model('s1/login_model');
	$this->login_model->login_out();//调用model中的登出模块
	echo '<script type="text/javascript">alert("退出成功！");</script>';//提示信息
	redirect("acco_home");
	//redirect("account_cancel");
}

}
	
?>