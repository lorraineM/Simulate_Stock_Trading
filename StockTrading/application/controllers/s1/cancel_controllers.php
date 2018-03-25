<?php
class cancel_controllers extends CI_Controller {  
   
function cancel_controllers(){  
    parent::__construct();
	$this->output->set_header("Content-Type: text/html; charset=utf-8");
} 

function index()//入口，显示界面
{
	$this -> load -> helper('form');  
    $this -> load -> library('form_validation'); 

    $this -> load -> model('s1/login_model');
    if ($this->login_model->check_login()==false)//判断是否登录，载入不同的界面
    {
        echo'<script type="text/javascript">alert("管理员未登录，请先进行管理员登录！");</script>';
        $this -> load->view('s1/navigation_home');
        $this -> load->view('s1/login_view');
    }
    else {
            $this -> load->view('s1/navigation_cancel');
            $this -> load->view('s1/cancel_view');
    }
}

function cancel()//注销账户主函数
{
	$this -> load -> helper('form');  
    $this -> load -> library('form_validation'); 
	
	$sel=$this -> input -> post('sel');
	
	if ($sel=="person")//若注销账户类型为自然人
	{
		$stock_num_person=$this -> input -> post('stock_num_person');
		$id_person=$this -> input -> post('id_person');
		
		$this -> load -> model('s1/cancel_model');
	
		if ($this->cancel_model->search("自然人证券账户","股票账户号码",$stock_num_person)==false)//判断证券账户号码是否存在
		{
			echo '<script type="text/javascript">alert("该证券号不存在！");history.back();</script>';//提示错误信息
			return;
		}
		
		if ($this->cancel_model->search("自然人证券账户","身份证号码",$id_person)==false)//判断身份证号码是否存在
		{
			echo '<script type="text/javascript">alert("该身份证号不存在！");history.back();</script>';//提示错误信息
			return;
		}
		
		if ($this->cancel_model->search_2("自然人证券账户","股票账户号码",$stock_num_person,"身份证号码",$id_person)==false)//判断证券账户号码和身份证号码是否对应
		{
			echo '<script type="text/javascript">alert("身份证号与账号不对应！");history.back();</script>';//提示错误信息
			return;
		}
		
		if ($this->cancel_model->check_stock_num($stock_num_person)==true)//判断证券账户中是否有股票没有卖出
		{
			echo '<script type="text/javascript">alert("尚有股票没有卖出！");history.back();</script>';//提示错误信息
			return;
		}
		
		$Services=1;
		if ($this->cancel_model->search("指定销户营业部","股票账户号码",$stock_num_person)==false)//判断是否已指定销户营业部
		{
			echo '<script type="text/javascript">alert("销户营业部未指定，请先办理销户营业部指定程序！");history.back();</script>';//提示错误信息
			return;
		}
		
		if ($this->cancel_model->search_2("指定销户营业部","股票账户号码",$stock_num_person,"指定销户营业部",$Services)==false)//判断是否在指定营业部销户
		{
			echo '<script type="text/javascript">alert("不是指定的销户营业部！");history.back();</script>';//提示错误信息
			return;
		}

		if ($this->cancel_model->search_2("自然人证券账户","股票账户号码",$stock_num_person,"账户状态","正常")==false)//判断是否在指定营业部销户
		{
			echo '<script type="text/javascript">alert("账户不在正常状态！");history.back();</script>';//提示错误信息
			return;
		}
		if ($this->cancel_model->sale_out($stock_num_person)==false)//判断账户名下证券是否完全卖出
		{
			echo '<script type="text/javascript">alert("账户名下证券尚未完全售出！");history.back();</script>';//提示错误信息
			return;
		}
		$this->cancel_model->update_fund($stock_num_person);
		$this->cancel_model->delete_sale($stock_num_person);
		$this->cancel_model->delete("自然人证券账户","股票账户号码",$stock_num_person);//在数据库删除证券账户信息
		$this->cancel_model->delete("股票证券账户关联表","股票账户号码",$stock_num_person);
		$this->cancel_model->delete("指定销户营业部","股票账户号码",$stock_num_person);
		echo '<script type="text/javascript">alert("销户成功！");history.back();</script>';//提示成功信息
		
	}
	else if ($sel=="legal")//若注销账户类型为法人
	{
		$stock_num_legal=$this -> input -> post('stock_num_legal');
		$id_legal=$this -> input -> post('id_legal');
		
		$this -> load -> model('s1/cancel_model');
	
		if ($this->cancel_model->search("法人证券账户","股票账户号码",$stock_num_legal)==false)//判断证券账户号码是否存在
		{
			echo '<script type="text/javascript">alert("该证券号不存在！");history.back();</script>';//提示错误信息
			return;
		}
		
		if ($this->cancel_model->search("法人证券账户","法人身份证号码",$id_legal)==false)//判断身份证号码是否存在
		{
			echo '<script type="text/javascript">alert("该身份证号不存在！");history.back();</script>';//提示错误信息
			return;
		}
		
		if ($this->cancel_model->search_2("法人证券账户","股票账户号码",$stock_num_legal,"法人身份证号码",$id_legal)==false)//判断证券账户号码和身份证号码是否对应
		{
			echo '<script type="text/javascript">alert("身份证号与账号不对应！");history.back();</script>';//提示错误信息
			return;
		}
		
		if ($this->cancel_model->check_stock_num($stock_num_legal)==true)//判断证券账户中是否有股票没有卖出
		{
			echo '<script type="text/javascript">alert("尚有股票没有卖出！");history.back();</script>';//提示错误信息
			return;
		}
		
		$Services=1;
		if ($this->cancel_model->search("指定销户营业部","股票账户号码",$stock_num_legal)==false)//判断是否已指定销户营业部
		{
			echo '<script type="text/javascript">alert("销户营业部未指定，请先办理销户营业部指定程序！");history.back();</script>';//提示错误信息
			return;
		}
		
		if ($this->cancel_model->search_2("指定销户营业部","股票账户号码",$stock_num_legal,"指定销户营业部",$Services)==false)//判断是否在指定营业部销户
		{
			echo '<script type="text/javascript">alert("不是指定的销户营业部！");history.back();</script>';//提示错误信息
			return;
		}

		if ($this->cancel_model->search_2("法人证券账户","股票账户号码",$stock_num_legal,"账户状态","正常")==false)//判断是否在指定营业部销户
		{
			echo '<script type="text/javascript">alert("账户不在正常状态！");history.back();</script>';//提示错误信息
			return;
		}
		if ($this->cancel_model->sale_out($stock_num_legal)==false)//判断账户名下证券是否完全卖出
		{
			echo '<script type="text/javascript">alert("账户名下证券尚未完全售出！");history.back();</script>';//提示错误信息
			return;
		}
	
		$this->cancel_model->update_fund($stock_num_legal); //资金账户冻结
		$this->cancel_model->delete_sale($stock_num_legal); //删除股票数目的表格行
		$this->cancel_model->delete("法人证券账户","股票账户号码",$stock_num_legal);//在数据库删除证券账户信息
		$this->cancel_model->delete("股票证券账户关联表","股票账户号码",$stock_num_legal);
		$this->cancel_model->delete("指定销户营业部","股票账户号码",$stock_num_legal);
		echo '<script type="text/javascript">alert("销户成功！");history.back();</script>';//提示成功信息
		
	}
}

function check_stock_num_person()//javascript调用的判断自然人证券账户是否存在的函数
{
	$stock_num_person=$this -> input -> get("stock_num_person");
	$this -> load -> model('s1/cancel_model');
	
	if ($this->cancel_model->search("自然人证券账户","股票账户号码",$stock_num_person)==false)
	echo "该证券号不存在！";
}

function check_id_person()//javascript调用的判断自然人身份证号码是否存在以及与证券账户号是否匹配的函数
{
	$id_person=$this ->input -> get("id_person");
	$this ->load ->model('s1/cancel_model');
	
	if ($this->cancel_model->search("自然人证券账户","身份证号码",$id_person)==false)
		echo "该身份证号不存在！";
	else {
		$stock_num_person=$this -> input -> get("stock_num_person");
		if ($this->cancel_model->search_2("自然人证券账户","股票账户号码",$stock_num_person,"身份证号码",$id_person)==false)
			echo "身份证号与账号不对应！";
	}
}

function check_stock_num_legal()//javascript调用的判断法人证券账户是否存在的函数
{
	$stock_num_legal=$this -> input -> get("stock_num_legal");
	$this -> load -> model('s1/cancel_model');
	
	if ($this->cancel_model->search("法人证券账户","股票账户号码",$stock_num_legal)==false)
	echo "该证券号不存在！";
}

function check_id_legal()//javascript调用的判断法人身份证号码是否存在以及与证券账户号是否匹配的函数
{
	$id_legal=$this ->input -> get("id_legal");
	$this ->load ->model('s1/cancel_model');
	
	if ($this->cancel_model->search("法人证券账户","法人身份证号码",$id_legal)==false)
		echo "该身份证号不存在！";
	else {
		$stock_num_legal=$this -> input -> get("stock_num_legal");
		if ($this->cancel_model->search_2("法人证券账户","股票账户号码",$stock_num_legal,"法人身份证号码",$id_legal)==false)
			echo "身份证号与账号不对应！";
	}
}

}
?>