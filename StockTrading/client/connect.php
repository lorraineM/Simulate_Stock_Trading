<?php
$con = mysql_connect("localhost",'trader', "programmer");  //�������ݿ�
if (!$con)  //������Ӳ��ɹ�
{
	die('Could not connect: ' . mysql_error());  //�������ӱ���
}
mysql_select_db("StockTrading", $con);
date_default_timezone_set('PRC');
?>
