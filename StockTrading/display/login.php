<?php
session_start();
include("connect.php");

if($GET[id] = 'logout')
{
	$_SESSION['user_name'] = '';
}

if($_POST['user_name']){
	
	
	$name = $_POST['user_name'];
	$passwd = md5($_POST['user_passwd']);
	$sql = "select * from users where name = '$name' && passwd = '$passwd'";
	
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
	
	if($rs){
		//�������ҳ��	
		$_SESSION['user_name'] = $name;
		$_SESSION['user_passwd'] = $passwd;
		echo("<script type='text/javascript'> alert('login success');location.href='index.php';</script>");
	}else{
		echo("<script type='text/javascript'> alert('wrong user_name or passwd');location.href='login.php';</script>");
		}
	
	
/*	if ($execute){
	 echo("<script type='text/javascript'> alert('д��ɹ���');location.href='jump_0.php';</script>");//������̽���
	}else{
	echo("<script type='text/javascript'> alert('д��ʧ�ܣ�');location.href='jump.php';</script>");
	}
	*/
}

?>
<html>
<meta charset="GBK">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title>��½</title>

<!-- Bootstrap core CSS -->
<link href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="reg.css" rel="stylesheet">

<div class="container">

      <form class="form-signin" role="form" method = "POST">
        <h2 class="form-signin-heading">�û���½</h2>
        <input type="text" class="form-control" name = "user_name" placeholder="�û���" required autofocus>
        <input type="password" class="form-control" name = "user_passwd" placeholder="����" required>
        <label class="checkbox">
          <!--<input type="checkbox" value="remember-me"> ��ס��-->
        </label>
        <button class="btn btn-lg btn-primary btn-block" name = "sumbit" value = "submit" type="submit">��½</button>
		<p class="navbar-text navbar-right">
		��û���û���?ȥ<a href = "register.php" class = "navbar-link">ע��</a></p>
	</form>
	</div>
	
 

</form>
</html>

