<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>账户挂失</title>
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
	body{
		width:560px;
		margin-left:auto;
		margin-right:auto;
	}
</style>
</head>

<body>
<form class="form-horizontal" role="form" action="s1/Lhome/manage_loss" method="post">

	<div class="form-group">
		<label for="inputlagency" class="col-sm-3 control-label">请选择补办类型</label>
		<div class="col-sm-8">
			<div class="col-sm-4">
				<label class="control-label">
  					<input type="radio" name="lagency" id="inputlagency" value="1" checked> 个人账户挂失

 				</label>
 				
 			</div>
 			<div class="col-sm-4">
 				<label class="control-label">
   					<input type="radio" name="lagency" id="inputlagency" value="0" > 法人账户挂失
   				</label>
   		</div>

   			<div class="col-sm-4">
 				<label class="control-label">
   					<input type="radio" name="lagency" id="inputlagency" value="-1" > 取消挂失	
   				</label>
   			</div>
   		</div>
	</div>


	<div class="form-group">
    	<label for="inputlid" class="col-sm-3 control-label">请输入证件号码</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputlid"  name="lid" placeholder="身份证号码">
    	</div>
	</div>


	<div class="form-group">
    	<div class="col-sm-offset-3 col-sm-6">
    		<label> </label>
      		<button type="submit" class="btn btn-primary btn-lg btn-block">确认</button>
      	</div>
      	
  	</div>
</form>

</body>
</html>