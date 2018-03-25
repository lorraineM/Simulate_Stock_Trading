<?php 
error_reporting(E_ALL & ~ E_NOTICE);
session_id($_GET[sessionid]);
 session_start(); 
 $thissession = session_id();

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

        

        <div class="col-xs-8 col-sm-8 " >
          <div class="row">
          <table class="table" id="stocktable">
               <thead>
                <tr>
                  <th>管理员id</th>
                  <th>管理员姓名</th>
                  <th>联系方式</th>
                  <th>详细信息</th>
                  <th>掌管股票</th>
                  <th>操作记录</th>
				          <th>删除</th>
                   <th></th>
                </tr>
              </thead>
              <tbody>
              <?php 
               include("conn.php");
                $supermanager=mysqli_query($conn,"select * from administrator where isSuper!='Y'");
                $count=mysqli_query($conn,"select max(id) from administrator ");
                $count1=mysqli_fetch_array($count);
                $countstock=mysqli_query($conn,"select max(uid) from stock ");
                //var_dump($countstock);
                //echo $countstock['uid'];
                $countstock1=mysqli_fetch_array($countstock);
                //var_dump($countstock1);
                //echo $countstock1['max(uid)'];
                while($row = mysqli_fetch_array($supermanager))
                {
                  echo "<tr>";
                  echo "<td>" . $row['id'] . "</td>";
                  echo "<td>" . $row['name'] . "</td>";
                  echo "<td>" . $row['telephone'] . "</td>";
                  //echo "<td> <button type = 'button' class='btn btn-info' data-toggle='collapse'   data-target='#info" . $row['id'] . "''>详细信息</button></td>";
                  echo //"<td> <button type = 'button' class='btn btn-info' data-toggle='modal'   data-target='#adinfo" . $row['id'] . "''>详细信息</button></td>";
                      "<td>
                          <button type='button ' class='btn btn-info'>
                            <a href='showadinfo.php?id=".$row['id']."&sessionid=".session_id()."'>查看详细信息</a>
                          </button>
                      </td>
                      ";
                  echo "<td>
                            <button type='button ' class='btn btn-info'>
                            <a href='showsocketlist.php?id=".$row['id']."&sessionid=".session_id()."'>查看所管股票</a>
                            </button>
                        </td>
                          ";
                 echo "<td>
                            <button type='button ' class='btn btn-info'>
                              <a href='showlog.php?id=".$row['id']."&sessionid=".session_id()."&startmonth=all&startday=all&endmonth=all&endday=all'>操作记录</a>
                            </button>
                        </td>
                       ";
                  echo "<td>
                            <button type='button ' class='btn btn-info'>
                              <a href='deletemanager.php?id=".$row['id']."&sessionid=".session_id()."'>删除</a>
                            </button>
                        </td>
                       ";
                  echo "</tr>";
                  
                  
                  echo "<tr>";
                  echo "</tr>";
                }
              ?>
              </tbody>
          </table>
          </div>
        
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-1">
                  <a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#addstock">添加股票</a>
                </div>
             
               
                <div class="col-sm-offset-2 col-sm-1">
                   <a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#addmanager">添加管理员</a>
                </div>

				
            </div>

            <div class="modal fade" id="addstock" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">添加股票</h4>
                    </div>
                    <div class="modal-body">
                       <form role="form" method="post" action="addstock.php">
                        <!--<div class="form-group">
                          <label for="id">管理员id</label>
                          <input type="text" class="form-control" name="id" id="id">
                        </div>-->
                        <div class="control-group">
                           <label class="control-label" for="uid">股票id</label>
                           <input type="text" class="form-control" name="uid" id="uid" value="<?php $tmp = (int)$countstock1['max(uid)'] + 1;$tmp2 = '00000000'.$tmp;$str = substr($tmp2,-6);
                           echo $str;
                           //echo $countstock1['max(uid)'];
                           ?>"  readonly="readonly">
                         </div>
                        <div class="form-group">
                          <label for="name">股票名</label>
                          <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                          <label for="number">股数</label>
                          <input type="text" class="form-control" name="number" id="number">
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
            
            <div class="modal fade" id="addmanager" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">添加管理员</h4>
                    </div>
                    <div class="modal-body">
                       <form role="form" method="post" action="addmanager.php">
                        <!--<div class="form-group">
                          <label for="id">管理员id</label>
                          <input type="text" class="form-control" name="id" id="id">
                        </div>-->
                        <div class="control-group">
                           <label class="control-label" for="id">管理员id</label>
                           <input type="text" class="form-control" name="id" id="id" value="<?php $tmp = (int)$count1['max(id)'] + 1;$tmp2 = '00000000'.$tmp;$str = substr($tmp2,-6);
                           echo $str;
                           ?>"  readonly="readonly" >
                         </div>
                        <div class="form-group">
                          <label for="name">姓名</label>
                          <input type="text" class="form-control" name="name" id="name">
                        </div>

                        <div class="form-group">
                          <div class="control-group">
                            <label class="control-label" for="sex">性别</label>
                            <div class="controls">
                              <select id="sex">
                                <option>Male</option>
                                <option>Female</option>
                              </select>
                            </div>
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="idCard">身份证号码</label>
                          <input type="text" class="form-control" name="idCard" id="idCard" onchange="checkidcard(this)">
                        </div>
                        <div class="form-group">
                          <label for="address">住址</label>
                          <input type="text" class="form-control" name="address" id="address">
                        </div>
                        <div class="form-group">
                          <label for="telephone">联系电话</label>
                          <input type="text" class="form-control" name="telephone" id="telephone" onchange="checktelephone(this)">
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

      function checktelephone(telephone){
        if(!/^0?(13[0-9]|15[012356789]|18[0236789]|14[57])[0-9]{8}$/.test(telephone.value)){
        alert("请提供有效的电话号码！");
        telephone.value='';
        telephone.focus();
        }
      }



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

     //判断身份证是否有效
     function checkidcard(idCard){
        if(IdCardValidate(idCard.value)==false)
        {
          alert("请提供有效的身份证号");
          idCard.value='';
          idCard.focus();
        }
     }
     /*function checkidcard(idCard){//更简单的检测idcard的方法
        //idCard = trim(idCard.replace(/ /g, ""));               //去掉字符串头尾空格 
        if (idCard.length != 18)
        {
          alert("请输入有效的18位身份证号");
          idCard.value="";
          idCard.focus();
        }
        else if(!/^[1-9]{1}[0-9]{14}$|^[1-9]{1}[0-9]{16}([0-9]|[xX])$/.test(idCard.value)){
          alert("请输入有效的18位身份证号");
          idCard.value="";
          idCard.focus();
        }
        else{}
     }*/
      var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];    // 加权因子   
      var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];            // 身份证验证位值.10代表X   
      function IdCardValidate(idCard) { 
          idCard = trim(idCard.replace(/ /g, ""));               //去掉字符串头尾空格                     
          if (idCard.length == 15) {   
              return isValidityBrithBy15IdCard(idCard);       //进行15位身份证的验证    
          } else if (idCard.length == 18) {   
              var a_idCard = idCard.split("");                // 得到身份证数组   
              if(isValidityBrithBy18IdCard(idCard)&&isTrueValidateCodeBy18IdCard(a_idCard)){   //进行18位身份证的基本验证和第18位的验证
                  return true;   
              }else {   
                  return false;   
              }   
          } else {   
              return false;   
          }   
      }   
      /**  
       * 判断身份证号码为18位时最后的验证位是否正确  
       * @param a_idCard 身份证号码数组  
       * @return  
       */  
      function isTrueValidateCodeBy18IdCard(a_idCard) {   
          var sum = 0;                             // 声明加权求和变量   
          if (a_idCard[17].toLowerCase() == 'x') {   
              a_idCard[17] = 10;                    // 将最后位为x的验证码替换为10方便后续操作   
          }   
          for ( var i = 0; i < 17; i++) {   
              sum += Wi[i] * a_idCard[i];            // 加权求和   
          }   
          valCodePosition = sum % 11;                // 得到验证码所位置   
          if (a_idCard[17] == ValideCode[valCodePosition]) {   
              return true;   
          } else {   
              return false;   
          }   
      }   
      /**  
        * 验证18位数身份证号码中的生日是否是有效生日  
        * @param idCard 18位书身份证字符串  
        * @return  
        */  
      function isValidityBrithBy18IdCard(idCard18){   
          var year =  idCard18.substring(6,10);   
          var month = idCard18.substring(10,12);   
          var day = idCard18.substring(12,14);   
          var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));   
          // 这里用getFullYear()获取年份，避免千年虫问题   
          if(temp_date.getFullYear()!=parseFloat(year)   
                ||temp_date.getMonth()!=parseFloat(month)-1   
                ||temp_date.getDate()!=parseFloat(day)){   
                  return false;   
          }else{   
              return true;   
          }   
      }   
        /**  
         * 验证15位数身份证号码中的生日是否是有效生日  
         * @param idCard15 15位书身份证字符串  
         * @return  
         */  
        function isValidityBrithBy15IdCard(idCard15){   
            var year =  idCard15.substring(6,8);   
            var month = idCard15.substring(8,10);   
            var day = idCard15.substring(10,12);   
            var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));   
            // 对于老身份证中的你年龄则不需考虑千年虫问题而使用getYear()方法   
            if(temp_date.getYear()!=parseFloat(year)   
                    ||temp_date.getMonth()!=parseFloat(month)-1   
                    ||temp_date.getDate()!=parseFloat(day)){   
                      return false;   
              }else{   
                  return true;   
              }   
        }   
      //去掉字符串头尾空格   
      function trim(str) {   
          return str.replace(/(^\s*)|(\s*$)/g, "");   
      }  
     
      //
       
  </script>
</body>
</html>