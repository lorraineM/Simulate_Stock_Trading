<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<base href="<?php  echo base_url();?>"/>
		<link rel="stylesheet" type="text/css" href="resources/s2/css/mycss.css" />
		<link rel="stylesheet" type="text/css" href="resources/s2/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="resources/s2/css/docs.css" />
		<script type="text/javascript" src="resources/s2/js/jquery.min.js"></script>
		<title>资金账户管理子系统:管理员日志</title>
		<style type="text/css">
			header#navbar-top{
				margin-top: 2%;
				display: block;
				height: 50px;
				box-shadow:  0 2px 3px rgba(0,0,0,0.1);
				z-index: 999;
			}
			div#tbar,#tbar_contain{
				width: 100%;
				background-color: #21384b;
			}
			ul#menu{
				width: 1200px;
				margin-left: 8%;
				position: relative;
				overflow: hidden;
				text-align: top;
			}
			input#src{
				width: 260px;
				text-align: left;
				border-radius: 5px;
				line-height: 1.1;
				height: 34px;
				font-size: 13px;
			}
			div#srcgroup{
				width: 100%;
			}
			div#main{
				padding-top: 10px;
				height: 40px;
				z-index: -100;

			}
			div#s1{
				width: 100%;
			}
			div#hello_admin{
				background-color: #ebeadc;
				color: #21384b;
			}
			form.js-search-form{
				width: 420px;
				margin: 0;
				padding: 0;
			}
			input.btn-success{
				font-size:15px;
				background-color:#ec650d;
				height:32px;
				line-height:0.4;
				border-color: #21384b;
			}
			.navbar-default .navbar-nav>.active>a{
				background: #21384b;
				color:#ffffff;
			}
			.navbar .nav li{
				display: inline-block;
				float: none;
				background-color: #21384b;
			}
			.nav>li{
				position:relative;
			}

		</style>
	</head>

	<body class="admin_bk">
		<div class="sito animated fadeIn">
			<header id="navbar-top" class="banner navbar navbar-default" role="banner">
				<div id="tbar" class="pannello-affix affix" data-spy="affix" data-offset-top="79">
					<div id="tbar_contain" class="container">
						<div class="navbar-inner">
							<nav class="collapse navbar-collapse" role="navigation">
								<ul id="menu" class="nav navbar-nav">
									<li class="active menu-home">
										<a href="/StockTrading/fund/fund_admin" class="roll">
											<span data-title="adminlogout">管理员主页</span>
										</a>
									</li>
									<li class="active menu-home">
										<a href="/StockTrading/fund/fund_reqn" class="roll">
											<span data-title="request">待审请求</span>
										</a>
									</li>
									<li class="active menu-home">
										<a href="/StockTrading/fund/fund_mkey" class="roll">
											<span data-title="modekey">修改密码</span>
										</a>
									</li>
									<li class="active menu-home">
										<a href="/StockTrading/fund/fund_reqhs" class="roll">
											<span data-title="allrequest">已处理请求</span>
										</a>
									</li>
									<li class="active menu-home">
										<a href="/StockTrading/fund/fund_log" class="roll">
											<span data-title="adminlog">管理日志</span>
										</a>
									</li>
									<li class="active menu-home">
										<a href="/StockTrading/fund/fund_logout" class="roll">
											<span data-title="adminlogout">退出登陆</span>
										</a>
									</li>
									<li class="li_form"><form action="/StockTrading/fund/fund_search" class="js-search-form hidden-xs" role="search">
										<input type="hidden" name="src" value="home">
										<div class="input-group" id="srcgroup">
											<input id="src" type="text" name="searchaim" class="form-control input-lg" placeholder="请输入要查询的资金账户卡号...">&nbsp;&nbsp;
											<input class="btn btn-success btn-lg" type="submit" value="search">
										</div>
									</form></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
				<section id="side2" class="header_bottom"></section>
			</header>
		</div>



		<div class="container" id="main" style="background-color:#ffffff;margin-top:5%">
			<div class="adrow row" style="background-color:#ffffff">
				<div class="col-md-3" style="margin-top:35px">
					<div class="span3 bs-docs-sidebar" role="complementart">
							<ul class="nav nav-list bs-docs-sidenav affix-top" style="margin-left:10px">
								<?php $url='<a href="/StockTrading/fund/fund_search?src=home&searchaim='.$fid.'">';?>
								<li><?php echo $url?><i class="icon-chevron-right"></i>单个账户详细信息</a></li>

								<?php $url='<a href="/StockTrading/fund/fund_singlelog?src=home&searchaim='.$fid.'">';?>
								<li><?php echo $url?>单个账户操作日志</a></li>

								<?php $url='<a href="/StockTrading/fund/fund_singlereq?src=home&searchaim='.$fid.'">';?>
								<li><?php echo $url?>单个账户待处理请求</a></li>
							</ul>
					</div>
				</div>

				<div class="col-md-9" role="main" style="background-color:#ffffff">
					<div class="docs-section">
						<div class="page-header"><h2 id="main_title">单个账户操作日志</h2></div>
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th style="width:120px">日志流水号</th>
									<th style="width:170px">管理内容</th>
									<th style="width:140px">操作时间</th>
								</tr>
								<tbody>
									<?php
									if($ck==1)
										echo $tb;
									else;?>
								</tbody>
							</thead>
						</table>
					</div>
				</div>



			</div>
		</div>



		<script type="text/javascript">
			function chiudiNavMobile() {
				$('.navbar ul li a').click(function() {
				$('.btn-navbar').addClass('collapsed');
				$('.navbar-collapse').removeClass('in').addClass('collapse').css('height', '0');
			});
		}
		</script>
	</body>
</html>
