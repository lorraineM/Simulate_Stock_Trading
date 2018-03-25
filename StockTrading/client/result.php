<?php 
include ("post.php");
include ("connect.php");
	session_start();
/*	if(isset($_SESSION['ID']) && $_SESSION['ID'] != '***'){
		//echo "您已经成功登录！";
		//$mid = $_SESSION['mid'];
	}else{
		echo "您尚未登录，请先<a href = login.php>登录</a>。";
		die();
	}*/
//include("connect.php");
$stock=@$_POST["stock"];
$price=@$_POST["price"];
$number=@$_POST["number"];
$buyer=@$_POST["buyer"];
$seller=@$_POST["seller"];
$ID=$_SESSION['ID'];
//$ID=123;
if($buyer==$ID)
{
	$sql_str="SELECT frozen,available FROM currency where fid=$ID";
	$result=mysql_query($sql_str);
	while($result!=null&&$row = mysql_fetch_array($result))
	{
		$frozen=$row["frozen"]; 
		$available=$row['available'] ;
	}
	echo "<script LANGUAGE='JavaScript'>alert(' 您已经购买". $stock ."股票 ".$number."股，价格为".$price."元。目前可用冻结资金为".$frozen."，可用资金为".$available."');history.back();</script>";
}
if($seller==$ID)
{
	$sql_str="SELECT frozen,available FROM currency where fid=$ID";
	$result=mysql_query($sql_str);
	while($result!=null&&$row = mysql_fetch_array($result))
	{
		$frozen=$row["frozen"]; 
		$available=$row['available'] ;
	}
	echo "<script LANGUAGE='JavaScript'>alert(' 您已经出售". $stock ."股票 ".$number."股，价格为".$price."元。目前可用冻结资金为".$frozen."，可用资金为".$available."');history.back();</script>";
}
else
{
	echo "<script LANGUAGE='JavaScript'>history.back();</script>";
}


mysql_close($con);   //断开数据库
?>
