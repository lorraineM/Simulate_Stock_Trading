<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mselect extends CI_Model {


    function __construct()
    {
        parent::__construct();
        $this->output->set_header("Content-Type: text/html; charset=utf-8");
        $this->load->database();
    }
    
    //查询该股票账户号码是否已经注册了证券账户
    function s_check_account1($s_stocknum)
    {
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\"");
        //$query_two = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\"");
        if ($query->num_rows()<1){
            return FALSE;}
        else{
            return TRUE;}
    }
    
    
    //查询该身份证是否已经注册了证券账户
    function s_check_account2($s_id)
    {
        $query = $this->db->query("select * from 自然人证券账户 where 身份证号码='$s_id'");
        //$query_two = $this->db->query("select * from 法人证券账户 where 法人身份证号码='$s_id'");
        if ($query->num_rows()<1){
            return FALSE;}
        else{
            return TRUE;}
    }
    
    
    function s_check_account3($s_stocknum,$s_id)
    {
        $set=0;
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'");
        //$query_two = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'");
        $set = $query->num_rows();
        return $set;
    }
    
        //查询该股票账户号码是否已经注册了证券账户
    function se_check_account1($s_stocknum)
    {
        //$query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\"");
        $query_two = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\"");
        if ($query_two->num_rows()<1){
            return FALSE;}
        else{
            return TRUE;}
    }
    
    
    //查询该身份证是否已经注册了证券账户
    function se_check_account2($s_id)
    {
        //$query = $this->db->query("select * from 自然人证券账户 where 身份证号码='$s_id'");
        $query_two = $this->db->query("select * from 法人证券账户 where 法人身份证号码='$s_id'");
        if ($query_two->num_rows()<1){
            return FALSE;}
        else{
            return TRUE;}
    }
    
    
    function se_check_account3($s_stocknum,$s_id)
    {
        $set=0;
        //$query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'");
        $query_two = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'");
        $set = $query_two->num_rows();
        return $set;
    }
    
    
    
    //向自然人证券账户插入新的账户信息
    function se_stocknum($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->股票账户号码;
                    }
        return $temp;
    }
    
    function se_t($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->登记日期;
                    }
        return $temp;
    }
    
    function se_id($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->身份证号码;
                    }
        return $temp;
    }
    
    function se_name($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->姓名;
                    }
        return $temp;
    }


function se_sex($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->性别;
                    }
        return $temp;
    }
    
    function se_tel($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->联系电话;
                    }
        return $temp;
    }
    
    function se_edu($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->学历;
                    }
        return $temp;
    }
    
    function se_address($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->家庭地址;
                    }
        return $temp;
    }

    function se_profession($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->职业;
                    }
        return $temp;
    }
    
    function se_work($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->工作单位;
                    }
        return $temp;
    }
    
    function se_acc($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->是否代办;
                    }
        return $temp;
    }
    
    function se_aname($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->代办人姓名;
                    }
        return $temp;
    }

    
    function se_aid($s_stocknum,$s_id){
        $query = $this->db->query("select * from 自然人证券账户 where 股票账户号码=\"$s_stocknum\" or 身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->代办人身份证号码;
                    }
        return $temp;
    }
    
    function se_stocknum1($s_stocknum,$s_id){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->股票账户号码;
                    }
        return $temp;
    }
    
    function se_regisnum1($s_stocknum,$s_id){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->法人注册登记号码;
                    }
        return $temp;
    }
    
    function se_bus_license1($s_stocknum,$s_id){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->营业执照号码;
                    }
        return $temp;
    }
    
    function se_aid1($s_stocknum,$s_id){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->法人身份证号码;
                    }
        return $temp;
    }


function se_aname1($s_stocknum,$s_id){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->法人姓名;
                    }
        return $temp;
    }
    
    function se_atel1($s_stocknum,$s_id){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->法人联系电话;
                    }
        return $temp;
    }
    
    
    function se_aaddress1($s_stocknum,$s_id){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->法人联系地址;
                    }
        return $temp;
    }

    function se_ename1($s_stocknum,$s_id){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->授权执行人姓名;
                    }
        return $temp;
    }
    
    function se_gid1($s_stocknum,$s_id){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->授权人身份证号码;
                    }
        return $temp;
    }
    
    function se_gtel1($s_stocknum,$s_id){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->授权人联系电话;
                    }
        return $temp;
    }
    
    function se_gaddress1($s_stocknum,$s_id){
        $query = $this->db->query("select * from 法人证券账户 where 股票账户号码=\"$s_stocknum\" or 法人身份证号码='$s_id'"); 
        foreach ($query->result() as $row){
                    $temp =$row->授权人地址;
                    }
        return $temp;
    }

 
 
}
?>