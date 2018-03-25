<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查询股票</title>
<link href="css/stock.css" rel="stylesheet" type="text/css">
<link href="css/button.css" rel="stylesheet" type="text/css">

</body>
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

	/*if(isset($_SESSION['id']) && $_SESSION['id'] != null){
		echo "您已经成功登录！";
		//$mid = $_SESSION['mid'];
	}else{
		echo "您尚未登录，请先<a href = login.php>登录</a>。";
		die();
	}*/

	include("connect_db.php");
	
	$stock_id = "";
	
	//获取用户输入
	$stock_name = @$_POST["stock_name"];
	
	//空白输入
	if(empty($stock_name))
	{
		echo"<br>";
		echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;输入不能为空";
		//echo '<p text-align="center">输入不能为空</p>';
		error();
	}
	//非空白输入
	else
	{
		//判断 代码or名称
		if(@ereg("^[0-9]{1,20}$", $stock_name))  //股票代码
		{
			//判断股票是否存在
			//$id = (int)$stock_name;
			$stock_id = $stock_name;
			$sql = "select * from stock where uid = $stock_name";
			$result=mysql_query($sql);
			$row = mysql_fetch_array($result);
			
			if(count($row) == 1)
			{
				echo"该股票不存在";
				error();
			}
			else
			{
				
			}
		}
		else                                    //股票名称
		{
			$sql = "select * from stock where name like '%$stock_name%'";
			$result=mysql_query($sql);
			$row = mysql_fetch_array($result);
			
			if(count($row) == 1)
			{
				echo"该股票不存在";
				error();
			}
			else
			{

				$stock_id = $row['uid'];
			}
		}
		
		//最新成交价格
		$sql = "select  * from transaction_list where stock_id = $stock_id order by time desc";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		$newest_p = $row['price'];
		$last_deal_time = $row['time'];
		
		
		//当前购买指令的最高价格
		$sql = "select  * from purchase_list where stock_id = $stock_id and time > '$last_deal_time' order by price desc";
		$result=mysql_query($sql);
		if (!mysql_query($sql,$con))
{
	die('Error: ' . mysql_error());
}
		$row = mysql_fetch_array($result);
		$purchase_high = $row['price'];
		
		//当前出售指令的最低价格
		$sql = "select  * from sales_list where stock_id = $stock_id and time > '$last_deal_time' order by price asc";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		$sale_low = $row['price'];
		
		//当日最高，最低成交价格 
		$today = date("Y-m-d H:i:s",mktime(0,0,0,date('m'), date('d'), date('Y')));
		$sql = "select * from transaction_list where stock_id = $stock_id and time > '$today' order by price desc";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		$today_high = $row['price'];
		$sql = "select * from transaction_list where stock_id = $stock_id and time > '$today' order by price asc";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		$today_low = $row['price'];
		
		//本周最高，最低成交价格
		$today = date("Y-m-d H:i:s",mktime(0,0,0,date('m'), date('d')-7, date('Y')));
		$sql = "select * from transaction_list where stock_id = $stock_id and time > '$today' order by price desc";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		$week_high = $row['price'];
		$today = date("Y-m-d H:i:s",mktime(0,0,0,date('m'), date('d')-7, date('Y')));
		$sql = "select * from transaction_list where stock_id = $stock_id and time > '$today' order by price asc";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		$week_low = $row['price'];
		
		//本月最高，最低成交价格
		$today = date("Y-m-d H:i:s",mktime(0,0,0,date('m'), 1, date('Y')));
		$sql = "select * from transaction_list where stock_id = $stock_id and time > '$today' order by price desc";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		$month_high = $row['price'];
		$today = date("Y-m-d H:i:s",mktime(0,0,0,date('m'), 1, date('Y')));
		$sql = "select * from transaction_list where stock_id = $stock_id and time > '$today' order by price asc";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		$month_low = $row['price'];
		
		//重要公告
		//$sql = "select * from gonggao where uid = $stock_id";
		//$result=mysql_query($sql);
		//$row = mysql_fetch_array($result);
		//$gonggao = $row['gonggao'];
		$gonggao = "";
		
		//绘制表格
		echo '<div>';
		echo '<p style="font-size:15pt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;查询结果如下:</p>';
		//
		echo '<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=1)" width="90%" align="center" color=#987cb9 SIZE=2>';
		echo "<br />";
   		echo "<table class=\"graytb\" border='1' align='center'>
			<tr>
			<th>最新成交价格</th>";
		echo "<td align = 'center' width = '50'>" . $newest_p . "</td>";
		echo "</tr>";
		echo "<tr>
			<th>当前购买指令最高价</th>";
		echo "<td align = 'center'>" . $purchase_high . "</td>";
		echo "</tr>";
		echo "<tr>
			<th>当前出售指令最低价</th>";
		echo "<td align = 'center'>" . $sale_low . "</td>";
		echo "</tr>";
		echo "<tr>
			<th>今日最高成交价</th>";
		echo "<td align = 'center'>" . $today_high . "</td>";
		echo "</tr>";
		echo "<tr>
			<th>今日最低成交价</th>";
		echo "<td align = 'center' >" . $today_low . "</td>";
		echo "</tr>";
		echo "<tr>
			<th>本周最高成交价</th>";
		echo "<td align = 'center'>" . $week_high . "</td>";
		echo "</tr>";
		echo "<tr>
			<th>本周最低成交价</th>";
		echo "<td align = 'center'>" . $week_low . "</td>";
		echo "</tr>";
		echo "<tr>
			<th>本月最高成交价</th>";
		echo "<td align = 'center'>" . $month_high . "</td>";
		echo "</tr>";
		echo "<tr>
			<th>本月最低成交价</th>";
		echo "<td align = 'center'>" . $month_low . "</td>";
		echo "</tr>";
		echo "<tr>
			<th>重要公告</th>";
		echo "<td align = 'center'>" . $gonggao . "</td>";
		echo "</tr>";
		
	}
	
	
	
	
	//-----错误处理函数------
	function error()
   {
	    echo nl2br("\n
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=query.php>点击此处重新查询……</a>");
	    die();
   }
	
?>
    </div><!--end of right_panel-->
</div>
<!--end of mainarea-->
</body>



</html>