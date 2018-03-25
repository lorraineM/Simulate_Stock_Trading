<?php
if (!session_id()) session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
<title>资金账户</title>
<link rel="stylesheet" href="stock.css">
<link href="css/stock.css" rel="stylesheet" type="text/css">
<link href="css/button.css" rel="stylesheet" type="text/css">
</head>

<body>
<!--<IFRAME 
frameBorder=no height=153
scrolling=no src="header.html" 
width=100%>
</IFRAME>-->
<?php include 'header.php';?>


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
<br><br>





<?php
// Remark:       0 人民币  1 美元  2 港币      3 欧元      4 英镑
//               5 日元    6 澳元  7 加拿大元  8 瑞士法郎  9 新加坡元


    // S3
	  function db_connect() {
        $result = new mysqli('localhost', 'trader', "programmer", "StockTrading");   //连接数据库
        if (!$result) {
            throw new Exception('Could not connect to database server');      // 报错
            // 若不需要，去掉即可
        } else {
            return $result;
        }
    }

	
    // 返回冻结资金的总金额
	
   function get_frozen($fid) {
        $conn = db_connect();
        $result = $conn->query("select * from rate order by currency");   // 得到汇率
        $rates = array();
		
        while ($row=mysqli_fetch_array($result)) {               // 按顺序得到汇率数组
            $rates[$row['currency']] = $row['exchange_rate'];
        }
        $sql = "select * from currency where fid =".strval($fid)." order by types";  // 得到该资金账户详细的资金信息
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {            // 该账户有资金
            $frozen = 0;
            while ($row = $result->fetch_assoc()) {               // 按顺序得到汇率数组
                $frozen = $frozen + $row['frozen']*$rates[$row['types']];     // 转换成人民币，累加各币种的汇率
            }
            return $frozen;
        } else {            // 该账户无资金
            return 0;
        }
		
		
		return $frozen;
    }

?>

<?php

if ($_SESSION['ID']){
  $link1=mysql_connect("localhost",'trader', "programmer") or die ("连接失败。可能是数据库服务没有开启或用户名密码错误".mysql_error());
  
	 $db_selected=mysql_select_db("StockTrading",$link1);
  
 	db_connect();
	
 	 $frozen=get_frozen($_SESSION['ID']);
 
 	//在资金信息表中检索资金信息
 	 $sql="select * from currency where fid='$_SESSION[ID]'";
  	 $result=mysql_query($sql);
   
   if(@$result==false)
   {
 		echo "false";
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
		 		 	<td width="100" align="center">可用资金</td>
					 <td height="20"align="center"width="100" >数额</td>
					</tr>
					
					<tr align="center" > 
		 			 <td width="100" align="center">人民币</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available0;?></td>
					</tr>
					
					<tr align="center" > 
					 <td width="100" align="center">美元</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available1;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">港币</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available2;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">欧元</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available3;?></td>
					 </tr>
					 
					 <tr align="center" > 				
					 <td width="100" align="center">英镑</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available4;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">日元</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available5;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">澳元</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available6;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">加拿大元</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available7;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">瑞士法郎</td>
					  <td height="20"align="center"width="100" >&nbsp;<?php echo $available8;?></td>
					 </tr>
					 
					 <tr align="center" > 
					 <td width="100" align="center">新加坡元</td>
					 <td height="20"align="center"width="100" >&nbsp;<?php echo $available9;?></td>
							</tr>
					 
				</table>				
				
				<table  border="1" align="center" cellspacing="2"  bordercolor="#FFFFFF"  bgcolor="#6699FF">
				<tr> 
		 			 <td width="100" align="center">冻结资金</td>			 
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
