<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>登陆界面</title>
<link href="resources/s1/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="resources/s1/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
<script src="resources/s1/js/check.js" charset="utf-8"></script>
</heade>
<body>
<div class="container">
<div class="col-lg-3">
<h3 class="text-primary"><a href="/StockTrading/acco_home">证券账户管理</a></h3>
<h3 class="text-primary"><a href="/StockTrading/fund">资金账户管理</a></h3>
<h3 class="text-primary"><a href="http://localhost/StockTrading/client/login.php">交易客户端</a></h3>
<h3 class="text-primary"><a href="http://localhost/StockTrading/display/index.php">网上信息发布</a></h3>
</div>
<div class="col-lg-9">
<form class="form-horizontal" role="form" action="s1/login_controllers/login" method="post">
	<div class="form-group">
    	<label for="inputid" class="col-sm-3 control-label">用户名</label>
    	<div class="col-sm-5">
      		<input type="text" class="form-control" class="text" id="inputid" placeholder="用户名" name="id"><br/>
    	</div>
  	</div>
  
	<div class="form-group">
    	<label for="inputname" class="col-sm-3 control-label">密码</label>
    	<div class="col-sm-5">
      		<input type="password" class="form-control" id="inputname"  name="pass" placeholder="密码"onKeyUp="check_pass(this.value)"/><span id="pass"></span><br/> 
    	</div>
	</div>

	<div class="form-group">

    	<div class="col-sm-offset-3 col-sm-5">
    		<label> </label>
      		<button type="submit" class="btn btn-primary btn-lg btn-block">登陆</button>
      
      	</div>
  	</div> 
</form>
</div>
</div>
</body>
</html>