<?php
session_start();
@$_SESSION['ID']=null;
   @$_SESSION['pw']=null;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
 
	<link rel="stylesheet" href="stock.css">
</head>
<body>

<IFRAME 
frameBorder=no height=153
scrolling=no src="header.html" 
width=100%>
</IFRAME>

<div class="header"></div><!--end of header-->

<!--start of main area-->
<div class="mainarea">
	<div class="left_panel">
    	<div class="function">
        	<div class="funclist">
        		<button class="funcbtn" type="submit">����</button>
            </div>
            <div class="funclist">
        		<button class="funcbtn" id="secur_account" type="submit">֤ȯ�˻���ѯ</button>
            </div>
            <div class="funclist">
        		<button class="funcbtn" type="submit">����</button>
            </div>
            <div class="funclist">
        		<button class="funcbtn" type="submit">......</button>
            </div>
        </div>
    </div><!--end of left_panel-->
<div class="right_panel">
<form name="login" method="post" action="login.php" onSubmit="return doCheck();">
  
    <p align="right"><strong> </strong></p>
    <div id="Layer3">
      <p align="left"><strong>�û�����</strong>
          <input name="ID" type="text" class="textinput" id="ID" size="16" maxlength="15" />
      </p>
      <p align="left"> <strong>���� �� </strong>
          <input name="password" type="password" class="textinput" id="password" size="16" maxlength="15" />
      </p>
      <p align="center">
        <input type="submit" name="submit" class="btn" value="��¼" />
         <input name="reset" type="reset" class="btn" value="����" />
      </p>
    </div>
    <p align="right">&nbsp;</p>
</form>
</div>
</div>
</body>

<body>





<?php
if (isset($_POST['submit']))
{  
   $link1=mysql_connect("localhost","root","") or die ("����ʧ�ܡ����������ݿ����û�п������û����������".mysql_error());
   if (!$link1)
  {
  die('Could not connect: ' . mysql_error());
  }
	 $db_selected=mysql_select_db("db",$link1);
   @$_SESSION['ID']=$_POST[ID];
   @$_SESSION['pw']=$_POST[password];
  
 
 //�ڱ��м����û�������
  $sql="select * from fund_account where fid='$_POST[ID]' and login_pin='$_POST[password]'";
   $result=mysql_query($sql);
    $row = mysql_num_rows($result);
 
 //�û����������
 if($row>0)
 {
     $link=mysql_connect("localhost","root","") or die ("����ʧ�ܡ����������ݿ����û�п������û����������".mysql_error());
	 $db_selected=mysql_select_db("db",$link);
	  
    if($link &&$db_selected)
      {
     ?>
	 <script type="text/javascript">

  alert("Welcome��")

 </script>
	 <?php
	  	 $url = "http://localhost/StockTrading/TradingClient/fund.php";//��½�ɹ�����ת��function_page
      	 echo "<script language='javascript' type='text/javascript'>";
     	 echo "window.location.href='$url'";
     	 echo "</script>";
      	}	 
   }
 else {
 ?>
	 <script type="text/javascript">


  alert("�û����������")

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
