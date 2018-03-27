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

//index.php
function actualizar_actividad(notificacion)
{	
	comments=document.getElementById('comments'+notificacion).value;
	divResultado = document.getElementById('notificacion'+notificacion);
	ajax=objetoAjax();
	ajax.open("POST","acciones_ajax/agregar_actividad_ajax.php",true);
	ajax.onreadystatechange=function()
	{	if(ajax.readyState==4)
		{ divResultado.innerHTML=ajax.responseText}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	if(document.getElementById('comments'+notificacion).value)
	{ajax.send("notificacion="+notificacion+"&comments="+comments);}
	else
	{alert('Please complete all fields')}
}

//current_rjects.hp
function detail_notification(idproyecto)
{   divResultado=document.getElementById('fila'+idproyecto);
	ajax=objetoAjax();
	ajax.open("POST","acciones_ajax/detail_notifications_ajax.php",true);
	ajax.onreadystatechange=function()
	{	if(ajax.readyState==4)
		{ divResultado.innerHTML=ajax.responseText}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("idproject="+idproyecto);	
}

//index.php
function finaliza_actividad(notificacion)
{ 	divResultado=document.getElementById('notificacion'+notificacion);
	ajax=objetoAjax();
	ajax.open("POST","acciones_ajax/finalizar_actividad_ajax.php",true);
	ajax.onreadystatechange=function()
	{	if(ajax.readyState==4)
		{ divResultado.innerHTML=ajax.responseText}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("notificacion="+notificacion);	
}
