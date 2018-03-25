<?php
  error_reporting(E_ALL & ~ E_NOTICE );
  $uid=$_POST[tomrateUid];
  $tomrate=$_POST[tomrate];
  $managerid=$_POST[mid];
  include "conn.php";
  $query=mysqli_query($conn,"update stock set tomrate = ".$tomrate." where uid = '".$uid."'");

  date_default_timezone_set ('PRC');
  $date = date('Y-m-d H:i:s',time());
  mysqli_query($conn,"insert into log (admin_id,date,event) values ('".$managerid."', '".$date."','Stock ".$uid." tomrate=".$tomrate."')");

  echo "<script language='javascript'>history.back();</script>";
  mysqli_close($conn);
?>