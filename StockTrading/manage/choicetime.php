<?php
error_reporting(E_ALL & ~ E_NOTICE );
$id=$_POST[id];        //接收管理员id
$sessionid=$_POST[sessionid];
$startyear=$_POST[startyear];
$startmonth=$_POST[startmonth];
$startday=$_POST[startday];
$endyear=$_POST[endyear];
$endmonth=$_POST[endmonth];
$endday=$_POST[endday];

echo "<script language=\"javascript\">";
echo "document.location=\"showlog.php?id=".$id."&sessionid=".$sessionid."&startmonth=".$startmonth."&startday=".$startday."&endmonth=".$endmonth."&endday=".$endday."\"";
echo "</script>";

?>