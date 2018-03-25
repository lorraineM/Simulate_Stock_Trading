<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>法人注册</title>
<link href="resources/s1/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="resources/s1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="resources/s1/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
<link href="resources/s1/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="resources/s1/css/style.css" rel="stylesheet" type="text/css">
<script src="resources/s1/js/hide.js"></script>
<script src="resources/s1/js/search_id.js"></script>
<style type="text/css">
	body{
		width:600px;
		margin-left:auto;
		margin-right:auto;
	}
</style>
</head>

<body>
<form class="form-horizontal" role="form" action="s1/home/insert_account_company" method="post">
	<div class="form-group">
    	<label for="inputregisnum" class="col-sm-3 control-label">法人注册登记号</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputregisnum"  name="regisnum" placeholder="法人注册登记号码">
    	</div>
	</div>

	<div class="form-group">
    	<label for="inputbus_license" class="col-sm-3 control-label">营业执照号码</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputbus_license"  name="bus_license" placeholder="营业执照号码">
    	</div>
	</div>

  	<div class="form-group">
    	<label for="inputaid" class="col-sm-3 control-label">法人身份证号码</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" class="text" id="inputaid" placeholder="法人身份证号码" name="aid" onKeyUp="searchid(this.value)"><span id="test_id"></span>
    	</div>
  	</div>

  	<div class="form-group">
    	<label for="inputaname" class="col-sm-3 control-label">法人姓名</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputaname"  name="aname" placeholder="法人姓名">
    	</div>
	</div>

	<div class="form-group">
    	<label for="inputatel" class="col-sm-3 control-label">法人联系电话</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputatel"  name="atel" placeholder="法人联系电话">
    	</div>
	</div>

	<div class="form-group">
    	<label for="inputaaddress" class="col-sm-3 control-label">法人联系地址</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputaaddress"  name="aaddress" placeholder="法人联系地址">
    	</div>
	</div>

	<div class="form-group">
    	<label for="inputename" class="col-sm-3 control-label">授权执行人姓名</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputename"  name="ename" placeholder="授权证券交易执行人姓名">
    	</div>
	</div>

	<div class="form-group">
    	<label for="inputgid" class="col-sm-3 control-label">授权人身份证号</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputgid"  name="gid" placeholder="授权人有效身份证号码">
    	</div>
	</div>

	<div class="form-group">
    	<label for="inputgtel" class="col-sm-3 control-label">授权人联系电话</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputgtel"  name="gtel" placeholder="授权人联系电话">
    	</div>
	</div>

	<div class="form-group">
    	<label for="inputgaddressl" class="col-sm-3 control-label">授权人地址</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputgaddress"  name="gaddress" placeholder="授权人地址">
    	</div>
	</div>

	<div class="form-group">
    	<div class="col-sm-offset-3 col-sm-6">
    		<label> </label>
      		<button type="submit" class="btn btn-primary btn-lg btn-block">有本事你点我！</button>
      	</div>
  	</div>

</form>
</body>
</html>
