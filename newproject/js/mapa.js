function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('mapa'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
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
            });

            markers.push(marker);



            document.getElementById('lat').value = place.geometry.location.lat();
            document.getElementById('lng').value = place.geometry.location.lng();

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