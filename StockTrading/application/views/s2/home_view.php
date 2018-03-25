<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Fund System!</title>
    <base href="<?php  echo base_url();?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/s2/css/bootstrap.css" />
    <style type="text/css">
        #nav_horizontal{
            margin-left: 13%;
            font-weight: bold;
            color:white;
        }
        #nav_vertical{
            width:15%;
            position:absolute;
            margin-top: 7%;
            margin-left: 17%;
        }
        #request_open,#request_loss,#request_reissue,#request_close,#status_query,
        #status_query_result,#deposit_save,#deposit_save_result,
        #modify_passwd,#fund_pwd,#admin_login{
            width:50%;position:absolute;
            margin-left:35%;
        }
        .input_text{
            width:320px;
        }
        .btn-self-def{
            height:40px;
            line-height: 0.8;
            font-size: 18px;
            width:80px;
            text-align: center;
        }
        .error{
        }
        .fund_foot{
            text-align: center;
            margin-top:8%;
            padding-top: 40px;
            margin-top: 40px;
            color: #777;
            text-align: center;
            border-top: 1px solid #e5e5e5
        }
    </style>

    <script type = "text/JavaScript">
        window.onload = function(){
            //alert("dfad");
            //alert(<?php echo $active_id ?>);
            if(<?php echo ($active_id) ?> !=undefined)
            {

            var div=document.getElementById("<?php echo $active_id; ?>");
           // alert(div);
            //<?php echo $active_id ?>.className = "tab-pane active";
            div.className = "tab-pane active";
            }
        };
    </script>
