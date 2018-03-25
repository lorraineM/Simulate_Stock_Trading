<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fund_account_model extends CI_Model {
/*
CREATE TABLE IF NOT EXISTS `fund_account` (  
  fid INT(16) NOT NULL AUTO_INCREMENT,  
  idc VARCHAR(18) NOT NULL,
  sid varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  login_pin VARCHAR(15) NOT NULL,
  trade_pin CHAR(6) NOT NULL,
  atm_pin CHAR(6) NOT NULL,
  fa_status INT(1) NOT NULL,
  agid INT(6) NOT NULL,
  create_date timestamp,

  PRIMARY KEY  (fid),
  FOREIGN KEY (agid) REFERENCES admin_account(agid),
  FOREIGN KEY (sid) REFERENCES 法人证券账户(股票账户号码)
) DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci;  

*/
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*     添加资金账户 ,返回新的账户号    */
    public function insert_fund_account($idc_in,$sid_in,$lp_in,$tp_in,$ap_in,$ag_in)
    {
        $phptime = time();
        date_default_timezone_set("PRC");
        $mysqltime=date('Y-m-d H:i:s',$phptime);        
        $query = $this->db->query("INSERT INTO fund_account
         VALUES(null,'$idc_in','$sid_in',
            '$lp_in','$tp_in','$ap_in',
            1,'$ag_in','$mysqltime',null)"); 
        //得到fid        
        $query = $this->db->query("SELECT * FROM fund_account WHERE create_date='$mysqltime'");  
        $row = $query->result();
        return $row[0]->fid;
    }

    //0. 查看资金账户号是否合法
    public function is_fid_valid($fid_in)
    {
        $query = $this->db->query("SELECT * FROM fund_account WHERE fid='$fid_in'");
        if($query->num_rows()>0)
            return true;
        else
            return false;
        //return $query->result();       
    }

    //1. 根据fid返回身份证号 idc varchar(18) 
    public function get_idc_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT idc FROM fund_account WHERE fid='$fid_in'");
        $row = $query->result();
        return $row[0]->idc;
    }
    //2. 根据fid返回证券账户号 sid varchar(20)
    public function get_sid_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT sid FROM fund_account WHERE fid='$fid_in'");
        $row = $query->result();
        return $row[0]->sid;
    }    
    //  检查资金账户号和证券账户号是否绑定   ADDED BY BJM 6.13 17:28
    public function is_bind_fid_sid($fid_in,$sid_in)
    {
        $query = $this->db->query("SELECT sid FROM fund_account WHERE fid='$fid_in'");
        if($query->num_rows()==0)
            return false;
        else{
            $sid_out = $query->result();
            $sid_out = $sid_out[0]->sid;
            if($sid_in==$sid_out)
                return true;
            else
                return false;
        }
    }
    //3. 根据fid返回登录密码 login_pin   varchar(15)
    public function get_lp_by_fid($fid_in)//todo
    {
        $query = $this->db->query("SELECT login_pin FROM fund_account WHERE fid='$fid_in'");
        $row = $query->result();
        return $row[0]->login_pin;
    }        

    //4. 根据fid返回交易密码 trade_pin   char(6)
    public function get_tp_by_fid($fid_in)//todo
    {
        $query = $this->db->query("SELECT trade_pin FROM fund_account WHERE fid='$fid_in'");
        $row = $query->result();
        return $row[0]->trade_pin;
    }      
    //   根据fid修改交易密码 trade_pin   char(6)
    public function update_tp_by_fid($fid_in,$tp_in)
    {
        $this->db->query("UPDATE fund_account SET trade_pin='$tp_in' WHERE fid='$fid_in'");
        //return $query->result();        
    }  

    //5. 根据fid返回存取款密码 atm_pin char(6)
    public function get_ap_by_fid($fid_in)//todo
    {
        $query = $this->db->query("SELECT atm_pin FROM fund_account WHERE fid='$fid_in'");
        $row = $query->result();
        return $row[0]->atm_pin;
    }     
    //   根据fid修改存取款密码 atm_pin char(6)
    public function update_ap_by_fid($fid_in,$ap_in)//todo
    {
        $this->db->query("UPDATE fund_account SET atm_pin='$ap_in' WHERE fid='$fid_in'");
        //return $query->result();          
    }     

    //6. 根据fid返回资金账户状态 fa_status   int(1)
    public function get_status_by_fid($fid_in)//todo
    {
        $query = $this->db->query("SELECT fa_status FROM fund_account WHERE fid='$fid_in'");
        $row = $query->result();
        return $row[0]->fa_status;
    }  
    //  根据fid返回资金账户是否正常
    public function is_normal($fid_in)
    {
        $query = $this->db->query("SELECT fa_status FROM fund_account WHERE fid='$fid_in'");
        if($query->num_rows()==0)
            return false;
        else{
            $row = $query->result();
            $row = $row[0]->fa_status;
            if($row==0)
                return true;
            else
                return false;
        }
    }  
    //更改状态为 0 ：正常
    public function set_normal($fid_in)
    {
        $this->db->query("UPDATE fund_account SET fa_status=0 WHERE fid='$fid_in'");
    }
    //更改状态为 1 ：申请开户中
    public function set_opening($fid_in)
    {
        $this->db->query("UPDATE fund_account SET fa_status=1 WHERE fid='$fid_in'");
    }
    //更改状态为 2 : 申请挂失中 
    public function set_lossing($fid_in)
    {
        $this->db->query("UPDATE fund_account SET fa_status=2 WHERE fid='$fid_in'");
    }
    //更改状态为 3 : 申请补办中
    public function set_reissueing($fid_in)
    {
        $this->db->query("UPDATE fund_account SET fa_status=3 WHERE fid='$fid_in'");
    }
    //更改状态为 4 : 申请销户中 
    public function set_closing($fid_in)
    {
        $this->db->query("UPDATE fund_account SET fa_status=4 WHERE fid='$fid_in'");
    }
    //更改状态为 5 : 已挂失
    public function set_lost($fid_in)
    {
        $this->db->query("UPDATE fund_account SET fa_status=5 WHERE fid='$fid_in'");
    }
    //更改状态为 6 : 已销户
    public function set_closed($fid_in)
    {
        $this->db->query("UPDATE fund_account SET fa_status=6 WHERE fid='$fid_in'");
    }
    //更改状态为 7 : 被锁住
    public function set_locked($fid_in)
    {
        $this->db->query("UPDATE fund_account SET fa_status=7 WHERE fid='$fid_in'");
    }    

    //7. 根据fid返回管理员id agid    int(6)
    public function get_agid_by_fid($fid_in)//todo
    {
        $query = $this->db->query("SELECT agid FROM fund_account WHERE fid='$fid_in'");
        $row = $query->result();
        return $row[0]->agid;
    }      
    //8. 根据fid返回资金账户开户时间 create_date timestamp
    public function get_cdate_by_fid($fid_in)//todo
    {
        $query = $this->db->query("SELECT create_date FROM fund_account WHERE fid='$fid_in'");
        $row = $query->result();
        return $row[0]->create_date;
    }     
}
/* End of file fund_account_model.php */
/* Location: ./application/models/fund_account_model.php */