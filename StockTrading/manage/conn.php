<?php
	 error_reporting(E_ALL & ~ E_NOTICE);
     $conn=mysqli_connect("localhost","trader","programmer","StockTrading") or die("数据库服务器连接错误：".mysql_error());
     mysqli_set_charset ($conn,utf8);
?>
