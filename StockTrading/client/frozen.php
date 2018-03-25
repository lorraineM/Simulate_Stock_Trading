<?php
    function db_connect() {
        $result = new mysqli('localhost', 'trader', "programmer", "StockTrading");   //连接数据库
        if (!$result) {
            throw new Exception('Could not connect to database server');      // 报错
            // 若不需要，去掉即可
        } else {
            return $result;
        }
    }
function trade_frozen($price, $fid) {
        $conn = db_connect();
        $result = $conn->query("select * from rate order by currency");   // µÃµ½»ãÂÊ
        $rates = array();
        while ($row=$result->fetch_assoc()) {               // °´Ë³ÐòµÃµ½»ãÂÊÊý×é
            $rates[$row['currency']] = $row['exchange_rate'];
        }
        $sql = "select * from currency where fid =".strval($fid)." order by types";  // µÃµ½¸Ã×Ê½ðÕË»§ÏêÏ¸µÄ×Ê½ðÐÅÏ¢
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {            // ¸ÃÕË»§ÓÐ×Ê½ð
            $currency = array();
            $num = 0;
            $avail = 0;
            while ($row = $result->fetch_assoc()) {               // °´Ë³ÐòµÃµ½»ãÂÊÊý×é
                $currency[$num++] = $row;
                $avail = $avail + $row['available']*$rates[$row['types']];     // ×ª»»³ÉÈËÃñ±Ò£¬ÀÛ¼Ó¸÷±ÒÖÖµÄ»ãÂÊ
            }
            if ($avail < $price) {
                return false;             // ×Ê½ð²»¹»
            } else {                      // ¶³½áÏàÓ¦×Ê½ð
                $amount = $price;        // ÐèÒªµÄ×Ê½ð
                foreach ($currency as $key => $value) {
                    if ($value['available'] >= $amount/$rates[$value['types']]) {      // µ±Ç°±ÒÖÖ¿ÉÒÔÂú×ãËùÐè×Ê½ð
                        $sql = "update currency set available=available-".strval($amount/$rates[$value['types']])." ,
                                frozen=frozen+".strval($amount/$rates[$value['types']])." where fid= ".$fid."
                                and types=".$value['types'];            // ¶³½á¸Ã±ÒÖÖµÄ¹ºÂò¹ÉÆ±µÄ×Ê½ð
                        $conn->query($sql);
                        break;
                    } else {
                        $amount = $amount - $value['available']*$rates[$value['types']];   // ¼õÈ¥µ±Ç°±ÒÖÖ¿ÉÖ§¸¶µÄ×Ê½ð
                        $sql = "update currency set available=0 ,frozen=frozen+".strval($value['available'])." "."
                                where fid=".$fid." and types=".$value['types'];
                        $conn->query($sql);            // ¶³½á¸Ã±ÒÖÖµÄ¹ºÂò¹ÉÆ±µÄ×Ê½ð
                    }
                }
                return true;
            }
        } else {                               // ¸ÃÕË»§ÎÞ×Ê½ð
            return false;
        }
    }


    function trade_cancel($price, $fid) {
        $conn = db_connect();
        $result = $conn->query("select * from rate order by currency");   // 得到汇率
        $rates = array();
        while ($row=mysqli_fetch_array($result)) {               // 按顺序得到汇率数组
            $rates[$row['currency']] = $row['exchange_rate'];
        }
        $sql = "select * from currency where fid =".strval($fid)." order by types";  // 得到该资金账户详细的资金信息
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {            // 该账户有资金
            $amount = $price;             // 需要的资金
            while ($row = $result->fetch_assoc()) {
                if ($row['frozen'] >= $amount/$rates[$row['types']]) {    // 当前币种的冻结资金可以满足所需资金
                    $sql = "update currency set available=available+".strval($amount/$rates[$row['types']])." ,
                            frozen=frozen-".strval($amount/$rates[$row['types']])." where fid= ".$fid."
                            and types=".$row['types'];            // 恢复该币种的购买股票的冻结资金
                    $conn->query($sql);
                    break;
                } else {
                    $amount = $amount - $row['frozen']*$rates[$row['types']];   // 减去当前币种冻结的资金
                    $sql = "update currency set frozen=0 ,available=available+".strval($row['frozen'])." "."
                            where fid=".$fid." and types=".$row['types'];
                    $conn->query($sql);            // 恢复该币种的购买股票的冻结资金
                }
            }
            return true;
        } else {                               // 该账户无资金
            return false;
        }
    }

?>
