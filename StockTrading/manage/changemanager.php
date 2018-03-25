<?php
  error_reporting(E_ALL & ~ E_NOTICE );
$id=$_POST[id];          //接收管理员id
$name=$_POST[name];     //接受管理员名字
$sex=$_POST[sex];       //接受管理员性别
$idCard=$_POST[idCard]; //接受管理员身份证号
$address=$_POST[address]; //接受管理员地址
$telephone=$_POST[telephone]; //接受管理员联系方式
$isSuper='F';//默认不是超级管理员

include("conn.php");//连接数据库

$res2=mysqli_query($conn,"update administrator set name='".$name."',sex='".$sex."',idCard='".$idCard."',address='".$address."',telephone='".$telephone."' where id='".$id."'");
if($res2<=0)
{
	//echo "<script>alert('".$name."')</script>";
	echo "<script type='text/javascript'>alert('更改信息失败');history.back();</script>";
}
else
{
	echo "<script type='text/javascript'>alert('更改信息成功');history.back();</script>";
}



?>