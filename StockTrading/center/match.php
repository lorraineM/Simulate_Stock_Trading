<?php
	include 'connect.php';
	$v = array("stock_id"=>"XXX","num"=>10,"price"=>8,"user_id"=>"BBBBBB");

	sales_match($v);
	
	function purchase_match($v){
		$match_info =array();
		$stock_id=$v['stock_id'];
		$timee=$v['time'];
		$uid=$v['user_id'];
		$result = mysql_query("SELECT * FROM sales_list where stock_id='$stock_id' ORDER BY price, time");
		$check= mysql_num_rows($result);
		//如果没有对应的股票ID匹配，则将信息INSERT到purchase列表中
		if($check==0){			
			$SQL="INSERT INTO purchase_list VALUES (NULL, '".$v['stock_id']."','".$v['num']."','".$v['price']."','".$v['user_id']."',CURRENT_TIMESTAMP".",'$timee'".")";
			echo $SQL;
			mysql_query("$SQL");
		}
		//如果有匹配，则进行。
		else{
			//一个匹配，直接进行
			if($check==1){
				$row = mysql_fetch_array($result);
				//如果数量相等并且价格合适
				if(($v['num']==$row['num'])&&($v['price']>=$row['price'])){
					$price=($v['price']+$row['price'])*1.0/2;
					$SQL="INSERT INTO transaction_list VALUES (NULL, '".$v['user_id']."','".$row['user_id']."','".$v['stock_id']."','".$v['num']."','".$price."',CURRENT_TIMESTAMP".")";
					mysql_query("$SQL");
					$id=mysql_insert_id();
					$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
					$ro = mysql_fetch_array($re);
					array_push($match_info, array("purcase_user_id"=>$v['user_id'],"sales_user_id"=>$row['user_id'],"num"=>$v['num'],"price"=>$price,"stock_id"=>$v['stock_id'],"time"=>$ro['time']));
					
					$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);
					if(mysql_num_rows($re)!=0){
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']+$v['num']*$price)/($ro['num']+$v['num']);
						$unum=$ro['num']+$v['num'];
						$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
						echo $SQL;
						mysql_query("$SQL");
					}
					else{
						$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$v['num']."','".$price."')";
						echo $SQL;
						mysql_query("$SQL");						
					}
					$suid=$row['user_id'];
					$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);	
					$ro=mysql_fetch_array($re);
					$new_cost=($ro['num']*$ro['cost']-$v['num']*$price)/($ro['num']-$v['num']);
					$unum=$ro['num']-$v['num'];
					$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
					mysql_query("$SQL");					

					$SQL = "DELETE FROM sales_list WHERE stock_id = '".$stock_id ."'";
					mysql_query("$SQL");					
				}
				else if(($v['num']<$row['num'])&&($v['price']>=$row['price'])){
					echo "yes";
					$new_num=$row['num']-$v['num'];
					$SQL = "UPDATE sales_list SET num = $new_num WHERE stock_id = '".$stock_id ."'";
					mysql_query("$SQL");
					$price=($v['price']+$row['price'])*1.0/2;
					$SQL="INSERT INTO transaction_list VALUES (NULL, '".$v['user_id']."','".$row['user_id']."','".$v['stock_id']."','".$v['num']."','".$price."',CURRENT_TIMESTAMP".")";
					mysql_query("$SQL");
					$id=mysql_insert_id();
					$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
					$ro = mysql_fetch_array($re);
					array_push($match_info, array("purcase_user_id"=>$v['user_id'],"sales_user_id"=>$row['user_id'],"num"=>$v['num'],"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time']));

					$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);
					if(mysql_num_rows($re)!=0){
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']+$v['num']*$price)/($ro['num']+$v['num']);
						$unum=$ro['num']+$v['num'];
						$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
						echo $SQL;
						mysql_query("$SQL");
					}
					else{
						$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$v['num']."','".$price."')";
						echo $SQL;
						mysql_query("$SQL");						
					}
					$suid=$row['user_id'];
					$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);	
					$ro=mysql_fetch_array($re);
					$new_cost=($ro['num']*$ro['cost']-$v['num']*$price)/($ro['num']-$v['num']);
					$unum=$ro['num']-$v['num'];
					$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
					mysql_query("$SQL");	
					
					
				}
				else if(($v['num']>$row['num'])&&($v['price']>=$row['price'])){
					$new_num=$v['num']-$row['num'];
					$SQL = "DELETE FROM sales_list WHERE stock_id = '".$stock_id ."'";
					mysql_query("$SQL");
					$SQL="INSERT INTO purchase_list VALUES (NULL, '".$v['stock_id']."','".$new_num."','".$v['price']."','".$v['user_id']."',CURRENT_TIMESTAMP".",'$timee'".")";
					mysql_query("$SQL");
					$price=($v['price']+$row['price'])*1.0/2;
					$SQL="INSERT INTO transaction_list VALUES (NULL, '".$v['user_id']."','".$row['user_id']."','".$v['stock_id']."','".$row['num']."','".$price."',CURRENT_TIMESTAMP".")";
					mysql_query("$SQL");
					$id=mysql_insert_id();
					$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
					$ro = mysql_fetch_array($re);
					array_push($match_info, array("purcase_user_id"=>$v['user_id'],"sales_user_id"=>$row['user_id'],"num"=>$row['num'],"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time']));	

					$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);
					if(mysql_num_rows($re)!=0){
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']+$row['num']*$price)/($ro['num']+$row['num']);
						$unum=$ro['num']+$row['num'];
						$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
						echo $SQL;
						mysql_query("$SQL");
					}
					else{
						$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$row['num']."','".$price."')";
						echo $SQL;
						mysql_query("$SQL");						
					}
					$suid=$row['user_id'];
					$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);	
					$ro=mysql_fetch_array($re);
					$new_cost=($ro['num']*$ro['cost']-$row['num']*$price)/($ro['num']-$row['num']);
					$unum=$ro['num']-$row['num'];
					$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
					mysql_query("$SQL");
					
				}
				else{
					$SQL="INSERT INTO purchase_list VALUES (NULL, '".$v['stock_id']."','".$v['num']."','".$v['price']."','".$v['user_id']."',CURRENT_TIMESTAMP".")";
					mysql_query("$SQL");				
				}
			}
			//多于一个匹配，按价格排序
			else{
				$num_remain=$v['num'];
				while($row = mysql_fetch_array($result)){
					$price=$row['price'];
					$time=$row['time'];
					if($v['price']<$row['price']) break;
					if($num_remain==$row['num']){					
						$price=($v['price']+$row['price'])*1.0/2;
						$SQL="INSERT INTO transaction_list VALUES (NULL, '".$v['user_id']."','".$row['user_id']."','".$v['stock_id']."','".$num_remain."','".$price."',CURRENT_TIMESTAMP".")";
						mysql_query("$SQL");
						$id=mysql_insert_id();
						$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
						$ro = mysql_fetch_array($re);
						array_push($match_info, array("purcase_user_id"=>$v['user_id'],"sales_user_id"=>$row['user_id'],"num"=>$num_remain,"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time']));

						$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);
						if(mysql_num_rows($re)!=0){
							$ro=mysql_fetch_array($re);
							$new_cost=($ro['num']*$ro['cost']+$num_remain*$price)/($ro['num']+$num_remain);
							$unum=$ro['num']+$num_remain;
							$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
							echo $SQL;
							mysql_query("$SQL");
						}
						else{
							$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$num_remain."','".$price."')";
							echo $SQL;
							mysql_query("$SQL");						
						}
						$suid=$row['user_id'];
						$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);	
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']-$num_remain*$price)/($ro['num']-$num_remain);
						$unum=$ro['num']-$num_remain;
						$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
						mysql_query("$SQL");
						
						$num_remain=0;
						$SQL = "DELETE FROM sales_list WHERE stock_id = '$stock_id' and price=$price and time='$time'";
						mysql_query("$SQL");						
						break;
					}
					else if($num_remain<$row['num']){
						$new_num=$row['num']-$num_remain;
						$SQL = "UPDATE sales_list SET num = $new_num WHERE stock_id = '$stock_id' and price=$price and time='$time'";
						mysql_query("$SQL");
						$price=($v['price']+$row['price'])*1.0/2;
						$SQL="INSERT INTO transaction_list VALUES (NULL, '".$v['user_id']."','".$row['user_id']."','".$v['stock_id']."','".$num_remain."','".$price."',CURRENT_TIMESTAMP".")";
						mysql_query("$SQL");
						$id=mysql_insert_id();
						$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
						$ro = mysql_fetch_array($re);
						array_push($match_info, array("purcase_user_id"=>$v['user_id'],"sales_user_id"=>$row['user_id'],"num"=>$num_remain,"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time']));

						$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);
						if(mysql_num_rows($re)!=0){
							$ro=mysql_fetch_array($re);
							$new_cost=($ro['num']*$ro['cost']+$num_remain*$price)/($ro['num']+$num_remain);
							$unum=$ro['num']+$num_remain;
							$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
							echo $SQL;
							mysql_query("$SQL");
						}
						else{
							$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$num_remain."','".$price."')";
							echo $SQL;
							mysql_query("$SQL");						
						}
						$suid=$row['user_id'];
						$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);	
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']-$num_remain*$price)/($ro['num']-$num_remain);
						$unum=$ro['num']-$num_remain;
						$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
						mysql_query("$SQL");
											
						$num_remain=0;
						break;
					}
					else{
						$num_remain_old=$num_remain;
						$num_remain=$num_remain-$row['num'];
						$SQL = "DELETE FROM sales_list WHERE stock_id = '$stock_id' and price=$price and time='$time'";
						mysql_query("$SQL");
						$price=($v['price']+$row['price'])*1.0/2;
						$SQL="INSERT INTO transaction_list VALUES (NULL, '".$v['user_id']."','".$row['user_id']."','".$v['stock_id']."','".$row['num']."','".$price."',CURRENT_TIMESTAMP".")";
						mysql_query("$SQL");	
						$id=mysql_insert_id();
						$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
						$ro = mysql_fetch_array($re);
						array_push($match_info, array("purcase_user_id"=>$v['user_id'],"sales_user_id"=>$row['user_id'],"num"=>$row['num'],"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time']));

						$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);
						if(mysql_num_rows($re)!=0){
							$ro=mysql_fetch_array($re);
							$new_cost=($ro['num']*$ro['cost']+$num_remain_old*$price)/($ro['num']+$num_remain_old);
							$unum=$ro['num']+$num_remain_old;
							$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
							echo $SQL;
							mysql_query("$SQL");
						}
						else{
							$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$num_remain_old."','".$price."')";
							echo $SQL;
							mysql_query("$SQL");						
						}
						$suid=$row['user_id'];
						$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);	
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']-$num_remain_old*$price)/($ro['num']-$num_remain_old);
						$unum=$ro['num']-$num_remain_old;
						$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
						mysql_query("$SQL");						
	
					}					
				}
				if($num_remain!=0){
					$SQL="INSERT INTO purchase_list VALUES (NULL, '".$v['stock_id']."','".$num_remain."','".$v['price']."','".$v['user_id']."',CURRENT_TIMESTAMP".",'$timee'".")";
					mysql_query("$SQL");
				}
			}
		}
		return $match_info;
	}

	function sales_match($v){
		$match_info =array();
		$stock_id=$v['stock_id'];
		$timee=$v['time'];
		
		$result = mysql_query("SELECT * FROM purchase_list where stock_id='$stock_id' ORDER BY price, time");
		$check= mysql_num_rows($result);
		//如果没有对应的股票ID匹配，则将信息INSERT到purchase列表中
		if($check==0){			
			$SQL="INSERT INTO sales_list VALUES (NULL, '".$v['stock_id']."','".$v['num']."','".$v['price']."','".$v['user_id']."',CURRENT_TIMESTAMP".",'$timee'".")";
			echo $SQL;
			mysql_query("$SQL");
		}
		//如果有匹配，则进行。
		else{
			//一个匹配，直接进行
			if($check==1){
				$row = mysql_fetch_array($result);
				$uid=$row['user_id'];
				//如果数量相等并且价格合适
				if(($v['num']==$row['num'])&&($v['price']<=$row['price'])){

					$price=($v['price']+$row['price'])*1.0/2;
					$SQL="INSERT INTO transaction_list VALUES (NULL, '".$row['user_id']."','".$v['user_id']."','".$v['stock_id']."','".$v['num']."','".$price."',CURRENT_TIMESTAMP".")";
					mysql_query("$SQL");
					$id=mysql_insert_id();
					$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
					$ro = mysql_fetch_array($re);
					array_push($match_info, array("purcase_user_id"=>$row['user_id'],"sales_user_id"=>$v['user_id'],"num"=>$v['num'],"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time']));

					$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);
					if(mysql_num_rows($re)!=0){
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']+$v['num']*$price)/($ro['num']+$v['num']);
						$unum=$ro['num']+$v['num'];
						$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
						echo $SQL;
						mysql_query("$SQL");
					}
					else{
						$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$v['num']."','".$price."')";
						echo $SQL;
						mysql_query("$SQL");						
					}
					$suid=$v['user_id'];
					$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);	
					$ro=mysql_fetch_array($re);
					$new_cost=($ro['num']*$ro['cost']-$v['num']*$price)/($ro['num']-$v['num']);
					$unum=$ro['num']-$v['num'];
					$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
					mysql_query("$SQL");	
					
					$SQL = "DELETE FROM purchase_list WHERE stock_id = '".$stock_id ."'";
					mysql_query("$SQL");				
				}
				else if(($v['num']<$row['num'])&&($v['price']<=$row['price'])){
					$new_num=$row['num']-$v['num'];
					echo $new_num;
					$SQL = "UPDATE purchase_list SET num = $new_num WHERE stock_id = '".$stock_id ."'";
					echo $SQL;
					mysql_query("$SQL");
					$price=($v['price']+$row['price'])*1.0/2;
					$SQL="INSERT INTO transaction_list VALUES (NULL, '".$row['user_id']."','".$v['user_id']."','".$v['stock_id']."','".$v['num']."','".$price."',CURRENT_TIMESTAMP".")";
					mysql_query("$SQL");
					$id=mysql_insert_id();
					$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
					$ro = mysql_fetch_array($re);
					array_push($match_info, array("purcase_user_id"=>$row['user_id'],"sales_user_id"=>$v['user_id'],"num"=>$v['num'],"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time']));

					$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);
					if(mysql_num_rows($re)!=0){
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']+$v['num']*$price)/($ro['num']+$v['num']);
						$unum=$ro['num']+$v['num'];
						$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
						echo $SQL;
						mysql_query("$SQL");
					}
					else{
						$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$v['num']."','".$price."')";
						echo $SQL;
						mysql_query("$SQL");						
					}
					$suid=$v['user_id'];
					$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);	
					$ro=mysql_fetch_array($re);
					$new_cost=($ro['num']*$ro['cost']-$v['num']*$price)/($ro['num']-$v['num']);
					$unum=$ro['num']-$v['num'];
					$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
					mysql_query("$SQL");	
					
				}
				else if(($v['num']>$row['num'])&&($v['price']<=$row['price'])){
					$new_num=$v['num']-$row['num'];
					$SQL = "DELETE FROM purchase_list WHERE stock_id = '".$stock_id ."'";
					mysql_query("$SQL");
					$SQL="INSERT INTO sales_list VALUES (NULL, '".$v['stock_id']."','".$new_num."','".$v['price']."','".$v['user_id']."',CURRENT_TIMESTAMP".",'$timee'".")";
					mysql_query("$SQL");
					$price=($v['price']+$row['price'])*1.0/2;
					$SQL="INSERT INTO transaction_list VALUES (NULL, '".$row['user_id']."','".$v['user_id']."','".$v['stock_id']."','".$row['num']."','".$price."',CURRENT_TIMESTAMP".")";
					mysql_query("$SQL");
					$id=mysql_insert_id();
					$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
					$ro = mysql_fetch_array($re);
					array_push($match_info, array("purcase_user_id"=>$row['user_id'],"sales_user_id"=>$v['user_id'],"num"=>$row['num'],"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time']));

					$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);
					if(mysql_num_rows($re)!=0){
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']+$row['num']*$price)/($ro['num']+$row['num']);
						$unum=$ro['num']+$row['num'];
						$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
						echo $SQL;
						mysql_query("$SQL");
					}
					else{
						$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$row['num']."','".$price."')";
						echo $SQL;
						mysql_query("$SQL");						
					}
					$suid=$v['user_id'];
					$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
					$re=mysql_query($SQL);	
					$ro=mysql_fetch_array($re);
					$new_cost=($ro['num']*$ro['cost']-$row['num']*$price)/($ro['num']-$row['num']);
					$unum=$ro['num']-$row['num'];
					$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
					mysql_query("$SQL");					
				}
				else{
					$SQL="INSERT INTO sales_list VALUES (NULL, '".$v['stock_id']."','".$v['num']."','".$v['price']."','".$v['user_id']."',CURRENT_TIMESTAMP".",'$timee'".")";
					mysql_query("$SQL");				
				}
			}
			//多于一个匹配，按价格排序
			else{
				$num_remain=$v['num'];
				$uid=$row['user_id'];
				while($row = mysql_fetch_array($result)){
					$price=$row['price'];
					$time=$row['time'];
					if($v['price']>$row['price']) break;
					if($num_remain==$row['num']){					

						$price=($v['price']+$row['price'])*1.0/2;
						$SQL="INSERT INTO transaction_list VALUES (NULL, '".$row['user_id']."','".$v['user_id']."','".$v['stock_id']."','".$num_remain."','".$price."',CURRENT_TIMESTAMP".")";
						mysql_query("$SQL");
						$id=mysql_insert_id();
						$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
						$ro = mysql_fetch_array($re);
						array_push($match_info, array("purcase_user_id"=>$row['user_id'],"sales_user_id"=>$v['user_id'],"num"=>$num_remain,"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time']));

						$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);
						if(mysql_num_rows($re)!=0){
							$ro=mysql_fetch_array($re);
							$new_cost=($ro['num']*$ro['cost']+$num_remain*$price)/($ro['num']+$num_remain);
							$unum=$ro['num']+$num_remain;
							$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
							echo $SQL;
							mysql_query("$SQL");
						}
						else{
							$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$num_remain."','".$price."')";
							echo $SQL;
							mysql_query("$SQL");						
						}
						$suid=$v['user_id'];
						$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);	
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']-$num_remain*$price)/($ro['num']-$num_remain);
						$unum=$ro['num']-$num_remain;
						$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
						mysql_query("$SQL");
						
						$num_remain=0;
						$SQL = "DELETE FROM purchase_list WHERE stock_id = '$stock_id' and price=$price and time='$time'";
						mysql_query("$SQL");
						break;
					}
					else if($num_remain<$row['num']){
						$new_num=$row['num']-$num_remain;
						$SQL = "UPDATE purchase_list SET num = $new_num WHERE stock_id = '$stock_id' and price=$price and time='$time'";
						mysql_query("$SQL");
						$price=($v['price']+$row['price'])*1.0/2;
						$SQL="INSERT INTO transaction_list VALUES (NULL, '".$row['user_id']."','".$v['user_id']."','".$v['stock_id']."','".$num_remain."','".$price."',CURRENT_TIMESTAMP".")";
						mysql_query("$SQL");
						$id=mysql_insert_id();
						$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
						$ro = mysql_fetch_array($re);
						array_push($match_info, array("purcase_user_id"=>$row['user_id'],"sales_user_id"=>$v['user_id'],"num"=>$num_remain,"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time']));	

						$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);
						if(mysql_num_rows($re)!=0){
							$ro=mysql_fetch_array($re);
							$new_cost=($ro['num']*$ro['cost']+$num_remain*$price)/($ro['num']+$num_remain);
							$unum=$ro['num']+$num_remain;
							$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
							echo $SQL;
							mysql_query("$SQL");
						}
						else{
							$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$num_remain."','".$price."')";
							echo $SQL;
							mysql_query("$SQL");						
						}
						$suid=$v['user_id'];
						$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);	
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']-$num_remain*$price)/($ro['num']-$num_remain);
						$unum=$ro['num']-$num_remain;
						$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
						mysql_query("$SQL");
						
						$num_remain=0;
						break;
					}
					else{
						$num_remain_old=$num_remain;
						$num_remain=$num_remain-$row['num'];
						$SQL = "DELETE FROM purchase_list WHERE stock_id = '$stock_id' and price=$price and time='$time'";
						mysql_query("$SQL");
						$price=($v['price']+$row['price'])*1.0/2;
						$SQL="INSERT INTO transaction_list VALUES (NULL, '".$row['user_id']."','".$v['user_id']."','".$v['stock_id']."','".$row['num']."','".$price."',CURRENT_TIMESTAMP".")";
						mysql_query("$SQL");	
						$id=mysql_insert_id();
						$re = mysql_query("SELECT time FROM transaction_list where t_id=$id");
						$ro = mysql_fetch_array($re);
						array_push($match_info, array("purcase_user_id"=>$row['user_id'],"sales_user_id"=>$v['user_id'],"num"=>$row['num'],"price"=>$row['price'],"stock_id"=>$v['stock_id'],"time"=>$ro['time']));	

						$SQL="SELECT * FROM relation_list WHERE user_id='$uid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);
						if(mysql_num_rows($re)!=0){
							$ro=mysql_fetch_array($re);
							$new_cost=($ro['num']*$ro['cost']+$num_remain_old*$price)/($ro['num']+$num_remain_old);
							$unum=$ro['num']+$num_remain_old;
							$SQL = "UPDATE relation_list SET cost = $new_cost , num=$unum WHERE user_id='$uid' AND stock_id='$stock_id'";
							echo $SQL;
							mysql_query("$SQL");
						}
						else{
							$SQL="INSERT INTO relation_list VALUES ('".$uid."','".$stock_id."','".$num_remain_old."','".$price."')";
							echo $SQL;
							mysql_query("$SQL");						
						}
						$suid=$v['user_id'];
						$SQL="SELECT * FROM relation_list WHERE user_id='$suid' AND stock_id='$stock_id'";
						$re=mysql_query($SQL);	
						$ro=mysql_fetch_array($re);
						$new_cost=($ro['num']*$ro['cost']-$num_remain_old*$price)/($ro['num']-$num_remain_old);
						$unum=$ro['num']-$num_remain_old;
						$SQL = "UPDATE relation_list SET num=$unum WHERE user_id='$suid' AND stock_id='$stock_id'";
						mysql_query("$SQL");						
	
					}					
				}
				if($num_remain!=0){
					$SQL="INSERT INTO sales_list VALUES (NULL, '".$v['stock_id']."','".$num_remain."','".$v['price']."','".$v['user_id']."',CURRENT_TIMESTAMP".")";
					mysql_query("$SQL");
				}
			}
		}
		return $match_info;
	}


	
?>