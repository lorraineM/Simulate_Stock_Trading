<?php  
class Mtest extends CI_Model{  
    function Mtest(){  
        parent::__construct();
		$this->output->set_header("Content-Type: text/html; charset=utf-8");		
    }  
    function insert($tab,$data)  
    {         
        $this->load->database();
        $this->db->insert($tab,$data);
        return;  
    }     
}  
?>  