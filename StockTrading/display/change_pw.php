<?php
session_start();

include("connect.php");
$name =  $_SESSION['user_name']; //
$old_true =  $_SESSION['user_passwd']; // 
/*
echo "$old_true";
var_dump($_SESSION); // 
*/

if(!empty($_POST['sub'])){
	if($_POST['passwd_new0'] != $_POST['passwd_new1'])
	{
		echo '<script>alert("������������벻һ����");location.href="change_pw.php"</script>';
		exit(0);
	}
	$old_input = md5($_POST['passwd_old']);
//	echo "$old_input";
	$new = md5($_POST['passwd_new0']);
	if($old_true == $old_input){
	$sql = "update users set passwd = '$new' where name = '$name'";
	$update = mysql_query($sql);
	if ($update){
		$_SESSION['user_name'] = $name;
		$_SESSION['user_passwd'] = $new;
		
	echo("<script type='text/javascript'> alert('�޸ĳɹ�');</script>");//������̽���
	echo("<script type='text/javascript'>location.href='index.php';</script>");
	}else{
	echo("<script type='text/javascript'> alert('�޸�ʧ�ܣ����ݿ�ִ��δ�ɹ�');location.href='change_pw.php';</script>");
	}
	}
	
	else {
		echo("<script type='text/javascript'> alert('ԭʼ���벻ƥ��');location.href='change_pw.php';</script>");
	}
}


?>



<!--<html>




<head>
<style type="text/css">
body {font-size:100%;}
p {font-size:3.875em;}

</style>
</head>


<body>
<div align="center">

<p>�޸�����</p>
<hr align="center" width="700" size="1" noshade>
<form method="post" action="change_pw.php"  onsubmit="return docheck()" name="regform">
<table width="600" height = "500" border="1" bgcolor="#000000" >
<!----- >
����ʽ
<!----->

<!--

<tr bgcolor="#FFFFFF">
<td>������</td>
<td><input name="passwd_old" type="password" id = "pw0"></td>
</tr>
<tr bgcolor="#FFFFFF">
<td>������</td>
<td><input name="passwd_new0" type="password" id = "pw1">
</td>
</tr>
<tr bgcolor="#FFFFFF">
<td>ȷ��������</td>
<td><input name="passwd_new1" type="password" id = "pw2">
</td>
</tr>

<tr bgcolor="#FFFFFF">
<td colspan="2"><div align="center">
<input type="submit" name="sub" value="�ύ">
<input type="reset" name="reset" value="��д">

<script language = "javascript">
function docheck(){


var pw1 = document.getElementById('pw1').value;
var pw2 = document.getElementById('pw2').value;

	if(pw1==""){
	  alert("�����������룡");
	    return false;
	}
	if(pw1 != pw2){
	  alert("������д�����벻��ͬ��");
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

    <title>�޸�����</title>

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

      <form class="form-signin" role="form" method ="POST">
        <h2 class="form-signin-heading">�޸�����</h2>
        <input type="password" class="form-control" name = "passwd_old" placeholder="������" required autofocus>
        <input type="password" class="form-control" name = "passwd_new0" placeholder="������" required>
		<input type="password" class="form-control" name = "passwd_new1" placeholder="�ظ�����" required>
        <button class="btn btn-lg btn-primary btn-block" name = "sub" value = "1" type="submit">�޸�</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>

