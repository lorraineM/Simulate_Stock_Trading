<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ޱ����ĵ�</title>
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
<form name="login" method="post" action="fund.php" onSubmit="return doCheck();">
  
    <p align="right"><strong> </strong></p>
    <div id="Layer3">
   
      <p align="center">
        <input type="submit" name="search" class="btn" value="��ѯ" />
      </p>
    </div>
    <p align="right">&nbsp;</p>
</form>



<?php
// Remark:       0 �����  1 ��Ԫ  2 �۱�      3 ŷԪ      4 Ӣ��
//               5 ��Ԫ    6 ��Ԫ  7 ���ô�Ԫ  8 ��ʿ����  9 �¼���Ԫ


    // S3
	  function db_connect() {
        $result = new mysqli('localhost', 'root', "", "db");   //�������ݿ�
        if (!$result) {
            throw new Exception('Could not connect to database server');      // ����
            // ������Ҫ��ȥ������
        } else {
            return $result;
        }
    }

	
    // ���ض����ʽ���ܽ��
	
   function get_frozen($fid) {
       /*  $conn = db_connect();
        $result = $conn->query("select * from rate order by currency");   // �õ�����
        $rates = array();
		 print_r($result);
        while ($row=$result->fetch_assoc()) {               // ��˳��õ���������
            $rates[$row['currency']] = $row['exchange_rate'];
        }
        $sql = "select * from currency where fid =".strval($fid)." order by types";  // �õ����ʽ��˻���ϸ���ʽ���Ϣ
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {            // ���˻����ʽ�
            $frozen = 0;
            while ($row = $result->fetch_assoc()) {               // ��˳��õ���������
                $frozen = $frozen + $row['frozen']*$rates[$row['types']];     // ת��������ң��ۼӸ����ֵĻ���
            }
            return $frozen;
        } else {            // ���˻����ʽ�
            return 0;
        }*/
		
		$frozen=20;
		return $frozen;
    }

?>

<?php
if (isset($_POST['search']))
{  
  $link1=mysql_connect("localhost","root","") or die ("����ʧ�ܡ����������ݿ����û�п������û����������".mysql_error());
  
	 $db_selected=mysql_select_db("db",$link1);
  
 	db_connect();
	
 	 $frozen=get_frozen($_SESSION['ID']);
 
 	//���ʽ���Ϣ���м����ʽ���Ϣ
 	 $sql="select * from currency where fid='$_SESSION[ID]'";
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
			   $available0=0;
			    $available1=0;
				 $available2=0;
				  $available3=0; 
				   $available4=0;
				   $available5=0;
				    $available6=0; 
					$available7=0;
					 $available8=0;
					  $available9=0;
					
			   		   
		do{
		if(@$info[types]==0)
			$available0=@$info[available];
			
		else if(@$info[types]==1)
			$available1=@$info[available];
			
		else if(@$info[types]==2)
			$available2=@$info[available];
			
		else if(@$info[types]==3)
			$available3=@$info[available];
			
		else if(@$info[types]==4)
			$available4=@$info[available];
			
		else if(@$info[types]==5)
			$available5=@$info[available];
		
		else if(@$info[types]==6)
			$available6=@$info[available];
			
		else if(@$info[types]==7)
			$available7=@$info[available];
		
		else if(@$info[types]==8)
			$available8=@$info[available];
			
		else if(@$info[types]==9)
			$available9=@$info[available];
		
 		 $info=@mysql_fetch_array($result);
   
   			}while($info);   
			   
					   ?>
					   
			
			   <table  border="1" align="center" cellspacing="2"  bordercolor="#FFFFFF"  bgcolor="#6699FF">

				<tr align="center" > 
		 		 	<td width="100" align="center">�����ʽ�</td>
					 <td height="20"align="center"width="100" >����</td>
					</tr>
					
					<tr align="center" > 
		 			 <td width="100" align="center">�����</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available0;?></td>
					</tr>
					
					<tr align="center" > 
					 <td width="100" align="center">��Ԫ</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available1;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">�۱�</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available2;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">ŷԪ</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available3;?></td>
					 </tr>
					 
					 <tr align="center" > 				
					 <td width="100" align="center">Ӣ��</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available4;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">��Ԫ</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available5;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">��Ԫ</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available6;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">���ô�Ԫ</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available7;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">��ʿ����</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available8;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">�¼���Ԫ</td>
					 <td height="20"align="center"width="100" >&nbsp;<?php echo $available9;?></td>
							</tr>
					 
				</table>				
				
				<table  border="1" align="center" cellspacing="2"  bordercolor="#FFFFFF"  bgcolor="#6699FF">
				<tr> 
		 			 <td width="100" align="center">�����ʽ�</td>			 
				</table>
				
				<table align="center"  border="1"  bordercolor="#FFFFFF"  bgcolor="#6699FF">
				<tr align="center"  >
				<td height="20"align="center"width="100" >&nbsp;<?php echo $frozen;?></td>			
				</tr>
				</table>
				
				</div>

</div>
			   </body>
			   <?php
			   
   }
   
 }
?>
</body>

</html>
