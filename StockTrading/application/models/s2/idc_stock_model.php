<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//自然人证券账户
class Idc_stock_model extends CI_Model {
/*
CREATE TABLE IF NOT EXISTS `自然人证券账户` (
  `股票账户号码` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `登记日期` date NOT NULL,
  `姓名` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `性别` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `身份证号码` char(18) COLLATE utf8_unicode_ci NOT NULL,
  `家庭地址` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `职业` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `学历` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `工作单位` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `联系电话` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `是否代办` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `代办人姓名` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `代办人身份证号码` char(18) COLLATE utf8_unicode_ci NOT NULL,
  `账户状态` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`股票账户号码`),
  UNIQUE KEY `身份证号码` (`身份证号码`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //2. 检查身份证号是否合法
    public function is_id_valid($id_in)
    {
      $query = $this->db->query("SELECT * FROM 自然人证券账户 WHERE 身份证号码='$id_in' AND 是否代办='0'");
      if($query->num_rows()!=0)//非代办
        return true;
      else
      {//是代办
        $query = $this->db->query("SELECT * FROM 自然人证券账户 WHERE 代办人身份证号码='$id_in' AND 是否代办='1'");
        if($query->num_rows()>0)
          return true;
        else
          return false;
      }
    }

    //0. 检查证券账户号是否合法
    public function is_sid_valid($sid_in)
    {
        $query = $this->db->query("SELECT 股票账户号码 FROM 自然人证券账户 WHERE 股票账户号码='$sid_in'");
        if($query->num_rows()>0)
            return true;
        else
            return false;
    }
    //1. 根据证券账户号返回自然人身份证号
    public function get_idc_by_sid($sid_in)
    {
        $query = $this->db->query("SELECT 是否代办,身份证号码,代办人身份证号码 FROM 自然人证券账户 WHERE 股票账户号码='$sid_in'");
        if($query->num_rows()==0)
          return null;
        else
        {
          $row = $query->result();
          if($row[0]->是否代办 == '1')
            return $row[0]->代办人身份证号码;
          else
            return $row[0]->身份证号码;
        }
    }

}
/* End of file stock_model.php */
/* Location: ./application/models/stock_model.php */
