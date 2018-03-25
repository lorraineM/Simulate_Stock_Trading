<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>查询持有股票</title>
<link href="file:///D|/Documents/Tencent Files/1622388554/FileRecv/css/stock.css" rel="stylesheet" type="text/css">
<link href="file:///D|/Documents/Tencent Files/1622388554/FileRecv/css/button.css" rel="stylesheet" type="text/css">
</head>

<body>
<!--<IFRAME 
frameBorder=no height=153
scrolling=no src="header.html" 
width=100%>
</IFRAME><!--end of header-->
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
	<?php 
		if (!session_id()) session_start();
		if(isset($_SESSION['ID']) && $_SESSION['ID'] != null){
		//echo "您已经成功登录！";
			$login_name = $_SESSION['ID'];
		//$mid = $_SESSION['mid'];
		}else{
			echo "您尚未登录，请先<a href = login.php>登录</a>。";
			die();
		}
	    
	   //$login_name = "Emma";
     	 $conn = new mysqli('localhost', 'trader', "programmer", "StockTrading"); 
	?>
    	<div class="security_account"><!--证券账户查询内容-->
        	<div class="acount_list">
            <br><br>
	     <?php
         
		 $sql_bondname = "select distinct sid from fund_account where fid = '{$login_name}'"; 
	     $result_bond = $conn->query($sql_bondname);
		 $row_bondname = $result_bond->fetch_assoc();
		  
					                 
                //echo '<div class="stock_list">';
                echo  '<table class="graytb">';
                echo  "<tr>";
                        echo "<th>股票代码</th>";
                        echo "<th>股票名称</th>";
                        echo "<th>持有总数</th>";
                        echo "<th>股票现价</th>";
                        echo "<th>成本</th>";
                        echo "<th>损益</th>";
                 echo "</tr>";
                
						  // echo "<h2>证券账户"; 
						   //echo $row_bondname['sid']."</h2>";
						   $sid = $row_bondname['sid'];
						   echo '<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=1)" width="80%" align="left" color=#987cb9 SIZE=2>';
						   echo '<br>';
						   $sql_certain_sid = "select * from `relation_list` where `user_id` = '$_SESSION[ID]'";
						   //echo $sql_certain_sid;
						   $query_certain_sid = $conn->query($sql_certain_sid);
						   
						   while($sid2 = $query_certain_sid->fetch_assoc()){
							   //echo $sid['sid'];
							   //echo "  ";
							  
							   $stock_id = $sid2['stock_id'];
							   $holdNumAll = $sid2['num'];
							   $holdPriceAll = $sid2['cost'];
							   
							   
							   $sql_stock = "select * from stock where uid = '{$sid2['stock_id']}' ";
	                           $result = $conn->query($sql_stock);
							   $row2 = $result->fetch_assoc(); 
                               
							  
							   $stockName = $row2['name'];
							   $stockPrice = $row2['nowprice'];						   
                               $profitAll = ( $stockPrice - $holdPriceAll) * $holdNumAll;
							   
							   //$english_format_number = number_format($holdPriceAll, 2, '.', '');
						       echo "<tr>";
							   
                               echo "<th>"; 
							   			echo $stock_id ; 
                               echo "</th>";
                        
                               echo "<th>";
						               echo $stockName ; 
							   echo "</th>";
                        
                               echo "<th>"; 
									  echo $holdNumAll ; 
						       echo "</th>";
                        
                               echo "<th>";
									  echo $stockPrice ;
                               echo "</th>";
                        
                               echo "<th>";
									  echo $holdPriceAll ; 
						       echo "</th>";
                       
                               echo "<th>";
									 echo $profitAll ; 
                               echo "</th>";
						   
                               echo "</tr>";
						   }
	
                      ?>
                   
                    </table>
                <!--/div-->	
            </div><!--end of acount_list-->
            
        </div>
        </div>
    </div><!--end of right_panel-->
</div>
<!--end of mainarea-->


<!--start of foot-->
<div class="box_body">
	<div class="box">
    	<div class="box_in">
        	联系我们||意见建议
        </div>
        <div class="box_in"></div>
    </div>
</div>
<!--end of foot-->
</body>
</html>
