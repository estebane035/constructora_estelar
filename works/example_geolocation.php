<!DOCTYPE>
<?php

?>
<html>
  <head>
    <meta charset="iso-8859-1" /><title>Show Work Description</title>
    <body>
      <div>
        <label>Localizacion</label>
        <input type="button" id="boton" onclick="getLocation();" value="Presiona">
        <input type="button" id="boton" onclick="getDistance();" value="Distancia">
        <input type="hidden" id="reference_latitude" value="20.632162">
        <input type="hidden" id="reference_longitude" value="-103.2741612">
        <input type="hidden" id="current_latitude" value="20.6327939">
        <input type="hidden" id="current_longitude" value="-103.2743451">
      </div>
    </body>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcIdm-qEy0BmocjEoX2pSLrPNKntg4Psk">
    </script>
    <script type="text/javascript">
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
            document.getElementById('current_latitude').value = latitud;
            document.getElementById('current_longitude').value = longitud;
            alert("Timestamp: " + times + "\nLatitud: " + latitud + "\nLongitud: " + longitud + "\nAltura en metros: " + altitud + "\nExactitud: " + exactitud);
        }
      }
      function getDistance(){
        var origin = new google.maps.LatLng(document.getElementById('current_latitude').value, document.getElementById('current_longitude').value);
        var destiny = new google.maps.LatLng(document.getElementById('reference_latitude').value, document.getElementById('reference_longitude').value);
        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix(
          {
            origins: [origin],
            destinations: [destiny],
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false,
          }, callback);

        function callback(response, status) {
          alert(JSON.stringify(response));
          alert(JSON.stringify(response["rows"][0]["elements"][0]["distance"]["text"]));
          // See Parsing the Results for
          // the basics of a callback function.
        }
      }
    </script>
  </head>
</html>
