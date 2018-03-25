<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
  public function Home(){
    parent::__construct();
    $this->load->library('session');
    $this->load->model('s2/admin_model');
  }


    public function index()
    {
      $this->load->helper('captcha');
      $vals = array(
      'word' => rand(1000, 10000),
      'img_path' => './captcha/',
      'img_url' => 'http://localhost/StockTrading/captcha/',
      //'font_path' => './path/to/fonts/texb.ttf',
      'img_width' => '150',
      'img_height' => 30,
      'expiration' => 7200
      );
      $cap = create_captcha($vals);
      $data['captcha']=$cap['image'];
      $data['active_id']='fish';

      $this->load->view("s2/home_view.php",$data);

    }

    public function status_query()
    {
        $this->load->library('form_validation');
        $config=array(
                array(
                     'field'   => 'account',
                     'label'   => 'account',
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'trade_password',
                     'label'   => 'Tradepassword',
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'atm_password',
                     'label'   => 'Atmpassword',
                     'rules'   => 'required'
                )
            );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE)
        {
            $account=$_POST["account"];
            $trade_password=$_POST["trade_password"];
            $atm_password=$_POST['atm_password'];
            $status=-1;//状态初值为-1，如果返回结果为-1，说明账户和密码不对

            $this->load->model("s2/Models");
            $status=$this->Models->status_query($account,$trade_password,$atm_password);
            if($status>=0)
            {
                $related_id=0;
                if($status==5)
                {
                  $related_id=$this->Models->related_id_query($account);
                }
                $this->add_log('fund',$account,"查询资金账户状态",1);
                $data["account"]=$account;
                $data["status"]=$status;
                $data["related_id"]=$related_id;
                $data["active_id"]="status_query_result";
                $this->load->view("s2/home_view.php",$data);
            }
            else
            {
                $data['active_id']='status_query';
                $data['error_sq']='资金账户和密码不匹配';
                $this->load->view("s2/home_view.php",$data);
            }
        }
        else
        {
            $data['active_id']="status_query";
            $data['error_sq']='存在未输入的项';
            $this->load->view("s2/home_view.php",$data);
        }
    }
    private function currency_ch($type)
    {
        switch($type)
        {
            case 0: return "人民币";
            case 1: return "美元";
            case 2: return "港币";
            case 3: return "欧元";
            case 4: return "英镑";
            case 5: return "日元";
            case 6: return "澳元";
            case 7: return "加元";
            case 8: return "瑞士法郎";
            case 9: return "新加坡元";
            default: return "无法识别的币种";
        }
    }
    private function table_row_color($type)
    {
        switch($type)
        {
            case 0: return "#FFFFCC";
            case 1: return "#FF99CC";
            case 2: return "#FFCC66";
            case 3: return "#CCFFCC";
            case 4: return "#CCFF66";
            case 5: return "#FFCC99";
            case 6: return "#99FFCC";
            case 7: return "#FFFFCC";
            case 8: return "#CCCCFF";
            case 9: return "#FFFF99";
            default:return "#FFFFFF";
        }
    }


    public function deposit_save()
    {
        $this->load->library('form_validation');
        $config=array(
                array(
                     'field'   => 'account',
                     'label'   => 'Account',
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'amount',
                     'label'   => 'Amount',
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'save_or_deposit',
                     'label'   => 'Save_or_deposit',
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'currency',
                     'label'   => 'Currency',
                     'rules'   => 'required'
                  )
            );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()==true)
        {
            $account=$_POST["account"];
            $password=$_POST["password"];
            $amount=$_POST["amount"];
            $save_or_deposit=$_POST["save_or_deposit"];
            $type=$_POST["currency"];
            $status=-1;


            $this->load->model("s2/Models");
            $status=$this->Models->deposit_save_password($account,$password);
            if($status==0)
            {
                if($this->Models->save_or_deposit($account,$amount,$save_or_deposit,$type))//存取款成功
                {
                    $this->add_log('fund',$account,"存取款",0);
                    $this->load->library('table');
                    $heading=array("资金账户ID","可用资金","冻结资金","总资金","币种");
                    $this->table->set_heading($heading);
                    $tmpl = array ( 'table_open'  => '<class="table table-hover table-bordered">' );
                    $this->table->set_template($tmpl);
                    $query=$this->Models->query_fund_info($account);
                    foreach($query->result() as $row)
                    {
                        $cell=array(
                            array('data'=>$row->fid,'bgcolor'=>$this->table_row_color($row->types) ),
                            array('data'=>$row->available,'bgcolor'=>$this->table_row_color($row->types) ),
                            array('data'=>$row->frozen,'bgcolor'=>$this->table_row_color($row->types) ),
                            array('data'=>$row->amount,'bgcolor'=>$this->table_row_color($row->types) ),
                            array('data'=>$this->currency_ch($row->types),'bgcolor'=>$this->table_row_color($row->types) )
                            );
                        $this->table->add_row($cell);
                    }
                    $data["account_info"]=$this->table->generate();
                    $data["active_id"]="deposit_save_result";
                    $this->load->view("s2/home_view.php",$data);
                }
                else
                {
                    $data['active_id']="deposit_save";
                    $data["error_ds"]="取款失败，可能资金不够";
                    $this->load->view("s2/home_view.php",$data);
                }
            }
            else
            {
                $data['active_id']="deposit_save";
                $data["error_ds"]="账户名密码出错或者卡不正常";
                $this->load->view("s2/home_view.php",$data);
            }
        }
        else
        {
             $data['active_id']='deposit_save';
             $data['error_ds']='存在未输入的项';
             $this->load->view("s2/home_view.php",$data);
        }

    }
    public function admin_login()
    {
        $this->load->library('form_validation');
        $config=array(
                array(
                     'field'   => 'account',
                     'label'   => 'account',
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'required'
                  )
            );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE)
        {
            $this->load->library('session');
            $account=$_POST["account"];
            $password=$_POST["password"];
            $this->load->model("s2/Models");
            if($this->Models->admin_login_password($account,$password))
            {
                $this->add_log('admin',$account,"管理员登陆",0);
                date_default_timezone_set("PRC");
                $newdata=array(
                  'agid' => $account,
                  'logintime' => date("Y-m-d H:i:s"),
                  //
                  'login' => '2R93R872@~~~~$ASA'
                );
                $this->admin_model->adLog($account,$newdata['logintime']);
                $this->session->set_userdata($newdata);
                redirect("/fund/fund_admin");
            }
            else
            {
                 $data['active_id']="admin_login";
                 $data["error_al"]="管理员账号密码出错";
                 $this->load->view("s2/home_view.php",$data);
            }
        }
        else
        {
          $data['active_id']='admin_login';
          $data["error_al"]="存在未输入的项";
          $this->load->view("s2/home_view.php",$data);
        }
    }

    public function add_log($fund_or_admin,$fid_or_agid,$content,$types)
    {
        $this->load->model("S2/Models");
        if($fund_or_admin=="fund")
        {
            $this->Models->add_fund_log($fid_or_agid,$content,$types);
        }
        else if($fund_or_admin=="admin")
        {
            $this->Models->add_admin_log($fid_or_agid,$content);
        }

    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
