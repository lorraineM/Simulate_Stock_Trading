<?php 
include ("post.php");
include ("connect.php");
	session_start();
/*	if(isset($_SESSION['ID']) && $_SESSION['ID'] != '***'){
		//echo "���Ѿ��ɹ���¼��";
		//$mid = $_SESSION['mid'];
	}else{
		echo "����δ��¼������<a href = login.php>��¼</a>��";
		die();
	}*/
//include("connect.php");
$stock=@$_POST["stock"];
$price=@$_POST["price"];
$number=@$_POST["number"];
$buyer=@$_POST["buyer"];
$seller=@$_POST["seller"];
$ID=$_SESSION['ID'];
//$ID=123;
if($buyer==$ID)
{
	$sql_str="SELECT frozen,available FROM currency where fid=$ID";
	$result=mysql_query($sql_str);
	while($result!=null&&$row = mysql_fetch_array($result))
	{
		$frozen=$row["frozen"]; 
		$available=$row['available'] ;
	}
	echo "<script LANGUAGE='JavaScript'>alert(' ���Ѿ�����". $stock ."��Ʊ ".$number."�ɣ��۸�Ϊ".$price."Ԫ��Ŀǰ���ö����ʽ�Ϊ".$frozen."�������ʽ�Ϊ".$available."');history.back();</script>";
}
if($seller==$ID)
{
	$sql_str="SELECT frozen,available FROM currency where fid=$ID";
	$result=mysql_query($sql_str);
	while($result!=null&&$row = mysql_fetch_array($result))
	{
		$frozen=$row["frozen"]; 
		$available=$row['available'] ;
	}
	echo "<script LANGUAGE='JavaScript'>alert(' ���Ѿ�����". $stock ."��Ʊ ".$number."�ɣ��۸�Ϊ".$price."Ԫ��Ŀǰ���ö����ʽ�Ϊ".$frozen."�������ʽ�Ϊ".$available."');history.back();</script>";
}
else
{
	echo "<script LANGUAGE='JavaScript'>history.back();</script>";
}


mysql_close($con);   //�Ͽ����ݿ�
?>
