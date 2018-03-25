<?php
@session_start();
error_reporting(E_ALL & ~ E_NOTICE );
$userid=$_POST[userid];          //接收表单提交的管理员名
$password=$_POST[password];            //接收表单提交的密码

class chkinput{                //定义类
   var $id; 
   var $pwd;

   function chkinput($x,$y){
     $this->id=$x;
     $this->pwd=$y;
    }

   function checkinput(){
     include("conn.php");         //连接数据源    
     $sql=mysqli_query($conn,"select * from administrator where id='".$this->id."' and password='".$this->pwd."'");
     $info=mysqli_fetch_array($sql,MYSQLI_ASSOC);       //检索管理员名称和密码是否正确
     if($info==false){                    //如果管理员名称或密码不正确，则弹出相关提示信息
          echo "<script language='javascript'>alert('管理员id或密码错误，请重新输入！');history.back();</script>";//history back();返回上一页
          exit;
       }
      else if($info['isSuper']=='Y'){//是超级管理员
        //include("supe『manager.php");
        //$manager=new SuperManager();
        $_SESSION[managerid]=$info['id'];
        //$manager->password=$info['password'];
        //$manager->name=$info['name'];
       // $manager->sex=$info['sex'];
        //$manager->idcard=$info['idcard'];
       // $manager->address=$info['address'];
       // $manager->telephone=$info['telephone'];
      //  $_SESSION[manager]= serialize($manager);
        $sessionid=session_id();
        echo "<script>alert('超级管理员登录成功!');window.location.href='supermanagerhome.php?sessionid={$sessionid}';</script>";
      }
      else{                              //如果管理员名称或密码正确，则弹出相关提示信息,是普通管理员
        //include("ordinarymanager.php"); 
        //$manager=new OrdinaryManager();
        //$manager->managerid=$info['id'];
        //$manager->password=$info['password'];
       // $manager->name=$info['name'];
       // $manager->sex=$info['sex'];
       // $manager->idcard=$info['idcard'];
       // $manager->address=$info['address'];
      //  $manager->telephone=$info['telephone'];
        $_SESSION[managerid]=$info['id'];
       // $_SESSION[manager]= serialize($manager);
        //$_SESSION[userid]=$this->id;
       //$_SESSION[password]=$this->pwd;
        //echo $_SESSION[manager]->managerid;
       $sessionid=session_id();
       //date_default_timezone_set ('PRC');
       //$date = date('Y-m-d H:i:s',time());
       //mysqli_query($conn,"insert into log (admin_id,date,event) values ('".$this->id."', '".$date."','Log in')");
       //echo $sessionid;
       $str1="<script>alert('普通管理员登录成功!');"."window.location.href=";
       $str2=$str1."'normal.php?sessionid=".$sessionid."';</script>";
       echo $str2;
   }
 }

}
if($userid==""||$password==""){
   echo "<script language='javascript'>alert('id和密码不能为空！');history.back();</script>";
}
else{
    $obj=new chkinput($userid,$password);      //创建对象
    $obj->checkinput();                     //调用类
  
}
?>