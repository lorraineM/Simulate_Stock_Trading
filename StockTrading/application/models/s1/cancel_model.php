<?php  
class cancel_model extends CI_Model{  
    function cancel_model(){  
        parent::__construct();
		$this->output->set_header("Content-Type: text/html; charset=utf-8");
		$this->load->database();	
    } 
	
	function search($table, $tab, $str)//在数据库的$table表中搜索列名为$tab值为$str的值，并返回是否存在
	{
		$result=$this->db->query("select * from $table where $tab = '$str'");//搜索
		if ($result->num_rows()>0)//判断是否存在
			return true;
		else return false;
	}
	
	function search_2($table, $tab1, $str1, $tab2, $str2)//在数据库的$table表中搜索列名为$tab1、$tab2值为$str1、$tab2的值，并返回是否存在
	{
		$result=$this->db->query("select * from $table where $tab1 = '$str1' and $tab2 = '$str2'");//搜索
		if ($result->num_rows()>0)//判断是否存在
			return true;
		else return false;
	}
	
	function check_stock_num($stock_num)//判断股票账户关联表中是否有股票没有卖出
	{
		$result=$this->db->query("select * from 股票证券账户关联表 where 股票账户号码 = '$stock_num' and 股票数目 > 0");
		if ($result->num_rows()>0)
			return true;
		else return false;
	}
	
	function delete($table, $tab, $str)//删除指定的行信息
	{
		$result=$this->db->query("delete from $table where $tab = '$str'");
	}

	function update_fund($sid)
    {
        $sql='SELECT fa_status FROM fund_account WHERE sid = ?';       // 选择出证券账户下的资金账户
        $query = $this->db->query($sql,array($sid));
        $res=$query->num_rows();
        if($res > 0){
            $row = $query->row();
            $row->fa_status = 7;                                // 置为锁住
            $this->db->where('sid',$sid);
            $this->db->update('fund_account',$row);
        }
    }

    function sale_out($sid)//查询是否有股票
	{
		$result=$this->db->query("select * from fund_stock where stock_id = '$sid'");
		$res=$result->num_rows();
		if ($res > 0){
			$row = $result->row();
			if ($row->num> 0)
				return FALSE;
		}
		return TRUE; 
	}
	function delete_sale($sid){ //删除股票账户的股票数目那一行
		$result=$this->db->query("delete from fund_stock where stock_id = '$sid'");
	}
}  
?>  