<?php

/**
* @param the instruction id of the instruction to be queried.
* @param instr_type: the type of the instruction to be canceled, i.e. buy(0) or sale(1)
* @return errorCode of the operation. 0: succeeded  1: failed
*/
function cancel($stock_id, $price, $time, $num, $user_id, $instr_type){

	//connect the database
	$conn = @mysql_connect("localhost","trader","programmer");
	//If fails to connect, show error.
	if (!$conn){
	    die("连接数据库失败：" . mysql_error());
	}

	//select the database
	mysql_select_db("StockTrading", $conn);

	// Construct the sql upate clause
	if ($stock_id == -1) {
		$query = mysql_query("DELETE FROM purchase_list");
		if (!$query) return 1;

		$query = mysql_query("DELETE FROM sales_list");
		if (!$query) return 1;
	}
	else {
		if ($instr_type == 0) {
			$query = mysql_query("DELETE FROM purchase_list WHERE stock_id = '$stock_id' AND price = $price AND num = $num AND user_id = '$user_id' AND timee = '$time'");
			echo "DELETE FROM sales_list WHERE stock_id = '$stock_id' AND price = $price AND num = $num AND user_id = '$user_id' AND timee = '$time'";
			echo "|".$query;
		}
		else {
			$query = mysql_query("DELETE FROM sales_list WHERE stock_id = '$stock_id' AND price = $price AND num = $num AND user_id = '$user_id' AND timee = '$time'");
			echo "DELETE FROM sales_list WHERE stock_id = '$stock_id' AND price = $price AND num = $num AND user_id = '$user_id' AND timee = '$time'";
			echo "|".$query;
		}
		if (!$query) return 1;
	}

	// return the result
	return 0;
}

//$response = cancel(-1);
//echo "";

?>
