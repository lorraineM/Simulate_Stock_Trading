<?php
if (!session_id())  session_start();
@$_SESSION['ID']=null;
   @$_SESSION['pw']=null;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
  <head>
    <title>登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
 
	<link rel="stylesheet" href="css/stock.css">
	<link rel="stylesheet" href="css/button.css">
    
</head>
<body>

<?php include 'header.php'; ?>



<!--start of main area-->
<div class="mainarea">
<div class="left_panel">
<div class="main_content">
          <li style="margin:0px"><a href="/StockTrading/acco_home">证券账户管理</a></li>
          <li><a href="/StockTrading/fund">资金账户管理</a></li>
          <li><a href="http://localhost/StockTrading/client/login.php">交易客户端</a></li>
          <li><a href="http://localhost/StockTrading/display/index.php">网上信息发布</a></li>
	</div>
	</div>  
<div class="right_panel">
<div class="main_content">
<form name="login" method="post" action="login.php" onSubmit="return doCheck();">
  
    <p align="right"><strong> </strong></p>
    <div id="Layer3">
      <p align="left"><strong>用户名：</strong>
          <input name="ID" type="text" class="textinput" id="ID" size="16" maxlength="15" placeholder="请输入用户名"/>
          <!--<input class="input-text" type="text" name="p" id="search-key" value="" >-->
      </p>
      <p align="left"> <strong>密码 ： </strong>
          <input name="password" type="password" class="textinput" id="password" size="16" maxlength="15" placeholder="请输入密码"/>
      </p>
      <br><br>
      <p>
        <input type="submit" name="submit" class="button glow button-primary" value="登录" />
         <input name="reset" type="reset" class="button glow button-flat" value="重置" />
      </p>
    </div>
    <p align="right">&nbsp;</p>
</form>
</div>
</div>
</div>
</body>

<body>





<?php
if (isset($_POST['submit']))
{  
   $link1=mysql_connect("localhost",'trader', "programmer") or die ("连接失败。可能是数据库服务没有开启或用户名密码错误".mysql_error());
   if (!$link1)
  {
  die('Could not connect: ' . mysql_error());
  }
	 $db_selected=mysql_select_db("StockTrading",$link1);
   @$_SESSION['ID']=$_POST[ID];
   @$_SESSION['pw']=$_POST[password];
  
 
 //在表中检索用户名密码
  $sql="select * from fund_account where fid='$_POST[ID]' and login_pin='$_POST[password]'";
   $result=mysql_query($sql);
    $row = mysql_num_rows($result);
 
 //用户名密码存在
 if($row>0)
 {
     $link=mysql_connect("localhost",'trader', "programmer") or die ("连接失败。可能是数据库服务没有开启或用户名密码错误".mysql_error());
	 $db_selected=mysql_select_db("StockTrading",$link);
	  
    if($link &&$db_selected)
      {
     ?>
	 <script type="text/javascript">

  alert("Welcome！")

 </script>
	 <?php
	  	 $url = "fund.php";//登陆成功，跳转到function_page
      	 echo "<script language='javascript' type='text/javascript'>";
     	 echo "window.location.href='$url'";
     	 echo "</script>";
      	}	 
   }
 else {
 ?>
	 <script type="text/javascript">


  alert("用户名密码错误！")

 </script>
	 <?php
} 
}
?>
</body>
 <script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>
</html>
