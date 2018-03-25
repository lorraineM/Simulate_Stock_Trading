<?php
// Remark:       0 人民币  1 美元  2 港币      3 欧元      4 英镑
//               5 日元    6 澳元  7 加拿大元  8 瑞士法郎  9 新加坡元

    //连接数据库
    function db_connect() {
        $result = new mysqli('localhost', 'trader', 'programmer', 'StockTrading');   //连接数据库
        if (!$result) {
            throw new Exception('Could not connect to database server');      // 报错
            // 若不需要，去掉即可
        } else {
            return $result;
        }
    }

    // S3
    // 返回冻结资金的总金额
    function get_frozen($fid) {
        $conn = db_connect();
        $result = $conn->query("select * from rate order by currency");   // 得到汇率
        $rates = array();
        while ($row=$result->fetch_assoc()) {               // 按顺序得到汇率数组
            $rates[$row['currency']] = $row['exchange_rate'];
        }
        $sql = "select * from currency where fid =".strval($fid)." order by types";  // 得到该资金账户详细的资金信息
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {            // 该账户有资金
            $frozen = 0;
            while ($row = $result->fetch_assoc()) {               // 按顺序得到汇率数组
                $frozen = $frozen + $row['frozen']*$rates[$row['types']];     // 转换成人民币，累加各币种的汇率
            }
            return $frozen;
        } else {            // 该账户无资金
            return 0;
        }
    }

    // S3
    // 判断是否能满足购买股票的资金，能，按币种冻结相应资金，不能，返回false
    function trade_frozen($price, $fid) {
        $conn = db_connect();
        $result = $conn->query("select * from rate order by currency");   // 得到汇率
        $rates = array();
        while ($row=$result->fetch_assoc()) {               // 按顺序得到汇率数组
            $rates[$row['currency']] = $row['exchange_rate'];
        }
        $sql = "select * from currency where fid =".strval($fid)." order by types";  // 得到该资金账户详细的资金信息
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {            // 该账户有资金
            $currency = array();
            $num = 0;
            $avail = 0;
            while ($row = $result->fetch_assoc()) {               // 按顺序得到汇率数组
                $currency[$num++] = $row;
                $avail = $avail + $row['available']*$rates[$row['types']];     // 转换成人民币，累加各币种的汇率
            }
            if ($avail < $price) {
                return false;             // 资金不够
            } else {                      // 冻结相应资金
                $amount = $price;        // 需要的资金
                foreach ($currency as $key => $value) {
                    if ($value['available'] >= $amount/$rates[$value['types']]) {      // 当前币种可以满足所需资金
                        $sql = "update currency set available=available-".strval($amount/$rates[$value['types']])." ,
                                frozen=frozen+".strval($amount/$rates[$value['types']])." where fid= ".$fid."
                                and types=".$value['types'];            // 冻结该币种的购买股票的资金
                        $conn->query($sql);
                        break;
                    } else {
                        $amount = $amount - $value['available']*$rates[$value['types']];   // 减去当前币种可支付的资金
                        $sql = "update currency set available=0 ,frozen=frozen+".strval($value['available'])." "."
                                where fid=".$fid." and types=".$value['types'];
                        $conn->query($sql);            // 冻结该币种的购买股票的资金
                    }
                }
                return true;
            }
        } else {                               // 该账户无资金
            return false;
        }
    }


    // S4
    // 扣除购买股票的冻结资金
    function trade_deal($price, $fid) {
        $conn = db_connect();
        $result = $conn->query("select * from rate order by currency");   // 得到汇率
        $rates = array();
        while ($row=$result->fetch_assoc()) {               // 按顺序得到汇率数组
            $rates[$row['currency']] = $row['exchange_rate'];
        }
        $sql = "select * from currency where fid =".strval($fid)." order by types";  // 得到该资金账户详细的资金信息
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {            // 该账户有资金
            $amount = $price;             // 需要的资金
            while ($row = $result->fetch_assoc()) {
                if ($row['frozen'] >= $amount/$rates[$row['types']]) {    // 当前币种的冻结资金可以满足所需资金
                    $sql = "update currency set amount=amount-".strval($amount/$rates[$row['types']])." ,
                            frozen=frozen-".strval($amount/$rates[$row['types']])." where fid= ".$fid."
                            and types=".$row['types'];            // 扣除该币种的购买股票的冻结资金
                    $conn->query($sql);
                    break;
                } else {
                    $amount = $amount - $row['frozen']*$rates[$row['types']];   // 减去当前币种可冻结的资金
                    $sql = "update currency set frozen=0 ,amount=amount-".strval($row['frozen'])." "."
                            where fid=".$fid." and types=".$row['types'];
                    $conn->query($sql);            // 扣除该币种的购买股票的冻结资金
                }
            }
            return true;
        } else {                               // 该账户无资金
            return false;
        }
    }

    // S4
    // 恢复购买股票的冻结资金
    function trade_cancel($price, $fid) {
        $conn = db_connect();
        $result = $conn->query("select * from rate order by currency");   // 得到汇率
        $rates = array();
        while ($row=$result->fetch_assoc()) {               // 按顺序得到汇率数组
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




    // S1 CI model
    // 当证券账户更改时，更新资金账户
    public function update_fund($sid, $newsid)
    {
        $sql='SELECT sid FROM fund_account WHERE sid = ?';       // 选择出原来的sid的资金账户
        $query = $this->db->query($sql,array($sid));
        $res=$query->num_rows();
        if($res>0){
            $row = $query->row();
            $row->sid = $newsid;                                // 更新 sid
            $this->db->where('sid',$sid);
            $this->db->update('fund_account',$row);
        }
    }

?>





