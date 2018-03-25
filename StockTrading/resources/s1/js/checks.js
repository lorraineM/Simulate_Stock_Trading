function searchid(str,str1)
{	
	if (str.length==0)
	{ 
		document.getElementById(str1).innerHTML="";
		return;
	}
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{	//if (xmlhttp.readyState==4 && xmlhttp.readyState=="complete")
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById(str1).innerHTML=xmlhttp.responseText;
			document.getElementById(str1).style.color="#dd2248";
		}
	}

	xmlhttp.open("GET","s1/hregister/test_lost_id?id="+str,true);
	xmlhttp.send(null);
}