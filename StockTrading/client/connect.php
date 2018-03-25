<?php
$con = mysql_connect("localhost",'trader', "programmer");  //连接数据库
if (!$con)  //如果连接不成功
{
	die('Could not connect: ' . mysql_error());  //进行连接报错
}
mysql_select_db("StockTrading", $con);
date_default_timezone_set('PRC');
?>
