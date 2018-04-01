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
          center: {lat: latitud, lng: longitud},
          zoom: 15,
          mapTypeId: 'roadmap'
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

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          var entro = false;
          places.forEach(function(place) {
            if (entro)
              return;
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }

            // Create a marker for each place.
            marker = new google.maps.Marker({
              map: map,
              animation: google.maps.Animation.DROP,
              title: place.name,
              position: place.geometry.location,
              draggable: true,
            });
            marker.addListener('dragend', function(evt) {
              map.setCenter(marker.getPosition());
              document.getElementById('lat').value = evt.latLng.lat();
              document.getElementById('lng').value = evt.latLng.lng();
              actualizarPosicion(evt.latLng.lat(), evt.latLng.lng(), document.getElementById('id_proyecto').value)
            });

            markers.push(marker);



            document.getElementById('lat').value = place.geometry.location.lat();
            document.getElementById('lng').value = place.geometry.location.lng();
            actualizarPosicion(place.geometry.location.lat(), place.geometry.location.lng(), document.getElementById('id_proyecto').value)

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }

            entro = true;
          });
          map.fitBounds(bounds);
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

function actualizarRango(id){
  var rango = document.getElementById('rango').value;
  var hora_check_in = document.getElementById('hora_check_in').value;
    $.ajax({
      url: "acciones_ajax/actualizar_rango.php",
      type: "POST",
      data: { rango: rango, hora_check_in:hora_check_in, id:id},
      success: function(datos)
      {
        if (datos != "1")
        {
          alert(datos);
        }
      }
    });
}