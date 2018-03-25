// JavaScript Document
function searchid(str)
{
/*	if (str.length==0)
	{ 
		document.getElementById("txtHint").innerHTML="";
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
	xmlhttp.onreadystatechange=function()*/
	{
//		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			tmp=document.getElementById("test_id");
//			tmp.innerHTML="ddd";
			tmp.style.color="#770099";
			if (tmp.hasChildNodes())
				tmp.removeChild(input);
			var input =document.createElement("input");
			input.type="button";
			input.value="测试";
			document.getElementById("test_id").appendChild(input);
			
		}
	}
//	xmlhttp.open("GET","test_id.php?id="+str,true);
//	xmlhttp.send();
}