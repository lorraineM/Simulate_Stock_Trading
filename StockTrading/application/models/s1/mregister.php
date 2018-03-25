<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mregister extends CI_Model {


    function __construct()
    {
        parent::__construct();
        $this->output->set_header("Content-Type: text/html; charset=utf-8");
        $this->load->database();
    }
    //查询该身份证是否已经注册了证券账户
    function check_account($id)
    {
        $query = $this->db->query("select * from 自然人证券账户 where 身份证号码='$id'");
        $query_two = $this->db->query("select * from 法人证券账户 where 法人身份证号码='$id'");
        if (($query->num_rows()<1)&&($query_two->num_rows()<1)){
            return FALSE;}
        else{
            return TRUE;}
    }
    //根据身份证号码去公安局查询相关人员信息
    function check_police($id)
    {
        $query = $this->db->query("select * from 公安局信息 where 身份证号码='$id'");
        if ($query->num_rows()<1)
            return FALSE;
        else
            return $query->result();
        //return $query->result();
        //return empty($query) ? FALSE : $query->result();
    }
    //根据身份证号码查询证监会工作人员信息
    function check_stock($id)
    {
        $query = $this->db->query("select * from 证监会信息 where 身份证号码='$id'");
        //return empty($query) ? FALSE : $query->result();
        if ($query->num_rows()<1)
            return FALSE;
        else
            return TRUE;
        //return empty($query) ? FALSE : $query->result();
    }

    //向自然人证券账户插入新的账户信息
    function insert_account_person($stocknum,$id,$name,$sex,$tel,$edu,$address,$profession,$work,$ifagen,$t,$aname,$aid){
        $state="正常";
        $query = $this->db->query("insert into 自然人证券账户 values ('$stocknum','$t','$name','$sex','$id','$address','$profession','$edu','$work','$tel','$ifagen','$aname','$aid','$state')"); 
    }

    function insert_account_company($stocknum,$regisnum,$bus_license,$aid,$aname,$atel,$aaddress,$ename,$gid,$gtel,$gaddress){
         $state="正常";
         $query = $this->db->query("insert into 法人证券账户 values ('$stocknum','$regisnum','$bus_license','$aid','$aname','$atel','$aaddress','$ename','$gid','$gtel','$gaddress','$state')"); 
    }

    //管理员登陆
    function manager_login_m($name,$secret){
        $query = $this->db->query("select * from 证券账户管理员 where 用户名='$name' And 密码='$secret'");
        if ($query->num_rows()<1)
            return FALSE;
        else
            return TRUE;
        //return empty($query) ? FALSE : TRUE;
    }
    //随机产生股票账户号码
    function randStr($len)
    {
        $chars='0123456789'; // characters to build the password from
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
    function check_stocknum_company($stocknum){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码='$stocknum'");
        if ($query->num_rows()<1)
            return FALSE;
        else
            return TRUE;
        //return empty($query) ? FALSE :$query->result();
    } 

}
?>