<header>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<script src="resources/s1/js/check_login.js" charset="utf-8"></script>

</header>
<body>
<form action="s1/login_controllers/login" method="post" enctype="multipart/form-data">
用户名 : <input type="text" name="id"/><br/>
密码 : <input type="password" name="pass" onKeyUp="check_pass(this.value)"/><span id="pass"></span><br/> 
<input type="submit" value="submit" />  
</form>  
</body>