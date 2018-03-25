<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//法人证券账户
class Leg_stock_model extends CI_Model {
/*
CREATE TABLE IF NOT EXISTS `法人证券账户` (
  `股票账户号码` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `法人注册登记号码` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `营业执照号码` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `法人身份证号码` char(18) COLLATE utf8_unicode_ci NOT NULL,
  `法人姓名` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `法人联系电话` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `法人联系地址` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `授权执行人姓名` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `授权人身份证号码` char(18) COLLATE utf8_unicode_ci NOT NULL,
  `授权人联系电话` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `授权人地址` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `账户状态` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`股票账户号码`),
  UNIQUE KEY `法人身份证号码` (`法人身份证号码`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    //2. 检查法人注册号是否合法
    public function is_id_valid($id_in)
    {
      //$query = $this->db->query("SELECT * FROM 法人证券账户 WHERE 法人注册登记号码='$id_in'");
      $query = $this->db->query("SELECT * FROM 法人证券账户 WHERE 法人注册登记号码= ?",array($id_in));
      if($query->num_rows()!=0)
        return true;
      else
        return false;
    }
    //0. 检查证券账户号是否合法
    public function is_sid_valid($sid_in)
    {
        $query = $this->db->query("SELECT 股票账户号码 FROM 法人证券账户 WHERE 股票账户号码=?",array($sid_in));
        if($query->num_rows()>0)
            return true;
        else
            return false;
    }
    //1. 根据证券账户号返回法人注册号
    public function get_leg_by_sid($sid_in)
    {
        //$query = $this->db->query("SELECT 法人注册登记号码 FROM 法人证券账户 WHERE 股票账户号码='$sid_in'");
        $query = $this->db->query("SELECT 法人注册登记号码 FROM 法人证券账户 WHERE 股票账户号码=?",array($sid_in));
        if($query->num_rows()!=0)
        {
          $row = $query->result();
          return $row[0]->法人注册登记号码;
        }
        else
          return null;
    }

}
/* End of file stock_model.php */
/* Location: ./application/models/stock_model.php */
