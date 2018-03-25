<html>
<body>
<?php
// some code

define("YUC_LOG_TYPE", "1,2,3,4,5,6"); //日志级别
define("M_PRO_DIR", "./"); //日志目录
define("FILE_APPEND", 1); //是否追加


function Write($msg, $level) {
    $arr_level = explode(',', YUC_LOG_TYPE);
    if (in_array($level, $arr_level)) {
        $record = date('Y-m-d H:m:s') . " >>> " . number_format(microtime(TRUE), 5, ".", "") . ' ' . " : " . $level . "\t" . $msg;
        $base = M_PRO_DIR . "/Log";
        $dest = $base . "/" . 'log.php';
        if (!file_exists($dest)) {
            @mkdir($base, 0777, TRUE);
            @file_put_contents($dest, "<?php die('Access Defined!');?>\r\n", FILE_APPEND);
        }
        if (file_exists($dest)) {
            @file_put_contents($dest, $record . "\r\n", FILE_APPEND);
        }
    }
}

$stock_id = $_POST["name"];
$trade_type = $_POST["type"];
$price = $_POST["price"];
$time = $_POST["time"];
//echo $time;
//&stock_id=abc&type=purchase&price=21&time=2014-12-11&num=100&user_id=iflee
//&stock_id=abc&trade_type=purchase&price=21&time=2014-12-11&num=100&user_id=iflee
//D:\Apache\bin>ab -n200 -c200 -v4 -p "post.txt" -T 'application/x-www-form-unlenc
//oded' http://localhost:8080/file/fu/get_info.php/
$num = $_POST["num"];
$user_id = $_POST["user_id"];
require 'query.php';
require 'cancel.php';
require 'match.php';
if($trade_type == "purchase"){
	$v = array("stock_id"=>$stock_id,"num"=>$num,"price"=>$price,"user_id"=>$user_id,"time"=>$time);
	$purchase_info = purchase_match($v);
	//var_dump($purchase_info);
	 $purchase_out = "";
    foreach ($purchase_info as $temp){
        foreach($temp as $t){
            echo $t;
            $purchase_out = $purchase_out." ".$t;
        }
    }
     Write($purchase_out,2);
        //Write($temp,2);
	//purchase_info is a 2-dimension array
	//"purcase_user_id"=>$v['user_id'],"sales_user_id"=>$row['usr_id'],"num"=>$row['num'],"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time'])
}
elseif($trade_type == 'sales'){
	$v = array("stock_id"=>$stock_id,"num"=>$num,"price"=>$price,"user_id"=>$user_id,"time"=>$time);
	$sales_info = sales_match($v);
    $sales_out = "";
    foreach ($sales_info as $temp){
        foreach($temp as $t){
            echo $t;
            $sales_out = $sales_out." ".$t;
           
        }
    }
     Write($sales_out,2);
	//Write('$sales_info',2);
}
elseif($trade_type == "delete_sale"){
	$cancel_info = cancel($stock_id,$price,$time,$num,$user_id, 1);
	$deletesales_out = "".$stock_id." ".$price." ".$time." ".$num." ".$user_id;
    Write($deletesales_out,2);
	//return 0 of cancel
}
elseif($trade_type == "delete_purchase"){
	$cancel_info = cancel($stock_id,$price,$time,$num,$user_id, 0);
    $deletepurchase_out = "".$stock_id." ".$price." ".$time." ".$num." ".$user_id;
    Write($deletepurchase_out,2);
	//return 0 of cancel
}
else{
	$query_info = query($stock_id);
	echo $query_info[0]." ";
	echo $query_info[1];
	//$query_info is an array
	//array($average_price,$total_num)
}
/*****
$purchase_curl = curl_init();
curl_setopt($purchase_curl, CURLOPT_URL, 'http://localhost/~iflee/client.php');
curl_setopt($purchase_curl, CURLOPT_POST, true);
curl_setopt($purchase_curl, CURLOPT_POSTFIELDS, $purchase_out);
curl_setopt($purchase_curl, CURLOPT_RETURNTRANSFER, true);
$purchae_str = curl_exec($purchase_curl);
curl_close($purchase_curl);
//echo $purchase_str;

$sales_curl = curl_init();
curl_setopt($sales_curl, CURLOPT_URL, 'http://localhost/~iflee/client.php');
curl_setopt($sales_curl, CURLOPT_POST, true);
curl_setopt($sales_curl, CURLOPT_POSTFIELDS, $sales_out);
curl_setopt($sales_curl, CURLOPT_RETURNTRANSFER, true);
$sales_str = curl_exec($sales_curl);
curl_close($sales_curl);
//echo $sales_str;

$cancelp_curl = curl_init();
curl_setopt($cancelp_curl, CURLOPT_URL, 'http://localhost/~iflee/client.php');
curl_setopt($cancelp_curl, CURLOPT_POST, true);
$cancelp_result = "result=".$deletepurchase_out;
curl_setopt($cancelp_curl, CURLOPT_POSTFIELDS, $cancelp_result);
curl_setopt($cancelp_curl, CURLOPT_RETURNTRANSFER, true);
$cancel_str = curl_exec($cancelp_curl);
curl_close($cancelp_curl);
//echo $cancel_str;

***/
//to s2-5,change the url
$query_curl = curl_init();
curl_setopt($query_curl, CURLOPT_URL, 'http://localhost/StockTrading/display/k/k/get.php');
curl_setopt($query_curl, CURLOPT_POST, true);
curl_setopt($query_curl, CURLOPT_POSTFIELDS, $query_info);
$sql = 'insert into test values($query_info)';
mysql_query($sql);
curl_setopt($query_curl, CURLOPT_RETURNTRANSFER, true);
$query_str = curl_exec($query_curl);
curl_close($query_curl);
//echo $query_str
//s******/

//echo $ID;

//<form action="search.php" method="post">
//mysqli_close($con);
?>

</body>
</html>