<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test_model extends CI_Model {


    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_last_ten_entries()
    {
        $query = $this->db->query('SELECT * FROM admin_account');
        return $query;
        //return $query->result();
    }

}
/*
    admin_account 
    admin_log 
    ci_sessions
    currency
    fund_account
    fund_info
    fund_log
    rate
    法人证券账户
*/
/* End of file test_model.php */
/* Location: ./application/models/test_model.php */