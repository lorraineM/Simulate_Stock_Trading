<?php
session_start();
error_reporting(0);
$con = mysql_connect("localhost","trader","programmer");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("StockTrading", $con);
mysql_query("SET NAMES UTF-8");
?>