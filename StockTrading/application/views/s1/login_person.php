<!doctype html>
<html lang="zn-cn">
<head>
<meta charset="utf-8">
<title>自然人注册</title>
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/style.css" rel="stylesheet" type="text/css">
<script src="http://localhost/StockTrading/resources/s1/js/hide.js"></script>
<script src="http://localhost/StockTrading/resources/s1/js/search_id.js"></script>
<style type="text/css">
	body{
		width:600px;
		margin-left:auto;
		margin-right:auto;
	}

</style>
</head>

<body>
<form class="form-horizontal" role="form" action="s1/hregister/insert_account" method="post">
	<div class="form-group">
    	<label for="inputid" class="col-sm-3 control-label">身份证号</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" class="text" id="inputid" placeholder="身份证号" name="id" onKeyUp="searchid(this.value)"><span id="test_id"></span>
    	</div>
  	</div>
  
<div class="form-group">
      <label for="inputid" class="col-sm-3 control-label">身份证号</label>
      <div class="col-sm-8">
          <input type="text" class="form-control" class="text" id="inputid" placeholder="身份证号" name="id" onKeyUp="searchid(this.value)"><span id="test_id"></span>
      </div>
    </div>

    <div class="form-group">
      <label for="inputid" class="col-sm-3 control-label">身份证号</label>
      <div class="col-sm-8">
          <input type="text" class="form-control" class="text" id="inputid" placeholder="身份证号" name="id" onKeyUp="searchid(this.value)"><span id="test_id"></span>
      </div>
    </div>

    <div class="form-group">
      <label for="inputid" class="col-sm-3 control-label">身份证号</label>
      <div class="col-sm-8">
          <input type="text" class="form-control" class="text" id="inputid" placeholder="身份证号" name="id" onKeyUp="searchid(this.value)"><span id="test_id"></span>
      </div>
    </div>

	<div class="form-group">
    	<label for="inputname" class="col-sm-3 control-label">姓名</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputname"  name="name" placeholder="姓名">
    	</div>
	</div>

	<div class="form-group">
		<label for="inputsex" class="col-sm-3 control-label">性别</label>
		<div class="col-sm-8">
			<div class="col-sm-6">
				<label class="control-label">
  					<input type="radio" name="sex" id="inputsex" value="male" checked> 男

 				</label>
 				
 			</div>
 			<div class="col-sm-6">
 				<label class="control-label">
   					<input type="radio" name="sex" id="inputsex" value="female" > 女	
   				</label>
   			</div>
   		</div>
	</div>

	<div class="form-group">
    	<label for="inputel" class="col-sm-3 control-label">联系电话</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputel"  name="tel" placeholder="联系电话">
    	</div>
	</div>

	<div class="form-group">
    	<label for="inputedu" class="col-sm-3 control-label">学历</label>
    	<div class="col-sm-8">
    		<label  class="control-label">
    			<div class="col-xs-30" >
    				<select name="edu" id="inputedu" class="form-control">
					<option value="初中学历及以下" >初中及以下</option>
					<option value="高中或者中专学历">高中或者中专</option>
					<option value="大专学历" >大专</option>
					<option value="本科学历">本科</option>
					<option value="本科以上学历">本科以上学历 包含硕士研究生学历、博士研究生学历</option>
					</select>
				</div>
			</label>
    	</div>
	</div>

	<div class="form-group">
    	<label for="inputaddress" class="col-sm-3 control-label">家庭地址</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputaddress"  name="address" placeholder="家庭地址">
    	</div>
	</div>

	<div class="form-group">
    	<label for="inputprofession" class="col-sm-3 control-label">职业</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputprofession"  name="profession" placeholder="职业">
    	</div>
	</div>

	<div class="form-group">
    	<label for="inputwork" class="col-sm-3 control-label">工作单位</label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="inputwork"  name="work" placeholder="工作单位">
    	</div>
	</div>

	<div class="form-group">
		<label for="inputagency" class="col-sm-3 control-label">是否代办</label>
		<div class="col-sm-8">
			<div class="col-sm-6">
				<label class="control-label">
  					<input type="radio" name="agency" id="inputagency" value="y" onClick="display('hide')" > 是

 				</label>
 				
 			</div>
 			<div class="col-sm-6">
 				<label class="control-label">
   					<input type="radio" name="agency" id="inputagency" value="n" onClick="hide('hide')" checked> 否	
   				</label>
   			</div>
   		</div>
	</div>

	<div id="hide" style="display:none">
		<div class="form-group">
    		<label for="inputaname" class="col-sm-3 control-label">代办人姓名</label>
    		<div class="col-sm-8">
      			<input type="text" class="form-control" id="inputaname"  name="aname" placeholder="代办人姓名">
    		</div>
		</div>
		<div class="form-group">
    		<label for="inputaid" class="col-sm-3 control-label">代办人身份证</label>
    		<div class="col-sm-8">
      			<input type="text" class="form-control" id="inputaid"  name="aid" placeholder="代办人姓名">
    		</div>
		</div>
	</div>
	
	<div class="form-group">

    	<div class="col-sm-offset-1 col-sm-2">
      		<button type="submit" class="btn btn-primary btn-lg btn-block">注册</button>
      </div>
  </div>
</form>
</body>
</html>
