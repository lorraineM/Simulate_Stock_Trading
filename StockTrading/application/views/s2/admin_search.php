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
		<title>资金账户管理子系统:搜索结果</title>
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
						<div class="page-header"><h2 id="main_title">查看账户详细信息</h2></div>
						<?php if($ck==1){?>
						<table class="table table-bordered table-striped" style="width:550">
							<thead>
								<tr class='success'>
									<th style="width:360px">资金账户卡号</th>
									<th style="width:360px"><?php echo str_pad($fid,16,0,STR_PAD_LEFT)?></th>
								</tr>
								<tr>
									<th style="width:360px">所属证券账户</th>
									<th style="width:360px"><?php echo $sid?></th>
								</tr>
								<tr>
									<th style="width:360px">资金账户所有者(个人/公司)</th>
									<th style="width:360px"><?php echo $idc?></th>
								</tr>
								<tr>
									<th style="width:360px">资金账户托管经纪商</th>
									<th style="width:360px"><?php echo $agid?></th>
								</tr>
								<tr>
									<th style="width:360px">资金账户状态</th>
									<th style="width:360px"><?php echo $status?></th>
								</tr>
								<tr>
									<th style="width:360px">账户生效日期</th>
									<th style="width:360px"><?php echo $cdate?></th>
								</tr>
							</thead>
						</table>
						<div class="page-header"><h2 id="main_title">账户资金情况</h2></div>
						<table class="table table-bordered table-striped" style="width:550">
							<thead>
								<!-- 显示账户资金情况v2新增 -->
								<!--// 0 人民币1 美元2 港币3 欧元4 英镑5 日元6 澳元7 加拿大元8 瑞士法郎9 新加坡元-->
									<?php if(isset($currency)){ ?>
										<?php if($currency==true){ ?>
											
											<?php if(isset($d10)){?>
											<tr class='active'>
												<th style="width:150px">人民币</th>
												<th style="width:190px"><?php echo $d10;?></th>
												<th style="width:190px"><?php echo $d20;?></th>
												<th style="width:190px"><?php echo $d30;?></th>
											</tr><?php }?>


											<?php if(isset($d11)){?>
											<tr>
												<th style="width:150px">美元</th>
												<th style="width:190px"><?php echo $d11;?></th>
												<th style="width:190px"><?php echo $d21;?></th>
												<th style="width:190px"><?php echo $d31;?></th>
											</tr><?php }?>

											<?php if(isset($d12)){?>
											<tr class='success'>
												<th style="width:150px">港币</th>
												<th style="width:190px"><?php echo $d12;?></th>
												<th style="width:190px"><?php echo $d22;?></th>
												<th style="width:190px"><?php echo $d32;?></th>
											</tr><?php }?>


											<?php if(isset($d13)){?>
											<tr>
												<th style="width:150px">欧元</th>
												<th style="width:190px"><?php echo $d13;?></th>
												<th style="width:190px"><?php echo $d23;?></th>
												<th style="width:190px"><?php echo $d33;?></th>
											</tr><?php }?>


											<?php if(isset($d14)){?>
											<tr class='warning'>
												<th style="width:150px">英镑</th>
												<th style="width:190px"><?php echo $d14;?></th>
												<th style="width:190px"><?php echo $d24;?></th>
												<th style="width:190px"><?php echo $d34;?></th>
											</tr><?php }?>


											<?php if(isset($d15)){?>
											<tr>
												<th style="width:150px">日元</th>
												<th style="width:190px"><?php echo $d15;?></th>
												<th style="width:190px"><?php echo $d25;?></th>
												<th style="width:190px"><?php echo $d35;?></th>
											</tr><?php }?>


											<?php if(isset($d16)){?>
											<tr class='info'>
												<th style="width:150px">澳元</th>
												<th style="width:190px"><?php echo $d16;?></th>
												<th style="width:190px"><?php echo $d26;?></th>
												<th style="width:190px"><?php echo $d36;?></th>
											</tr><?php }?>

											<?php if(isset($d17)){?>
											<tr>
												<th style="width:150px">加元</th>
												<th style="width:190px"><?php echo $d17;?></th>
												<th style="width:190px"><?php echo $d27;?></th>
												<th style="width:190px"><?php echo $d37;?></th>
											</tr><?php }?>


											<?php if(isset($d18)){?>
											<tr class='danger'>
												<th style="width:150px">瑞郎</th>
												<th style="width:190px"><?php echo $d18;?></th>
												<th style="width:190px"><?php echo $d28;?></th>
												<th style="width:190px"><?php echo $d38;?></th>
											</tr><?php }?>


											<?php if(isset($d19)){?>
											<tr>
												<th style="width:150px">新加坡元</th>
												<th style="width:190px"><?php echo $d19;?></th>
												<th style="width:190px"><?php echo $d29;?></th>
												<th style="width:190px"><?php echo $d39;?></th>
											</tr><?php }?>

										<?php }else{?>
											<tr>
												<th style="width:360px">资金账户情况</th>
												<th style="width:360px"><?php echo $curr;?></th>
											</tr>

										<?php }}?>
						<?php }else{ echo '对不起，您输入的资金账户卡号有误或者您的权限不够'; }?>
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