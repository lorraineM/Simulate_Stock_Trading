<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>指令撤销</title>
<link rel="stylesheet" href="css/stock.css">
</head>

<body>
<!--<IFRAME 
frameBorder=no height=153
scrolling=no src="header.html" 
width=100%>
</IFRAME>-->

<?php include 'header.php'; ?>
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
<div class="main_content">
<?php 
	if (!session_id()) 	session_start();
	if(isset($_SESSION['ID']) && $_SESSION['ID'] != null){
		//echo "您已经成功登录！";
		//$mid = $_SESSION['mid'];
	}else{
		echo "您尚未登录，请先<a href = login.php>登录</a>。";
		die();
	}
	include("connect.php");
	include("post.php");
	include("frozen.php");

//-------------查询------------
	$ID=$_SESSION['ID'];
//	$ID=123;
	$sql_str="SELECT * FROM purchase_list where user_id='$ID'";
	$result_p=mysql_query($sql_str);
	echo "<table class='graytb'>
	<tr>
	<th>购买股票代码</th>
	<th>购买股票数量</th>
	<th>购买股票价格</th>
	<th>命令</th>
	</tr>";
	
	$i=0;
	while($result_p!=null&&$row = mysql_fetch_array($result_p))
	{
		echo "<tr>";
		echo "<td>" . $row['stock_id'] . "</td>";
		echo "<td>" . $row['num'] . "</td>";
		echo "<td>" . $row['price'] . "</td>";
		echo "<td><form action=\"instru_cancel.php\" method=\"post\"><input type=\"submit\" name=" .$i.  " value=\"撤销\"></form></td>";
		echo "</tr>";
		$process_id[$i] = $row['p_id'];
		$process_num[$i] = $row['num'];
		$process_price[$i] = $row['price'];
		$i=$i+1;
	}
	$sql_str="SELECT * FROM Transaction_list where p_id='$ID'";
	$result_p=mysql_query($sql_str);
	while($result_p!=null&&$row = mysql_fetch_array($result_p))
	{
		echo "<tr>";
		echo "<td>" . $row['stock_id'] . "</td>";
		echo "<td>" . $row['num'] . "</td>";
		echo "<td>" . $row['price'] . "</td>";
		echo "<td> </td>";
		echo "</tr>";
	}
	echo "</table>";

	$mark=$i;

	$sql_str="SELECT * FROM Sales_list where user_id='$ID'";
	$result_s=mysql_query($sql_str);
	echo "<table border='1'>
	<tr>
	<th>出售股票代码</th>
	<th>出售股票数量</th>
	<th>出售股票价格</th>
	<th> </th>
	</tr>";
	
	while($result_s!=null&&$row = mysql_fetch_array($result_s))
	{
		echo "<tr>";
		echo "<td>" . $row['stock_id'] . "</td>";
		echo "<td>" . $row['num'] . "</td>";
		echo "<td>" . $row['price'] . "</td>";
		echo "<td><form action=\"instru_cancel.php\" method=\"post\"><input type=\"submit\" name=" .$i.  " value=\"撤销\"></form></td>";
		echo "</tr>";
		$process_id[$i] = $row['s_id'];
		$process_num[$i] = $row['num'];
		$process_price[$i] = $row['price'];
		$i=$i+1;
	}
	$sql_str="SELECT * FROM Transaction_list where s_id='$ID'";
	$result_p=mysql_query($sql_str);
	while($result_p!=null&&$row = mysql_fetch_array($result_p))
	{
		echo "<tr>";
		echo "<td>" . $row['stock_id'] . "</td>";
		echo "<td>" . $row['num'] . "</td>";
		echo "<td>" . $row['price'] . "</td>";
		echo "<td> </td>";
		echo "</tr>";
	}
	echo "</table>";
	
	$j=0;
	while($j<$i){
		if(isset($_POST["$j"]))
		{
			if($j<$mark) 
			//是在购买的表中
			{
//				$sql_str="DELETE FROM purchase_list WHERE p_id = '$process_id[$j]'";
//				mysql_query($sql_str);
				$sql_str="DELETE FROM purchase_list WHERE p_id = '$process_id[$j]'";
				$result_s=mysql_query($sql_str);
				if($result_s)
				{
					$ret=trade_cancel($process_price[$j]*$process_num[$j], $ID);
					if($ret)
					{
					echo "<script LANGUAGE='JavaScript'>alert('您已经成功撤销指令！');history.back();</script>";
					}
					else
					{
					echo "<script LANGUAGE='JavaScript'>alert('指令撤销失败！');history.back();</script>";
					}
				}
				else
				{
					echo "<script LANGUAGE='JavaScript'>alert('指令撤销失败！');history.back();</script>";
				}
			}
			else
			{
				$sql_str="DELETE FROM Sales_list WHERE s_id = '$process_id[$j]'";
				$result_p=mysql_query($sql_str);
				if($result_p)
				{
					echo "<script LANGUAGE='JavaScript'>alert('您已经成功撤销指令！');history.back();</script>";
				}
				else
				{
					echo "<script LANGUAGE='JavaScript'>alert('指令撤销失败！');history.back();</script>";
				}
			}
		}
		$j=$j+1;
	}
	
	
	
/*	$j=0;
	while($j<$i){
		if(isset($_POST["$j"]))
		{
			$k=0;
			$row=mysql_data_seek($result_p,0);//指针复位 
			while($row = mysql_fetch_array($result_p)&&$k!=$j)
			{
				$k++;
			}
			if($k<$j)
			{
				$row=mysql_data_seek($result_s,0);//指针复位
				while($row = mysql_fetch_array($result_p)&&$k!=$j)
				{
					$k++;
				}
				$sql_str="DELETE FROM Sales_list WHERE s_id = '$row[stock_id]'";
			}
			else 
			{
				$sql_str="DELETE FROM purchase_list WHERE p_id = '$row[stock_id]'";
			}
		}
		$j++;		
	}*/
	
mysql_close($con);   //断开数据库
?>
</div>
</div>
</div>
</body>
</html>