// JavaScript Document
function iFrameHeight() { 
var ifm= document.getElementById("iframe_2"); 
var subWeb = document.frames ? document.frames["iframe_2"].document : ifm.contentDocument; 
if(ifm != null && subWeb != null) { 
ifm.height = subWeb.body.scrollHeight; 
} 
} 