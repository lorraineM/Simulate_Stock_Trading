<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>出售股票</title>
<link rel="stylesheet" href="css/stock.css">
<link rel="stylesheet" href="css/button.css">
<style>
input, button { font-family:"Arial", "Tahoma", "微软雅黑", "雅黑"; border:0; vertical-align:middle; margin:8px; line-height:18px; font-size:18px }
.btns { width:143px; height:40px; background:url("bg11.jpg") no-repeat left top; color:#FFF; }
</style>
</head>
<?php
include("connect.php");
include("post.php");
//-----查询-----
$stock_id = @$_POST["stock_id"];
$price = @$_POST["price"];
$num = @$_POST["num"];

//
//$ID=123;
if (!session_id()) 	session_start();
$ID=$_SESSION['ID'];
if(isset($_POST["sub"]))
{
//------判断是否信息完整-------
	if($stock_id==null)
		echo "<script>alert('请输入要出售的股票代码！');history.back();</script>";
	else if ($price==null)
		echo "<script>alert('请输入要出售的购买价格！');history.back();</script>";
	else if ($num==null)
		echo "<script>alert('请输入要出售的购买数量！');history.back();</script>";
	
	else
	{
	//------------------确定指令<strong>的正确性--------------------
	//(part1)-------出售的数量不得少于持有数量-------
		$sql = "select  * from relation_list where stock_id = $stock_id and user_id=$ID ";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		if($row==null)
		{
			echo "<script>alert('您未购买该支股票，不能出售');history.back();</script>";
		}
		else 
		{
			$max = $row['num'];
			if($max<$num)
			{
				echo "<script>alert('卖出的股票数不能大于持有股票数！');history.back();</script>";
			}
			else
			{
				//-----插入交易记录表--------
				//(part2)-------------向中央交易系</strong>统发出指令-------------------
				$today = date("Y-m-d H:i:s",time());
				$post_data = array(
					'user_id' => "$ID",
		  			'name' => "$stock_id",
		  			'price'=>"$price",
		 		 	'num'=>"$num",
		  			'type'=>"sales",
		  			'time' => "$today"
					);
				$ch=curl_init();
		  		$curlPost=$post_data;
		  		curl_setopt($ch,CURLOPT_URL,'http://localhost/StockTrading/center/get_info.php');
		  		curl_setopt($ch,CURLOPT_POST,1);
		  		curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
		  		curl_setopt($ch,CURLOPT_RETURNTRANSFER,0);
		  		curl_exec($ch);
		  		curl_close($ch);
				echo "<script>alert('成功发出购买指令！');history.back();</script>";
			}
		}
	}
}

if(isset($_POST["get_price"]))
{
	$today = date("Y-m-d H:i:s",time());
	$sql = "select * from transaction_list where stock_id = $stock_id and time < '$today' order by time desc";
	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row==null)
	{
		echo "<script>alert('没有这支股票');history.back();</script>";
	}
	else
	{
		$price_yesterday=$row['price'];
		$high_price=$price_yesterday*1.1;
		$low_price=$price_yesterday*0.9;
		echo "<script>alert('价格上限为".$high_price."元， 下限为".$low_price."元');history.back();</script>";
	}
}



//查询
/*if(isset($_POST["sub"])){
//	if($_SESSION['ID']=="***")
	if(0)
		echo "<script>alert('请先登录资金账户！')</script>";
	else 
	{
		if($_POST["stock_id"]==null)
			echo "<script>alert('请输入要出售的股票代码！')</script>";
		else if ($_POST["price"]==null)
			echo "<script>alert('请输入要出售的购买价格！')</script>";
		else if ($_POST["num"]==null)
			echo "<script>alert('请输入要出售的购买数量！')</script>";
		else
		{
			$sql_str="select * from Sales_list";
			$result=mysql_query($sql_str);
			$s_id=mysql_num_rows($result);
			$now=time();
			$sql_str="insert into purchase_list(s_id,stock_id,num,price,use_id,time) values ('$s_id' , '$_POST[stock_id]','$_POST[num]','$_POST[price]','123','$now')";
			mysql_query($sql_str);
		}	
	}
}*/	
mysql_close($con);   //断开数据库
?>