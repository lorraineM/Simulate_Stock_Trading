<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<base href="<?php  echo base_url();?>"/>
		<link rel="stylesheet" type="text/css" href="resources/s2/css/mycss.css" />
		<link rel="stylesheet" type="text/css" href="resources/s2/css/bootstrap.min.css" />
		<script type="text/javascript" src="resources/s2/js/jquery.min.js"></script>
		<title>资金账户管理子系统:请求详细</title>
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
			form#checkreqform{
				width:800px;
				height: 200px;
			}
			input#reason{
				width:560px;
				height: 150px;
				border-radius: 8px;
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
						<div>

							<ul class="nav nav-list bs-docs-sidenav affix-top" style="margin-left:10px">
								<li><h4>管理员</h4></li>
								<li><h5><?php echo $agid?></h5></li>
								<h4>登陆时间</h4>
								<h5><?php echo $logintime?></h5>
							</ul>
						</div>
					</div>
				</div>

				<div class="col-md-9" role="main" style="background-color:#ffffff">
					<div class="docs-section">
						<div class="page-header"><h2 id="main_title">查看请求详细信息</h2></div>
						<?php if($ck==1){?>
						<table class="table table-bordered table-striped" style="width:550">
							<thead>
								<tr>
									<th style="width:260px">请求流水号</th>
									<th style="width:260px"><?php echo $rid?></th>
								</tr>
								<tr>
									<th style="width:260px">资金账户卡号</th>
									<th style="width:260px"><?php echo str_pad($fid,16,0,STR_PAD_LEFT)?></th>
								</tr>
								<tr>
									<th style="width:260px">资金账户所有者(个人/公司)</th>
									<th style="width:260px"><?php echo $idc?></th>
								</tr>
								<tr>
									<th style="width:260px">请求类型</th>
									<th style="width:260px"><?php echo $types?></th>
								</tr>
								<tr>
									<th style="width:260px">请求发出日期</th>
									<th style="width:260px"><?php echo $cdate?></th>
								</tr>
							</thead>
						</table>
						<?php }else{ echo '对不起，您查看的请求不存在或者已处理'; }?>
					</div>

					<div class="docs-section">
						<div class="page-header"><h2 id="main_title">审批请求</h2></div>
						<?php if($ck==1){?>
						<form id="checkreqform" action="/StockTrading/fund/fund_checkreq" method="post" class="js-search-form hidden-xs">
							<input id="reason" name="reason" value="证件齐全，情况属实">
							<input type="hidden" name="rid" value=<?php echo $rid?>>
							<input type="hidden" name="fid" value=<?php echo $fid?>>
							<input type="hidden" name="type" value=<?php echo $types?>>

							<input name="ag" class="mkey_btn btn btn-danger btn-lg" type="submit" value="批准" style="border-color:#ffffff">
							<input name="ag" class="mkey_btn btn btn-primary btn-lg" type="submit" value="拒绝" style="border-color:#ffffff">
						</form>
						<?php }else;?>
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
