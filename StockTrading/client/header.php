<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>header</title>
<style type="text/css">
	.header{
	background-color:#666;
	width: 100%;
	height: 153px;
	overflow: hidden;
	}
	.logo{
		height:120px;
		width:960px;
		margin-left:auto;
		margin-right:auto;
	}
	.logo_image{
		float:left;
		height:	120px;
		width: 222px;
		position:relative;
		margin-left:20px;
		overflow:hidden;
	}
	.box_login{
		margin-top:8px;
		font-size:12px;
		padding-left:10px;
		color:#C06;
		float:left;
	}
	#login_href{
		color:#F0C;
	}
	.menu {
		width: 100%;
		height: 33px;
		background-image: url(image/menu.png);
	}
	.menu_size {
		width: 1000px;
		height: 33px;
		margin-left: auto;
		margin-right: auto;
		position:relative;
	}
	.menu1 {
		text-align: center;
		width: 120px;
		height: 33px;
		color: #FFF;
		font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
		font-weight: 900;
		font-size: 20px;
		float: left;
	}
	.menu1:hover{
	background-image: url(image/menu_select.png);
	}
</style>
<script>
	function login_out()
	{
		document.cookie="Is_login=0";
		window.location.reload();
	}
</script>
</head>

<body style="margin:0 0">
<div class="header">
	<div class="logo">
    	<div class="logo_image">
	    <img src="header.jpg" width="200" height="110"  alt=""/>
        </div>
    </div>
	<div class="menu">
		<div class="menu_size">
        <a href="selectStock.php" target="_parent">
			<div class="menu1">
            	已买股票
            </div>
        </a>
        <a href="fund.php" target="_parent">
            <div class="menu1">
            	资金账户
            </div>
        </a>
		<a href="buy.php" target="_parent">
			<div class="menu1">
            	购买股票
            </div>
        </a>
		<a href="sell.php" target="_parent">
			<div class="menu1">
            	出售股票
            </div>
        </a>
		<a href="instru_cancel.php" target="_parent">
			<div class="menu1">
            	撤销指令
            </div>
        </a>
		<a href="query.php" target="_parent">
			<div class="menu1">
            	股 票
            </div>
        </a>
		<a href="change_passwd.php" target="_parent">
			<div class="menu1">
            	修改密码
            </div>
        </a>
            <div class="box_login">
            	<?php
					if (!session_id())  session_start();
					if(!isset($_SESSION['ID'])) echo "<a href='login.php' target='_parent' style='color:#fff; font-size:16px;' id='login_href'>登录资金账户</a>";
					else echo "<a href='login.php' style='color:#fff;font-size:16px;' id='login_href' type='submit'> 退 出</a>";
				?>
					<!--<script type="application/javascript">
					var Is_login=0;
					var search = "Is_login=";
            		if (document.cookie.length>0)
					{
						offset = document.cookie.indexOf(search);
						if (offset != -1)
						{ 
							offset += search.length;
							end = document.cookie.indexOf(";", offset);
							if (end == -1) end = document.cookie.length;
							Is_login = unescape(document.cookie.substring(offset, end))
						}
					}
					
					
						//document.write(" <a href='' target='_self' id='login_href' onClick='login_out()'> 退 出</a>");
					
						document.write("<a href='login.php' target='_parent' id='login_href'>  登陆资金账户 </a>");
					
				</script>
			</div>
            <div class="box_login"><a href="login.php" id='login_href' type="submit"> 退 出</a>-->
            </div>
            <!--</form>-->
		</div>  
	</div>
</div>
</body>
</html>
