<?php
error_reporting(E_ALL & ~ E_NOTICE );
@session_start();
$uid=$_GET[uid];          //接收表单提交的管理员名
$adminid=$_GET[adminid];            //接收表单提交的密码

include("conn.php");//连接数据库
$res=mysqli_query($conn,"delete from admin_stock where admin_id='".$adminid."' and uid='".$uid."'");
if($res<=0)
{
  echo "<script type='text/javascript'>alert('删除失败');history.back();</script>";
}
else
{
  echo "<script type='text/javascript'>alert('删除成功');history.back();</script>";
}
?>