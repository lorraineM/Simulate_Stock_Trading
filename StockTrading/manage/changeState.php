<?php
  error_reporting(E_ALL & ~ E_NOTICE );
  $uid=$_POST[uid];
  $state=$_POST[state];
  $managerid=$_POST[managerid];
  //echo "<script>alert('".$managerid."')</script>";
  include "conn.php";
  if($state=='false'){
    $query=mysqli_query($conn,"update stock set state = '0' where uid = '".$uid."'");

	date_default_timezone_set ('PRC');
	$date = date('Y-m-d H:i:s',time());
	mysqli_query($conn,"insert into log (admin_id,date,event) values ('".$managerid."', '".$date."','Stock ".$uid." OFF')");
    }
  else{
    $query=mysqli_query($conn,"update stock set state = '1' where uid = '".$uid."'");

    date_default_timezone_set ('PRC');
	$date = date('Y-m-d H:i:s',time());
	mysqli_query($conn,"insert into log (admin_id,date,event) values ('".$managerid."', '".$date."','Stock ".$uid." ON')");
	}

  mysqli_close($conn);


?>