<?php
session_start();
include("connect.php");

if($_POST['value'])
{
	
	$name = $_SESSION['user_name'];
	$value = (int)$_POST['value'];
	if($value < 1000)
	{
		echo '<script>alert("充值金额不足！");location.href="update.php";</script>';
		exit(0);
	}
	else if($value >= 1000 && $value <= 2000)
	{
		$sql = "update users set vip = '1' where name = '$name'";
		$query = mysql_query($sql);
		if($query)
		{
			echo '<script>alert("充值vip1成功！");location.href="index.php";</script>';
		}
	}
	else
	{
		$sql = "update users set vip = 2 where name = '$name'";
		
		$query = mysql_query($sql);
		if($query)
		{
			echo '<script>alert("充值vip2成功！");location.href="index.php";</script>';
		}
	}
}

?>
<html>
<meta charset="GBK">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title>用户升级</title>

<!-- Bootstrap core CSS -->
<link href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="reg.css" rel="stylesheet">

<div class="container">

      <form class="form-signin" role="form" method = "POST">
        <h2 class="form-signin-heading">用户升级</h2>
        <input type="text" class="form-control" name = "value" placeholder="请填写充值金额" required autofocus>
		 <label class="checkbox">
          <!--<input type="checkbox" value="remember-me"> 记住我-->
        </label>
        <button class="btn btn-lg btn-primary btn-block" name = "sumbit" value = "submit" type="submit">充值</button>
	</form>
	</div>
	<center>
	<b>充值说明：充值1000元可以升级为VIP1用户，可以查看一年内的股票价格和日K线，充值2000元可以升级为VIP2用户，可以查看一年内的月K线和年K线。</b></center>
 

</form>
</html>

