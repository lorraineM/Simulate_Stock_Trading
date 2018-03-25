<?php
	$allitem = array();
	$itemInpage = 20;
	$page = $_GET['page'];
	$cont = $_GET['cont'];
	if(!checkvalue($page)||$page<1){
		$page = 1;	//set it as first page;
	}
	if(!checkvalue($cont)){	//search all	
		//$result = mysql_query('SELECT * FROM testDBs.fortest ');	
		
		$result = mysql_query('SELECT * FROM five 
			where (uid, date, time) in (
				SELECT uid, date, max(time) FROM five
					where (uid, date) in (
						SELECT uid, max(date) FROM five group by uid
						) 
				group by uid
			)');// order by time desc limit '.($page-1)*$itemInpage.','.($page)*$itemInpage);

		$stocknum = mysql_num_rows($result);
		$result = mysql_query('SELECT * FROM five 
			where (uid, date, time) in (
				SELECT uid, date, max(time) FROM five
					where (uid, date) in (
						SELECT uid, max(date) FROM five group by uid
						) 
				group by uid
			) order by time desc limit '.($page-1)*$itemInpage.','.($page)*$itemInpage);

		formatresult($result, $allitem);
	}
	else{
		$splitstr = preg_split('/\s+/', trim($cont));
		$querystring = 'select * from five where ';
		$first = true;
		foreach($splitstr as $tosearch){
			if($first) {
				$first = false;
				$querystring = $querystring.'(';
			}
			else $querystring = $querystring.' or ';
			$querystring = $querystring.'concat(uid, name) like "%'.$tosearch.'%"';
			//echo $querystring;
		}
		$querystring = $querystring.')';
		$querystring = $querystring.' and (uid, date, time) in 
			(SELECT uid, date, max(time) FROM five 
					where (uid, date) in (
						SELECT uid, max(date) FROM five group by uid
						) 
				group by uid
			)';// order by time desc limit '.($page-1)*$itemInpage.','.($page)*$itemInpage;
		//echo $querystring.'<br>';
		$result = mysql_query($querystring);
		$stocknum = mysql_num_rows($result);
		$querystring = $querystring.' order by time desc limit '.($page-1)*$itemInpage.','.($page)*$itemInpage;
		//echo $querystring;
		$result = mysql_query($querystring);
		formatresult($result, $allitem);
	}

	$totalpage = (int)($stocknum/$itemInpage+1);

/*
	echo '<table class="table table-striped">
          <thead>
            <th>股票代码</th>
            <th>股票名称</th>
            <th>最高价</th>
            <th>最低价</th>
            <th>成交量</th>
            <th>最近成交时间</th>
          </thead>
          <tbody>'; ?>
       <?php
              foreach($allitem as $eachvalue){
                echo '<tr>
                  <td>'.$eachvalue['uid'].'</td> 
                  <td>'.$eachvalue['name'].'</td>
                  <td>'.$eachvalue['highprice'].'</td>
                  <td>'.$eachvalue['lowprice'].'</td>
                  <td>'.$eachvalue['number'].'</td>
                  <td>'.$eachvalue['time'].'</td>
                </tr>';
              }
 			?>
	<?php echo '</tbody></table>';?>
*/

	
	function formatresult($result, &$allitem){
		$i = 0;
		while($row = mysql_fetch_array($result)){	
			$allitem[$i] = array(
				'uid'=>$row['uid'],
				'name'=>$row['name'],
				'date'=>$row['date'],
				'time'=>$row['time'],
				'highprice'=>$row['highprice'],
				'lowprice'=>$row['lowprice'],
				'number'=>$row['number']
			);
			$i++;
		}
	}
	function checkvalue($value){
		if($value==null||$value=='')	return false;
		else return true;
	}
?>