</head>
<body>
    <!-- 导航条 -->
    <nav class="navbar navbar-inverse" role="navigation">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse ">
            <ul class="nav navbar-nav" id="nav_horizontal" style="width:100%">
                <li class="active "><a href="fund/#fish" data-toggle="tab">资金账户管理子系统</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="">用户申请
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="fund/#request_open" data-toggle="tab">注册请求</a></li>
                        <li><a href="fund/#request_loss" data-toggle="tab">挂失请求</a></li>
                        <li><a href="fund/#request_reissue" data-toggle="tab">补办请求</a></li>
                        <li><a href="fund/#request_close" data-toggle="tab">注销请求</a></li>
                    </ul>
                </li>
                <li><a href="fund/#status_query" data-toggle="tab">账户查询</a></li>
                <li><a href="fund/#deposit_save" data-toggle="tab">存取款</a></li>
                <li><a href="fund/#fund_pwd" data-toggle="tab">修改密码</a></li>
                <li id="nav_admin_login"><a href="fund/#admin_login" data-toggle="tab">管理员登陆</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>


    <!-- 测边链接, 连接到其他子系统-->
    <ul class="nav nav-pills nav-stacked" id="nav_vertical">
        <li style="margin:0px"><a href="/StockTrading/acco_home">证券账户管理</a></li>
        <li><a href="/StockTrading/fund">资金账户管理</a></li>
        <li><a href="http://localhost/StockTrading/client/login.php">交易客户端</a></li>
        <li><a href="http://localhost/StockTrading/display/index.php">网上信息发布</a></li>
    </ul>


    <!-- 中间主要显示部分 -->
    <div class="tab-content">

        <!-- 主页显示-->
        <div class="tab-pane" id="fish">
            <div style="margin-top:60px;margin-left:220px">
                <center><embed height=350 type=application/x-shockwave-flash width=600 src='/StockTrading/resources/s2/img/fish.swf' FLASHVARS="up_numFish=6&amp;up_fishColor4=#FFFFFF&amp;up_fishColor1=F4A61C&amp;up_fishColor7=F45540&amp;up_fishColor6=F45540&amp;up_fishColor8=F45540&amp;up_fishColor2=C4C4C4&amp;up_fishColor9=F45540&amp;up_fishColor3=#600000&amp;up_fishName=Fish&amp;up_fishColor5=F45540&amp;up_fishColor10=F45540&amp;up_backgroundImage=http://&amp;up_foodColor=FCB347&amp;" BGCOLOR="#F6F6F6" WMODE="zaizheli" ></embed></center>
            </div>
            <footer class="fund_foot">
                <div class="container">
                    <p>© 2014 浙江大学软件工程课程 S2-2开发团队. </p>
                    <P>建议使用chrome或firefox浏览器</P>
                </div>
            </footer>
        </div>


        <!-- 申请开户-->
        <div class="tab-pane" id="request_open" style="width:60%">
            <form class="form-signin" role="form" action="s2/Request_open_control/do_request_open" method="post">
                <h2>请输入开户信息</h2>
                <hr/>
                <!-- 以下是开户必须填的信息: 提交后等待管理员处理 -->
                <!-- 1.身份证号/法人注册号 -->
                <div class="row">
                    <div class="col-md-6">
                        <label>身份证号或法人注册号</label>
                        <input type="text" name="fo_id"class="form-control input_text" placeholder="身份证号/法人注册号" required autofocus>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <label>选择注册账号种类</label>
                        </div>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="radio" name="fo_idtype" value="idc" checked="checked">身份证号
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="fo_idtype" value="leg" >法人注册号
                            </label>
                        </div>
                    </div>
                </div>
                <!-- 2.证券账户号 -->
                <div class="form-group" style="margin-top:15px">
                    <label>证券账户号</label>
                    <input type="text" name="fo_sid" class="form-control input_text" placeholder="证券账户号" >
                </div>
                <!-- 5. 登录密码及确认 ADDED BY BJM 6.13 15：43-->
                <div class="row">
                    <div class="col-md-6">
                        <label>登陆密码</label>
                        <input type="password" name="fo_lp" class="form-control input_text" placeholder="登陆密码" >
                    </div>
                    <div class="col-md-6">
                        <label>登陆密码确认</label>
                        <input type="password" name="fo_lpc" class="form-control input_text" placeholder="登陆密码确认">
                    </div>
                </div>
                <!-- 3.交易密码及确认 -->
                <div class="row">
                    <div class="col-md-6">
                        <label>交易密码</label>
                        <input type="password" name="fo_tp" class="form-control input_text" placeholder="交易密码" >
                    </div>
                    <div class="col-md-6">
                        <label>交易密码确认</label>
                        <input type="password" name="fo_tpc" class="form-control input_text" placeholder="交易密码确认">
                    </div>
                </div>
                <!-- 4.取款密码及确认 -->
                <div class="row">
                    <div class="col-md-6">
                        <label>取款密码</label>
                        <input type="password" name="fo_ap" class="form-control input_text" placeholder="取款密码" >
                    </div>
                    <div class="col-md-6">
                        <label>取款密码确认</label>
                        <input type="password" name="fo_apc" class="form-control input_text" placeholder="取款密码确认" >
                    </div>
                </div>
                <!-- 6. 选择经纪商 -->
                <div class="row"><div class="col-md-6">    
                <select name="fo_agi" id="a_list" style="height:30px;margin-top:5%">
                    <option value="000000" selected="selected">请选择证券经纪商</option>
                    <option value="000001">中信证券</option>
                    <option value="000002">光大证券</option>
                    <option value="000003">国信证券</option>
                    <option value="000004">华泰证券</option>
                    <option value="000005">广发证券</option>
                    <option value="000006">海通证券</option>
                </select></div></div>
                <!-- 提交/取消按钮 ADDED BY BJM 6.13 16:42-->
                <div class="error">
                <?php if(isset($error_ro)){ ?>
                    <div class="form-inline" style="width:700px;margin-top:50px">
                        <span class="mkey_span alert alert-warning"><?php echo $error_ro;?></span>
                    </div>
                <?php }?>
                </div>
                <div style="margin-top:30px">
                    <button class="btn btn-lg btn-danger btn-self-def " type="submit">确定</button>
                    <button class="btn btn-lg btn-primary btn-self-def " type="reset">取消</button>
                </div>
            </form>
        </div>
        <!-- 申请挂失-->
        <div class="tab-pane" id="request_loss" >
            <form class="form-signin" role="form" action="s2/Request_loss_control/do_request_loss" method="post">
                <h2>请输入挂失信息</h2>
                <hr/>
                <!-- 以下是申请挂失必须填的信息: 提交后等待管理员处理 -->
                <!-- 1.身份证号/法人注册号 -->
                <div class="form-group">
                    <label>身份证号或者法人注册号</label>
                    <input type="text" name="fl_id"class="form-control input_text" placeholder="身份证号/法人注册号"  required autofocus>
                </div>
                <div>
                    <label>选择注册账号种类</label>
                </div>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="fl_idtype" value="idc" checked="checked">身份证号
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="fl_idtype" value="leg">法人注册号
                    </label>
                </div>
                <!-- 2.证券账户号 -->
                <div class="form-group" style="margin-top:15px">
                    <label>证券账户</label>
                    <input type="text" name="fl_sid"class="form-control input_text" placeholder="证券账户号" required>
                </div>
                <!-- 3.资金账户号 -->
                <div class="form-group">
                    <label>资金账户</label>
                    <input type="text" name="fl_fid"class="form-control input_text" placeholder="资金账户号" required>
                </div>
                <div class="error">
                <?php if(isset($error_rl)){ ?>
                    <div class="form-inline" style="width:700px;margin-top:50px">
                        <span class="mkey_span alert alert-warning"><?php echo $error_rl;?></span>
                    </div>
                <?php }?>
                </div>
                <!-- 提交/取消按钮 -->
                <div style="margin-top:30px">
                    <button class="btn btn-lg btn-danger btn-self-def " type="submit">提交</button>
                    <button class="btn btn-lg btn-primary btn-self-def" type="reset">取消</button>
                </div>
              </form>
        </div>
        <!-- 申请补办 -->
        <div class="tab-pane" id="request_reissue">
            <form class="form-signin" role="form" action="s2/Request_reissue_control/do_request_reissue" method="post">
                <h2>请输入补办信息</h2>
                <hr/>
                <!-- 以下是申请补办必须填的信息,提交后等待管理员处理 -->
                <!-- 1.身份证/法人号 -->
                <div class="form-group">
                    <label>身份证号或者法人注册号</label>
                    <input type="text" name="fr_id"class="form-control input_text" placeholder="身份证号/法人注册号"  required autofocus>
                </div>
                <div>
                    <label>选择注册账号种类</label>
                </div>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="fr_idtype" value="idc" checked="checked">身份证号
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="fr_idtype" value="leg">法人注册号
                    </label>
                </div>
                <!-- 2.证券账户号 -->
                <div class="form-group" style="margin-top:15px">
                    <label>证券账户</label>
                    <input type="text" name="fr_sid" class="form-control input_text" placeholder="证券账户号" required >
                </div>
                <!-- 5.资金账户号 ADDED BY BJM 6.13 15:51-->
                <div class="form-group">
                    <label>资金账户</label>
                    <input type="text" name="fr_fid" class="form-control input_text" placeholder="资金账户号" required >
                </div>
                <div class="error">
                <?php if(isset($error_rr)){ ?>
                    <div class="form-inline" style="width:700px;margin-top:50px">
                        <span class="mkey_span alert alert-warning"><?php echo $error_rr;?></span>
                    </div>
                <?php }?>
                </div>
                <!-- 提交和取消按钮 -->
                <div style="margin-top:30px">
                    <button class="btn btn-lg btn-danger btn-self-def " type="submit">提交</button>
                    <button class="btn btn-lg btn-primary btn-self-def " type="reset">取消</button>
                </div>
            </form>
        </div>
        <!-- 申请销户-->
        <div class="tab-pane" id="request_close">
            <form class="form-signin" role="form" action="s2/Request_close_control/do_request_close" method="post">
                <h2>请输入销户信息</h2>
                <hr/>
                <!-- 以下是申请销户必须填的信息:资金账户号
                  提交后等待管理员处理 -->
                <!-- 1.身份证号/法人号 -->
                 <div class="form-group">
                    <label>身份证号或者法人注册号</label>
                    <input type="text" name="fc_id"class="form-control input_text" placeholder="身份证号/法人注册号"  required autofocus>
                </div>
                <div>
                    <label>选择注册账号种类</label>
                </div>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="fc_idtype" value="idc" checked="checked">身份证号
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="fc_idtype" value="leg">法人注册号
                    </label>
                </div>
                <!-- 2.证券账户号 -->
                <div class="form-group" style="margin-top:15px">
                    <label>证券账户</label>
                    <input type="text" name="fc_sid" class="form-control input_text" placeholder="证券账户号" required >
                </div>
                <!-- 5.资金账户号 ADDED BY BJM 6.13 15:51-->
                <div class="form-group">
                    <label>资金账户</label>
                    <input type="text" name="fc_fid" class="form-control input_text" placeholder="资金账户号" required >
                </div>
                <div class="error">
                <?php if(isset($error_rc)){ ?>
                    <div class="form-inline" style="width:700px;margin-top:50px">
                        <span class="mkey_span alert alert-warning"><?php echo $error_rc;?></span>
                    </div>
                <?php }?>
                </div>
                <!-- 提交和取消按钮 -->
                <div style="margin-top:30px">
                    <button class="btn btn-lg btn-danger btn-self-def " type="submit">提交</button>
                    <button class="btn btn-lg btn-primary btn-self-def " type="reset">取消</button>
                </div>
            </form>
        </div>

        <!-- 账户查询 -->
        <div class="tab-pane" id="status_query">
            <h2>资金账户状态查询</h2>
            <hr/>
            <form role="form" action="/StockTrading/fund/status_query" method="post">
                <!--输入资金账户id -->
                <div class="form-group" style="margin-bottom:10px">
                    <label for="FundAccount" style="margin-bottom:15px">资金账户</label>
                    <input type="text" class="form-control input_text" name="account"  id="FundAccount" placeholder="资金账户号">
                </div>
                <!--输入交易密码-->
                <div class="form-group" style="margin-bottom:10px">
                    <label for="TradePassword" style="margin-bottom:15px">交易密码</label>
                    <input type="password" class="form-control input_text" name="trade_password" id="TradePassword" placeholder="交易密码">
                </div>
                <!--输入取款密码-->
                <div class="form-group" style="margin-bottom:10px">
                    <label for="AtmPassword" style="margin-bottom:15px">取款密码</label>
                    <input type="password" class="form-control input_text" name="atm_password" id="AtmPassword" placeholder="取款密码">
                </div>
                <div class="error">
                <?php if(isset($error_sq)){ ?>
                    <div class="form-inline" style="width:700px;margin-top:50px">
                        <span class="mkey_span alert alert-warning"><?php echo $error_sq;?></span>
                    </div>
                <?php }?>
                </div>
                <!--提交按钮-->
                <div style="margin-top:30px">
                    <button type="submit" class="btn btn-lg btn-danger btn-self-def">确定</button>
                    <button type="reset" class="btn btn-lg btn-primary btn-self-def">取消</button>
                </div>
            </form>
        </div>


        <!-- 账户查询结果显示 -->
        <div class="tab-pane " id="status_query_result">
            <h2>资金账户状态查询结果</h2>
            <hr/>
            <table class="table table-hover table-bordered" >
                <tr>
                    <th>资金账户ID</th>
                    <th>卡状态</th>
                </tr>
                <tr>
                    <td><?php echo $account;?></td>
                    <td><?php
                        switch($status)
                        {
                            case 0:echo "正常";break;
                            case 1:echo "申请开户中";break;
                            case 2:echo "申请挂失中";break;
                            case 3:echo "申请补办中";break;
                            case 4:echo "申请销户中";break;
                            case 5:echo "已挂失 ( 新的资金账户ID: $related_id )";break;
                            case 6:echo "已销户";break;
                            default:echo "未知状态";break;
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <!-- 用户存取款 -->
        <div class="tab-pane" id="deposit_save">
            <h2>用户存取款操作</h2>
            <hr/>
            <form role="form" action="/StockTrading/fund/deposit_save" method="post">
                <div class="form-group">
                    <label>资金账户</label>
                    <input type="text" class="form-control input_text" name="account" id="FundAccount" placeholder="资金账户号">
                </div>
                <div class="form-group">
                    <label >存取款密码</label>
                    <input type="password" class="form-control input_text" name="password" id="DepositSavePassword" placeholder="取款密码">
                </div>
                <div class="form-group">
                    <label >存取款金额</label>
                    <input type="text" class="form-control input_text" name="amount"  id="amount" placeholder="0.00">
                </div>
                <div>
                    <label>选择操作</label>
                </div>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="save_or_deposit" id="option0" value="save"> 存款
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="save_or_deposit" id="option1" value="deposit"> 取款
                    </label>
                </div>
                <div style="margin-top:15px">
                    <label>选择币种</label>
                </div>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="currency" id="option0" value="0"> 人民币
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="currency" id="option1" value="1"> 美元
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="currency" id="option2" value="2"> 港币
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="currency" id="option3" value="3"> 欧元
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="currency" id="option4" value="4"> 英镑
                    </label>
                    <label class="btn btn-default" >
                        <input type="radio" name="currency" id="option5" value="5"> 日元
                    </label>
                    <br/>
                    <label class="btn btn-default">
                        <input type="radio" name="currency" id="option6" value="6"> 澳元
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="currency" id="option7" value="7"> 加拿大元
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="currency" id="option8" value="8"> 瑞士法郎
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="currency" id="option9" value="9"> 新加坡元
                    </label>
                </div>
                <!-- <div class="form-group">
                <label>验证码：</label>
                <input type="text"  name="captcha" value="">

                <?php echo $captcha; ?> -->
                <div class="error">
                <?php if(isset($error_ds)){ ?>
                    <div class="form-inline" style="width:700px;margin-top:50px">
                        <span class="mkey_span alert alert-warning"><?php echo $error_ds;?></span>
                    </div>
                <?php }?>
                </div>
                <div style="margin-top:30px">
                <button type="submit" class="btn btn-lg btn-danger btn-self-def">确认</button>
                <button type="reset" class="btn btn-lg btn-primary btn-self-def">取消</button>
                </div>
            </form>
        </div>

       <!-- 存取款结果显示 -->
        <div class="tab-pane" id="deposit_save_result">
            <h2>用户存取款结果</h2>
            <hr/>
            <table class="table table-hover table-bordered" >
                <?php
                   echo $account_info;
                ?>
            </table>
        </div>


       <!-- 修改资金账户交易,取款密码-->
        <div class="tab-pane" id="fund_pwd" >
            <form class="form-signin " role="form" action="s2/Fund_pwd_control/do_change_pwd" method="post">
                <h2>请输入资金账户信息</h2>
                <hr/>
                <!-- 以下是修改资金账户密码必须填的信息:资金账户号;原交易密码(+确认),新交易密码;原取款密码(+确认),新取款密码.
                提交后根据要修改的密码类型fpwd_type检查 -->
                <div class="form-group">
                    <label>资金账户</label>
                    <input type="text" name="fund_id"class="form-control input_text" placeholder="资金账户号"  required autofocus>
                </div>
                <div>
                    <label>选择密码种类</label>
                </div>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="fpwd_type" value="trans" checked="checked"> 交易密码
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="fpwd_type" value="withd"> 取款密码
                    </label>
                </div>
                <div class="form-group" style="margin-top:15px">
                    <label>原密码</label>
                    <input type="password" name="fund_op" class="form-control input_text" placeholder="原密码" >
                </div>
                <div class="form-group">
                    <label>新密码</label>
                    <input type="password" name="fund_np" class="form-control input_text" placeholder="新密码" >
                </div>
                <div class="form-group">
                    <label>新密码确认</label>
                    <input type="password" name="fund_npc" class="form-control input_text" placeholder="新密码确认">
                </div>
                <div class="error">
                <?php if(isset($error_rp)){ ?>
                    <div class="form-inline" style="width:700px;margin-top:50px">
                        <span class="mkey_span alert alert-warning"><?php echo $error_rp;?></span>
                    </div>
                <?php }?>
                </div>
                <div style="margin-top:30px">
                    <button class="btn btn-lg btn-danger btn-self-def" type="submit">确认</button>
                    <button class="btn btn-lg btn-primary btn-self-def" type="reset">取消</button>
                </div>
            </form>
        </div>

       <!-- 管理员登陆 -->
        <div class="tab-pane" id="admin_login">
            <h2>管理员登陆</h2>
            <hr/>
            <form role="form" action="/StockTrading/fund/admin_login" method="post">
                <div class="form-group">
                    <label for="AgentAccount">经纪商账号</label>
                    <input type="text" class="form-control input_text" name="account"  id="AgentAccount" placeholder="经纪商账号">
                </div>
                <div class="form-group">
                    <label for="AgentPassword">经纪商密码</label>
                    <input type="password" class="form-control  input_text" name="password" id="AgentPassword" placeholder="经纪商密码">
                </div>
                <div class="error">
                <?php if(isset($error_al)){ ?>
                    <div class="form-inline" style="width:700px;margin-top:50px">
                        <span class="mkey_span alert alert-warning"><?php echo $error_al;?></span>
                    </div>
                <?php }?>
                </div>
                <div style="margin-top:30px">
                    <button type="submit" class="btn btn-lg btn-danger btn-self-def">确认</button>
                    <button type="reset" class="btn btn-lg btn-primary btn-self-def">取消</button>
                </div>
            </form>
        </div>

    </div>
    

    <script src="resources/s2/js/jquery.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="resources/s2/js/bootstrap.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->


</body>
</html>
