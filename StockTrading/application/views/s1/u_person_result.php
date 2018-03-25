<!doctype html>
<html>
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
			<td>修改时间</td>
			<td><?php echo "{$t}"; ?></td>
		</tr> 		
	
	
		<tr>
			<td>身份证号码</td>
			<td><?php echo "{$id}"; ?></td>
		</tr> 		
	
	
		<tr>
			<td>姓名</td>
			<td><?php echo "{$name}"; ?></td>
		</tr> 	

		<tr>
			<td>性别</td>
			<td><?php echo "{$sex}"; ?></td>
		</tr> 	

		<tr>
			<td>联系电话</td>
			<td><?php echo "{$tel}"; ?></td>
		</tr> 	

		<tr>
			<td>教育背景</td>
			<td><?php echo "{$edu}"; ?></td>
		</tr> 

		<tr>
			<td>家庭联系</td>
			<td><?php echo "{$address}"; ?></td>
		</tr> 

		<tr>
			<td>职业</td>
			<td><?php echo "{$profession}"; ?></td>
		</tr> 

		<tr>
			<td>工作单位</td>
			<td><?php echo "{$work}"; ?></td>
		</tr> 
	</table>
 </div>	
 <div class="button_box">
  <p align="center"><a href="http://127.0.0.1/StockTrading/select" class="btn btn-primary btn-lg  active" role="button">确 认 返 回</a></p>   	
</div>
  	


</body>
</html>