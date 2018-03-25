<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>欢迎界面</title>
<base href="<?php  echo base_url();?>"/>
<link href="resources/s1/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="resources/s1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="resources/s1/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
<link href="resources/s1/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="col-sm-offset-1">
  <h1 class="col-sm-offset-1 text-primary"><strong>欢迎登陆<strong><small class="text-primary">证券账户系统</small></h1>
  <label></label>
   <h3 class="col-sm-offset-1 text-info"><strong>证券账户系统功能介绍</strong></h3>
   <label></label>
  <dl class="col-sm-offset-1 dl-horizontal">
    <dt  class="text-info"><a href="register">证券账户注册</a></dt>
    <dd class="text-muted">提供自然人证券账户和法人证券账户的注册功能。</dd>
  </dl>
  <dl class="col-sm-offset-1 dl-horizontal">
    <dt class="text-info"><a href="account_cancel">证券账户注销</a></dt>
    <dd class="text-muted">提供自然人证券账户和法人证券账户的注销功能，需要提供股票账户号码和身份证号码。</dd>
  </dl>
  <dl class="col-sm-offset-1 dl-horizontal">
    <dt  class="text-info"><a href="select">证券账户查询/修改</a></dt>
    <dd class="text-muted">提供自然人证券账户和法人证券账户的查询和修改信息功能。</dd>
  </dl>
  <dl class="col-sm-offset-1 dl-horizontal">
    <dt class="text-info"><a href="lost">证券账户挂失/补办</a></dt>
    <dd class="text-muted">提供自然人证券账户和法人证券账户的挂失和补办功能，挂失期满10天后才能进行补办操作。</dd>
  </dl>
  

  <h5 class="col-sm-offset-1 text-info"><strong>请点击上方导航条选择您所需要的功能</strong></h5>

 <div class="form-group">
      <div class="col-sm-offset-4 col-sm-4">
        <label> </label>
          <button type="submit" class="btn btn-primary btn-sm btn-block" onclick="javascript:window.location.href='s1/login_controllers/login_out'">退出登录</button>
        </div>
    </div>
</div>
</body>
</html>