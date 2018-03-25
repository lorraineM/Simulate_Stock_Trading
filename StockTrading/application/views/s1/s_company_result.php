<!doctype html>
<html lang="zn-cn">
<head>
<meta charset="utf-8">
<title>操作结果</title>
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
<link href="http://localhost/StockTrading/resources/s1/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<style type="text/css">
	body{
	
		margin-left:auto;
		margin-right:auto;
	}
	.box_right{
	min-height:0;
	box-shadow: 0 0 10px #BDBDBD;
	-webkit-box-shadow: 0 0 10px #BDBDBD;
	-moz-box-shadow: 0 0 10px #BDBDBD;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	padding:20px;
	width:600px;
	margin-left:auto;
	margin-right:auto;
	}
	.button_box{
		margin-top:15px;
	}
</style>
</head>

<body>
<h2  class="text-primary" align="center">操作成功！</h2>
<label></label>
<div class="col-sm-offset-3 box_right">
	<table class="table table-hover">
		<tr>
			<td>股票账户号码</td>
			<td><?php echo "{$stocknum}"; ?></td>
		</tr> 		
	
	
		<tr>
			<td>法人注册登记号码</td>
			<td><?php echo "{$regisnum}"; ?></td>
		</tr> 		
	
	
		<tr>
			<td>营业执照号码</td>
			<td><?php echo "{$bus_license}"; ?></td>
		</tr> 		
	
	
		<tr>
			<td>法人身份证号码</td>
			<td><?php echo "{$aid}"; ?></td>
		</tr> 	

		<tr>
			<td>法人姓名</td>
			<td><?php echo "{$aname}"; ?></td>
		</tr> 	

		<tr>
			<td>法人联系电话</td>
			<td><?php echo "{$atel}"; ?></td>
		</tr> 	

		<tr>
			<td>法人联系地址</td>
			<td><?php echo "{$aaddress}"; ?></td>
		</tr> 


		<tr>
			<td>授权人联系电话</td>
			<td><?php echo "{$gtel}"; ?></td>
		</tr> 

		<tr>
			<td>授权人地址</td>
			<td><?php echo "{$gaddress}"; ?></td>
		</tr>
	</table>
 </div>	

   <div class="button_box">
  <p align="center"><a href="http://127.0.0.1/StockTrading/select" class="btn btn-primary btn-lg  active" role="button">确 认 返 回</a></p>   	
</div> 	  	
	
</body>

</html>