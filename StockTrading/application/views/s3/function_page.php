<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
</head>

<body>
<form name="login" method="post" action="fund_page.php" onSubmit="return doCheck();">
  
    <p align="right"><strong> </strong></p>
    <div id="Layer3">
   
      <p align="center">
        <input type="submit" name="search" class="btn" value="查询" />
      </p>
    </div>
    <p align="right">&nbsp;</p>
</form>
</body>

<body>
<?php
if (isset($_POST['search']))
{  
  $link1=mysql_connect("localhost","root","") or die ("连接失败。可能是数据库服务没有开启或用户名密码错误".mysql_error());
  
 $db_selected=mysql_select_db("db",$link1);
  
 
 //在资金信息表中检索资金信息
  $sql="select * from fund_info where fid='$_SESSION[ID]'";
   $result=mysql_query($sql);
   
   if(@$result==false)
   {
 		
   }
   
   else{
   			//以表格输出结果
			$info=@mysql_fetch_array($result);
			
			if(@!$info)//结果条数为0
			   {
			?>
			</body>
			
			<body>
			<table  align="center"  bgcolor="#6699FF" >
			<td width="200"  >没有符合条件的记录</td>
			</body>
			</table>
			</form>
			</body>
			
			
			<?php
				exit;
			   }
			   
					   ?>
			   <body>
			   <table  border="1" align="center" cellspacing="2"  bordercolor="#FFFFFF"  bgcolor="#6699FF">

				<tr> 
		 		 	<td width="100" align="center">可用资金</td>
		 			 <td width="100" align="center">冻结资金</td>
				</table>

				<table align="center"  border="1"  bordercolor="#FFFFFF"  bgcolor="#6699FF">
				<tr align="center"  >
				<td height="20"align="center" width="100"  >&nbsp;<?php echo @$info[available];?></td>
				<td height="20"align="center"width="100" >&nbsp;<?php echo @$info[frozen];?></td>
				
				</tr>
				</table>
			   </body>
			   <?php
			   
   }
   
 }
?>
</body>

</html>
