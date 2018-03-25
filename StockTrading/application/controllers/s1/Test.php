<?php  
class Test extends CI_Controller {  
   
function Test(){  
    parent::__construct();
	$this->output->set_header("Content-Type: text/html; charset=utf-8");
} 

function index(){
	$this -> load -> helper('form');  
    $this -> load -> library('form_validation');

    $this -> load -> view('s1/login_person');
} 
   
function form(){
	$this -> load -> helper('form');  
    $this -> load -> library('form_validation'); 
	
	$name=$this -> input -> post('name');
	$id=$this -> input -> post('id');
	$account=$this -> input -> post('account');
	
	echo $name;
	
	$data = array('name' => $name, 'id' => $id, 'account' => $account);
	
	$this -> load -> model('s1/Mtest');
	
	$this->Mtest->insert("test1",$data);
}
}
?>