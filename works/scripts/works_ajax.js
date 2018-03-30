// JavaScript Document
$(document).ready(function() {
  getLocation();
	check_state = $('#check_state').val();
	switch (check_state) {
		case '0':
			break;
		case '1':
			$('#check').css("background", "#EA1111");
			$('#check').css("border", "3px solid #EA1111");
			$('#text_check').text("Check Out");
			break;
		case '2':
			$('#check').css("background", "#8AE943");
			$('#check').css("border", "3px solid #8AE943");
			$('#text_check').text("Check In");
			//$('#text_check').prop('onclick',null).off('click');
			break;
	}
});
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

function check(id_proyecto, id_trabajador){
	$.ajax({
		type : "POST",
		url : "acciones_form/add_check.php",
		data : {
			id_proyecto : id_proyecto,
			id_trabajador : id_trabajador
		},
		success: function(result){
			// 1: Entrada registrada
			// 2: Salida registrada
			// 3: Ya se ha registrado la Salida
			// 0: Error
			switch(result){
				case "0":
					alert("Error");
					break;
				case "1":
					alert("Entrada registrada");
					$('#check').css("background", "#EA1111");
					$('#check').css("border", "3px solid #EA1111");
					$('#text_check').text("Check Out");
					break;
				case "2":
					alert("Salida registrada");
					$('#check').css("background", "#8AE943");
					$('#check').css("border", "3px solid #8AE943");
					$('#text_check').text("Check In");
					//$('#text_check').prop('onclick',null).off('click');
					break;
				case "3":
					alert("Ya se ha registrado la salida");
					break;
			}

		},
		error: function($result){
			alert ("Error");
		}
	});
}

function validateDistance(id_proyecto, id_trabajador){
  var origin = new google.maps.LatLng($('#current_latitude').val(), $('#current_longitude').val());
  var destiny = new google.maps.LatLng($('#project_latitude').val(), $('#project_longitude').val());
  var service = new google.maps.DistanceMatrixService();
  service.getDistanceMatrix(
    {
      origins: [origin],
      destinations: [destiny],
      travelMode: 'DRIVING',
      unitSystem: google.maps.UnitSystem.METRIC,
      avoidHighways: false,
      avoidTolls: false,
    }, function (response, status) {
      //alert(JSON.stringify(response));
      if(status != 'OK'){
        alert("No se pudo determinar la ubicación, vuelve a intentar");
      }
      else{
        var distance = response.rows[0].elements[0].distance.value;
        alert(distance + " metros");
        if(distance > 100)
          alert("Te encuentras muy lejos, no es posible realizar el check");
        else
          check(id_proyecto, id_trabajador);
      }
    //alert(JSON.stringify(response));
    //return JSON.stringify(response["rows"][0]["elements"][0]["distance"]["text"]);
    //alert(JSON.stringify(response["rows"][0]["elements"][0]["distance"]["text"]));
    // See Parsing the Results for
    // the basics of a callback function.
  });
}
function getLocation() {

  var latitud;
  var longitud;
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(mostrarUbicacion);
  }
  else {
      alert("¡Error! Este navegador no soporta la Geolocalización.");
  }
  function mostrarUbicacion(position) {
      var times = position.timestamp;
      latitud = position.coords.latitude;
      longitud = position.coords.longitude;
      var altitud = position.coords.altitude;
      var exactitud = position.coords.accuracy;
      $('#current_latitude').val(latitud);
      $('#current_longitude').val(longitud);
      //document.getElementById('current_latitude').value = latitud;
      //document.getElementById('current_longitude').value = longitud;
      //alert("Timestamp: " + times + "\nLatitud: " + latitud + "\nLongitud: " + longitud + "\nAltura en metros: " + altitud + "\nExactitud: " + exactitud);
  }
}
