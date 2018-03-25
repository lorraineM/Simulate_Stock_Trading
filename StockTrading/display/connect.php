<?php
mysql_connect("localhost","trader","programmer")or die("mysql connect fail");
mysql_select_db("StockTrading") or die("select db fail");
mysql_query("set names 'GBK'");
?>