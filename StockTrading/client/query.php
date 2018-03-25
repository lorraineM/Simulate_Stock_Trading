<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查询股票</title>
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
	
	
?>
    <form action="search_stock.php" method="post" topmargin="100">
		<table width="300" border="0" align="center" cellpadding="2" cellspacing="2" topmargin="100">
			<br>
			<br>
			<tr>
			<td width="200" topmargin="10"><div align="center" >股票名称/代码：</div></td> 
			<td width="80"><input type="text" name="stock_name"></td> 
			</tr> 
			
		</table>
		<br>
		<p align="center"> 
			<input class="button glow button-primary" type="submit" name="Submit" value="Submit"> 
			<input class="button button-flat" type="reset" name="Reset" value="Reset"> 
		</p> 
	</form> 


    </div><!--end of right_panel-->
</div>
<!--end of mainarea-->

</body>

</html>
