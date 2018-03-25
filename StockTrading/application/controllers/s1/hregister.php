<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hregister extends CI_Controller{
    function Hregister(){  
        parent::__construct();
        $this->output->set_header("Content-Type: text/html; charset=utf-8");
        //$this->load->library('session');
    }    
    function index()
    {   
       
        $this -> load -> helper('form');   //支持form
        $this -> load -> library('form_validation'); //支持form进行表单验证 
        //$this -> load -> view('s1/test_view');
        //$this->load->model('s1/model','Test');
        //$this->load->view('s2/home_view',$data);
        //$this ->load->view('s1/login_manager');  
        //$this ->load->view('s1/login_person');
        //$this ->load->view('s1/register_view');
        //$this ->load->view('s1/login_view');
        //$this -> load -> view('list_news');  
        //$this -> load -> view('s1/bview');
        //$this -> load -> view('s1/lview');
        //$this -> load -> view('s1/register_view');
        //$this -> load -> view('s1/navigation_reg');
        //$this ->load->view('s1/login_person');
        $this -> load -> model('s1/login_model'); //连接model部分的php程序，便于进行数据库交接
        if ($this->login_model->check_login()==false) //检查是否处于登陆状态
        {
            echo'<script type="text/javascript">alert("管理员未登录，请先进行管理员登录！");</script>';//不属于等于状态要报错
            $this -> load->view('s1/navigation_home');//如果不属于登陆状态就加载相应的提示页面
            $this -> load->view('s1/login_view');
        }
        else {
            $this -> load->view('s1/navigation_reg');//如果处于登陆状态跳转到正确的页面
            $this -> load->view('s1/register_view');
        }

    } 

   /* function manager_login(){//该函数不被使用
        session_start();
        $this -> load -> model('s1/mregister','MOD');  
        $name=$this -> input -> post('name');  
        $secret=$this -> input -> post('secret');
        //$result=$this -> MOD -> manager_loginin($name,$secret);
        $data['query']==$this -> MOD -> manager_login_m($name,$secret);
        $this->load->view('s1/back',$data);
       /* if ($result == TRUE){
           // $_SESSION['name']=$name;
            //echo "<a href='s1/login_person.php'>前往下一页</a>";
           //$this ->load->view('s1/login_person');
           
           
        }
        else {
            echo "用户名不存在";
        }
    }*/
    function insert_account(){   //插入自然人账户的程序
        $if_insert=0;
        $this -> load -> helper('form');  
        $this -> load -> library('form_validation');  //支持表单验证
        $this -> load -> model('s1/mregister','MOD'); //连接model里的php文件进行数据库的交接
        
        $id=$this -> input -> post('id');  //获得用户身份证信息
        $name=$this -> input -> post('name');//获得用户姓名信息
        $sex=$this -> input -> post('sex');//获得用户性别信息
        $tel=$this -> input -> post('tel');//获得用户电话信息
        $edu=$this -> input -> post('edu');//获得用户教育信息
        $address=$this -> input -> post('address');//获得用户地址信息
        $profession=$this -> input -> post('profession');//获得用户职业信息
        $work=$this -> input -> post('work');//获得用户工作信息
        $ifagen=$this -> input -> post('agency'); //获得用户是否代办信息
        
        //check 

        $this -> form_validation -> set_rules('id','身份证号码','required|min_length[18]|max_length[18]');//对表单身份证号码做了验证   
        if($this -> form_validation ->run() == false) {  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("身份证号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        } 
        $this -> form_validation -> set_rules('name','姓名','required|max_length[10]');//对表单姓名做了验证
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("姓名信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        } 
        $this -> form_validation -> set_rules('sex','性别','required');//对表单性别做了验证
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("性别信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        } 
        $this -> form_validation -> set_rules('tel','电话号码','required|max_length[15]');//对表单电话号码做了验证
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("电话号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        } 
        $this -> form_validation -> set_rules('edu','教育背景','required|max_length[80]');//对表单教育背景做了验证
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("教育背景信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        } 
        $this -> form_validation -> set_rules('address','家庭地址','required|max_length[50]');
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("家庭地址信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        } 
        $this -> form_validation -> set_rules('profession','职业','required|max_length[30]');//对表单职业做了验证
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("职业信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        } 
        $this -> form_validation -> set_rules('work','工作单位','required|max_length[50]');//对工作单位职业做了验证
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("工作单位信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        } 
        $this -> form_validation -> set_rules('agency','是否代办','required');//对表单是否代办做了验证
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  //如果格式验证失败，提示信息
            echo'<script type="text/javascript">alert("是否代办信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        } 
        if ($ifagen == 'y') { //如果用户选择了代办则读取代办人信息
            $aname=$this -> input -> post('aname'); //或许代办人信息
            $aid=$this -> input -> post('aid'); //代办人身份证信息
            $this -> form_validation -> set_rules('aname','代办人姓名','required|max_length[10]'); //对表单代办人姓名做了验证
            if (($this -> form_validation ->run() == false) && ($if_insert==0)){  //如果格式验证失败，提示信息
                echo'<script type="text/javascript">alert("代办人姓名信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
                $if_insert=1; 
            } 
            $this -> form_validation -> set_rules('aid','代办人身份证号码','required|min_length[18]|max_length[18]');//对表单代办人身份证号码做了验证
            if (($this -> form_validation ->run() == false) && ($if_insert==0)){  //如果格式验证失败，提示信息
                echo'<script type="text/javascript">alert("代办人身份证号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
                $if_insert=1; 
            } 
        }
        else {
           $aname='NULL'; //如果不是代办，则代办人姓名和身份证号码一栏为null
           $aid='NULL';
        }
        
        /*if (($stocknum=='')||($id=='')||($name=='')||($sex=='')||($tel=='')||($edu=='')||($address=='')||($profession=='')||($work=='')||($ifagen==''))
        {  
            $if_insert=1;
        }
        if ($if_insert==1){
            $data['information']="信息尚未填写完整，请审核后重新填写";

           
        }*/

        if (($this->MOD->check_account($id) != FALSE)&& ($if_insert==0)){  //检测是否存在该身份证号码的股票账户号码 ，存在报错
            echo'<script type="text/javascript">alert("该身份号码已经存在，请确认后重新输入");history.back();</script>';
            $if_insert=1;
        }
        else {
            $police_result=$this->MOD->check_police($id); //连接公安局数据库，提取该身份证号码的人的信息
            if (($police_result== FALSE)&& ($if_insert==0)){ //如果查询不到该身份证信息，报错
                echo'<script type="text/javascript">alert("公安局信息查询不到此身份证号码，请确认后重新输入");history.back();</script>'; 
                $if_insert=1;
            }
            else{ 
                foreach ($police_result as $row){ //获取查询结果
                //$row=mysqli_fetch_array($police_result);
                //$arr = $row;
                //if ( $row['年龄'] < 18){
                if (( $row->年龄 < 18)&& ($if_insert==0)){  //如果年龄不符合，未成年，报错
                    echo'<script type="text/javascript">alert("未满18周岁,不具备注册资格,请确认后重新输入");history.back();</script>';
                    $if_insert=1;
                }
                else{
                    //if (($row['是否违反证券法规'] == 'Y') && ($row['是否期满'] == 'N')){
                    if (($row->是否违反证券法规 == 'Y') && ($row->是否期满 == 'N')&& ($if_insert==0)){ //如果违反证券法规，未期满，报错
                        echo'<script type="text/javascript">alert("违反证券法规且禁期未满,不具备注册资格,请确认后重新输入");history.back();</script>';
                        $if_insert=1;
                    }
                    else if (($row->姓名 != $name)&& ($if_insert==0)){ //身份证号码和信息不对应，报错
                        echo'<script type="text/javascript">alert("身份证号和姓名信息不对印,请确认后重新输入");history.back();</script>';
                        $if_insert=1;
                    }
                    else{
                        $stock_result=$this->MOD->check_stock($id); //获取证券营业厅工作人员信息
                        if (($stock_result != FALSE)&& ($if_insert==0)) //如果从证券人员信息中查询到该身份证号码则报错
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
            if ($id==$aid){ //如果代办人身份证号码和注册人身份证号码相同，报错
                echo '<script type="text/javascript">alert( "注册身份证和代办人身份证不能相同，请确认后重新输入");history.back();</script>';
                $if_insert=1;
            }
            $police_result=$this->MOD->check_police($aid);
            if (($police_result== FALSE)&& ($if_insert==0)){ //如果代办人身份证信息在公安局查询不到报错
                echo'<script type="text/javascript">alert("公安局信息查询不到代办人身份证号码，请确认后重新输入");history.back();</script>'; 
                $if_insert=1;
            }
            else{
                foreach ($police_result as $row){
                    if(($row->姓名 != $aname)&& ($if_insert==0)){//如果代办人姓名和身份证号码不符合，报错
                        echo'<script type="text/javascript">alert("代办人身份证号码和姓名不符合，请确认后重新输入");history.back();</script>';  
                        $if_insert=1;
                    }
                }

            }
        }

        //


        if($if_insert==0){
            $t = gmdate("Y-m-d H:i:s", mktime() + 8 * 3600); //获取当前时间

            $stocknum=$this->MOD->randStr(10); //调用随机数产生10位股票账户号码
            $check_stocknum=$this->MOD->check_stocknum_person($stocknum); //检查该股票账户是否存在
            while ($check_stocknum!=FALSE){  //如果存在则一直循环产生10位股票账户号码，直至检查到该股票账户号码不存在
                $stocknum=$this->MOD->randStr(10);
                $check_stocknum=$this->MOD->check_stocknum_person($stocknum); 
            }
            $this->MOD->insert_account_person($stocknum,$id,$name,$sex,$tel,$edu,$address,$profession,$work,$ifagen,$t,$aname,$aid); //插入自然人注册信息
            //echo'<script type="text/javascript">alert("成功注册");history.back();</script>';
            $data['stocknum']= $stocknum;  //将注册的信息的方式值赋值到data的数组中，返回到确认页面
            $data['t']= $t; //时间
            $data['id']= $id; //身份证
            $data['name']= $name;//名字
            if ($sex=="male")
                $data['sex']= "男";//性别
            else 
                $data['sex']='女';
            $data['tel']= $tel;//电话
            $data['edu']= $edu;//教育
            $data['address']= $address;//地址
            $data['profession']= $profession;//职业
            $data['work']= $work;//工作
            if ($ifagen=='y'){//如果是代办
                $data['ifagen']="代办账户"; //是代办
                $data['aname']= $aname;//代办人姓名
                $data['aid']= $aid;//身份证
            }
            else{
                $data['ifagen']="非代办账户";//不是代办
                $data['aname']= "-"; //信息为空
                $data['aid']= "-";
            }
            $this->load->view('s1/person_result',$data);//加载确认页面，同时传递参数
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




    function testid(){//检查注册时的身份证号码是否可用，此为JS调用的函数
        //$id=$this -> input -> get('id');
        $id=$_GET["id"]; //获取身份证信息
        $this -> load -> model('s1/mregister','MOD');//链接model函数

            if ($this->MOD->check_account($id) != FALSE){//检查股票账户中是否已经注册了改身份证，如果是，报错
                echo "该身份号码已经存在，请确认后重新输入";
            }
            else {
                $police_result=$this->MOD->check_police($id);//从公安机关提取改身份证信息
                if ($police_result == FALSE){//找不到此身份证信息报错
                    echo "公安局查询不到此身份证号码，请确认后重新输入"; 
                }
                else{ 
                    foreach ($police_result as $row){
                    if ( $row->年龄 < 18){//如果未满18周岁，报错
                        echo "未满18周岁,不具备注册资格,请确认后重新输入";
                    }
                    else{
                    //if (($row['是否违反证券法规'] == 'Y') && ($row['是否期满'] == 'N')){
                        if (($row->是否违反证券法规 == 'Y') && ($row->是否期满 == 'N')){//如果违反证券法规未期满，报错
                            echo "违反证券法规且禁期未满,不具备注册资格,请确认后重新输入";
                        }
                        else{
                            $stock_result=$this->MOD->check_stock($id);//从证券从业人员信息表格查询该身份证
                            if ($stock_result == TRUE)//如果查询此人为证券从业人员报错
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
    function test_lost_id(){  //测试挂失时输入的身份证号码是否有效，此为JS调用
        $id=$_GET["id"];//获取身份证信息
        $this -> load -> model('s1/mregister','MOD');//链接model
        if ($this->MOD->check_account($id) != FALSE){//查询股票账户表中是否有该身份证号信息，如果不存在，则提示不存在，不能挂失
            echo "";
            }
        else{
            echo "该身份号码尚未注册证券账户，请确认后重新输入";
        }
    }
    function insert_account_company(){//插入证券账户的函数
        $if_insert=0;
        $this -> load -> helper('form');  
        $this -> load -> library('form_validation');  //支持表单验证
        $this -> load -> model('s1/mregister','MOD');//链接model
        
        $regisnum=$this -> input -> post('regisnum');//注册登记号
        $bus_license=$this -> input -> post('bus_license');//营业执照号码
        $aid=$this -> input -> post('aid');//法人身份证
        $aname=$this -> input -> post('aname');//法人姓名
        $atel=$this -> input -> post('atel');//法人电话
        $aaddress=$this -> input -> post('aaddress');//法人地址
        $ename=$this -> input -> post('ename');//执行人姓名
        $gid=$this -> input -> post('gid');//授权人身份证
        $gtel=$this -> input -> post('gtel'); //授权人电话
        $gaddress=$this -> input -> post('gaddress'); //授权人地址
        
        //check 

        $this -> form_validation -> set_rules('regisnum','法人注册登记号码','required|max_length[20]');   //法人注册登记号表单验证，如果不符和报错

        if($this -> form_validation ->run() == false) {  
            echo'<script type="text/javascript">alert("法人注册登记号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }

        $this -> form_validation -> set_rules('bus_license','营业执照','required|max_length[9]');//营业执照表单验证，如果不符和报错
        
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("法营业执照号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }        

        $this -> form_validation -> set_rules('aid','法人身份证号码','required|min_length[18]|max_length[18]');//法人身份证号码表单验证，如果不符和报错

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("法人身份证号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }  

        $this -> form_validation -> set_rules('aname','法人姓名','required|max_length[10]');//法人姓名表单验证，如果不符和报错

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("法人姓名信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }  

        $this -> form_validation -> set_rules('atel','法人联系电话','required|max_length[15]');//法人联系电话表单验证，如果不符和报错

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("法人联系电话信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }  


        $this -> form_validation -> set_rules('aaddress','法人联系地址','required|max_length[50]');//法人联系地址表单验证，如果不符和报错

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("法人联系地址信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }  

        $this -> form_validation -> set_rules('ename','授权执行人姓名','required|max_length[10]');//授权执行人姓名表单验证，如果不符和报错

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("授权执行人姓名信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }  


        $this -> form_validation -> set_rules('gid','授权人身份证号码','required|min_length[18]|max_length[18]');//授权人身份证号码表单验证，如果不符和报错

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("授权人身份证号码信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }  

        $this -> form_validation -> set_rules('gtel','授权人联系电话','required|max_length[15]');//授权人联系电话表单验证，如果不符和报错

        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("授权人联系电话信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }  

        $this -> form_validation -> set_rules('gaddress','授权人地址','required|max_length[50]');//授权人地址表单验证，如果不符和报错
        if (($this -> form_validation ->run() == false) && ($if_insert==0)){  
            echo'<script type="text/javascript">alert("授权人地址信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        }  
        
        /*if($this -> form_validation ->run() == false) {  
            echo'<script type="text/javascript">alert("信息格式不符合要求,请确认后重新输入");history.back();</script>'; 
            $if_insert=1; 
        } */

        if (($this->MOD->check_account($aid) != FALSE)&& ($if_insert==0)){ //检查身份证是否已经注册了股票账户号码，是则报错
            echo'<script type="text/javascript">alert("该身份号码已经存在，请确认后重新输入");history.back();</script>';
            $if_insert=1;
        }
        else {
            $police_result=$this->MOD->check_police($aid);//获取公安局信息
            if (($police_result== FALSE)&& ($if_insert==0)){//公安局信息找不到身份证信息则报错
                echo'<script type="text/javascript">alert("公安局信息查询不到此身份证号码，请确认后重新输入");history.back();</script>'; 
                $if_insert=1;
            }
            else{ 
                foreach ($police_result as $row){
                //$row=mysqli_fetch_array($police_result);
                //$arr = $row;
                //if ( $row['年龄'] < 18){
                if (($row->年龄 < 18)&& ($if_insert==0)){//未成年人不具备注册资格报错
                    echo'<script type="text/javascript">alert("未满18周岁,不具备注册资格,请确认后重新输入");history.back();</script>';
                    $if_insert=1;
                }
                else{
                    //if (($row['是否违反证券法规'] == 'Y') && ($row['是否期满'] == 'N')){
                    if (($row->是否违反证券法规 == 'Y') && ($row->是否期满 == 'N')&& ($if_insert==0)){//违反法规未满期限不具备资格，报错
                        echo'<script type="text/javascript">alert("违反证券法规且禁期未满,不具备注册资格,请确认后重新输入");history.back();</script>';
                        $if_insert=1;
                    }
                    else if (($row->姓名 != $aname)&& ($if_insert==0)){//法人身份证号码和信息不对应，报错
                        echo'<script type="text/javascript">alert("法人身份证号和姓名信息不对印,请确认后重新输入");history.back();</script>';
                        $if_insert=1;
                    }
                    else{
                        $stock_result=$this->MOD->check_stock($aid);//获取证券从业人员信息
                        if (($stock_result != FALSE)&& ($if_insert==0))//判断为证券从业人员，报错
                        {   
                            echo'<script type="text/javascript">alert( "身份信息为证券从业人员,不具备注册资格");history.back();</script>';
                            $if_insert=1;
                        }
                        else {
                            ///////////////
                            $police_result=$this->MOD->check_police($gid);//获取授权人的公安局信息
                            if (($police_result== FALSE)&& ($if_insert==0)){//查询不到授权人的信息，报错
                                echo'<script type="text/javascript">alert("公安局信息查询不到授权人身份证号码，请确认后重新输入");history.back();</script>'; 
                                $if_insert=1;
                            }
                            else{
                                foreach ($police_result as $row){
                                    if(($row->姓名 != $ename)&& ($if_insert==0)){//授权人身份证号码和姓名不符合，报错
                                        echo'<script type="text/javascript">alert("授权人身份证号码和姓名不符合，请确认后重新输入");history.back();</script>';  
                                        $if_insert=1;
                                    }
                                }

                            }
        
                            /////////////////
                        }
                    }
                }}
            }
        
        }
        if($if_insert==0){ //如果上诉检测都没有报错，则执行向数据库插入法人证券账户信息的步骤
            $t = gmdate("Y-m-d H:i:s", mktime() + 8 * 3600);//获取时间，在这里其实没什么用，只是和自然人注册同一下

            $stocknum=$this->MOD->randStr(10);//随即产生10位股票账户号码
            $check_stocknum=$this->MOD->check_stocknum_company($stocknum);//检查是否可用，是否已经存在
            while ($check_stocknum!=FALSE){//存在 则反复进行产生10位股票账户号码，直至号码可用
                $stocknum=$this->MOD->randStr(10);
                $check_stocknum=$this->MOD->check_stocknum_company($stocknum); 
            }
            $this->MOD->insert_account_company($stocknum,$regisnum,$bus_license,$aid,$aname,$atel,$aaddress,$ename,$gid,$gtel,$gaddress);//执行插入数据操作
            //echo'<script type="text/javascript">alert("成功注册");history.back();</script>';
            $data['stocknum']= $stocknum;//将数值返回给确认页面
            $data['regisnum']= $regisnum;//注册登记号
            $data['bus_license']= $bus_license;//营业执照
            $data['aid']= $aid;//法人身份证
            $data['aname']= $aname;//法人姓名
            $data['atel']= $atel;//法人电话
            $data['aaddress']= $aaddress;//法人地址
            $data['ename']= $ename;//执行人姓名
            $data['gid']= $gid;//授权人身份证
            $data['gtel']= $gtel;//授权人电话
            $data['gaddress']= $gaddress;//授权人地址
            $this->load->view('s1/company_result',$data);//加载确认页面，传送data
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
    /*function __construct(){
        parent::__construct();
        $this->load->database();
    }
    function user_info(){
        $this->load->model("M_user");
        if ($this->M_user->check_account($id))
            $data['users']
        //$data['users']=$this->M_user->check_account($id);
        $this->load->view("user",$data);               //将数据传到视图层
        //var_dump($data);
    }
    function hello(){
        $this->load->model("M_user");
        $data['users']=$this->M_user->test_insert();
        $this->load->view("user",$data);               //将数据传到视图层
        //var_dump($data);
    }*/
}
