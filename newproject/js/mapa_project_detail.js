var marker;
var latitud = parseFloat(document.getElementById('lat').value);
var longitud = parseFloat(document.getElementById('lng').value);

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

function initMap() {
  var map = new google.maps.Map(document.getElementById('mapa'), {
    zoom: 15,
    center: {lat: latitud, lng: longitud}
  });

  marker = new google.maps.Marker({
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
    position: {lat: latitud, lng: longitud}
  });
  marker.addListener('dragend', function(evt) {
              map.setCenter(marker.getPosition());
              document.getElementById('lat').value = evt.latLng.lat();
              document.getElementById('lng').value = evt.latLng.lng();
              actualizarPosicion(evt.latLng.lat(), evt.latLng.lng(), document.getElementById('id_proyecto').value)
            });
}

function actualizarPosicion(lat, lng, id){
  if (lat && lng)
  {
    ajax=objetoAjax();
    ajax.open("POST","acciones_ajax/actualizar_posicion.php",true);
    ajax.onreadystatechange=function()
    { if(ajax.readyState==4)
      { alert(ajax.responseText)}
    }
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("latitud="+lat+"&longitud="+lng+"&id="+id);
  }
}