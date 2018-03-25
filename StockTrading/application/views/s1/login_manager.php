<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>管理员登陆界面</title>
<style type="text/css">
	.box_submit{
		margin-top: 30px;
		margin-left: 120px;
		width: 80px;
		height: 30px;
		float: left;
		background: #636363;
		color: #FFFFFF;
		font-weight: normal;
		font-size: x-large;
		font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
		text-align:center;
	}
	.box{
		width:960px;
		height:60px;
	}
	.box_right{
		height:30px;
		margin-top:10px;
		float:left;
	}
	.box_left{
		margin-top: 15px;
		width: 80px;
		height: 20px;
		float: left;
		text-align: justify;
		text-justify : distribute-all-lines;
		color: #B9B9B9;
		font-family: Constantia, "Lucida Bright", "DejaVu Serif", Georgia, serif;
		font-weight: 900;
	}
</style>
</head>

<body>
<form action="s1/home/manager_login" method="post">
<div class="box">
	<div class="box_left">
    	用户名 :
    </div>
    <div class="box_right">
    	<input type="text" name="name" id="in"/>
    </div>
</div>
<div class="box">
	<div class="box_left">
    	密 码:
    </div>
    <div class="box_right">
    	<input type="text" name="secret" id="in"/>
    </div>
</div>
<div class="box_submit">
	<input type="submit" value="提交" /> 
</div>
</form>
</body>
</html>