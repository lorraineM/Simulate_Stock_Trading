<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mselect extends CI_Model {


    function __construct()
    {
        parent::__construct();
        $this->output->set_header("Content-Type: text/html; charset=utf-8");
        $this->load->database();
    }
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
  /*  //随机产生股票账户号码
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
    }    */
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

     function update_person_id($id)
    {
        $query = $this ->db->query("update 自然人证券账户 set 身份证号码 = '$id'");
    }
    
    function update_person_name($name)
    {
         $query = $this ->db->query("update 自然人证券账户 set 姓名 = '$name'");
    }
    function update_person_sex($id,$sex)
    {
         $query = $this ->db->query("update 自然人证券账户 set 性别 = '$sex' where 身份证号码 = '$id'");
    }
    function update_person_address($id,$address)
    {
         $query = $this ->db->query("update 自然人证券账户 set 家庭地址 = '$address' where 身份证号码 = '$id'");
    }
    function update_person_work($id,$work)
    {
        $query = $this ->db->query("update 自然人证券账户 set 工作单位 = '$work' where 身份证号码 = '$id'");
    }
    function update_person_tel($id,$tel)
    {
        $query = $this ->db->query("update 自然人证券账户 set 联系电话 = '$tel' where 身份证号码 = '$id'");
    }
    function update_person_profession($id,$profession)
    {
        $query = $this ->db->query("update 自然人证券账户 set 职业 = '$profession' where 身份证号码 = '$id'");
    }
    function update_person_edu($id,$edu)
    {
        $query =$this ->db->query("update 自然人证券账户 set 学历 ='$edu' where 身份证号码 = '$id'");
    }
    function update_company_regisnum($aid,$regisnum)
    {
        $query = $this ->db->query("update 法人证券账户 set 法人注册登记号码 ='$regisnum' where 法人身份证号码 ='$aid'");
    }
    function update_company_bus_license($aid,$bus_license)
    {
        $query = $this->db->query("update 法人证券账户 set 营业执照号码 ='$bus_license' where 法人身份证号码 = '$aid'");
    }
    function update_company_atel($aid,$atel)
    {
        $query = $this->db->query("update 法人证券账户 set 法人联系电话 = '$atel' where 法人身份证号码 = '$aid'");
    }
    function update_company_aaddress($aid,$aaddress)
    {
        $query = $this->db->query("update 法人证券账户 set 法人联系地址 ='$aaddress' where 法人身份证号码 ='$aid'");
    }
    function update_company_gtel($aid,$gtel)
    {
        $query = $this->db->query("update 法人证券账户 set 授权人联系电话 ='$gtel' where 法人身份证号码 ='$aid'");
    }
    function update_company_gaddress($aid,$gaddress)
    {
        $query = $this->db->query("update 法人证券账户 set 授权人地址 = '$gaddress' where 法人身份证号码 ='$aid'");
    }
 
}
?>