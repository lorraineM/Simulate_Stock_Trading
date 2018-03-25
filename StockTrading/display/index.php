<?php include('connectsql.php');?>
<?php session_start();
//if(isset($_GET['id'])){
  if($_GET['id'] == 'logout'){
	   $_SESSION['user_name'] = '';
	   echo '<script>location.href="index.php"</script>';
  }
//}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="bengy">
    <!-- TODO: 方式title的logo
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
-->
    <title>股票信息发布系统</title>
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
    <script type="text/javascript" src="jquery.js"></script>
    <script src="index.js"></script>
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container">

      <div class="header">

        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="index.php">首页</a></li>
		  <?php
      //if(isset($_SESSION['user_name'])){
		      $username = $_SESSION['user_name'];
		      if($username){
			     echo '<li><a href="change.php">修改个人信息</a></li>';
			     echo '<li><a href="change_pw.php">密码修改</a></li>';
			     echo '<li><a href="update.php">用户升级</a></li>';
          //}
		  }?>
        </ul>
        <h3 class="text-muted">Welcome</h3>
        <div class="user">
		<?php
    //if(isset($_SESSION['user_name'])){
		  $username = $_SESSION['user_name'];
		  if($username){
			   echo '<span>'.$username.'</span> &nbsp;&nbsp;';
			   echo '<a href="index.php?id=logout"><span>退出</span></a>';
      }
      else{
        echo '<a href="login.php"><span>登陆</span></a>';
      }
		//}
		 ?>
        </div>

      </div>
<!-- TODO :ajax-->
<?php require('query.php'); ?>

      <div class="searchpan">
        <form class="form-inline" action="" method="GET">
         <div>
          <input class="form-control" type="text" <?php echo 'value="'.$cont.'"'?> placeholder="输入股票代码或名称" name="cont" autofocus>
          <input class="btn btn-default" type="submit" value="搜索">
         </div>
        </form>
      </div>
   
      <div class="row marketing">
        <div class="refresh">
          <span class="glyphicon glyphicon-repeat"></span>
          
          <?php echo '<a href="./index.php?'.$_SERVER["QUERY_STRING"].'" ><span id="refresh">刷新</span></a>';?>
        </div>
        <div id="inner">
          <!-- TODO:ajax -->
        <table class="table table-striped">
          <thead>
            <th>股票代码</th>
            <th>股票名称</th>
            <th>最高价</th>
            <th>最低价</th>
            <th>成交量</th>
            <th>最近成交时间</th>
          </thead>
          <tbody>
            <?php
              foreach($allitem as $eachvalue){
                ?>
                <tr>
                  <td><?php 
				echo '<a href="/StockTrading/display/k/k/five.php?'.$eachvalue['uid'].'">';
			?><?php echo $eachvalue['uid'];?></td> 
                  <td><?php echo $eachvalue['name'];?></td>
                  <td><?php echo $eachvalue['highprice'];?></td>
                  <td><?php echo $eachvalue['lowprice'];?></td>
                  <td><?php echo $eachvalue['number'];?></td>
                  <td><?php echo $eachvalue['time'];?></td>
                </tr> 
                <?php
              }
            ?>
          </tbody>
        </table>

        </div>
      </div>
      <div class="pickpage" >
        <?php 
        //if(isset($totalpage)){
          if($page>1) $lastpage = $page-1;
          else $lastpage = 1;
          echo '<a class="enable" href="./index.php?page='.$lastpage.'&cont='.$cont.'">上一页</a>';
          if($totalpage < 11){
            forpage($page, $cont, 0, $totalpage);
          }
          else{
            if($page>4&&$page<$totalpage-4){
              displayhead();
              forpage($page, $cont, $page-2,$page+1);
              displayend($totalpage);
            }
            else if($page<4){
              forpage($page, $cont, 0, 4);
              displayend($totalpage);
            }
            else{
              displayhead();
              forpage($page, $cont, $totalpage-4, $totalpage);
            }
          }    
          if($page<$totalpage) $nextpage = $page+1;
          else $nextpage = $totalpage;
          echo '<a class="enable" href="./index.php?page='.$nextpage.'&cont='.$cont.'">下一页</a>';
      //  }
        ?>
      <?php
        function forpage($pagenumber ,$origininput, $head, $end){
          for($i=$head;$i<$end;$i++){
            if($i+1 == $pagenumber)
              echo '<a class="disable">'.$pagenumber.'</a>';
            else
              prpage($i+1, $origininput);
          }
        }
        function prpage($pagenumber, $origininput){
          echo '<a class="enable" href="./?page='.$pagenumber.'&cont='.$origininput.'">'.$pagenumber.'</a>';
        }
        function displayhead(){
          echo '<a class="enable" href="./?page=1&cont='.$cont.'">1</a>';
          echo '<span class="disable">...</span>';
        }
        function displayend($totalpage){
          echo '<span class="disable">...</span>';
          echo '<a class="enable" href="./?page='.$totalpage.'&cont='.$cont.'">'.$totalpage.'</a>';
        }
      ?>
      </div>
      <div class="footer">
        <p>&copy; S2-Team5</p>
		      <li style="margin:0px"><a href="/StockTrading/acco_home">证券账户管理</a></li>
          <li><a href="/StockTrading/fund">资金账户管理</a></li>
          <li><a href="http://localhost/StockTrading/client/login.php">交易客户端</a></li>
          <li><a href="http://localhost/StockTrading/display/index.php">网上信息发布</a></li>
      </div>
    </div>
  </body>
</html>
