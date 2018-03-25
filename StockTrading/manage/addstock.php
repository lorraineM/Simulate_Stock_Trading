<?php
  error_reporting(E_ALL & ~ E_NOTICE );
$uid=$_POST[uid];          //接收管理员id
$name=$_POST[name];     //接受管理员名字
$rise=0.1;
$nowprice=0.0;
$openprice=0.0;
$closeprice=0.0;
$buyprice=0.0;
$saleprice=0.0;
$oknumber=0.0;
$highprice=0.0;
$lowprice=0.0;
$date=date('Y-m-d H:i:s',time());
$todayrate=0.1;
$tomrate=0.1;
$state=1;
$number=$_POST[number];

include("conn.php");//连接数据库
$res=mysqli_query($conn,"insert into stock values ('".$uid."','".$name."','".$rise."','".$nowprice."','".$openprice."','".$closeprice."','".$buyprice."','".$saleprice."','".$oknumber."','".$highprice."','".$lowprice."','".$date."','".$todayrate."','".$tomrate."','".$state."','".$number."')");
if($res<=0)
{
	//echo "<script type='text/javascript'>alert('".$rise."');history.back();</script>";
	echo "<script type='text/javascript'>alert('添加股票失败');history.back();</script>";
}
else
{
	echo "<script type='text/javascript'>alert('添加股票成功');history.back();</script>";
}

?>