<?php	if(!defined('BASEPATH')) exit('No direct script access allowed');
	class Lmodel extends CI_Model{
		function __construct()
		{
			parent::__construct();
			$this->output->set_header("Content-Type:text/html;charset=utf-8");
			$this->load->database();
		}
		//在自然人证券表中查询个人挂失身份证是否存在
		function check_pid($pid)
		{
			$query=$this->db->query("select * from 自然人证券账户 where 身份证号码='$pid'");
			if($query->num_rows()<1)
				return 0;
			else
				return 1;
		}
		//查询特定的自然人的账户信息
		function detail_pid($pid)
		{
			$query = $this->db->query("select * from 自然人证券账户 where 身份证号码='$pid'");
        	if ($query->num_rows()<1)
            	return 0;
        	else
            	return $query->result();
		}
		//删除自然人账户记录
		function cancel_pid($pid)
		{
			$query=$this->db->query("delete from 自然人证券账户 where 身份证号码='$pid'");
		}
		//在法人证券表中查询法人挂失身份证是否存在
		function check_fid($fid)
		{
			$query=$this->db->query("select * from 法人证券账户 where 法人身份证号码='$fid'");
			if($query->num_rows()<1)
				return 0;
			else
				return 1;
		}
		//查询特定的法人账户信息
		function detail_fid($fid)
		{
			$query = $this->db->query("select * from 法人证券账户 where 法人身份证号码='$fid'");
        	if ($query->num_rows()<1)
            	return 0;
        	else
            	return $query->result();
		}
		//删除法人账户信息
		function cancel_fid($fid)
		{
			$query=$this->db->query("delete from 法人证券账户 where 法人身份证号码='$fid'");
		}
		//在挂失账户表中查询补办账户是否存在
		function check_bid($bid)
		{
			$query=$this->db->query("select * from 挂失账户 where 身份证号码='$bid'");
			if($query->num_rows()<1)
				return 0;
			else
				return 1;
		}
		//在挂失账户表中查询挂失时间是否到了规定时间
		function check_btime($bid)
		{
			$query=$this->db->query("select 挂失时间 from 挂失账户 where 身份证号码='$bid'");
			foreach($query->result_array() as $row)
				$stime=$row['挂失时间'];//在挂失表中查询挂失时间
			$nowtime=time();
			if(($nowtime-strtotime($stime)-864000)>0)//判定挂失时间是否大于10天
				$result=1;
			else
				$result=0;
			return $result;
		}
		//在挂失账户表中插入挂失身份证号和日期
		function insert_lid($lid)
		{
			$nowtime=date('Y-m-d',time());
			$query=$this->db->query("insert into 挂失账户 values('$lid','$nowtime')");
		}
		//在挂失账户中删除挂失身份证和日期
		function cancel_lid($lid)
		{
			$query=$this->db->query("delete from 挂失账户 where 身份证号码='$lid'");
		}
		//在自然人证券账户中修改账户状态为挂失
		function lupdate_pid($pid)
		{
			if($this->check_pid($pid))
				$query=$this->db->query("update 自然人证券账户 set 账户状态='挂失' where 身份证号码='$pid'");
		}
		//在自然人证券账户中修改账户状态为补办并删除挂失账户中的记录
		function bupdate_pid($pid)
		{
			$query=$this->db->query("update 自然人证券账户 set 账户状态='补办' where 身份证号码='$pid'");
			$query=$this->db->query("delete from 挂失账户 where 身份证号码='$pid'");
		}
		//在法人证券账户中修改账户状态为挂失
		function lupdate_fid($fid)
		{
			if($this->check_fid($fid))
				$query=$this->db->query("update 法人证券账户 set 账户状态='挂失' where 法人身份证号码='$fid'");
		}
		//在法人证券账户中修改账户状态为补办并删除挂失账户中的记录
		function bupdate_fid($fid)
		{ 
			$query=$this->db->query("update 法人证券账户 set 账户状态='补办' where 法人身份证号码='$fid'");
			$query=$this->db->query("delete from 挂失账户 where 身份证号码='$fid'");
		}
		//自然人取消挂失
		function cancel_ploss($pid)
		{
			if($this->check_bid($pid)&&(!$this->check_btime($pid)))
			{
				$this->cancel_lid($pid);
				$query=$this->db->query("update 自然人证券账户 set 账户状态='正常' where 身份证号码='$pid'");
			}	
		}
		//法人取消挂失
		function cancel_floss($fid)
		{
			if($this->check_bid($fid)&&(!$this->check_btime($fid)))
			{
				$this->cancel_lid($fid);
				$query=$this->db->query("update 法人证券账户 set 账户状态='正常' where 法人身份证号码='$fid'");	
			}
		}
		//随机产生股票账户号码
    	function randStr($len)
    	{
        	$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz'; // characters to build the password from
        	$string='';
        	for(;$len>=1;$len--)
        	{
            	$position=rand()%strlen($chars);
            	$string.=substr($chars,$position,1);
        	}
        	return $string;
    	}
    	//检查自然人账户数据库中是否存在该股票账户号码了
    	function check_stocknum_person($stocknum){
        	$query = $this->db->query("select * from 自然人证券账户 where 股票账户号码='$stocknum'");
        	if ($query->num_rows()<1)
            	return FALSE;
        	else
            	return TRUE;
        	//return empty($query) ? FALSE :$query->result();
    	} 
    	//检查法人账户数据库中是否存在该股票账户号码
    	function check_stocknum_company($stocknum){
        	$query = $this->db->query("select * from 法人证券账户 where 股票账户号码='$stocknum'");
        	if ($query->num_rows()<1)
            	return FALSE;
        	else
            	return TRUE;
        	//return empty($query) ? FALSE :$query->result();
    	} 	
    	//向自然人证券账户插入新的账户信息
   	    function insert_account_person($stocknum,$t,$name,$sex,$id,$address,$profession,$edu,$work,$tel,$ifagen,$aname,$aid){
        	$state="正常";
        	$query = $this->db->query("insert into 自然人证券账户 values ('$stocknum','$t','$name','$sex','$id','$address','$profession','$edu','$work','$tel','$ifagen','$aname','$aid','$state')"); 
    	}
    	//向法人证券账户中插入新的账户信息
    	function insert_account_company($stocknum,$regisnum,$bus_license,$aid,$aname,$atel,$aaddress,$ename,$gid,$gtel,$gaddress){
         	$state="正常";
         	$query = $this->db->query("insert into 法人证券账户 values ('$stocknum','$regisnum','$bus_license','$aid','$aname','$atel','$aaddress','$ename','$gid','$gtel','$gaddress','$state')"); 
    	}
    	  // 当证券账户更改时，更新资金账户
    	public function update_fund($sid, $newsid)
    	{
        	$sql='SELECT sid FROM fund_account WHERE sid = ?';       // 选择出原来的sid的资金账户
        	$query = $this->db->query($sql,array($sid));
        	$res=$query->num_rows();
        	if($res > 0){
            	$row = $query->row();
            	$row->sid = $newsid;                                // 更新 sid
            	$this->db->where('sid',$sid);
            	$this->db->update('fund_account',$row);
        	}
   		}


    	// S1 CI model
    	// 当证券账户冻结时，冻结其所有的资金账户
    	public function lock_fund($sid)
    	{
        	$sql='SELECT fa_status FROM fund_account WHERE sid = ? AND fa_status= ?';       // 选择出证券账户下的资金账户
        	$query = $this->db->query($sql,array($sid,0));
        	$res=$query->num_rows();
        	if($res > 0){
            	$row = $query->row();
            	$row->fa_status = 7;                                // 置为锁住
            	$this->db->where('sid',$sid);
            	$this->db->update('fund_account',$row);
            	return 1;
        	}
        	else
        		return 0;
    	}

    	// S1 CI model
    	// 当证券账户解冻时，解冻其所有的资金账户
    	public function unlock_fund($sid)
    	{
        	$sql='SELECT fa_status FROM fund_account WHERE sid = ?';       // 选择出证券账户下的资金账户
        	$query = $this->db->query($sql,array($sid));
        	$res=$query->num_rows();
        	if($res > 0){
            	$row = $query->row();
            	$row->fa_status = 0;                                // 置为锁住
            	$this->db->where('sid',$sid);
            	$this->db->update('fund_account',$row);
        	}
    	}		
	}
?>