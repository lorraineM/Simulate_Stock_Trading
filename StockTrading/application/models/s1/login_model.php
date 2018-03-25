<?php  
class login_model extends CI_Model{  
    function login_model(){  
        parent::__construct();
		$this->output->set_header("Content-Type: text/html; charset=utf-8");		
    }  
    
	function check_login(){//判断用户账号信息是否存在于session中，即判断用户是否登录
		$this->load->library('session');
		
		$id=$this->session->userdata('id');//获取用户名信息
		
		if ($id == null)//若无法查找到用户名信息，则表示用户未登录，否则，已登录
			return false;
		else return true;
	}
	
	function login_out(){//退出登录
		$this->load->library('session');
		
		$this->session->unset_userdata('id');//删除用户账号信息
	}
}  
?>  