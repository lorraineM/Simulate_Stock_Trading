<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fund_log_model extends CI_Model {
/*
CREATE TABLE IF NOT EXISTS `fund_log`(
  lgid int(18) NOT NULL AUTO_INCREMENT,
  fid int(16) NOT NULL,
  content varchar(100) COLLATE utf8_unicode_ci,
  dates timestamp,
  types int(1),

  primary key(lgid),
  foreign key(fid) references fund_account(fid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci;
*/

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /*          添加资金账户日志        */
    public function insert_fund_log($fid_in,$content_in,$types_in)
    {
        $phptime = time();
        date_default_timezone_set("PRC");
        $mysqltime=date('Y-m-d H:i:s',$phptime);
        $query = $this->db->query("INSERT INTO fund_log VALUES(null,'$fid_in','$content_in','$mysqltime','$types_in')"); 
    }

    /*          根据lgid处理            */
    //1. 获得fid
    function get_fid_by_lgid($lgid_in)
    {
        $query = $this->db->query("SELECT fid FROM fund_log WHERE lgid='$lgid_in'");
        $row = $query->result();
        return $row[0]->fid;        
    }
    //2. 获得content
    function get_content_by_lgid($lgid_in)
    {
        $query = $this->db->query("SELECT content FROM fund_log WHERE lgid='$lgid_in'");
        $row = $query->result();
        return $row[0]->content;        
    }    
    //3. 获得dates
    function get_dates_by_lgid($lgid_in)
    {
        $query = $this->db->query("SELECT dates FROM fund_log WHERE lgid='$lgid_in'");
        $row = $query->result();
        return $row[0]->dates;        
    }      
    //4. 获得types
    function get_types_by_lgid($lgid_in)
    {
        $query = $this->db->query("SELECT types FROM fund_log WHERE lgid='$lgid_in'");
        $row = $query->result();
        return $row[0]->types;        
    }     
    /*         根据fid处理              */
    //1. 获得完整日志记录
    function get_log_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT * FROM fund_log WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;        
    }    
    //2. 获得一定日期范围日志记录 TODO
    function get_last_d_log_by_fid($fid_in,$days)
    {
        $phptime = time();
        $phptime = $phptime - 60*60*24*$days;
        $mysqltime=date('Y-m-d H:i:s',$phptime);
        
        $query = $this->db->query("SELECT * FROM fund_log WHERE dates>=$mysqltime and fid='$fid_in'");
        $row = $query->result();
        return $row;         
//PHP->mySQL         $mysqltime=date('Y-m-d H:i:s',$phptime);
//mySQL->PHP　　　　$phptime=strtotime($mysqldate);
    }
    //3. 获得一定数量日志记录
    function get_last_n_log_by_fid($fid_in,$num)
    {
        $query = $this->db->query("SELECT * FROM fund_log WHERE fid='$fid_in'",$num);
        $row = $query->result();
        return $row;        
    }  


}
/* End of file test_model.php */
/* Location: ./application/models/test_model.php */