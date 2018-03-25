<?php
  error_reporting(E_ALL & ~ E_NOTICE );
$id=$_POST[id];          //接收管理员id
$password='123456';      //默认管理员密码为123456
$name=$_POST[name];     //接受管理员名字
$sex1=$_POST[sex];       //接受管理员性别
$idCard=$_POST[idCard]; //接受管理员身份证号
$address=$_POST[address]; //接受管理员地址
$telephone=$_POST[telephone]; //接受管理员联系方式
$isSuper='F';//默认不是超级管理员


if($sex1=='Female') $sex='F';
else $sex='M';

include("conn.php");//连接数据库
$res=mysqli_query($conn,"insert into administrator values ('".$id."','".$password."','".$name."','".$sex."','".$idCard."','".$address."','".$telephone."','".$isSuper."')");
if($res<=0)
{
	echo "<script type='text/javascript'>alert('添加管理员失败');history.back();</script>";
}
else
{
	echo "<script type='text/javascript'>alert('添加管理员成功');history.back();</script>";
}

?>