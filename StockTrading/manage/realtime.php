<?php 
error_reporting(E_ALL & ~ E_NOTICE);
//if()
session_id($_GET[sessionid]);
 session_start(); 
 $stockid=($_GET[stockid]);
 //$thesessionid=session_id();

?>

<html>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="5"> 
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
            Welcome 管理员
            <?php
             include ("ordinarymanager.php");    
             //  include("conn.php");    
             //if(isset($_SESSION[manager])) 
              //echo session_id();
              //$a=$_SESSION['manager'];
              //echo "<script>alert('$a')</script>";
              //if(!is_object($_SESSION['manager']))
                //echo session_id();
              //$a=unserialize($_SESSION[manager]);
              $managerid=$_SESSION[managerid];
              include("conn.php");
              $sql=mysqli_query($conn,"select * from administrator where id='".$managerid."'");
              $info=mysqli_fetch_array($sql,MYSQLI_ASSOC);  

              $manager=new OrdinaryManager();
              $manager->managerid=$info['id'];
              $manager->password=$info['password'];
              $manager->name=$info['name'];
              $manager->sex=$info['sex'];
              $manager->idcard=$info['idcard'];
              $manager->address=$info['address'];
              $manager->telephone=$info['telephone'];
              mysqli_close($conn);
              //$manager=unserialize($_SESSION[manager]);
            //$_SESSION[manager]= $a;
            
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
                <input type="text" class="form-control" name="themanagerid" id="themanagerid" value="<?php echo $manager->managerid?>"  readonly="readonly" >
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





    <div class="container">

             <?php 
                include "conn.php";
                $stock=mysqli_query($conn,"select * from stock where uid='".$stockid."'");
                $stock=mysqli_fetch_array($stock);
                $sales=mysqli_query($conn,"select * from sales_list where stock_id=".$stockid." order by price");
                $purchase=mysqli_query($conn,"select * from purchase_list where stock_id=".$stockid." order by price desc");
               ?>
          <div class="row">
            <div class="col-xs-2 col-sm-2">
               <div class="well">
                <h3>股票<?php echo $stockid;?></h3>
                <p>最新成交价格:<?php echo $stock['nowprice'];?></p>
                <p>最新成交数量:<?php echo $stock['oknumber'];?></p>
                <p><a class="btn btn-primary" role="button" onclick="history.back();">返回</a></p>
              </div>
            </div>

            <div class="col-xs-5 col-sm-5"><!--the pachrase list-->
              <table class="table table-striped">
                 <thead>
                    <tr>
                      <th>买表id</th>
                      <th>买入价格</th>
                       <th>买入股数</th>
                       <th>进入系统时间</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php while($row = mysqli_fetch_array($purchase)){?>
                    <tr>
                      <td><?php echo $row['p_id'];?></td>
                      <td><?php echo $row['price'];?></td>
                      <td><?php echo $row['num'];?></td>
                      <td><?php echo $row['timee'];?></td>
                    </tr>
                  <?php ;}?>
                  </tbody>
              </table>
            </div>
              
            <div class="col-xs-5 col-sm-5"><!--the sales list-->
                <table class="table table-striped">
                 <thead>
                    <tr>
                      <th>卖表id</th>
                      <th>卖出价格</th>
                       <th>卖出股数</th>
                       <th>进入系统时间</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php while($row = mysqli_fetch_array($sales)){?>
                    <tr>
                      <td><?php echo $row['s_id'];?></td>
                      <td><?php echo $row['price'];?></td>
                      <td><?php echo $row['num'];?></td>
                      <td><?php echo $row['timee'];?></td>
                    </tr>
                  <?php ;}?>
                  </tbody>
                </table>
            </div>
          </div><!--row-->

            
    
    
    
 
 


     

    </div><!--/.container-->


<!-- Include all compiled plugins (below), or include individual files as needed -->
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script type="text/javascript"  src="js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript"  src="js/bootstrap.min.js"></script>
 <script type="text/javascript"  src="js/bootstrapSwitch.js"></script>
 
  <script type="text/javascript">
     function check(number){
      if(!/^([1-9]\d*|[1-9]\d*\.\d*|0\.\d*[1-9]\d*|0)$/.test(number.value)){
        alert("涨跌幅只能为正的小数");
        number.value='';
        number.focus();
        }
     }

      function checkuid(uid){
        var table = document.getElementById("stocktable");
        var rowsNumber = table.rows.length;
        //alert(rowsNumber);
        for(var i =1;i<rowsNumber;i=i+2){
          //alert(table.rows[i].cells[0].innerHTML);
           if(uid.value==table.rows[i].cells[0].innerHTML){
           return;
              
            }     
        }
        alert("你没有权限访问该股票或股票不存在！");
        uid.value='';
         uid.focus();

     
     }
     
      $(".switch").each(function(){
        $(this).on('switch-change', function (e,data){
         var uid = $(this).attr("id");
         //var $el = $(data.el)
          //  , value = data.value;
         // console.log(e, $el, value);
         //alert(uid );
          //alert(data.value);
         var managerid = document.getElementById("themanagerid");
          $.post("changeState.php", { state: data.value, uid: uid, managerid: <?php echo $manager->managerid;?>} );
      
    })
    });

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