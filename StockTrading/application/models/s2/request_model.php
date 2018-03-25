<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//请求
class Request_model extends CI_Model {
/*
CREATE TABLE IF NOT EXISTS `request`(
  rid int(18) NOT NULL AUTO_INCREMENT,
  fid int(16) NOT NULL,
  types int(1) NOT NULL,
  status int(1) NOT NULL,
  idc VARCHAR(18) NOT NULL,
  agid char(6) NOT NULL,
  senddates timestamp,
  dealdates timestamp,
  primary key(rid),
  foreign key(fid) references fund_account(fid),
  foreign key(agid) references admin_account(agid)
) DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci;
*/
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*          添加请求记录           */
    public function insert_request($fid_in,$types_in,$idc_in,$agid_in)
    {
        $phptime = time();
        date_default_timezone_set("PRC");
        $mysqltime=date('Y-m-d H:i:s',$phptime);
        $query = $this->db->query("INSERT INTO request VALUES(null,'$fid_in','$types_in',0,'$idc_in','$agid_in','$mysqltime',null,null)");
    }

}
/* End of file stock_model.php */
/* Location: ./application/models/stock_model.php */
