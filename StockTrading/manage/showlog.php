<?php 
error_reporting(E_ALL & ~ E_NOTICE);
$id=$_GET[id];
$sessionid=$_GET[sessionid];
$startmonth=$_GET[startmonth];
$startday=$_GET[startday];
$endmonth=$_GET[endmonth];
$endday=$_GET[endday];
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





    <div class="container" style="margin-left:30%">

      <div class="row row-offcanvas row-offcanvas-right">

        

        <div class="col-xs-8 col-sm-8">
          <div class="row">
          <table class="table" id="stocktable">
               <thead>
                <tr>
                  <th>管理员id</th>
                  <th>时间</th>
                  <th>操作</th>
                   <th></th>
                </tr>
              </thead>
              <tbody>
              <?php 
               include("conn.php");
                if($startmonth=="all")//选择全部月份
                  $startmonth="00";
                if($startday=="all")//选择全部月份
                  $startday="00";
                if($endmonth=="all")//选择全部月份
                  $endmonth="13";
                if($endday=="all")//选择全部月份
                  $endday="33";
                $str1="2014-".$startmonth."-".$startday." 00:00:00";
                $str2="2014-".$endmonth."-".$endday." 00:00:00";
                //echo "<script type='text/javascript'>alert('select * from log where admin_id=".$id." and date>=".$str1." and date<=".$str2." order by date desc');</script>";
                $stock=mysqli_query($conn,"select * from log where admin_id='".$id."' and date>='".$str1."' and date<='".$str2."' order by date desc");

                while($row = mysqli_fetch_array($stock))
                { 
                  echo "<tr>";
                  echo "<td>" . $row['admin_id'] . "</td>";
                  echo "<td>" . $row['date'] . "</td>";
                  echo "<td>" . $row['event'] . "</td>";
                  echo "</tr>";
                }
              ?>
              </tbody>
          </table>
          </div>
          


          <div class="form-group">
                <div class="col-sm-offset-1 col-sm-2">
                   <a href="supermanagerhome.php?sessionid=<?php echo $sessionid ;?>" class="btn btn-lg btn-success">返回</a>
                </div>

                <div class="col-sm-offset-1 col-sm-1">
                  <a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#choicetime">选择时间</a>
                </div>
          </div>
           

          <div class="modal fade" id="choicetime" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">选择时间</h4>
                    </div>
                    <div class="modal-body">
                       <form role="form" method="post" action="choicetime.php">

                        <div class="form-group">
                          <input type="hidden" value = "<?php echo $id;?>" name="id" id="id">
                        </div>
                        <div class="form-group">
                          <input type="hidden" value = "<?php echo $sessionid;?>" name="sessionid" id="sessionid">
                        </div>

                        <div class="form-group ">
                              <div >
                                 <label class="control-label" for="starttime">开始时间:</label>
                              </div>
                              <div class="row">
                                  <div class="col-xs-1 col-md-2">
                                    <!--<input type="text" class="form-control" name="startyear" id="startyear">-->
                                    <div class="controls">
                                      <select id="startyear" name="startyear">
                                        <option>all</option>
                                        <option>2014</option>
                                        <option>2015</option>
                                        <option>2016</option>
                                        <option>2017</option>
                                        <option>2018</option>
                                        <option>2019</option>
                                        <option>2020</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-1 col-md-1">年</div>
                                  <div class="col-xs-1 col-md-2">
                                    <!--<input type="text" class="form-control" name="startmonth" id="startmonth">-->
                                    <div class="controls">
                                      <select id="startmonth" name="startmonth">
                                        <option>all</option>
                                        <option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-1 col-md-1">月</div>
                                  <div class="col-xs-1 col-md-2">
                                    <!--<input type="text" class="form-control" name="startday" id="startday">-->
                                    <div class="controls">
                                      <select id="startday" name="startday">
                                        <option>all</option>
                                        <option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                        <option>13</option>
                                        <option>14</option>
                                        <option>15</option>
                                        <option>16</option>
                                        <option>17</option>
                                        <option>18</option>
                                        <option>19</option>
                                        <option>20</option>
                                        <option>21</option>
                                        <option>22</option>
                                        <option>23</option>
                                        <option>24</option>
                                        <option>25</option>
                                        <option>26</option>
                                        <option>27</option>
                                        <option>28</option>
                                        <option>29</option>
                                        <option>30</option>
                                        <option>31</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-1 col-md-1">日</div>
                              </div>
                              

                              <div >
                                 <label class="control-label" for="starttime">截至时间:</label>
                              </div>
                              <div class="row">
                                  <div class="col-xs-1 col-md-2">
                                    <!--<input type="text" class="form-control" name="endyear" id="endyear">-->
                                    <div class="controls">
                                      <select id="endyear" name="endyear">
                                        <option>all</option>
                                        <option>2014</option>
                                        <option>2015</option>
                                        <option>2016</option>
                                        <option>2017</option>
                                        <option>2018</option>
                                        <option>2019</option>
                                        <option>2020</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-1 col-md-1">年</div>
                                  <div class="col-xs-1 col-md-2">
                                    <!--<input type="text" class="form-control" name="endmonth" id="endmonth">-->
                                    <div class="controls">
                                      <select id="endmonth" name="endmonth">
                                        <option>all</option>
                                        <option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-1 col-md-1">月</div>
                                  <div class="col-xs-1 col-md-2">
                                    <!--<input type="text" class="form-control" name="endday" id="endday">-->
                                    <div class="controls">
                                      <select id="endday" name="endday">
                                        <option>all</option>
                                        <option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                        <option>13</option>
                                        <option>14</option>
                                        <option>15</option>
                                        <option>16</option>
                                        <option>17</option>
                                        <option>18</option>
                                        <option>19</option>
                                        <option>20</option>
                                        <option>21</option>
                                        <option>22</option>
                                        <option>23</option>
                                        <option>24</option>
                                        <option>25</option>
                                        <option>26</option>
                                        <option>27</option>
                                        <option>28</option>
                                        <option>29</option>
                                        <option>30</option>
                                        <option>31</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xs-1 col-md-1">日</div>
                              </div>
                        </div>

                        <!--
                        <div class="form-group">
                          <label for="sex">性别</label>
                          <input type="text" class="form-control" name="sex" id="sex" onchange="check(this)">
                        </div>-->
                        
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