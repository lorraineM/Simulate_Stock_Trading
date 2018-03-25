<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码</title>
<link href="css/stock.css" rel="stylesheet" type="text/css">
<link href="css/button.css" rel="stylesheet" type="text/css">

</head>

<body>

	<!--<IFRAME 
		frameBorder=no height=153
		scrolling=no src="header.html" 
		width=100%>
	</IFRAME>-->
    <?php include 'header.php'; ?>
	
	<!--start of main area-->
	<div class="mainarea">
		<div class="left_panel">
		<div class="main_content">
 			<li style="margin:0px"><a href="/StockTrading/acco_home">证券账户管理</a></li>
        	<li><a href="/StockTrading/fund">资金账户管理</a></li>
        	<li><a href="http://localhost/StockTrading/client/login.php">交易客户端</a></li>
        	<li><a href="http://localhost/StockTrading/display/index.php">网上信息发布</a></li>
		</div>
		</div>  
	<div class="right_panel">
    <br><br>
    
	<form action="process_pwd.php" method="post">
	<?php
	if (!session_id())  session_start();
	if(isset($_SESSION['ID']) && $_SESSION['ID'] != null){
		//echo "您已经成功登录！";
		$name = $_SESSION['ID'];
		//$mid = $_SESSION['mid'];
	}else{
		echo "您尚未登录，请先<a href = login.php>登录</a>。";
		die();
	}
	
	
?>

	
	<table width="330" height="92" border="0" align="center" cellpadding="2" cellspacing="2">
		<br>
		<tr> 
			<td width="250"><div align="left">当前投资取款密码：</div></td> 
			<td width="80"><input type="password" name="old_atm_pwd"></td> 
		</tr> 
		<tr> 
		  	<td width="200"><div align="left">新投资取款密码：</div></td> 
			<td width="80"><input type="password" name="new_atm_pwd"></td> 
		</tr> 
		<tr> 
		  	<td width="200"><div align="left">确认投资取款密码：</div></td> 
			<td width="80"><input type="password" name="insure_atm_pwd"></td> 
		</tr> 
		<td></td> <td></td>
		<tr> 
		</tr>
		</tr> 
		<td></td> <td></td>
		<tr> 
		</tr>
		<tr> 
			<td width="200"><div align="left">当前交易密码：</div></td> 
			<td width="80"><input type="password" name="old_trade_pwd"></td> 
		</tr> 
		<tr> 
			<td width="200"><div align="left">新交易密码：</div></td> 
			<td width="80"><input type="password" name="new_trade_pwd"></td> 
		</tr>
		<tr> 
		  	<td width="200"><div align="left">确认交易密码：</div></td> 
			<td width="80"><input type="password" name="insure_trade_pwd"></td> 
		</tr> 
	</table>
	<p align="center"> 
	<input class="button glow button-primary"type="submit" name="保存" value="Submit"> 
	<input class="button button-flat" type="reset" name="重置" value="Reset"> 
	</p> 
	
	</form> 
	</div><!--end of right_panel-->
	</div>
<!--end of mainarea-->
</body>
</html>
