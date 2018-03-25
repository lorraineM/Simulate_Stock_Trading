<?php
$con = mysql_connect("localhost", 'trader', "programmer"); //选择数据库之前需要先连接数据库服务器 
if (!$con)
  {
     die('Could not connect: ' . mysql_error());
  }
 

mysql_select_db("StockTrading", $con);

date_default_timezone_set('PRC'); 
// Create table in my_db database
/*

$sql = "select * from Transaction_list";


if (!mysql_query($sql,$con))
{
	die('Error: ' . mysql_error());
}
$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		$purchase_high = $row['time'];
		echo $purchase_high;
		
		echo date('Y-m-d H:i:s');
mysql_close($con);*/
?>