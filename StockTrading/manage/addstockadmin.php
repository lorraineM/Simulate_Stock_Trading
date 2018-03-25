 
<?php
  error_reporting(E_ALL & ~ E_NOTICE );
  $uid=$_POST[uid];
  $adminid=$_POST[adminid];
  
  include("conn.php");
  $query1=mysqli_query($conn,"select * from stock where uid='".$uid."'");//判定股票是否存在
  $info1=mysqli_fetch_array($query1);
  $query2=mysqli_query($conn,"select * from admin_stock where uid='".$uid."'");//判断股票是否被别的管理员绑定
  $info2=mysqli_fetch_array($query2);
  if($info1==NULL)
  {
	//echo "<script type='text/javascript' charset='utf-8'>alert('".$uid."'".$adminid."')</script>";
  	echo "<script type='text/javascript' charset='utf-8'>alert('该股票不存在')</script>";
  }
  else if($info2!=NULL)
  {
  	echo "<script type='text/javascript' charset='utf-8'>alert('该股票已被其他管理员绑定')</script>";
  }
  else
  {
  	$query3=mysqli_query($conn,"insert into admin_stock values ('".$adminid."','".$uid."')");//插入新数据
  	if($query3<=0)
	{
		echo "<script type='text/javascript' charset='utf-8'>alert('绑定失败')</script>";
	}
	else
	{
		echo "<script type='text/javascript' charset='utf-8'>alert('绑定成功')</script>";
	}
  }
  
  
  echo "<script language='javascript'>history.back();</script>";
  mysqli_close($conn);
?>