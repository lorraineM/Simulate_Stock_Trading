<?php
  error_reporting(E_ALL & ~ E_NOTICE );
  $id=$_POST[themanagerid];
  $password=$_POST[password];
   $password1=$_POST[password1];
   $password2=$_POST[password2];
    include "conn.php";
   if($password2!=$password1){
     echo "<script language='javascript'>alert('新密码不一致！请重新输入！');history.back();</script>";//history back();返回上一页
   }
   else{
 
 
  $sql=mysqli_query($conn,"select * from administrator where id='".$id."' and password='".$password."'");
   $info=mysqli_fetch_array($sql,MYSQLI_ASSOC);       //检索管理员名称和密码是否正确
     if($info==false){                    //如果管理员名称或密码不正确，则弹出相关提示信息
     
          echo "<script language='javascript'>alert('密码错误，请重新输入！');history.back();</script>";//history back();返回上一页
        
       }
      else{                              //如果管理员名称或密码正确，则弹出相关提示信息
  $query=mysqli_query($conn,"update administrator set password = '".$password1."' where id = '".$id."'");
  //echo $id;
  //echo $password1;
  //先过滤掉超级管理员的登出操作
 //$manager=mysqli_query($conn,"select * from administrator where id=".$id);
 //$res=mysqli_fetch_array($manager);
 //if($res['isSuper']=='F'){
 // date_default_timezone_set ('PRC');
 // $date = date('Y-m-d H:i:s',time());
 // mysqli_query($conn,"insert into log (admin_id,date,event) values ('".$id."', '".$date."','Change password')");
//}
  echo "<script language='javascript'>alert('修改成功');history.back();</script>";}
  mysqli_close($conn);
}

?>