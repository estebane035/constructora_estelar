// JavaScript Document
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		} 
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

//workers_contact.php
function actualiza_telefono(idworker)
{   //alert(idworker);
	telephone=document.getElementById('valor_telephone'+idworker).value;
	if(telephone)
	{
	divResultado = document.getElementById('telephone'+idworker);
	ajax=objetoAjax();
	ajax.open("POST","acciones_ajax/actualiza_telefono_ajax.php",true);
	ajax.onreadystatechange=function()
	{	if(ajax.readyState==4)
		{ divResultado.innerHTML=ajax.responseText}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("idworker="+idworker+"&telefono="+telephone);
	}
}

function actualiza_email(idworker)
{
	email=document.getElementById('valor_email'+idworker).value;
	if(email)
	{
	divResultado = document.getElementById('email'+idworker);
	ajax=objetoAjax();
	ajax.open("POST","acciones_ajax/actualiza_email_ajax.php",true);
	ajax.onreadystatechange=function()
	{	if(ajax.readyState==4)
		{ divResultado.innerHTML=ajax.responseText}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("idworker="+idworker+"&email="+email);
	}
}
