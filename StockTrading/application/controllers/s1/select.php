 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class select extends CI_Controller{
    function select(){  
        parent::__construct();
        $this->output->set_header("Content-Type: text/html; charset=utf-8");
    }    
    function index()
    {   
       
        $this -> load -> helper('form');   //支持form
        $this -> load -> library('form_validation'); //支持form进行表单验证 
       // $this ->load->view('s1/select_view');
            $this -> load -> model('s1/login_model');
    if ($this->login_model->check_login()==false)//判断是否登录，载入不同的界面
    {
        echo'<script type="text/javascript">alert("管理员未登录，请先进行管理员登录！");</script>';
        $this -> load->view('s1/navigation_home');
        $this -> load->view('s1/login_view');
    }
    else {
            $this -> load->view('s1/navigation_select');
            $this -> load->view('s1/select_view');
    }

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
            echo'<script type="text/javascript">alert("该股票账户号码格式错误，将根据身份证号码进行查询");</script>'; 
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
            //$data['sex']= $this->MOD->se_sex($s_stocknum,$s_id); //性别
            $sex=$this->MOD->se_sex($s_stocknum,$s_id); 
            if ($sex=='m')
                $data['sex']= "男";//性别
            else 
                $data['sex']='女';
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
            $this->load->view('s1/s_person_result',$data);//加载确认页面，同时传递参数
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
            echo'<script type="text/javascript">alert("该股票账户号码格式错误，将根据身份证号码进行查询");</script>'; 
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
            $this->load->view('s1/s_company_result',$data);//加载确认页面，传送data
        }
        }
        
    }
    
    function update_account_person(){
        $if_insert=0;
        $if_update_id=0;$if_update_name=0;$if_update_sex=0;$if_update_tel=0;$if_update_edu=0;
        $if_update_address=0; $if_update_profession=0;$if_update_work=0;
        $if_update_aname=0;$if_update_aid=0;
        $this -> load -> helper('form');  
        $this -> load -> library('form_validation');  
        $this -> load -> model('s1/mselect','MOD');
        
        $id=$this -> input -> post('id');
        $name=$this -> input -> post('name');
        $sex=$this -> input -> post('sex');
        $tel=$this -> input -> post('tel');
        $edu=$this -> input -> post('edu');
        $address=$this -> input -> post('address');
        $profession=$this -> input -> post('profession');
        $work=$this -> input -> post('work');
        $ifagen=$this -> input -> post('agency'); 
        
        //check 

        $this -> form_validation -> set_rules('id','身份证号码','required|min_length[18]|max_length[18]');   
        if($this -> form_validation ->run() == false) {  
            echo'<script type="text/javascript">alert("身份证号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
            
        } 
        if ($id == null) {$if_update_id=1;}
        $this -> form_validation -> set_rules('name','姓名','required|max_length[10]');
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("姓名信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
           
        }       
        if ($name==null) {$if_update_name=1;}
        $this -> form_validation -> set_rules('sex','性别');
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("性别信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
           
        }    
        if ($sex==null) {$if_update_sex=1;}
        $this -> form_validation -> set_rules('tel','电话号码','max_length[15]');
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("电话号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
            
        }  
         if ($tel == null) {$if_update_tel=1;}
        $this -> form_validation -> set_rules('edu','教育背景','max_length[80]');
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("教育背景信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
           
        }  
        if ($edu == null) {$if_update_edu = 1;}
        $this -> form_validation -> set_rules('address','家庭地址','max_length[50]');
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("家庭地址信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
            
        }   
        if($address==null) {$if_update_address = 1;}
        $this -> form_validation -> set_rules('profession','职业','max_length[30]');
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("职业信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
            
        }     
        if ($profession == null) {$if_update_profession = 1;}
        $this -> form_validation -> set_rules('work','工作单位','max_length[50]');
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("工作单位信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
            //if($work==null) {if_update_work=1;}
        } 
        if ($work == null) {$if_update_work = 1;}
        /*$this -> form_validation -> set_rules('agency','是否代办',"required");
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("是否代办信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
            
        } */
       /* if ($ifagen == 'y') {
            $aname=$this -> input -> post('aname'); 
            $aid=$this -> input -> post('aid'); 
            $this -> form_validation -> set_rules('aname','代办人姓名','max_length[10]'); 
            if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
                echo'<script type="text/javascript">alert("代办人姓名信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
                $if_insert=1; 
            } 
      
            $this -> form_validation -> set_rules('aid','代办人身份证号码','min_length[18]|max_length[18]');
            if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
                echo'<script type="text/javascript">alert("代办人身份证号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
                $if_insert=1; 
            } 
        }
        else {
           $aname='NULL'; 
           $aid='NULL';
        }
        */
        /*if (($stocknum=='')||($id=='')||($name=='')||($sex=='')||($tel=='')||($edu=='')||($address=='')||($profession=='')||($work=='')||($ifagen==''))
        {  
            $if_insert=1;
        }
        if ($if_insert==1){
            $data['information']="信息尚未填写完整，请审核后重新填写";

           
        }*/
            //  ($this->MOD->check_account($id) != FALSE)&& ($if_insert==0)    
        if (0){
           // echo'<script type="text/javascript">alert("该身份号码已经存在，请确认后重新输入");history.back();</script>';
            $if_insert=1;
        }
        else {
            $police_result=$this->MOD->check_police($id);
            if (($police_result== FALSE)&& ($if_insert==0)){
                echo'<script type="text/javascript">alert("公安局信息查询不到此身份证号码，请确认后重新输入");history.back();</script>'; 
                $if_insert=1;
            }
            else{ 
                foreach ($police_result as $row){
                //$row=mysqli_fetch_array($police_result);
                //$arr = $row;
                //if ( $row['年龄'] < 18){
                if (( $row->年龄 < 18)&& ($if_insert==0)){
                    echo'<script type="text/javascript">alert("未满18周岁,不具备注册资格,请确认后重新输入");history.back();</script>';
                    $if_insert=1;
                }
                else{
                    //if (($row['是否违反证券法规'] == 'Y') && ($row['是否期满'] == 'N')){
                    if (($row->是否违反证券法规 == 'Y') && ($row->是否期满 == 'N')&& ($if_insert==0)){
                        echo'<script type="text/javascript">alert("违反证券法规且禁期未满,不具备注册资格,请确认后重新输入");history.back();</script>';
                        $if_insert=1;
                    }
                    else if (($row->姓名 != $name)&& ($if_insert==0)){
                        echo'<script type="text/javascript">alert("身份证号和姓名信息不对印,请确认后重新输入");history.back();</script>';
                        $if_insert=1;
                    }
                    else{
                        $stock_result=$this->MOD->check_stock($id);
                        if (($stock_result != FALSE)&& ($if_insert==0))
                        {   
                            echo'<script type="text/javascript">alert( "身份信息为证券从业人员,不具备注册资格");history.back();</script>';
                            $if_insert=1;
                        }
                        else {
                            ;
                        }
                    }
                }}
            }
        
        }
        //  验证 代办人身份证号码
        if ($ifagen == 'y') {
            $police_result=$this->MOD->check_police($aid);
            if (($police_result== FALSE)&& ($if_insert==0)){
                echo'<script type="text/javascript">alert("公安局信息查询不到代办人身份证号码，请确认后重新输入");history.back();</script>'; 
                $if_insert=1;
            }
            else{
                foreach ($police_result as $row){
                    if(($row->姓名 != $aname)&& ($if_insert==0)){
                        echo'<script type="text/javascript">alert("代办人身份证号码和姓名不符合，请确认后重新输入");history.back();</script>';  
                        $if_insert=1;
                    }
                }

            }
        }

        //


        if($if_insert==0){
            $t = gmdate("Y-m-d H:i:s", mktime() + 8 * 3600);
            /*
            $stocknum=$this->MOD->randStr(10);
            $check_stocknum=$this->MOD->check_stocknum_person($stocknum);
            while ($check_stocknum!=FALSE)
            {
                $stocknum=$this->MOD->randStr(10);
                $check_stocknum=$this->MOD->check_stocknum_person($stocknum); 
            } *////
            //$this->MOD->insert_account_person($stocknum,$id,$name,$sex,$tel,$edu,$address,$profession,$work,$ifagen,$t,$aname,$aid);
            //echo'<script type="text/javascript">alert("成功注册");history.back();</script>';
            //if ($if_update_id==0){$this->MOD->update_person_id($id);}
            //if ($if_update_name==0){$this->MOD->update_person_name($name);}
            if ($if_update_sex==0){$this->MOD->update_person_sex($id,$sex);}
            if ($if_update_tel==0){$this->MOD->update_person_tel($id,$tel);}
            if ($if_update_edu==0){$this->MOD->update_person_edu($id,$edu);}
            if ($if_update_address==0){$this->MOD->update_person_address($id,$address);}
            if ($if_update_profession==0){$this->MOD->update_person_profession($id,$profession);}
            if ($if_update_work==0){$this->MOD->update_person_work($id,$work);}
            //if (if_update_id==0){$this->MOD->update_person_id($id);}
            //$data['stocknum']= $stocknum;
            $data['t']= $t;
            $data['id']= $id;
            $data['name']= $name;
            if ($sex=="male")
                $data['sex']= "男";//性别
            else 
                $data['sex']='女';
            //$data['sex']= $sex;
            $data['tel']= $tel;
            $data['edu']= $edu;
            $data['address']= $address;
            $data['profession']= $profession;
            $data['work']= $work;
            if ($ifagen=='y'){
                $data['ifagen']="代办账户";
                $data['aname']= $aname;
                $data['aid']= $aid;
            }
            else{
                $data['ifagen']="非代办账户";
                $data['aname']= "-";
                $data['aid']= "-";
            }
            $this->load->view('s1/u_person_result',$data);
        }
        
    }
   /*//////////////////////////
        $id=$this -> input -> post('id');
        $name=$this -> input -> post('name');
        $sex=$this -> input -> post('sex');
        $tel=$this -> input -> post('tel');
        $edu=$this -> input -> post('edu');
        $address=$this -> input -> post('address');
        $profession=$this -> input -> post('profession');
        $work=$this -> input -> post('work');
        $ifagen=$this -> input -> post('agency'); 
///////////////////////////////////////////*/




    function testid(){
        //$id=$this -> input -> get('id');
        $id=$_GET["id"];
        $this -> load -> model('s1/mregister','MOD');

            if ($this->MOD->check_account($id) != FALSE){
                echo "该身份号码已经存在，请确认后重新输入";
            }
            else {
                $police_result=$this->MOD->check_police($id);
                if ($police_result == FALSE){
                    echo "公安局查询不到此身份证号码，请确认后重新输入"; 
                }
                else{ 
                    foreach ($police_result as $row){
                    if ( $row->年龄 < 18){
                        echo "未满18周岁,不具备注册资格,请确认后重新输入";
                    }
                    else{
                    //if (($row['是否违反证券法规'] == 'Y') && ($row['是否期满'] == 'N')){
                        if (($row->是否违反证券法规 == 'Y') && ($row->是否期满 == 'N')){
                            echo "违反证券法规且禁期未满,不具备注册资格,请确认后重新输入";
                        }
                        else{
                            $stock_result=$this->MOD->check_stock($id);
                            if ($stock_result == TRUE)
                            {   
                                echo "身份信息为证券从业人员,不具备注册资格";
                            }
                            else {
                                echo "";
                            }
                        }
                }   }
            }
        
        }

    
        
    }
    function update_account_company(){
        $if_insert=0;
        $if_update_regisnum=0;$if_update_bus_license=0;$if_update_atel=0;
        $if_update_aaddress=0;$if_update_gtel=0;$if_update_gaddress=0;
        $this -> load -> helper('form');  
        $this -> load -> library('form_validation');  
        $this -> load -> model('s1/mselect','MOD');
        
        $regisnum=$this -> input -> post('regisnum');
        $bus_license=$this -> input -> post('bus_license');
        $aid=$this -> input -> post('aid');
        $aname=$this -> input -> post('aname');
        $atel=$this -> input -> post('atel');
        $aaddress=$this -> input -> post('aaddress');
        //$ename=$this -> input -> post('ename');
       // $gid=$this -> input -> post('gid');
        $gtel=$this -> input -> post('gtel'); 
        $gaddress=$this -> input -> post('gaddress'); 
        
        //check 
    /*
        $this -> form_validation -> set_rules('regisnum','法人注册登记号码','max_length[20]');   

        if($this -> form_validation ->run() == false) {  
            echo'<script type="text/javascript">alert("法人注册登记号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
            
        }
        if($regisnum==null) {$if_update_regisnum=1;}
        $this -> form_validation -> set_rules('bus_license','营业执照','max_length[9]');
        
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("法营业执照号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
            
        }        
        if($bus_license==null){$if_update_bus_license=1;}
    */
    
    
        $this -> form_validation -> set_rules('aid','法人身份证号码','required|min_length[18]|max_length[18]');

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("法人身份证号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }  

        $this -> form_validation -> set_rules('aname','法人姓名','required|max_length[10]');

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("法人姓名信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }  

        $this -> form_validation -> set_rules('atel','法人联系电话','max_length[15]');

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("法人联系电话信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1;
            
        }  
         if ($atel==null) {$if_update_atel=1;} 

        $this -> form_validation -> set_rules('aaddress','法人联系地址','max_length[50]');

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("法人联系地址信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
           
        }   
          if ($aaddress==null){$if_update_aaddress=1;}
        $this -> form_validation -> set_rules('gtel','授权人联系电话','max_length[15]');

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("授权人联系电话信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
           
        }  
          if ($gtel==null){$if_update_gtel=1;}
        $this -> form_validation -> set_rules('gaddress','授权人地址','max_length[50]');
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("授权人地址信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
           
        }  
          if($gaddress==null) {$if_update_gaddress=1;}
        /*if($this -> form_validation ->run() == false) {  
            echo'<script type="text/javascript">alert("信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        } */

        if (0){
            echo'<script type="text/javascript">alert("该身份号码已经存在，请确认后重新输入");history.back();</script>';
            $if_insert=1;
        }
        else {
            $police_result=$this->MOD->check_police($aid);
            if (($police_result== FALSE)&& ($if_insert==0)){
                echo'<script type="text/javascript">alert("公安局信息查询不到此身份证号码，请确认后重新输入");history.back();</script>'; 
                $if_insert=1;
            }
            else{ 
                foreach ($police_result as $row){
                //$row=mysqli_fetch_array($police_result);
                //$arr = $row;
                //if ( $row['年龄'] < 18){
                if (($row->年龄 < 18)&& ($if_insert==0)){
                    echo'<script type="text/javascript">alert("未满18周岁,不具备注册资格,请确认后重新输入");history.back();</script>';
                    $if_insert=1;
                }
                else{
                    //if (($row['是否违反证券法规'] == 'Y') && ($row['是否期满'] == 'N')){
                    if (($row->是否违反证券法规 == 'Y') && ($row->是否期满 == 'N')&& ($if_insert==0)){
                        echo'<script type="text/javascript">alert("违反证券法规且禁期未满,不具备注册资格,请确认后重新输入");history.back();</script>';
                        $if_insert=1;
                    }
                    else if (($row->姓名 != $aname)&& ($if_insert==0)){
                        echo'<script type="text/javascript">alert("法人身份证号和姓名信息不对印,请确认后重新输入");history.back();</script>';
                        $if_insert=1;
                    }
                    else{
                        $stock_result=$this->MOD->check_stock($aid);
                        if (($stock_result != FALSE)&& ($if_insert==0))
                        {   
                            echo'<script type="text/javascript">alert( "身份信息为证券从业人员,不具备注册资格");history.back();</script>';
                            $if_insert=1;
                        }
                        else {
                            ///////////////
                            //$police_result=$this->MOD->check_police($gid);
                          /*  if (($police_result== FALSE)&& ($if_insert==0)){
                                echo'<script type="text/javascript">alert("公安局信息查询不到授权人身份证号码，请确认后重新输入");history.back();</script>'; 
                                $if_insert=1;
                            }
                            else{
                                foreach ($police_result as $row){
                                    if(($row->姓名 != $ename)&& ($if_insert==0)){
                                        echo'<script type="text/javascript">alert("授权人身份证号码和姓名不符合，请确认后重新输入");history.back();</script>';  
                                        $if_insert=1;
                                    }
                                }

                            }
        
                            /////////////////
                      */  } 
                        
                    }
                }}
            }
        
        }
        if($if_insert==0){
            $t = gmdate("Y-m-d H:i:s", mktime() + 8 * 3600);
            /*
            $stocknum=$this->MOD->randStr(10);
            $check_stocknum=$this->MOD->check_stocknum_company($stocknum);
            while ($check_stocknum!=FALSE){
                $stocknum=$this->MOD->randStr(10);
                $check_stocknum=$this->MOD->check_stocknum_company($stocknum); 
            } */
            //$this->MOD->insert_account_company($stocknum,$regisnum,$bus_license,$aid,$aname,$atel,$aaddress,$ename,$gid,$gtel,$gaddress);
            //echo'<script type="text/javascript">alert("成功注册");history.back();</script>';
            //if ($if_update_regisnum==0){$this->MOD->update_company_regisnum($aid,$regisnum);}
            //if ($if_update_bus_license==0){$this->MOD->update_company_bus_license($aid,$bus_license);}
            if ($if_update_atel==0){$this->MOD->update_company_atel($aid,$atel);}
            if ($if_update_aaddress==0){$this->MOD->update_company_aaddress($aid,$aaddress);}
            if ($if_update_gtel==0){$this->MOD->update_company_gtel($aid,$gtel);}
            if ($if_update_gaddress==0){$this->MOD->update_company_gaddress($aid,$gaddress);}
            //$data['stocknum']= $stocknum;
            $data['regisnum']= $regisnum;
            $data['bus_license']= $bus_license;
            $data['aid']= $aid;
            $data['aname']= $aname;
            $data['atel']= $atel;
            $data['aaddress']= $aaddress;
           // $data['ename']= $ename;
            //$data['gid']= $gid;
            $data['gtel']= $gtel;
            $data['gaddress']= $gaddress;
            $this->load->view('s1/u_company_result',$data);
        }
        /*//////////////////////////////////
        $regisnum=$this -> input -> post('regisnum');
        $bus_license=$this -> input -> post('bus_license');
        $aid=$this -> input -> post('aid');
        $aname=$this -> input -> post('aname');
        $atel=$this -> input -> post('atel');
        $aaddress=$this -> input -> post('aaddress');
        $ename=$this -> input -> post('ename');
        $gid=$this -> input -> post('gid');
        $gtel=$this -> input -> post('gtel'); 
        $gaddress=$this -> input -> post('gaddress'); 
        /////////////////////////////////*/

    }
    }
    


