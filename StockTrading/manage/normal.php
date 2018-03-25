<?php 
session_start(); 
error_reporting(E_ALL & ~ E_NOTICE);
//if()
session_id($_GET[sessionid]);
 
 //$thesessionid=session_id();
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





    <div class="container" style="margin-left:20%">

      <div class="row row-offcanvas row-offcanvas-right">


        <div class="col-xs-8 col-sm-8">
          <div class="row">
          <table class="table" id="stocktable">
               <thead>
                <tr>
                  <th>股票代码</th>
                  <th>股票名称</th>
                  <th>开盘价</th>
                  <th>收盘价</th>
                  <th>股票状态</th>
                   <th></th>
                    <th></th>
                </tr>
              </thead>
              <tbody>
              <?php 
               include("conn.php");
                $stocks=mysqli_query($conn,"select * from admin_stock inner join stock on admin_stock.uid = stock.uid where admin_stock.admin_id='".$manager->managerid."' ");
                


                while($row = mysqli_fetch_array($stocks))
                {
                  echo "<tr>";
                  echo "<td>" . $row['uid'] . "</td>";
                  echo "<td>" . $row['name'] . "</td>";
                  echo "<td>" . $row['openprice'] . "</td>";
                  echo "<td>" . $row['closeprice'] . "</td>";
                  if ( $row['state']=='1') {
                     echo "<td><div class='switch' data-on='info' data-off='success'   id='" . $row['uid'] . "'> <input type='checkbox'   checked /></div></td>";
                  } else {
                     echo "<td><div  class='switch' data-on='info' data-off='success'  id='" . $row['uid'] . "'> <input type='checkbox' /></div></td>";
                  }
                  echo "<td> <button type = 'button' class='btn btn-info' data-toggle='collapse'   data-target='#info" . $row['uid'] . "'>详细信息</button></td>";
                  echo "<td> <a href='realtime.php?stockid=".$row['uid']."&sessionid=".session_id()."' button type = 'button' class='btn btn-info' id='stockid" . $row['uid'] . "'  >实时情况</button></td>";
                  echo "</tr>";
                  echo "<tr>";
                  echo "<td colspan='6'><div id='info" . $row['uid'] . "' class='collapse' ><pre >涨幅：".$row['rise']."   当日最大涨跌幅：".$row['todayrate']."   次日最大涨跌幅： ".$row['tomrate']."</br>注册日期：".$row['date']."</pre></div></td>";
                  echo "</tr>";
                }
              ?>
              </tbody>
          </table>
          </div>
          

            <div class="row text-center">
              <div >
                <a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#setrise">修改次日最大涨幅</a>
              </div>
            </div>

            <div class="modal fade" id="setrise" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">修改次日最大涨幅</h4>
                    </div>
                    <div class="modal-body">
                       <form role="form" method="post" action="setTomrate.php">
                        <div class="form-group">
                          <label for="uid">股票代码</label>
                          <input type="text" class="form-control" name="tomrateUid" id="tomrateUid" onchange="checkuid(this)">
                        </div>
                        <div class="form-group">
                          <label for="tomrate">次日最大涨幅</label>
                          <input type="text" class="form-control" name="tomrate" id="tomrate" onchange="check(this)">
                        </div>
                         <div class="form-group">
                          <label for="uid">管理员id</label>
                          <input type="text" class="form-control" name="mid" id="mid"  style="visibility:hidden" value="<?php echo $manager->managerid;?>">
                        </div>

                        <button type="submit" class="btn btn-info" >确定</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                      </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                  </div>
                </div>
              </div>

              
            
        </div><!--/span-->
      </div><!--/row-->
    
 
 


     

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
          $.post("changeState.php", { state: data.value, uid: uid, managerid: '<?php echo $manager->managerid;?>'} );
      
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