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
<script src="resources/s1/js/search_id.js"></script>
<script src="resources/s1/js/check.js"></script>
<script src="resources/s1/js/checks.js" charset="utf-8">
</script>
</head>

<body>
<div class="container">
<div class="container-fluid">
  <div class="row-fluid">
	<div class="col-lg-3">
      <div class="box_left">
		<ul id="myTab" class="nav nav-pills nav-stacked" >
    		<li class="active"><a href="#guashi" data-toggle="tab">账号挂失</a></li>
			<li><a href="#buban" data-toggle="tab">账号补办</a></li>
		</ul>
       </div>
	</div>
    <div class="col-lg-9">
    <div class="box_right">
		<div id="myTabContent" class="tab-content">
        	<div class="tab-pane fade active in" id="guashi">
            <form class="form-horizontal" role="form" action="s1/Lhome/manage_loss" method="post">
            <div class="form-group">
              <label for="inputlagency" class="col-sm-3 control-label">请选择补办类型</label>
              <div class="col-sm-8">
                <div class="col-sm-4">
                  <label class="control-label">
                    <input type="radio" name="lagency" id="inputlagency" value="1" checked> 个人账户挂失
                  </label>
                </div>
              <div class="col-sm-4">
                <label class="control-label">
                  <input type="radio" name="lagency" id="inputlagency" value="0" > 法人账户挂失
                </label>
              </div>
              <div class="col-sm-4">
                <label class="control-label">
                  <input type="radio" name="lagency" id="inputlagency" value="-1" > 取消挂失  
                </label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="inputlid" class="col-sm-3 control-label">请输入证件号码</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="inputlid"  name="lid" placeholder="身份证号码">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <label> </label>
              <button type="submit" class="btn btn-primary btn-lg btn-block">确认</button>
            </div>    
          </div>
          </form>
          </div>

          <div class="tab-pane fade" id="buban">
            <form  class="form-horizontal" role="form" action="s1/Bhome/manage_bban" method="post">
            <div class="form-group">
              <label for="inputbagency" class="col-sm-3 control-label">请选择补办类型</label>
              <div class="col-sm-8">
                <div class="col-sm-6">
                  <label class="control-label">
                    <input type="radio" name="bagency" id="inputbagency" value="1" checked> 自然人补办
                  </label>   
                </div>
                <div class="col-sm-6">
                  <label class="control-label">
                    <input type="radio" name="bagency" id="inputbagency" value="0" > 法人补办 
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="inputbid" class="col-sm-3 control-label">请输入证件号码</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputbid"  name="bid" placeholder="身份证号码"onKeyUp="searchid(this.value,'lost_id_person')"><span id="lost_id_person"></span>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-6">
                <label> </label>
                <button type="submit" class="btn btn-primary btn-lg btn-block">确认</button>
              </div>
            </div>
            </form>
          </div>
        </div>
    </div>
    </div>
  </div>
</div>
</div>
</body>
</html>