<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>出售指令</title>
<link rel="stylesheet" href="css/stock.css">
<link rel="stylesheet" href="css/button.css">
<style>
input, button { font-family:"Arial", "Tahoma", "微软雅黑", "雅黑"; border:0; vertical-align:middle; margin:8px; line-height:18px; font-size:18px }
.btns { width:143px; height:40px; background:url("bg11.jpg") no-repeat left top; color:#FFF; }
</style>
</head>

<body>
<!--<IFRAME 
frameBorder=no height=153
scrolling=no src="header.html" 
width=100%>
</IFRAME>-->
<?php include 'header.php'; ?>
<?php 
	if (!session_id()) 	session_start();
	if(isset($_SESSION['ID']) && $_SESSION['ID'] != '***'){
		//echo "您已经成功登录！";
		//$mid = $_SESSION['mid'];
	}else{
		echo "您尚未登录，请先<a href = login.php>登录</a>。";
		die();
	}
//	$val=123
//	$val=@$_GET["val"];
?>

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
<center>
<form action="sell_process.php" method="post">
股票代码<input type="text" name="stock_id"><br>
出售价格<input type="text" name="price" ><br>
出售数量<input type="text" name="num"><br>
<br><br>
<input type="submit" name="sub" class="button glow button-primary" value="确定出售">
<input type="reset" name="reset" class="button glow button-flat" value="重置">
<input type="submit" name="get_price" class="button glow button-primary" value="当前价格查询">
</form>
</center>
</div>
</div>
</body>
</html>
