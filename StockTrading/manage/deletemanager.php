<?php
error_reporting(E_ALL & ~ E_NOTICE );
$id=$_GET[id];          //接收管理员id

include("conn.php");//连接数据库
//echo "<script type='text/javascript'>alert('".$id."');history.back();</script>";
$res=mysqli_query($conn,"delete from admin_stock where admin_id='".$id."'");
if($res<=0)
{
  echo "<script type='text/javascript'>alert('删除失败');history.back();</script>";
}
else
{
  //echo "<script type='text/javascript'>alert('删除成功');history.back();</script>";

	$res=mysqli_query($conn,"delete from administrator where id='".$id."'");
	if($res<=0)
	{
	  echo "<script type='text/javascript'>alert('删除失败');history.back();</script>";
	}
	else
	{
	  echo "<script type='text/javascript'>alert('删除成功');history.back();</script>";
	}
}

?>