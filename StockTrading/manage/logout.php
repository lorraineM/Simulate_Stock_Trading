<?php 
error_reporting(E_ALL & ~ E_NOTICE);
session_id($_GET[sessionid]);
 session_start(); 
include "conn.php";
 $managerid=$_SESSION[managerid];
 //先过滤掉超级管理员的登出操作
 //$manager=mysqli_query($conn,"select * from administrator where id=".$managerid);
 //$res=mysqli_fetch_array($manager);
 //if($res['isSuper']=='F'){
 	//date_default_timezone_set ('PRC');
	//$date = date('Y-m-d H:i:s',time());
	//mysqli_query($conn,"insert into log (admin_id,date,event) values ('".$managerid."', '".$date."','Log out')");
//}
session_destroy();
echo "<script>window.location.href='index.php';</script>";


?>

