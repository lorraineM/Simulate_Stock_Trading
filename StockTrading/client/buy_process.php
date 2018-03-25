<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>购买股票</title>
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
include ("frozen.php");
//-----查询-----
if (!session_id()) 	session_start();
$stock_id = @$_POST["stock_id"];
$price = @$_POST["price"];
$num = @$_POST["num"];

$ID=$_SESSION['ID'];

//------判断是否信息完整-------
if(isset($_POST["sub"]))
{
	echo $stock_id;
	if($stock_id==null)
	{
		echo "<script>alert('请输入要购买的股票代码！');history.back();</script>";
	}
	else if ($price==null)
	{
		echo "<script>alert('请输入要购买的购买价格！');history.back();</script>";
	}
	else if ($num==null)
	{
		echo "<script>alert('请输入要购买的购买数量！');history.back();</script>";
	}
	else if ($num<100)
	{
		echo "<script>alert('购买数量不得少于100股！');history.back();</script>";
	}
	else
	{
		$sql = "select * from stock where uid = $stock_id";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);

		if(count($row) == 1)
		{
			echo "<script>alert('该支股票不存在！');history.back();</script>";
			die();
		}
		//-----获得交易记录的id以及时间--------
		$sql_str="select * from purchase_list";
		$result=mysql_query($sql_str);
		$p_id=mysql_num_rows($result);
		$now=time();
		
		//------------------确定指令的正确性--------------------
		//(part1)-------更改冻结资金和可用资金-------
		//调用给的函数，希望能返回调用是否成功
		$freeze=trade_frozen($price*$num, $ID);
		echo $freeze;
		if($freeze)  //冻结成功
		{
		//-----插入交易记录表--------
		//(part2)-------------向中央交易系统发出指令-------------------
		$today = date("Y-m-d H:i:s",time());
		$post_data = array(
		  'user_id' => "$ID",
		  'name' => "$stock_id",
		  'price'=>"$price",
		  'num'=>"$num",
		  'type'=>"purchase",
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
		else
		{
			echo "<script>alert('资金冻结失败，请确定资金账户中的资金！');history.back();</script>";
		}		
	}
}
if(isset($_POST["get_price"]))
{
	$sql = "select  * from transaction_list where stock_id = $stock_id order by time desc";
	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);	
	if(count($row) == 1)
	{
		echo "<script>alert('no record！');history.back();</script>";
	}
	else
	{
		$row = mysql_fetch_array($result);
		$val = $row['price'];
//	$val=123;
		echo "<script>alert('当前价格为".$val."元');history.back();</script>";
/*	ob_start();
	echo"<script>Location='page2.php?val=".$val."';history.back();</script>";
	ob_end_flush();*/
	}
}


/*if(isset($_POST["sub"])){
//	if($_SESSION['ID']=="***")
	if(0)
		echo "<script>alert('请先登录资金账户！')</script>";
	else 
	{
		$value=$_SESSION['ID'];
		$sql_str="SELECT available FROM fund_info where fid='$value'";
		$result=mysql_query($sql_str);
		if($_POST["stock_id"]==null)
			echo "<script>alert('请输入要购买的股票代码！')</script>";
		else if ($_POST["price"]==null)
			echo "<script>alert('请输入要购买的购买价格！')</script>";
		else if ($_POST["num"]==null)
			echo "<script>alert('请输入要购买的购买数量！')</script>";
		else if ($_POST["price"]*$_POST["num"]>$result)
			echo "<script>alert('资金不足！')</script>";
		else
		{
			$sql_str="select * from purchase_list";
			$result=mysql_query($sql_str);
			$p_id=mysql_num_rows($result);
			$now=time();
			$sql_str="insert into purchase_list(p_id,stock_id,num,price,user_id,time) values ('$p_id' , '$_POST[stock_id]','$_POST[num]','$_POST[price]','123','$now')";
			mysql_query($sql_str);
			$sql_str="UPDATE fund_info SET frozen = frozen+$_POST[num]*$_POST[price] WHERE fid = '$_SESSION[ID]'";
			mysql_query($sql_str);
			$sql_str="UPDATE fund_info SET available = available-$_POST[num]*$_POST[price] WHERE fid = 'S$_SESSION[ID]'";
			mysql_query($sql_str);
			$queue_id=10086; //定义一个队列id
			if(!msg_queue_exists($queue_id))
			{ //检测队列id是否存在，即被使用
				$queue=msg_get_queue($queue_id);
			}
			msg_send($queue,1,"frozen");
		}	
	}
}*/
mysql_close($con);   //断开数据库
?>
