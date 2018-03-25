<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Request_reissue_control extends CI_Controller {

  //获得输入
  private $r_id;//身份证号/法人注册号
  private $r_type;//类别  
  private $r_sid;//证券账户号  
  private $r_fid;//资金账户号
  //检查表单
  private $id_ok;
  private $sid_ok;
  private $fid_ok;
  //区分阶段
  private $chk_format,$chk_content,$handle;

  public function Request_reissue_control(){
    parent::__construct();
    $this->output->set_header("Content-Type: text/html; charset=utf-8");    
  }

    public function index()
    {
      $this->load->helper('form');
      $this->load->library('form_validation');
      //$this->load->model('s2/Fund_account_model');    
      $this->load->view('s2/request_reissue_view');
    }

    public function do_request_reissue()
    {
      $this->load->helper('form');
      $this->load->library('form_validation');          

      //0. get form input
      $r_id = $this->input->post('fr_id');
      $r_type = $this->input->post('fr_idtype');
      $r_sid = $this->input->post('fr_sid');
      $r_fid = $this->input->post('fr_fid');

      $id_ok = false;
      $sid_ok = false;
      $fid_ok = false;

      $chk_format = false;
      $chk_content = false;
      $handle = false;

      //1. check format
      //1-1. 身份证号/法人注册号
      if($r_type=="idc")//身份证号
      {
        $this->form_validation->set_rules('fr_id','身份证号','required|exact_length[18]|alpha_numeric');
        if($this->form_validation->run() == false){
          $id_ok = false;
          //echo '<script type="text/javascript">alert("身份证号格式不符合要求,请确认后重新输入");history.back();</script>';
          $data['active_id']="request_reissue";
          $data['error_rr']='身份证号格式不符合要求';
          $this->load->view('s2/home_view',$data);
        }
        else $id_ok = true;
      }
      else//法人注册号
      {
        $this->form_validation->set_rules('fr_id','法人注册号','required |exact_length[9]|alpha_numeric');
        if($this->form_validation->run() == false){
          $id_ok = false;
          //echo '<script type="text/javascript">alert("法人注册号格式不符合要求,请确认后重新输入");history.back();</script>';
          $data['active_id']="request_reissue";
          $data['error_rr']='法人注册号格式不符合要求';
          $this->load->view('s2/home_view',$data);
        }
        else $id_ok = true; 
      }
      //1-2. 证券账户号
      if($id_ok){
        $this->form_validation->set_rules('fr_sid','证券账户号','required|exact_length[18]|alpha_numeric');
        if($this->form_validation->run() == false){
          $sid_ok = false;
          //echo '<script type="text/javascript">alert("证券账户号格式不符合要求,请确认后重新输入");history.back();</script>';
          $data['active_id']="request_reissue";
          $data['error_rr']='证券账户号格式不符合要求';
          $this->load->view('s2/home_view',$data);
        }
        else $sid_ok = true;
      }      
      //1-3. 资金账户号
      if($sid_ok){
        $this->form_validation->set_rules('fr_fid','资金账户号','required|numeric|min_length[1]|max_length[16]');
        if($this->form_validation->run() == false){
          $fid_ok = false;
          //echo '<script type="text/javascript">alert("资金账户号格式不符合要求,请确认后重新输入");history.back();</script>';
          $data['active_id']="request_reissue";
          $data['error_rr']='资金账户号格式不符合要求';
          $this->load->view('s2/home_view',$data);
        }
        else $fid_ok = true;
      }
      $chk_format = $id_ok&$sid_ok&$fid_ok;

      //2. check content
      if($chk_format)
      {
        //2-1. 检查证券账户号是否存在
        $this->load->model('s2/Fund_account_model');
        $this->load->model('s2/Leg_stock_model');
        $this->load->model('s2/Idc_stock_model');
        if($r_type=="leg")//法人证券账户
        { 
          //2-1. 检查法人注册号是否存在
          if($this->Leg_stock_model->is_id_valid($r_id))
          {//法人注册号存在
            //2-2. 检查法人注册号和证券账户号是否对应
            if($r_id == $this->Leg_stock_model->get_leg_by_sid($r_sid))
            {//法人注册号和证券账户号对应
              //2-3. 检查资金账户号和证券账户号是否对应
              if($this->Fund_account_model->is_bind_fid_sid($r_fid,$r_sid))
              {//资金账户号和证券账户号对应
                $chk_content = true;
              }
              else{//资金账户号和证券账户号不对应
                $chk_content = false;
                //echo '<script type="text/javascript">alert("资金账户未绑定到证券账户！");history.back();</script>';                
                $data['active_id']="request_reissue";
                $data['error_rr']='资金账户未绑定到证券账户';
                $this->load->view('s2/home_view',$data);
              }
            }
            else{//法人注册号和证券账户号不对应
              $chk_content = false;
              //echo '<script type="text/javascript">alert("证券账户号和法人注册号不对应！");history.back();</script>';
              $data['active_id']="request_reissue";
              $data['error_rr']='证券账户号和法人注册号不对应';
              $this->load->view('s2/home_view',$data);
            }
          }
          else
          {//法人注册号不存在
            $chk_content = false;
            //echo '<script type="text/javascript">alert("该法人没有证券账户！");history.back();</script>';
            $data['active_id']="request_reissue";
            $data['error_rr']='该法人没有证券账户';
            $this->load->view('s2/home_view',$data);
          }
        }
        else//自然人证券账户
        { 
          //2-1. 检查身份证号是否存在
          if($this->Idc_stock_model->is_id_valid($r_id))
          {//身份证号存在
            //2-2. 检查身份证号和证券账户号是否对应
            if($r_id == $this->Idc_stock_model->get_idc_by_sid($r_sid))
            {//身份证号和证券账户号对应
              //2-3. 检查资金账户号和证券账户号是否对应
              if($this->Fund_account_model->is_bind_fid_sid($r_fid,$r_sid))
              {//资金账户号和证券账户号对应
                $chk_content = true;
              }
              else{//资金账户号和证券账户号不对应
                $chk_content = false;
                //echo '<script type="text/javascript">alert("资金账户未绑定到证券账户！");history.back();</script>';                
                $data['active_id']="request_reissue";
                $data['error_rr']='资金账户未绑定到证券账户';
                $this->load->view('s2/home_view',$data);
              }
            }
            else{//身份证号和证券账户号不对应
              $chk_content = false;
              //echo '<script type="text/javascript">alert("证券账户号和身份证号不对应！");history.back();</script>';
              $data['active_id']="request_reissue";
              $data['error_rr']='证券账户号和身份证号不对应';
              $this->load->view('s2/home_view',$data);
            }
          }
          else
          {//身份证号不存在
            $chk_content = false;
            //echo '<script type="text/javascript">alert("该自然人没有证券账户！");history.back();</script>';
            $data['active_id']="request_reissue";
            $data['error_rr']='该自然人没有证券账户';
            $this->load->view('s2/home_view',$data);
          }
        }
      }
      //3. handle
      if($chk_content)
      {
        //3-0. 检查账户是否正常
        if($this->Fund_account_model->is_normal($r_fid))        
        {
          //3-1. 更新资金账户状态
          $this->Fund_account_model->set_reissueing($r_fid);
          //3-2. 写fund_log日志
          $this->load->model('s2/Fund_log_model');
          $this->Fund_log_model->insert_fund_log($r_fid,'请求补办',1);
          //3-3. 写request
          $this->load->model('s2/Request_model');
          $agid_r = $this->Fund_account_model->get_agid_by_fid($r_fid);
          $this->Request_model->insert_request($r_fid,2,$r_id,$agid_r);
          //echo '<script type="text/javascript">alert("申请补办成功！");history.back();</script>';      
          $data['active_id']="request_reissue";
          $data['error_rr']='申请补办成功！';
          $this->load->view('s2/home_view',$data);
        }
        else{
          //echo '<script type="text/javascript">alert("资金账户正在进行其他处理，申请补办失败！");history.back();</script>';
          $data['active_id']="request_reissue";
          $data['error_rr']='资金账户正在进行其他处理，申请补办失败！';
          $this->load->view('s2/home_view',$data);
        }
      }
    }

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
}
?>