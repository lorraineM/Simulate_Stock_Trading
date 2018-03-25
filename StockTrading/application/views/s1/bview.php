<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>账户补办</title>
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
<form  class="form-horizontal" role="form" action="s1/Bhome/manage_bban" method="post">
	<div class="form-group">
		<label for="inputbagency" class="col-sm-3 control-label">请选择补办类型</label>
		<div class="col-sm-8">
			<div class="col-sm-6">
				<label class="control-label">
  					<input type="radio" name="bagency" id="inputbagency" value="1" checked> 自然人补办

 				</label>
 				
 			</div>
 			<div class="col-sm-6">
 				<label class="control-label">
   					<input type="radio" name="bagency" id="inputbagency" value="0" > 法人补办	
   				</label>
   			</div>
   		</div>
	</div>

	<div class="form-group">
    	<label for="inputbid" class="col-sm-3 control-label">请输入证件号码</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputbid"  name="bid" placeholder="身份证号码">
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