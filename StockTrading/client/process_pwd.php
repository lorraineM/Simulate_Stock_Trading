<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码</title>
<link href="css/stock.css" rel="stylesheet" type="text/css">
<link href="css/button.css" rel="stylesheet" type="text/css">
</head>

<body>
	<IFRAME 
		frameBorder=no height=153
		scrolling=no src="header.html" 
		width=100%>
	</IFRAME>
	
	<!--start of main area-->
	<div class="mainarea">
	<div class="left_panel">
<div class="main_content">
 <a href="" >aa</a>
  <a href="" ></a>
   <a href="" ></a>
    <a href="" ></a>
 	 <a href="" ></a>
	</div>
	</div>  
	
	<div class="right_panel">
	<?php
	if (!session_id()) session_start();
	if(isset($_SESSION['ID']) && $_SESSION['ID'] != null){
		//echo "您已经成功登录！";
		$name = $_SESSION['ID'];
		//$mid = $_SESSION['mid'];
	}else{
		echo "您尚未登录，请先<a href = login.php>登录</a>。";
		die();
	}
	
	
	include("connect_db.php");
	
	//获取用户输入
	$old_atm_pwd = @$_POST["old_atm_pwd"];
	$new_atm_pwd = @$_POST["new_atm_pwd"];
	$insure_atm_pwd = @$_POST["insure_atm_pwd"];
	$old_trade_pwd = @$_POST["old_trade_pwd"];
	$new_trade_pwd = @$_POST["new_trade_pwd"];
	$insure_trade_pwd = @$_POST["insure_trade_pwd"];
	
	//----验证两次输入是否一致----
	$is_alert = 0;
	$word = "";
	if(strcmp($new_atm_pwd, $insure_atm_pwd)!=0)
	{
		$is_alert = 1;
		$word = "投资取款密码输入不一致";
	}
	if(strcmp($new_trade_pwd, $insure_trade_pwd)!=0)
	{
		if($is_alert == 0)
			$is_alert = 2;
		else if($is_alert == 1)
			$is_alert = 3;
		$word = $word . "交易密码输入不一致";
	}
	if($is_alert == 1)
		//alert($word);
		echo "<script type='text/javascript'>alert(\"投资取款密码输入不一致\");</script>";
	else if($is_alert == 2)
		echo "<script type='text/javascript'>alert(\"交易密码输入不一致\");</script>";
	else if($is_alert == 3)
		echo "<script type='text/javascript'>alert(\"投资取款密码输入不一致\\n交易密码输入不一致\");</script>";
	if($is_alert>0)
	{
		//header("Location: change_passwd.php"); 
		//exit;
		$url = "change_passwd.php";//登陆成功，跳转到function_page
      	 echo "<script language='javascript' type='text/javascript'>";
     	 echo "window.location.href='$url'";
     	 echo "</script>";
		 die();
	}
	
	//-----密码位数是否为6位-----
	if((strlen($new_atm_pwd)!=6)||(strlen($insure_atm_pwd)!=6))
	{
		echo "<script type='text/javascript'>alert(\"投资取款密码位数不正确，请输入6位密码\");</script>";
		$url = "change_passwd.php";//登陆成功，跳转到function_page
      	 echo "<script language='javascript' type='text/javascript'>";
     	 echo "window.location.href='$url'";
     	 echo "</script>";
		 die();
	}
	if((strlen($new_trade_pwd)!=6)||(strlen($insure_trade_pwd)!=6))
	{
		echo "<script type='text/javascript'>alert(\"交易密码位数不正确，请输入6位密码\");</script>";
		$url = "change_passwd.php";//登陆成功，跳转到function_page
      	 echo "<script language='javascript' type='text/javascript'>";
     	 echo "window.location.href='$url'";
     	 echo "</script>";
		 die();
	}
	
	
	//----投资取款密码-----
	$sql = "select * from fund_account where fid = $name";
	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);
	$correct_atm = $row['atm_pin'];
		
	
	//验证
	if(strcmp($old_atm_pwd, $correct_atm) == 0)  //修改投资取款密码
	{
		$sql = "update fund_account set atm_pin = '$new_atm_pwd' where fid = $name";
		if (!mysql_query($sql))
		{
			echo "Error: " . mysql_error();
		}
		else
			echo"<tr><br>投资取款密码修改成功</tr>";
	}
	else
	{
		echo"<tr><br>当前投资取款密码不正确</tr>";
	}
	
	//----交易密码----
	$sql = "select * from fund_account where fid = $name";
	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);
	$correct_trade = $row['trade_pin'];
	//验证
	if(strcmp($old_trade_pwd, $correct_trade) == 0)  //修改投资取款密码
	{
		$sql = "update fund_account set trade_pin = '$new_trade_pwd' where fid = $name";
		if (!mysql_query($sql))
		{
			echo "Error: " . mysql_error();
		}
		else
			echo"<tr><br>交易密码修改成功</tr>";
	}
	else
	{
		echo"<tr><br>当前交易密码不正确</tr>";
	}
?>
	</div><!--end of right_panel-->
	</div>
<!--end of mainarea-->

</body>
</html>
