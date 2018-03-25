<?php 
error_reporting(E_ALL & ~ E_NOTICE);
$id=$_GET[id];
$sessionid=$_GET[sessionid];
?>

<html>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrapSwitch.css">
<head>
<title>股票交易系统</title>
</head>

<body background="background.jpg">
  <div class="navbar navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="">交易系统管理子系统</a>
        </div>
       <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="">
            Welcome 超级管理员
            <?php
              include ("supermanager.php");
             //  include("conn.php");     
              $managerid=$_SESSION[managerid];
              include("conn.php");
              $sql=mysqli_query($conn,"select * from administrator where id='".$managerid."'");
              $info=mysqli_fetch_array($sql,MYSQLI_ASSOC);  

              $manager=new SuperManager();
              $manager->managerid=$info['id'];
              $manager->password=$info['password'];
              $manager->name=$info['name'];
              $manager->sex=$info['sex'];
              $manager->idcard=$info['idcard'];
              $manager->address=$info['address'];
              $manager->telephone=$info['telephone'];
              mysqli_close($conn);
             // $sql=mysqli_query($conn,"select * from administrator where id='".$this->id."' and password='".$this->pwd."'");
              echo $manager->managerid;
              ?></a>
            </li> 
            <li ><a href="logout.php?sessionid=<?php echo session_id()?>">登出 </a></li>
            <li><a href="#" data-toggle="modal" data-target="#changePassword">修改密码</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div>
    </div>

     <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  onclick="clearModal()">&times;</button>
            <h4 class="modal-title" id="myModalLabel">修改密码</h4>
          </div>
          <div class="modal-body">
             <form class="form" method="post" action="changePassword.php">
             <div class="form-group" >
                <label for="ID">管理员ID</label>
                <input type="text" class="form-control" name="themanagerid" id="themanagerid" value="<?php echo $manager->managerid?>"  readonly="readonly"  >
              </div>
              <div class="form-group">
                <label for="password">请输入原密码</label>
                <input type="password" class="form-control" name="password" id="password" onblur="checknull()" >
              </div>
              <div class="form-group">
                <label for="password1">请输入新密码</label>
                <input type="password" class="form-control" name="password1" id="password1" onblur="checknull1()" onchange="checksame1()">
              </div>
              <div class="form-group">
                <label for="password2">再次输入新密码</label>
                <input type="password" class="form-control" name="password2" id="password2" onblur="checknull2()" onchange="checksame2()">
              </div>
               <button type="button" class="btn btn-default" data-dismiss="modal" onclick="clearModal()">关闭</button>
              <button type="submit" class="btn btn-info"  >确定</button>
            </form>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>





     <div class="container" style="margin-left:20%">

      <div class="row row-offcanvas row-offcanvas-right">

            <?php //查询原记录
            include("conn.php");
            $res=mysqli_query($conn,"select * from administrator where id=".$id);
            $row=mysqli_fetch_array($res);
            ?>
             <div class="col-xs-8 col-sm-8">
             
            <form class="form-horizontal" role="form" method="post" action="changemanager.php">
              <div class="form-group">
                <label for="id" class="col-sm-2 control-label">管理员id</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="id" value="<?php echo $id;?>" readonly="readonly">
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">姓名</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>">
                </div>
              </div>
              <div class="form-group">
                <label for="sex" class="col-sm-2 control-label">性别</label>
                <div class="col-sm-5">
                  <select name="sex">
                  <option <?php if($row['sex']=='M'){echo "selected";} ?>>Male</option>
                  <option <?php if($row['sex']=='F'){echo "selected";} ?>>Female</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="idCard" class="col-sm-2 control-label">身份证号</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="idCard" value="<?php echo $row['idCard'];?>">
                </div>
              </div>
              <div class="form-group">
                <label for="address" class="col-sm-2 control-label">地址</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="address" value="<?php echo $row['address'];?>">
                </div>
              </div>
              <div class="form-group">
                <label for="telephone" class="col-sm-2 control-label">联系方式</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="telephone" value="<?php echo $row['telephone'];?>">
                </div>
              </div>
               <div class="form-group">
                <div class="col-sm-offset-2 col-sm-1">
                  <button type="submit" class="btn btn-lg  btn-success">保存</button>
                </div>
             
               
                <div class="col-sm-offset-1 col-sm-2">
                   <a href="supermanagerhome.php?sessionid=<?php echo $sessionid ;?>" class="btn btn-lg  btn-success">返回</a>
                </div>
              </div>
            </form>
        
          
        </div><!--/span-->
      </div><!--/row-->
    
 
 


     

    </div><!--/.container-->


<!-- Include all compiled plugins (below), or include individual files as needed -->
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script type="text/javascript"  src="js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript"  src="js/bootstrap.min.js"></script>
 <script type="text/javascript"  src="js/bootstrapSwitch.js"></script>
 
  <script type="text/javascript">

      function checknull(){ 
      var password = document.getElementById("password");
        if(password.value=="")
          alert("原密码不能为空！");
      }
       function checknull1(){ 
       var password1 = document.getElementById("password1");
        if(password1.value==""){
          alert("新密码不能为空！");
          }
       
      }

       function checksame1(){ 
       var password1 = document.getElementById("password1");
       var password2 = document.getElementById("password2");
       
      if(password1.value!=password2.value&&password2.value!=""){
          alert("两次输入密码必须一致！");
        }
      }

       function checknull2(){ 
        var password2 = document.getElementById("password2");
        if(password2.value==""){
          alert("请再次输入新密码！");
          
          }
      }

      function checksame2(){ 
        var password2 = document.getElementById("password2");
        var password1 = document.getElementById("password1");
        if(password1.value!=password2.value){
          alert("两次输入密码必须一致！");
        }
      }

      function clearModal(){
         var password = document.getElementById("password");
        var password1 = document.getElementById("password1");
        var password2 = document.getElementById("password2");
        password.value="";
        password1.value="";
        password2.value="";
      }
     
      //
       
  </script>
</body>
</html>