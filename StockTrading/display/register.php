<?php
include("connect.php");

if($_POST['user_name'] && $_POST['passwd_0'])
{
	if($_POST['passwd_0'] != $_POST['passwd_1'])
	{
		echo("<script>alert('两次输入的密码不一样！');location.href='register.php';</script>");
		exit(0);
	}
	$name = $_POST['user_name'];
	$passwd = md5($_POST['passwd_0']);
	$sex = $_POST['sex'];
	$age = $_POST['age'];
	$job = $_POST['job'];
	$sql = "insert into users values('$name','$passwd','$sex','$age','$job','')";
	$insert = mysql_query($sql);
	if ($insert)
	{
		echo("<script type='text/javascript'> alert('注册成功！');location.href='index.php';</script>");//进入大盘界面
	}
	else
	{
		echo("<script type='text/javascript'> alert('注册失败！用户名重复');location.href='register.php';</script>");
	}
}
?>






<!--<html>

<head>
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css">
<link href="reg.css" rel="stylesheet">
</head>


<body>
<div align="center">

<p>用户注册</p>
<hr align="center" width="700" size="1" noshade>
<form method="post" action="register.php"  onsubmit="return docheck()" name="regform">
<table width="600" height = "500" border="1" bgcolor="#000000" >
<!----- >
表样式
<!----->

<!--
<tr bgcolor="#FFFFFF">
<td width="80">用户名</td>
<td width="300"><input name="user_name" id="name" type="text"></td>
</tr>
<tr bgcolor="#FFFFFF">
<td>密码</td>
<td><input name="passwd_0" type="password" id = "pw0"></td>
</tr>
<tr bgcolor="#FFFFFF">
<td>确认密码</td>
<td><input name="passwd_1" type="password" id = "pw1">
</td>
</tr>
<tr bgcolor="#FFFFFF">
<td colspan="2"><div align="center">
<input type="submit" name="sub" value="提交">
<input type="reset" name="reset" value="重写">

<script language = "javascript">
function docheck(){

var name = document.getElementById('name').value;
var pw0 = document.getElementById('pw0').value;
var pw1 = document.getElementById('pw1').value;
if(name==""){
	  alert("请输入用户名！");
	    return false;
	}
	if(pw0==""){
	  alert("请输入密码！");
	    return false;
	}
	if(pw1 != pw0){
	  alert("两次填写的密码不相同！");
	  return false;
	}

}
</script>


</div></td>
</tr>
</table>
</form>



</div>
</body>
</html>-->

<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="GBK">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>注册</title>

    <!-- Bootstrap core CSS -->
    <link href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="reg.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" role="form" method = "POST">
        <h2 class="form-signin-heading">用户注册</h2>
        <input type="text" class="form-control" name = "user_name" placeholder="用户名" required autofocus>
        <input type="password" class="form-control" name = "passwd_0" placeholder="密码" required>
		<input type="password" class="form-control" name = "passwd_1" placeholder="重复密码" required>
		<input type="text" class="form-control" name = "sex" placeholder="身份证号" required>
        <input type="text" class="form-control" name = "job" placeholder="职业" required>
		<input type="text" class="form-control" name = "age" placeholder="年龄" required>
        <label class="checkbox">
          <!--<input type="checkbox" value="remember-me"> 记住我-->
        </label>
        <button class="btn btn-lg btn-primary btn-block" name = "sumbit" value = "submit" type="submit">注册</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
