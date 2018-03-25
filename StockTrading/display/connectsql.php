<?php
	$DEBUG = true;
	if($DEBUG){
		$dbHandler = mysql_connect('localhost', 'trader', 'programmer');
		mysql_query('set names "utf8"');
		mysql_select_db('StockTrading',$dbHandler);
	}
	else{
		$dbHandler = null;
	}
?>