<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ޱ����ĵ�</title>
</head>

<body>
<form name="login" method="post" action="fund_page.php" onSubmit="return doCheck();">
  
    <p align="right"><strong> </strong></p>
    <div id="Layer3">
   
      <p align="center">
        <input type="submit" name="search" class="btn" value="��ѯ" />
      </p>
    </div>
    <p align="right">&nbsp;</p>
</form>
</body>

<body>
<?php
if (isset($_POST['search']))
{  
  $link1=mysql_connect("localhost","root","") or die ("����ʧ�ܡ����������ݿ����û�п������û����������".mysql_error());
  
 $db_selected=mysql_select_db("db",$link1);
  
 
 //���ʽ���Ϣ���м����ʽ���Ϣ
  $sql="select * from fund_info where fid='$_SESSION[ID]'";
   $result=mysql_query($sql);
   
   if(@$result==false)
   {
 		
   }
   
   else{
   			//�Ա��������
			$info=@mysql_fetch_array($result);
			
			if(@!$info)//�������Ϊ0
			   {
			?>
			</body>
			
			<body>
			<table  align="center"  bgcolor="#6699FF" >
			<td width="200"  >û�з��������ļ�¼</td>
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
		 		 	<td width="100" align="center">�����ʽ�</td>
		 			 <td width="100" align="center">�����ʽ�</td>
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
