<?php 
error_reporting(E_ALL & ~ E_NOTICE);

?>
<html>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="css/bootstrap.min.css">
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
          <a class="navbar-brand" href="#">交易系统管理子系统</a>
        </div>
          
      </div>
    </div>




    <div class="container" style="margin-left:30%">

      <div class="row row-offcanvas row-offcanvas-right">

        

        <div class="col-xs-6 col-sm-3" id="sidebar" role="navigation">
           <form role="form" method="post" action="checklogin.php">
            <div class="form-group">
              <label for="userid">管理员id</label>
              <input type="text" class="form-control" name="userid" placeholder="请输入id">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">密码</label>
              <input type="password" class="form-control" name="password" placeholder="请输入密码">
            </div>
            <button type="submit" class="btn btn-info">登录</button>
          </form>
        </div><!--/span-->
      </div><!--/row-->


     

    </div><!--/.container-->


<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>