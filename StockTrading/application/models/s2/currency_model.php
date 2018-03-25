<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Currency_model extends CI_Model {
/*
CREATE TABLE IF NOT EXISTS `currency`(
  cid int(15) NOT NULL AUTO_INCREMENT,primary key,
  fid int(16) NOT NULL,foreign key(fid) references fund_account(fid)
  types int(2) DEFAULT 0,
  amount DECIMAL(20,6) DEFAULT 0,
  frozen DECIMAL(20,6) DEFAULT 0,   
  available DECIMAL(20,6) DEFAULT 0,
  interest  DECIMAL(20,6) DEFAULT 0,
  product   DECIMAL(20,6) DEFAULT 0,
) DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci; 
*/

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    //  获得冻结资金总量
    function get_frozen_total_by_fid($fid_in)
    {
        $total = 0;
        $query = $this->db->query("SELECT frozen FROM currency WHERE fid='$fid_in'");
        if($query->num_rows()==0)
            return 0;
        else{
            foreach ($query->result() as $row) {
                $total = $total + $row->frozen;
            }
            return $total;
        }
    }  
    //  获得可用资金总量
    function get_available_total_by_fid($fid_in)
    {
        $total = 0;
        $query = $this->db->query("SELECT available FROM currency WHERE fid='$fid_in'");
        if($query->num_rows()==0)
            return 0;
        else{
            foreach ($query->result() as $row) {
                $total = $total + $row->available;
            }
            return $total;
        }        
    }
    


    /*          根据cid处理                 */
    //1.获得fid int(16)
    function get_fid_by_cid($cid_in)
    {
        $query = $this->db->query("SELECT fid FROM currency WHERE cid='$cid_in'");
        $row = $query->result();
        return $row[0]->fid;
    }
    //2.获得types int(2)
    function get_types_by_cid($cid_in)
    {
        $query = $this->db->query("SELECT types FROM currency WHERE cid='$cid_in'");
        $row = $query->result();
        return $row[0]->types;
    }    
    //3.获得amount DECIMAL(20,6)
    function get_amount_by_cid($cid_in)
    {
        $query = $this->db->query("SELECT amount FROM currency WHERE cid='$cid_in'");
        $row = $query->result();
        return $row[0]->amount;
    }    
    //4.获得frozen DECIMAL(20,6)
    function get_frozen_by_cid($cid_in)
    {
        $query = $this->db->query("SELECT frozen FROM currency WHERE cid='$cid_in'");
        $row = $query->result();
        return $row[0]->frozen;
    }    
    //5.获得available DECIMAL(20,6)
    function get_available_by_cid($cid_in)
    {
        $query = $this->db->query("SELECT available FROM currency WHERE cid='$cid_in'");
        $row = $query->result();
        return $row[0]->available;
    }    
    //6.获得interest  DECIMAL(20,6)
    function get_interest_by_cid($cid_in)
    {
        $query = $this->db->query("SELECT interest FROM currency WHERE cid='$cid_in'");
        $row = $query->result();
        return $row[0]->interest;
    }      
    //7.获得product   DECIMAL(20,6)
    function get_product_by_cid($cid_in)
    {
        $query = $this->db->query("SELECT product FROM currency WHERE cid='$cid_in'");
        $row = $query->result();
        return $row[0]->product;
    }    

    /*            根据fid处理             */
    //1.获得cid int(16)
    function get_cid_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT cid FROM currency WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;
    }
    //2.获得types int(2)
    function get_types_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT types FROM currency WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;
    }    
    //3.获得amount DECIMAL(20,6)
    function get_amount_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT amount FROM currency WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;
    }   
    //4.获得frozen DECIMAL(20,6)
    function get_frozen_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT frozen FROM currency WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;
    }              
    //  冻结所有可用资金
    function freeze_available_by_fid($fid_in)
    {
        $this->db->query("UPDATE currency SET frozen=available WHERE fid='$fid_in'");
        $this->db->query("UPDATE currency SET available=0 WHERE fid='$fid_in'");
    }          
    //5.获得available DECIMAL(20,6)
    function get_available_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT available FROM currency WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;
    }    
    //6.获得interest  DECIMAL(20,6)
    function get_interest_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT interest FROM currency WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;
    }      
    //7.获得product   DECIMAL(20,6)
    function get_product_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT product FROM currency WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;
    }     
}
/* End of file test_model.php */
/* Location: ./application/models/test_model.php */