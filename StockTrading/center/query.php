<?php

/**
* @param $stock_id: the stock id of the stock to be queryed.
* @return $an array with two numbers, the first is the average_price(double) 			of today,the last is the total_num(int) of today.
*/
function query($stock_id){

	//connect the database
	$conn = @mysql_connect("localhost","trader","programmer");
	//If fails to connect, show error.
	if (!$conn){
	    die("连接数据库失败：" . mysql_error());
	}

	//select the database
	mysql_select_db("StockTrading", $conn);

	//get the current date
	date_default_timezone_set('Asia/Shanghai');  //set timezone
	$current_time_minus5 = time() - 5*60;
	//echo "current_time_minus_5 is ".$current_minus5."<br/>";

	//construct the sql query
	$query = mysql_query("select * from transaction_list where stock_id='$stock_id'");

	//initialize three variables to store data
	$total_num = 0;
	$min_price = 2147483647;
	$max_price = 0;
	$min_found = false;


	//if found
	if($num = mysql_num_rows($query)){
		//fetch each result row
		while($row = mysql_fetch_array($query)){
			//get the timestamp
			$time = strtotime($row['time']);
			//echo "This time ".$row['time']." is ".$time."<br/>";

			//if this transaction is made in ealier 5 minutes
			if($time >= $current_time_minus5){
				//add the num
				$total_num += $row['num'];
				//compare the max and min
				if($row['price'] > $max_price)
					$max_price = $row['price'];
				if($row['price'] < $min_price){
					$min_price = $row['price'];
					$min_found = true;
				}
			};
		}
	}


	if(!$min_found)
		$min_price = 0;

	echo "The max_price is :".$max_price."<br>";
	echo "The min_price is :".$min_price."<br>";
	echo "The total_num is :".$total_num."<br>";

	//return the result
	return array("max_price"=>$max_price,"min_price"=>$min_price,"total_num"=>$total_num);
}

//$response = query('123456');
//echo "The average price is :".$response[0]."<br>";
//echo "The total_num is :".$response[1]."<br>";

?>
