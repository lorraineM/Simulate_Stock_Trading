<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fund_info_model extends CI_Model {
/*
1  fundinfoid  int(15)         否   无   AUTO_INCREMENT   修改 修改   删除 删除   更多 显示更多操作
2  fid         否   无        修改 修改   删除 删除   更多 显示更多操作
3  principal              是   0.000000         修改 修改   删除 删除   更多 显示更多操作
4  frozen             是   0.000000         修改 修改   删除 删除   更多 显示更多操作
5  available
*/

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /*       通过fiid操作             */
    //1. 根据fiid获得fid int(16) 
    function get_fid_by_fiid($fiid_in)
    {
        $query = $this->db->query("SELECT fid FROM fund_info WHERE fundinfoid='$fiid_in'");
        $row = $query->result();
        return $row[0]->fid;
    }
    //2. 根据fiid获得principal(本金) decimal(20,6)
    function get_principal_by_fiid($fiid_in)
    {
        $query = $this->db->query("SELECT principal FROM fund_info WHERE fundinfoid='$fiid_in'");
        $row = $query->result();
        return $row[0]->principal;
    }
    //3. 根据fiid获得frozen(冻结量) decimal(20,6)
    function get_frozen_by_fiid($fiid_in)
    {
        $query = $this->db->query("SELECT frozen FROM fund_info WHERE fundinfoid='$fiid_in'");
        $row = $query->result();
        return $row[0]->fid;
    }   
    //4. 根据fiid获得available(可用量) DECIMAL(20,6)
    function get_available_by_fiid($fiid_in)
    {
        $query = $this->db->query("SELECT available FROM fund_info WHERE fundinfoid='$fiid_in'");
        $row = $query->result();
        return $row[0]->fid;
    }    

    /*       通过fid操作              */
    //1. 根据fid获得fiid int(15) 
    function get_fiid_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT fundinfoid FROM fund_info WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;
    }
    //2. 根据fid获得principal(本金) decimal(20,6)
    function get_principal_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT principal FROM fund_info WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;
    }
    //   根据fid获得本金总和
    function get_total_principal_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT principal FROM fund_info WHERE fid='$fid_in'");
        $total = 0;
        foreach ($query->result() as $row) {
            $total = $total + $row->principal;
        }
        return $total;
    }    
    //3. 根据fid获得frozen(冻结量) decimal(20,6)
    function get_frozen_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT frozen FROM fund_info WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;
    }   
    //   根据fid获得冻结量总和
    function get_total_frozen_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT frozen FROM fund_info WHERE fid='$fid_in'");
        $total = 0;
        foreach ($query->result() as $row) {
            $total = $total + $row->frozen;
        }
        return $total;
    }     
    //4. 根据fid获得available(可用量) DECIMAL(20,6)
    function get_available_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT available FROM fund_info WHERE fid='$fid_in'");
        $row = $query->result();
        return $row;
    }  
    //  根据fid获得可用量总和
    function get_total_available_by_fid($fid_in)
    {
        $query = $this->db->query("SELECT available FROM fund_info WHERE fid='$fid_in'");
        $total = 0;
        foreach ($query->result() as $row) {
            $total = $total + $row->available;
        }
        return $total;
    }        
    //5. 根据fid冻结可用资金
    function freeze_available_by_fid($fid_in)
    {
        $this->db->query("UPDATE fund_info SET frozen=available WHERE fid='$fid_in'");
        $this->db->query("UPDATE fund_info SET available=0 WHERE fid='$fid_in'");
    }     
    //6. 根据fid解除冻结(变更为可用资金)
    function freeze_available_by_fid($fid_in)
    {
        $this->db->query("UPDATE fund_info SET available=frozen WHERE fid='$fid_in'");
        $this->db->query("UPDATE fund_info SET frozen=0 WHERE fid='$fid_in'");
    }       
}
/* End of file test_model.php */
/* Location: ./application/models/test_model.php */