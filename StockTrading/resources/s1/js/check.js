function check_pass(str)
{
	if (str.length<6)
	{
		document.getElementById("pass").style.color="#FF0000";
		document.getElementById("pass").innerHTML="密码长度不能小于6位";
	}
	else {
		document.getElementById("pass").innerHTML="";
	}
}

function check_stock_num_person(str)
{
	if (str.length==0)
	{ 
		document.getElementById("warn_stock_num_person").innerHTML="";
		return;
	}
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			tmp=document.getElementById("warn_stock_num_person");
			tmp.innerHTML=xmlhttp.responseText;
			tmp.style.color="#FF0000";
		}
	}
	
	xmlhttp.open("GET","s1/cancel_controllers/check_stock_num_person?stock_num_person="+str,true);
	xmlhttp.send();
}

function check_id_person(str)
{
	if (str.length==0)
	{ 
		document.getElementById("warn_id_person").innerHTML="";
		return;
	}
	if (str.length<18)
	{ 
		document.getElementById("warn_id_person").innerHTML="身份证号码长度不符合";
		document.getElementById("warn_id_person").style.color="#FF0000";
		return;
	}
	if (str.length>18)
	{ 
		document.getElementById("warn_id_person").innerHTML="身份证号码长度不符合";
		document.getElementById("warn_id_person").style.color="#FF0000";
		return;
	}
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			tmp=document.getElementById("warn_id_person");
			tmp.innerHTML=xmlhttp.responseText;
			tmp.style.color="#FF0000";
		}
	}
	
	stock_num=document.getElementById("stock_num_person").value;
	
	xmlhttp.open("GET","s1/cancel_controllers/check_id_person?id_person="+str+"&stock_num_person="+stock_num,true);
	xmlhttp.send();
}

function check_stock_num_legal(str)
{
	if (str.length==0)
	{ 
		document.getElementById("warn_stock_num_legal").innerHTML="";
		return;
	}
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			tmp=document.getElementById("warn_stock_num_legal");
			tmp.innerHTML=xmlhttp.responseText;
			tmp.style.color="#FF0000";
		}
	}
	
	xmlhttp.open("GET","s1/cancel_controllers/check_stock_num_legal?stock_num_legal="+str,true);
	xmlhttp.send();
}

function check_id_legal(str)
{
	if (str.length==0)
	{ 
		document.getElementById("warn_id_legal").innerHTML="";
		return;
	}
	if (str.length<18)
	{ 
		document.getElementById("warn_id_legal").innerHTML="身份证号码长度不符合";
		document.getElementById("warn_id_legal").style.color="#FF0000";
		return;
	}
	if (str.length>18)
	{ 
		document.getElementById("warn_id_legal").innerHTML="身份证号码长度不符合";
		document.getElementById("warn_id_legal").style.color="#FF0000";
		return;
	}
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			tmp=document.getElementById("warn_id_legal");
			tmp.innerHTML=xmlhttp.responseText;
			tmp.style.color="#FF0000";
		}
	}
	
	stock_num=document.getElementById("stock_num_legal").value;
	
	xmlhttp.open("GET","s1/cancel_controllers/check_id_legal?id_legal="+str+"&stock_num_legal="+stock_num,true);
	xmlhttp.send();
}

function login_out()
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","s1/login_controllers/login_out",true);
	xmlhttp.send();
}

function check_login(str)
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	if (str=="register")
	{
		xmlhttp.open("GET","s1/check_login/register",true);
		xmlhttp.send();
	}
}