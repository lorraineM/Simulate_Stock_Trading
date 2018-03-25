<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>注册界面</title>
<link href="resources/s1/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="resources/s1/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
<link href="resources/s1/css/css_reg.css" rel="stylesheet" type="text/css"/>
<link href="resources/s1/css/css_nav.css" rel="stylesheet" type="text/css"/>
<script src="resources/s1/js/jquery-2.1.1.js"></script>
<script src="resources/s1/js/bootstrap.js"></script>
<script src="resources/s1/js/hide.js"></script>
<script src="resources/s1/js/check.js"></script>
</head>

<body>

<div class="container">
<div class="container-fluid">
  <div class="row-fluid">
	<div class="col-lg-3">
      <div class="box_left">
		<ul id="myTab" class="nav nav-pills nav-stacked" >
    		<li class="active"><a href="#select_tab" data-toggle="tab">查询账户</a></li>
			<li><a href="#login_person" data-toggle="tab">自然人账户修改</a></li>
      <li><a href="#login_company" data-toggle="tab">法人账户修改</a></li>
		</ul>
       </div>
	</div>

    <div class="col-lg-9">
    <div class="box_right">
		<div id="myTabContent" class="tab-content">
        	<div class="tab-pane fade in active" id="select_tab">
            <form class="form-horizontal" role="form" action="s1/select/select_account" method="post">
            
            <div class="form-group">
            <label for="inputclass" class="col-sm-3 control-label">账户类型</label>
              <div class="col-sm-8">
                <div class="col-sm-6">
                  <label class="control-label">
                    <input type="radio" name="sel" id="s_class" value=1 checked> 自然人账户

                  </label>
        
                </div>
                <div class="col-sm-6">
                  <label class="control-label">
                    <input type="radio" name="sel" id="s_class" value=2 > 法人账户 
                  </label>
                </div>
              </div>
              </div>
            
            
            <div class="form-group">
            <label for="inputname" class="col-sm-3 control-label">股票账户号码</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputs_stocknum"  name="s_stocknum" placeholder="股票账户号码">
              </div>
            </div>
            
            
            <div class="form-group">
            <label for="inputid" class="col-sm-3 control-label">身份证号</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputs_id" name="s_id" placeholder="身份证号">
              </div>
            </div>
  
        

            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-6">
                <label> </label>
                <button type="submit" class="btn btn-primary btn-lg btn-block">查询</button>
              </div>
            </div>
            
            
            </form>
           </div>
  
  
           
           <div class="tab-pane fade" id="login_person">
           <form class="form-horizontal" role="form" action="s1/select/update_account_person" method="post">
                          <div class="form-group">
            <label for="inputid" class="col-sm-3 control-label">身份证号(必填)</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" class="text" id="inputid" placeholder="身份证号" name="id" onKeyUp="searchid(this.value,'test_id_person')"><span id="test_id_person"></span>
              </div>
            </div>
  
            <div class="form-group">
            <label for="inputname" class="col-sm-3 control-label">姓名(必填)</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputname"  name="name" placeholder="姓名">
              </div>
            </div>

            <div class="form-group">
            <label for="inputsex" class="col-sm-3 control-label">性别(必填)</label>
              <div class="col-sm-8">
                <div class="col-sm-6">
                  <label class="control-label">
                    <input type="radio" name="sex" id="inputsex" value="male" checked> 男

                  </label>
        
                </div>
                <div class="col-sm-6">
                  <label class="control-label">
                    <input type="radio" name="sex" id="inputsex" value="female" > 女 
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group">
            <label for="inputel" class="col-sm-3 control-label">联系电话</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputel"  name="tel" placeholder="联系电话">
              </div>
            </div>

            <div class="form-group">
            <label for="inputedu" class="col-sm-3 control-label">学历(必填)</label>
              <div class="col-sm-8">
                <label  class="control-label">
                  <div class="col-xs-30" >
                    <select name="edu" id="inputedu" class="form-control">
                      <option value="初中学历及以下" >初中及以下</option>
                      <option value="高中或者中专学历">高中或者中专</option>
                      <option value="大专学历" >大专</option>
                      <option value="本科学历">本科</option>
                      <option value="本科以上学历">本科以上学历 包含硕士研究生学历、博士研究生学历</option>
                    </select>
                  </div>
                </label>
              </div>
            </div>

            <div class="form-group">
            <label for="inputaddress" class="col-sm-3 control-label">家庭地址</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputaddress"  name="address" placeholder="家庭地址">
              </div>
            </div>

            <div class="form-group">
            <label for="inputprofession" class="col-sm-3 control-label">职业</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputprofession"  name="profession" placeholder="职业">
              </div>
            </div>

            <div class="form-group">
            <label for="inputwork" class="col-sm-3 control-label">工作单位</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputwork"  name="work" placeholder="工作单位">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-6">
                <label> </label>
                  <button type="submit" class="btn btn-primary btn-lg btn-block">确认修改</button>
              </div>
            </div>
           </form>
           </div>
           
           <div class="tab-pane fade" id="login_company">
           <form class="form-horizontal" role="form" action="s1/select/update_account_company" method="post">
            <div class="form-group">
              <label for="inputaid" class="col-sm-3 control-label">法人身份证号码(必填)</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" class="text" id="inputaid" placeholder="法人身份证号码" name="aid" onKeyUp="searchid(this.value,'test_id_company')"><span id="test_id_company"></span>
              </div>
            </div>

            <div class="form-group">
              <label for="inputaname" class="col-sm-3 control-label">法人姓名(必填)</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputaname"  name="aname" placeholder="法人姓名">
              </div>
            </div>

            <div class="form-group">
              <label for="inputatel" class="col-sm-3 control-label">法人联系电话</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputatel"  name="atel" placeholder="法人联系电话">
              </div>
            </div>

            <div class="form-group">
              <label for="inputaaddress" class="col-sm-3 control-label">法人联系地址</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputaaddress"  name="aaddress" placeholder="法人联系地址">
              </div>
            </div>
            <div class="form-group">
              <label for="inputgtel" class="col-sm-3 control-label">授权人联系电话</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputgtel"  name="gtel" placeholder="授权人联系电话">
              </div>
            </div>

            <div class="form-group">
              <label for="inputgaddressl" class="col-sm-3 control-label">授权人地址</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputgaddress"  name="gaddress" placeholder="授权人地址">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-6">
                <label> </label>
                <button type="submit" class="btn btn-primary btn-lg btn-block">确认修改</button>
              </div>
            </div>
            
            </form>
           </div>
           
           
           

  </div>
</div>
</div>

    

</body>
</html>