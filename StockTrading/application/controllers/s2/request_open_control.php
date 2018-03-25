<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//[开户要不要和证券账户关联]
class Request_open_control extends CI_Controller {
	//获得输入
  private $o_id,$o_type;//身份证/法人注册号,类别
	private $o_sid;//证券账户号
  private $o_lp,$o_lpc;//登录密码及确认
	private $o_tp,$o_tpc;//交易密码及确认
	private $o_ap,$o_apc;//取款密码及确认
  private $o_agi;//经纪商编号

  //检查表单每一项
  private $id_ok;
  private $sid_ok;
  private $lp_ok,$lpc_ok;
  private $tp_ok,$tpc_ok;
  private $ap_ok,$apc_ok;
  private $agi_ok;

  //区分阶段
  private $chk_format,$chk_content,$handle;

	public function Request_open_control(){
		parent::__construct();
		$this->output->set_header("Content-Type: text/html; charset=utf-8");
	}

  public function index()
  {
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->view('s2/request_open_view');
   // $this->output->enable_profiler(TRUE);

  }

  //执行申请开户操作
  public function do_request_open()
  {
    $this->load->helper('form');
    $this->load->library('form_validation');

    //var_dump($_POST);
    //0. get form input
    $o_id = $this->input->post('fo_id');
    $o_type = $this->input->post('fo_idtype');
    $o_sid = $this->input->post('fo_sid');
    $o_lp = $this->input->post('fo_lp');
    $o_lpc = $this->input->post('fo_lpc');
    $o_tp = $this->input->post('fo_tp');
    $o_tpc = $this->input->post('fo_tpc');
    $o_ap = $this->input->post('fo_ap');
    $o_apc = $this->input->post('fo_apc');
    $o_agi = $this->input->post('fo_agi');

    $id_ok = false;
    $sid_ok = false;
    $lp_ok = false;
    $lpc_ok = false;
    $tp_ok = false;
    $tpc_ok = false;
    $ap_ok = false;
    $apc_ok = false;
    $agi_ok = false;

    $chk_format = false;
    $chk_content = false;
    $handle = false;

    //1. check format
    //1-1. 身份证号/法人注册号
    if($o_type=="idc")//身份证号
    {
      $this->form_validation->set_rules('fo_id','身份证号','required|exact_length[18]|alpha_numeric');
      if($this->form_validation->run() == false){
        $id_ok = false;
       // echo '<script type="text/javascript">alert("身份证号格式不符合要求,请确认后重新输入");history.back();</script>';
        $data['active_id']="request_open";
        $data['error_ro']='身份证号格式不符合要求';
        $this->load->view('s2/home_view',$data);
      }
      else $id_ok = true;
    }
    else//法人注册号
    {
      $this->form_validation->set_rules('fo_id','法人注册号','required |exact_length[9]|alpha_numeric');
      if($this->form_validation->run() == false){
        $id_ok = false;
        //echo '<script type="text/javascript">alert("法人注册号格式不符合要求,请确认后重新输入");history.back();</script>';
        $data['active_id']="request_open";
        $data['error_ro']='法人注册号格式不符合要求';
        $this->load->view('s2/home_view',$data);
      }
      else $id_ok = true;
    }
    //1-2. 证券账户号
    if($id_ok){
      //modified by MXY at 1:21 2014.07.02 for exact_length[18]
      $this->form_validation->set_rules('fo_sid','证券账户号','required|exact_length[10]|alpha_numeric');
      if($this->form_validation->run() == false){
        $sid_ok = false;
        //echo '<script type="text/javascript">alert("证券账户号格式不符合要求,请确认后重新输入");history.back();</script>';
        $data['active_id']="request_open";
        $data['error_ro']='证券账户号格式不符合要求';
        $this->load->view('s2/home_view',$data);
      }
      else $sid_ok = true;
    }
    //1-3. 密码和密码确认
    if($sid_ok){//登录密码
      $this->form_validation->set_rules('fo_lp','登陆密码','required|min_length[6]|max_length[15]|alpha_numeric');
      if($this->form_validation->run() == false){
        $lp_ok = false;
        //echo '<script type="text/javascript">alert("登陆密码格式不符合要求,请确认后重新输入");history.back();</script>';
        $data['active_id']="request_open";
        $data['error_ro']='登陆密码格式不符合要求';
        $this->load->view('s2/home_view',$data);
      }
      else $lp_ok = true;
    }
    if($lp_ok){//登录密码确认
      $this->form_validation->set_rules('fo_lpc','登陆密码确认','required|min_length[6]|max_length[15]|alpha_numeric');
      if($this->form_validation->run() == false){
        $lpc_ok = false;
        //echo '<script type="text/javascript">alert("登陆密码确认格式不符合要求,请确认后重新输入");history.back();</script>';
        $data['active_id']="request_open";
        $data['error_ro']='登陆密码确认格式不符合要求';
        $this->load->view('s2/home_view',$data);
      }
      else $lpc_ok = true;
    }
    if($lpc_ok){//交易密码
      $this->form_validation->set_rules('fo_tp','交易密码','required|exact_length[6]|numeric');
      if($this->form_validation->run() == false){
        $tp_ok = false;
        //echo '<script type="text/javascript">alert("交易密码格式不符合要求,请确认后重新输入");history.back();</script>';
        $data['active_id']="request_open";
        $data['error_ro']='交易密码格式不符合要求';
        $this->load->view('s2/home_view',$data);
      }
      else $tp_ok = true;
    }
    if($tp_ok){//交易密码确认
      $this->form_validation->set_rules('fo_tpc','交易密码确认','required|exact_length[6]|numeric');
      if($this->form_validation->run() == false){
        $tpc_ok = false;
        //echo '<script type="text/javascript">alert("交易密码确认格式不符合要求,请确认后重新输入");history.back();</script>';
        $data['active_id']="request_open";
        $data['error_ro']='交易密码确认格式不符合要求';
        $this->load->view('s2/home_view',$data);
      }
      else $tpc_ok = true;
    }
    if($tpc_ok){//取款密码
      $this->form_validation->set_rules('fo_ap','取款密码','required|exact_length[6]|numeric');
      if($this->form_validation->run() == false){
        $ap_ok = false;
        //echo '<script type="text/javascript">alert("取款密码格式不符合要求,请确认后重新输入");history.back();</script>';
        $data['active_id']="request_open";
        $data['error_ro']='取款密码格式不符合要求';
        $this->load->view('s2/home_view',$data);
      }
      else $ap_ok = true;
    }
    if($ap_ok){//取款密码确认
      $this->form_validation->set_rules('fo_apc','取款密码确认','required|exact_length[6]|numeric');
      if($this->form_validation->run() == false){
        $apc_ok = false;
        //echo '<script type="text/javascript">alert("取款密码确认格式不符合要求,请确认后重新输入");history.back();</script>';
        $data['active_id']="request_open";
        $data['error_ro']='取款密码确认格式不符合要求';
        $this->load->view('s2/home_view',$data);
      }
      else $apc_ok = true;
    }
    if($apc_ok){//经纪商编号
      if($o_agi==0){
        $agi_ok = false;
        //echo '<script type="text/javascript">alert("请选择经纪商");history.back();</script>';
        $data['active_id']="request_open";
        $data['error_ro']='请选择经纪商';
        $this->load->view('s2/home_view',$data);
      }
      else $agi_ok = true;
    }
    $chk_format = $id_ok&$sid_ok&$lp_ok&$lpc_ok&$tp_ok&$tpc_ok&$ap_ok&$apc_ok&$agi_ok;

    //2. check content
    if($chk_format)//输入格式正确时检查内容
    {
      // 重置
      $id_ok = false;
      $sid_ok = false;
      $lp_ok = false;
      $tp_ok = false;
      $ap_ok = false;
      $agi_ok = false;
      //2-1. 检查证券账户号是否存在
      $this->load->model('s2/Fund_account_model');
      $this->load->model('s2/Leg_stock_model');
      $this->load->model('s2/Idc_stock_model');
      if($o_type=="leg")//法人证券账户
      {
        //2-1. 检查法人注册号是否存在
        if($this->Leg_stock_model->is_id_valid($o_id))
        {//法人注册号存在
          $id_ok = true;
          //2-2. 检查法人注册号和证券账户号是否对应
          if($o_id == $this->Leg_stock_model->get_leg_by_sid($o_sid))
          {//法人注册号和证券账户号对应
            $sid_ok = true;
          }
          else{//法人注册号和证券账户号不对应
            $sid_ok = false;
            //echo '<script type="text/javascript">alert("证券账户号和法人注册号不对应！");history.back();</script>';
            $data['active_id']="request_open";
            $data['error_ro']='证券账户号和法人注册号不对应';
            $this->load->view('s2/home_view',$data);
          }
        }
        else
        {//法人注册号不存在
          $id_ok = false;
          //echo '<script type="text/javascript">alert("该法人没有证券账户！");history.back();</script>';
          $data['active_id']="request_open";
          $data['error_ro']='该法人没有证券账户';
          $this->load->view('s2/home_view',$data);
        }
      }
      else//自然人证券账户
      {
        //2-1. 检查身份证号是否存在
        if($this->Idc_stock_model->is_id_valid($o_id))
        {//身份证号存在
          $id_ok = true;
          //2-2. 检查身份证号和证券账户号是否对应
          if($o_id == $this->Idc_stock_model->get_idc_by_sid($o_sid))
          {//身份证号和证券账户号对应
            $sid_ok = true;
          }
          else{//身份证号和证券账户号不对应
            $sid_ok = false;
            //echo '<script type="text/javascript">alert("证券账户号和身份证号不对应！");history.back();</script>';
            $data['active_id']="request_open";
            $data['error_ro']='证券账户号和身份证号不对应';
            $this->load->view('s2/home_view',$data);
          }
        }
        else
        {//身份证号不存在
          $id_ok = false;
          //echo '<script type="text/javascript">alert("该自然人没有证券账户！");history.back();</script>';
          $data['active_id']="request_open";
          $data['error_ro']='该自然人没有证券账户';
          $this->load->view('s2/home_view',$data);
        }
      }
      if($o_lp!=$o_lpc){
        $lp_ok = false;
        //echo '<script type="text/javascript">alert("登录密码及确认不一致！");history.back();</script>';
        $data['active_id']="request_open";
        $data['error_ro']='登录密码及确认不一致';
        $this->load->view('s2/home_view',$data);
      }
      else{
        $lp_ok = true;
        if($o_tp!=$o_tpc){
          $tp_ok = false;
          //echo '<script type="text/javascript">alert("交易密码及确认不一致！");history.back();</script>';
          $data['active_id']="request_open";
          $data['error_ro']='交易密码及确认不一致';
          $this->load->view('s2/home_view',$data);
        }
        else {
          $tp_ok = true;
          if($o_ap!=$o_apc){
            $ap_ok = false;
            //echo '<script type="text/javascript">alert("取款密码及确认不一致！");history.back();</script>';
            $data['active_id']="request_open";
            $data['error_ro']='取款密码及确认不一致';
            $this->load->view('s2/home_view',$data);
          }
          else $ap_ok = true;
        }
      }
    }
    $chk_content = $chk_format&$id_ok&$sid_ok&$lp_ok&$tp_ok&$ap_ok;

    //3. handle
    if($chk_content)//输入内容正确时进行处理
    {
      //1. 更新fund_account
      $fn_id = $this->Fund_account_model->insert_fund_account($o_id,$o_sid,$o_lp,$o_tp,$o_ap,$o_agi);
      //2. 写fund_log日志
      $this->load->model('s2/Fund_log_model');
      $this->Fund_log_model->insert_fund_log($fn_id,'请求开户',1);
      //3. 写请求
      $this->load->model('s2/Request_model');
      $this->Request_model->insert_request($fn_id,0,$o_id,$o_agi);
      //echo '<script type="text/javascript">alert("申请开户成功！");history.back();</script>';
      $data['active_id']="request_open";
      $data['error_ro']='申请开户成功！您的新资金账户号是'.$fn_id;
      $this->load->view('s2/home_view',$data);
    }
  }

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
}
?>
