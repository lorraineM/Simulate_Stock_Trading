<?php
session_start();
include("connect.php");

if($_POST['value'])
{
	
	$name = $_SESSION['user_name'];
	$value = (int)$_POST['value'];
	if($value < 1000)
	{
		echo '<script>alert("��ֵ���㣡");location.href="update.php";</script>';
		exit(0);
	}
	else if($value >= 1000 && $value <= 2000)
	{
		$sql = "update users set vip = '1' where name = '$name'";
		$query = mysql_query($sql);
		if($query)
		{
			echo '<script>alert("��ֵvip1�ɹ���");location.href="index.php";</script>';
		}
	}
	else
	{
		$sql = "update users set vip = 2 where name = '$name'";
		
		$query = mysql_query($sql);
		if($query)
		{
			echo '<script>alert("��ֵvip2�ɹ���");location.href="index.php";</script>';
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

<title>�û�����</title>

<!-- Bootstrap core CSS -->
<link href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="reg.css" rel="stylesheet">

<div class="container">

      <form class="form-signin" role="form" method = "POST">
        <h2 class="form-signin-heading">�û�����</h2>
        <input type="text" class="form-control" name = "value" placeholder="����д��ֵ���" required autofocus>
		 <label class="checkbox">
          <!--<input type="checkbox" value="remember-me"> ��ס��-->
        </label>
        <button class="btn btn-lg btn-primary btn-block" name = "sumbit" value = "submit" type="submit">��ֵ</button>
	</form>
	</div>
	<center>
	<b>��ֵ˵������ֵ1000Ԫ��������ΪVIP1�û������Բ鿴һ���ڵĹ�Ʊ�۸����K�ߣ���ֵ2000Ԫ��������ΪVIP2�û������Բ鿴һ���ڵ���K�ߺ���K�ߡ�</b></center>
 

</form>
</html>

