<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>证券账户注销</title>
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
<script src="resources/s1/js/select.js" charset="utf-8">
</script>
<script src="resources/s1/js/check.js" charset="utf-8">
</script>
<style type="text/css">
#person{
	display:block;
}
#legal{
	display:none;
}
.box{
  min-height:0;
  box-shadow: 0 0 10px #BDBDBD;
  -webkit-box-shadow: 0 0 10px #BDBDBD;
  -moz-box-shadow: 0 0 10px #BDBDBD;
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  padding-top:20px;
  padding-bottom:20px;
}
</style>
</head>

<body>
<div class="container">
<div class="box">
<form class="form-horizontal" role="form" action="s1/cancel_controllers/cancel" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="inputsel" class="col-sm-3 control-label">请选择账户类型</label>
		<div class="col-sm-8">
			<div class="col-sm-4">
				<label class="control-label">
  					<input type="radio" name="sel" id="inputsel" value="person" onClick="sele('person','legal')" checked> 个人账户注销
 				</label>
 				
 			</div>
 			<div class="col-sm-4">
 				<label class="control-label">
   					<input type="radio" name="sel" id="inputsel" value="legal" onClick="sele('legal','person')"> 法人账户注销
   				</label>
   			</div>
   		</div>
	</div>
	<div id="person">
		<div class="form-group">
    		<label for="stock_num_person" class="col-sm-3 control-label">股票账户号码</label>
    		<div class="col-sm-8">
      			<input type="text" class="form-control" id="stock_num_person"  name="stock_num_person" placeholder="股票账户号码" onKeyUp="check_stock_num_person(this.value)"/><span id="warn_stock_num_person"></span><br/>
    		</div>
		</div>
		<div class="form-group">
    		<label for="id_person" class="col-sm-3 control-label">身份证号码</label>
    		<div class="col-sm-8">
      			<input type="text" class="form-control" id="inputss"  name="id_person" placeholder="身份证号码" onKeyUp="check_id_person(this.value)"/><span id="warn_id_person"></span><br/>
    		</div>
		</div>
	</div>
	<div id="legal">
		<div class="form-group">
    		<label for="stock_num_legalw" class="col-sm-3 control-label">股票账户号码</label>
    		<div class="col-sm-8">
      			<input type="text" class="form-control" id="stock_num_legal"  name="stock_num_legal" placeholder="股票账户号码" onKeyUp="check_stock_num_legal(this.value)"/><span id="warn_stock_num_legal"></span><br/>
    		</div>
		</div>
		<div class="form-group">
    		<label for="inputssw" class="col-sm-3 control-label">身份证号码</label>
    		<div class="col-sm-8">
      			<input type="text" class="form-control" id="inputssw"  name="id_legal" placeholder="身份证号码" onKeyUp="check_id_legal(this.value)"/><span id="warn_id_legal"></span><br/>
    		</div>
		</div>
	</div>

	<div class="form-group">
    	<div class="col-sm-offset-3 col-sm-6">
    		<label> </label>
      		<button type="submit" class="btn btn-primary btn-lg btn-block">确认</button>
      	</div>
      	
  	</div>
  </form> 
</div> 
</div>
</body>
</html>