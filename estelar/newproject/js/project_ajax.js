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

/*
function funcion(parametros)
{ divResultado = document.getElementById('');
	ajax=ObjetoAjax();
	ajax.open("POST","ruta",true);
	ajax.onreadystatechange=function()
	{	if(ajax.readyState==4)
		{ divResultado.innerHTML=ajax.responseText}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send();
}*/

/*index.php*/
function agregar_trabajo()
{ //alert(1);
	// alert($('input[name="trabajador"]:checked').val()); 
	c=0;
	descripcion="";
	contratista="";
	if(document.getElementById('descripciontrabajo').selectedIndex==0)
		{c++}else{ descripcion=document.getElementById('descripciontrabajo').value;}
	if(document.getElementById('contratista').selectedIndex==0)
		{c++}else{ contratista=document.getElementById('contratista').value;}
	
	trabajadores=document.getElementsByName('trabajador');
	trabajador="";
	for(i=0;i<trabajadores.length;i++)
	{ //alert(trabajadores.item(i).value);
		if(trabajadores.item(i).checked==true)
		{ //alert(trabajadores.item(i).value);
		  trabajador=trabajadores.item(i).value;
		}
	}
	contactos=document.getElementsByName('contacto_contratista[]');
	contacto="";
	for(i=0;i<contactos.length;i++)
	{ if(contactos.item(i).checked==true)
		{ contacto=contacto+contactos.item(i).value+"-";}
	}
	//alert(contactos.length);
	
	if(descripcion&&contratista&&contacto&&trabajador)
	{	
		divResultado = document.getElementById('trabajos');
		ajax=objetoAjax();
		ajax.open("POST","acciones_ajax/agregar_trabajo_ajax.php",true);
		ajax.onreadystatechange=function()
		{	if(ajax.readyState==4)
			{ divResultado.innerHTML=ajax.responseText}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("descripcion="+descripcion+"&contratista="+contratista+"&trabajador="+trabajador+"&contactos="+contacto);
	}
	else
	{alert('Please Complete all fields');}
}
/*detail_project.php*/
function cerrar_actividad(notificaciones_abiertas,notificaciones_cerradas,actividad)
{
   if(notificaciones_abiertas>0)
   {	
   if(notificaciones_abiertas==notificaciones_cerradas)
   {
	   	divResultado = document.getElementById('actividad'+actividad);
		ajax=objetoAjax();
		ajax.open("POST","acciones_ajax/cerrar_actividad_ajax.php",true);
		ajax.onreadystatechange=function()
		{	if(ajax.readyState==4)
			{ divResultado.innerHTML=ajax.responseText}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("idactividad="+actividad);
   }
   else
   {alert('All notifications must be closed to close activity');}
   }
}

/*inlcudes/trabajos.php*/
function muestra_contactos_contratistas(valor)
{ //alert(valor.value);
	if(valor.value!=0)
	{
	divResultado = document.getElementById('tabla_contactos_contratista');
	ajax=objetoAjax();
	ajax.open("POST","acciones_ajax/muestra_contactos_contratista_ajax.php",true);
	ajax.onreadystatechange=function()
	{	if(ajax.readyState==4)
		{ divResultado.innerHTML=ajax.responseText}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("idcontratista="+valor.value);
	}
	else
	{document.getElementById('tabla_contactos_contratista').innerHTML="";}
}
/*Notificacion.php*/
function muestra_detalle_notificacion(idproyecto)
{
	divResultado = document.getElementById('fila'+idproyecto);
	ajax=objetoAjax();
	ajax.open("POST","acciones_ajax/detalle_notificaciones_ajax.php",true);
	ajax.onreadystatechange=function()
	{	if(ajax.readyState==4)
		{ divResultado.innerHTML=ajax.responseText}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("idpto="+idproyecto);
}