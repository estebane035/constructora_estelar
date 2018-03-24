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

//show_works_descripction.php
$(function(){ 
  $("input[name='file']").on("change", function(){
            var formData = new FormData($("#formulario")[0]);
            var ruta = "acciones_ajax/imagen-ajax.php";
            $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(datos)
                {
                    $("#respuesta").html(datos);
                }
            });
   });
});


//acciones_Ajax/notificacion_seleccionada_ajax.php
function muestra_notificaciones()
{ /*
	divResultado = document.getElementById('main_notifications');
	ajax=objetoAjax();
	ajax.open("POST","acciones_ajax/notificacion_lista_ajax.php",true);
	ajax.onreadystatechange=function()
	{	if(ajax.readyState==4)
		{ divResultado.innerHTML=ajax.responseText}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send();*/
	location.href='notification_selected.php?idnot='+idnotificacion+'&idwork='+idwork;alert(1);
}
//show_works_description
function notificacion_seleccionada(idnotificacion,idwork)
{ /*
	divResultado = document.getElementById('main_notifications');
	ajax=objetoAjax();
	ajax.open("POST","acciones_ajax/notificacion_seleccionada_ajax.php",true);
	ajax.onreadystatechange=function()
	{	if(ajax.readyState==4)
		{ divResultado.innerHTML=ajax.responseText}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("idnot="+idnotificacion);*/
	location.href='notification_selected.php?idnot='+idnotificacion+'&idwork='+idwork;

}




//index.php
function show_works(work)
{ //alert(work);
/*
	divResultado = document.getElementById('work_description');
	ajax=objetoAjax();
	ajax.open("POST","acciones_ajax/show_works_description_ajax.php",true);
	ajax.onreadystatechange=function()
	{	if(ajax.readyState==4)
		{ divResultado.innerHTML=ajax.responseText}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("idwork="+work);
*/
	location.href='show_works_description.php?idwork='+work;
}
