<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fund_pwd_control extends CI_Controller {

  //获得输入
  private $f_id;//资金账户号
  private $f_type;//要修改的密码
  private $f_op;//旧密码
  private $f_np,$f_npc;//新密码/新密码确认
  //检查表单
  private $fid_ok;
  private $op_ok;
  private $np_ok;
  //区分阶段
  private $chk_format,$chk_content,$handle;

  public function Fund_pwd_control(){
    parent::__construct();
    $this->output->set_header("Content-Type: text/html; charset=utf-8");
  }

  public function index()
  {
    $this->load->helper('form');
    $this->load->library('form_validation');
      
    $this->load->model('s2/Fund_account_model');
    $this->load->view('s2/fund_pwd_view');
  }    

  //执行更改密码操作
  public function do_change_pwd()
  {
    $this->load->helper('form');
    $this->load->library('form_validation');     
      
    //0. get form input
    $f_id = $this->input->post('fund_id');
    $f_type = $this->input->post('fpwd_type');
    $f_op = $this->input->post('fund_op');
    $f_np = $this->input->post('fund_np');
    $f_npc = $this->input->post('fund_npc');

    $fid_ok = false;
    $op_ok = false;
    $np_ok = false;

    $chk_format = false;
    $chk_content = false;
    $handle = false;

    //1. check format
    //1-1. 资金账户号
    $this->form_validation->set_rules('fund_id','资金账户号','required|numeric|min_length[1]|max_length[16]');
    if($this->form_validation->run() == false)
    {
      $fid_ok = false;
      //echo '<script type="text/javascript">alert("资金账户号格式不符合要求,请确认后重新输入");history.back();</script>';
      $data['active_id']="fund_pwd";
      $data['error_rp']='资金账户号格式不符合要求';
      $this->load->view('s2/home_view',$data);     
    }
    else $fid_ok = true;
    //1-2. 原密码
    if($fid_ok)
    {
      $this->form_validation->set_rules('fund_op','原密码','required|exact_length[6]|numeric'); 
      if($this->form_validation->run() == false){
        $op_ok = false;
        //echo '<script type="text/javascript">alert("原密码格式不符合要求,请确认后重新输入");history.back();</script>';
        $data['active_id']="fund_pwd";
        $data['error_rp']='原密码格式不符合要求';
        $this->load->view('s2/home_view',$data);   
      }
      else $op_ok = true;
    }
    //1-3. 新密码及确认
    if($op_ok)
    {
      $this->form_validation->set_rules('fund_np','新密码','required|exact_length[6]|numeric'); 
      if($this->form_validation->run() == false){
        $np_ok = false;
        //echo '<script type="text/javascript">alert("新密码格式不符合要求,请确认后重新输入");history.back();</script>';
        $data['active_id']="fund_pwd";
        $data['error_rp']='新密码格式不符合要求';
        $this->load->view('s2/home_view',$data);  
      }
      else
      {
        $this->form_validation->set_rules('fund_npc','新密码确认','required|exact_length[6]|numeric'); 
        if($this->form_validation->run() == false){
          $np_ok = false;
          //echo '<script type="text/javascript">alert("新密码确认格式不符合要求,请确认后重新输入");history.back();</script>';  
          $data['active_id']="fund_pwd";
          $data['error_rp']='新密码确认格式不符合要求';
          $this->load->view('s2/home_view',$data); 
        }
        else $np_ok = true;
      }
    }
    $chk_format = $fid_ok&$op_ok&$np_ok;

    //2. check content
    if($chk_format)
    {
      //2.1 检查资金账户是否存在
      $this->load->model('s2/Fund_account_model');
      if(!$this->Fund_account_model->is_fid_valid($f_id))
      {//资金账户不存在
        $chk_content = false;
        //echo '<script type="text/javascript">alert("资金账户不存在,请确认后重新输入");history.back();</script>';  
        $data['active_id']="fund_pwd";
        $data['error_rp']='资金账户不存在';
        $this->load->view('s2/home_view',$data); 
      }
      else{//2.2 检查原密码是否正确
        if($f_type=="trans")
        {//要修改交易密码
          if($f_op!=$this->Fund_account_model->get_tp_by_fid($f_id))
          {//原交易密码错误
            $chk_content = false;
            //echo '<script type="text/javascript">alert("原密码错误,请确认后重新输入");history.back();</script>';    
            $data['active_id']="fund_pwd";
            $data['error_rp']='原密码错误';
            $this->load->view('s2/home_view',$data); 
          }
          else{//原交易密码正确
            //2.3 检查新密码和新密码确认是否相同
            if($f_np == $f_npc)
              $chk_content = true;
            else{
              $chk_content = false;
              //echo '<script type="text/javascript">alert("新密码与新密码确认不匹配,请确认后重新输入");history.back();</script>';    
              $data['active_id']="fund_pwd";
              $data['error_rp']='新密码与新密码确认不匹配';
              $this->load->view('s2/home_view',$data); 
            }
          }
        }
        else
        {//要修改取款密码
          if($f_op!=$this->Fund_account_model->get_ap_by_fid($f_id))
          {//原取款密码错误
            $chk_content = false;
            //echo '<script type="text/javascript">alert("原密码错误,请确认后重新输入");history.back();</script>';    
            $data['active_id']="fund_pwd";
            $data['error_rp']='原密码错误';
            $this->load->view('s2/home_view',$data); 
          }
          else{//原取款密码正确
            //2.3 检查新密码和新密码确认是否相同
            if($f_np == $f_npc)
              $chk_content = true;
            else{
              $chk_content = false;
              //echo '<script type="text/javascript">alert("新密码与新密码确认不匹配,请确认后重新输入");history.back();</script>';    
              $data['active_id']="fund_pwd";
              $data['error_rp']='新密码与新密码确认不匹配';
              $this->load->view('s2/home_view',$data); 
            }
          }
        }
      }  
    }

    //3. handle
    if($chk_content)//不用request
    {
      //3-0. 检查账户是否正常
      if($this->Fund_account_model->is_normal($f_id))
      {//资金账户正常
        //3-1. 更新资金账户密码
        //3-2. 写fund_log日志
        if($f_type=="trans"){//更改交易密码
          $this->Fund_account_model->update_tp_by_fid($f_id,$f_np);
          $this->load->model('s2/Fund_log_model');
          $this->Fund_log_model->insert_fund_log($f_id,'修改交易密码',1);
          //echo '<script type="text/javascript">alert("更改交易密码成功！");history.back();</script>';
          $data['active_id']="fund_pwd";
          $data['error_rp']='更改交易密码成功！';
          $this->load->view('s2/home_view',$data); 
        }
        else{//更改取款密码
          $this->Fund_account_model->update_ap_by_fid($f_id,$f_np);
          $this->load->model('s2/Fund_log_model');
          $this->Fund_log_model->insert_fund_log($f_id,'修改取款密码',1);
          //echo '<script type="text/javascript">alert("更改取款密码成功！");history.back();</script>';          
          $data['active_id']="fund_pwd";
          $data['error_rp']='更改取款密码成功！';
          $this->load->view('s2/home_view',$data); 
        }
      }
      else{//资金账户不正常
        //echo '<script type="text/javascript">alert("资金账户正在进行其他处理，更改密码失败！");history.back();</script>';
        $data['active_id']="fund_pwd";
        $data['error_rp']='资金账户正在进行其他处理，更改密码失败！';
        $this->load->view('s2/home_view',$data); 
      }
    }
  }


}
?>