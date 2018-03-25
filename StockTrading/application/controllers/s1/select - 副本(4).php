 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class select extends CI_Controller{
    function Hselect(){  
        parent::__construct();
        $this->output->set_header("Content-Type: text/html; charset=utf-8");
    }    
    function index()
    {   
       
        $this -> load -> helper('form');   //支持form
        $this -> load -> library('form_validation'); //支持form进行表单验证 
        $this ->load->view('s1/select_view');

    } 
    
    function select_account(){   //查找自然人账户的程序
        $if_select1=0;
        $if_select2=0;
        $if_select3=0;
        $this -> load -> helper('form');  
        $this -> load -> library('form_validation');  //支持表单验证
        $this -> load -> model('s1/mselect','MOD'); //连接model里的php文件进行数据库的交接
        
        
        $s_stocknum=$this -> input -> post('s_stocknum'); //获得用户账号信息
        $s_id=$this -> input -> post('s_id');  //获得用户身份证信息
        $sel=$this -> input -> post('sel');  //获得查询类型
        
        //check 

         
        if(strlen($s_stocknum) != 10) {  //如果格式验证失败，提示信息
            //echo'<script type="text/javascript">alert("股票账户号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_select1 = 1; 
        } 
         

        $this -> form_validation -> set_rules('s_id','身份证号码','required|min_length[18]|max_length[18]');//对表单身份证号码做了验证   
        if($this -> form_validation ->run() == false) {  //如果格式验证失败，提示信息
            //echo'<script type="text/javascript">alert("身份证号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_select2 = 1; 
        } 
        
        if ( ($if_select1==1) && ($if_select2==1)){  //检测是否输入至少一项信息 ，不存在报错
            echo'<script type="text/javascript">alert("请输入至少一项正确信息");history.back();</script>';
            $if_select3=1;
        }
        
        if($sel==1){
        
       
        
        
        if(($this->MOD->s_check_account3($s_stocknum,$s_id) != 1)&& ($if_select3==0)){ //检测信息是否指向唯一用户 ，若不是则报错
            echo'<script type="text/javascript">alert("信息有误，请重新输入");history.back();</script>';
            $if_select3=1;
        }
        
        if (($this->MOD->s_check_account1($s_stocknum) == FALSE)&& ($if_select1==0)&&($if_select3==0)){  //检测是否存在该股票账户号码的股票账户 ，不存在报错
            echo'<script type="text/javascript">alert("该股票账户号码未存在，将根据身份证号码进行查询");</script>';
            
        }
        if (($this->MOD->s_check_account2($s_id) == FALSE)&& ($if_select2==0)&&($if_select3==0)){  //检测是否存在该身份证号码的股票账户 ，不存在报错
            echo'<script type="text/javascript">alert("该身份证号码未存在，将根据股票账户号码进行查询");</script>';
           
        }
        
        if((strlen($s_stocknum) != 10)&&($if_select3==0)) {  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("该股票账户号码格式错误，将根据股票账户号码进行查询");</script>'; 
        }
        
        
        if(($this -> form_validation ->run() == false)&&($if_select3==0)) {  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("该身份证号码格式错误，将根据股票账户号码进行查询");</script>'; 
        }
        
        if($if_select3==0){ //如果上诉检测都没有报错，则执行向数据库查询自然人证券账户信息的步骤
            //$ss_stocknum = $this->MOD->se_stocknum($s_stocknum,$s_id);
            $data['stocknum']= $this->MOD->se_stocknum($s_stocknum,$s_id);  //将注册的信息的方式值赋值到data的数组中，返回到确认页面
            $data['t']= $this->MOD->se_t($s_stocknum,$s_id);  //时间
            $data['id']= $this->MOD->se_id($s_stocknum,$s_id); //身份证
            $data['name']= $this->MOD->se_name($s_stocknum,$s_id); //名字
            $data['sex']= $this->MOD->se_sex($s_stocknum,$s_id); //性别
            $data['tel']= $this->MOD->se_tel($s_stocknum,$s_id); //电话
            $data['edu']= $this->MOD->se_edu($s_stocknum,$s_id); //教育
            $data['address']= $this->MOD->se_address($s_stocknum,$s_id); //地址
            $data['profession']= $this->MOD->se_profession($s_stocknum,$s_id); //职业
            $data['work']= $this->MOD->se_work($s_stocknum,$s_id); //工作
            if ($this->MOD->se_acc($s_stocknum,$s_id) =='y'){//如果是代办
                $data['ifagen']="代办账户"; //是代办
                $data['aname']= $this->MOD->se_aname($s_stocknum,$s_id);//代办人姓名
                $data['aid']= $this->MOD->se_aid($s_stocknum,$s_id);//身份证
            }
            else{
                $data['ifagen']="非代办账户";//不是代办
                $data['aname']= "-"; //信息为空
                $data['aid']= "-";
            }
            $this->load->view('s1/person_result',$data);//加载确认页面，同时传递参数
        }
        }
        
        
        if($sel==2){
        
        if(($this->MOD->se_check_account3($s_stocknum,$s_id) != 1)&& ($if_select3==0)){ //检测信息是否指向唯一用户 ，若不是则报错
            echo'<script type="text/javascript">alert("信息有误，请重新输入");history.back();</script>';
            $if_select3=1;
        }
        
        if (($this->MOD->se_check_account1($s_stocknum) == FALSE)&& ($if_select1==0)&&($if_select3==0)){  //检测是否存在该股票账户号码的股票账户 ，不存在报错
            echo'<script type="text/javascript">alert("该股票账户号码未存在，将根据身份证号码进行查询");</script>';
            
        }
        if (($this->MOD->se_check_account2($s_id) == FALSE)&& ($if_select2==0)&&($if_select3==0)){  //检测是否存在该身份证号码的股票账户 ，不存在报错
            echo'<script type="text/javascript">alert("该身份证号码未存在，将根据股票账户号码进行查询");</script>';
           
        }
        
        if((strlen($s_stocknum) != 10)&&($if_select3==0)) {  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("该股票账户号码格式错误，将根据股票账户号码进行查询");</script>'; 
        }
        
        
        if(($this -> form_validation ->run() == false)&&($if_select3==0)) {  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("该身份证号码格式错误，将根据股票账户号码进行查询");</script>'; 
        }
        
        if(($if_select3==0)&&($sel==2)){ //如果上诉检测都没有报错，则执行向数据库查询法人证券账户信息的步骤
            $data['stocknum']= $this->MOD->se_stocknum1($s_stocknum,$s_id);  //将注册的信息的方式值赋值到data的数组中，返回到确认页面
            $data['regisnum']= $this->MOD->se_regisnum1($s_stocknum,$s_id);  //时间
            $data['bus_license']= $this->MOD->se_bus_license1($s_stocknum,$s_id); //身份证
            $data['aid']= $this->MOD->se_aid1($s_stocknum,$s_id); //名字
            $data['aname']= $this->MOD->se_aname1($s_stocknum,$s_id); //性别
            $data['atel']= $this->MOD->se_atel1($s_stocknum,$s_id); //电话
            $data['aaddress']= $this->MOD->se_aaddress1($s_stocknum,$s_id); //地址
            $data['ename']= $this->MOD->se_ename1($s_stocknum,$s_id); //职业
            $data['gid']= $this->MOD->se_gid1($s_stocknum,$s_id); //职业
            $data['gtel']= $this->MOD->se_gtel1($s_stocknum,$s_id); //工作
            $data['gaddress']= $this->MOD->se_gaddress1($s_stocknum,$s_id); //工作
            $this->load->view('s1/company_result',$data);//加载确认页面，传送data
        }
        }
        
    }
    }
    


