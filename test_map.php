<?php
$apiKey = "AIzaSyBy5yabtN3ZFIlRM8-NEghybXTCZ-UQ7Dk";
$sensor = "true";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height: 100% }
    </style>
    <script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=<?php echo $apiKey; ?>&sensor=<?php echo $sensor;?>">
    </script>
    <script type="text/javascript">
        var geocoder;
        var map;
        var latElement;
        var lngElement;
        var markerAddress;
        var markerLocation;
        var addressElement;

        function initialize() {
            // Get elements
        	latElement = document.getElementById("lat");
            lngElement = document.getElementById("lng");
            addressElement = document.getElementById("address");

            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(60.39126, 5.32205);
            latElement.innerHTML = latlng.lat().toFixed(5);
            lngElement.innerHTML = latlng.lng().toFixed(5);
            var myOptions = {
                zoom: 15,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                zoomControl: true,
                streetViewControl: false,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                  }
            };
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            // Marker
            markerAddress = new google.maps.Marker({
                map: map,
                position: latlng
            });

            // Map click
            google.maps.event.addListener(map, 'click', function(event) {
              	latElement.innerHTML = event.latLng.lat().toFixed(5);
                lngElement.innerHTML = event.latLng.lng().toFixed(5);
                markerAddress.setPosition(event.latLng);

                // Get address
              	geocoder.geocode({'latLng': event.latLng}, function(results, status) {
                  	if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            console.log(results[0]);
                            addressElement.value = results[0].formatted_address;
                        }
                  	}
                  	else
                  	{
                  	    alert("Geocoder failed due to: " + status);
                  	}
              	});
          	});
        }

        function codeAddress() {
          var address = addressElement.value;
          geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
            	latElement.innerHTML = results[0].geometry.location.lat();
          	    lngElement.innerHTML = results[0].geometry.location.lng();
              map.setCenter(results[0].geometry.location);
              if (!markerAddress){
              markerAddress = new google.maps.Marker({
                  map: map,
                  position: results[0].geometry.location
              });
              }
              else
              {
                  markerAddress.setPosition(results[0].geometry.location);
              }
            } else {
              alert("Geocode was not successful for the following reason: " + status);
            }
          });
        }
    </script>
  </head>
  <body onload="initialize()">
        <div id="map_canvas" style="width: 400px; height: 200px;"></div>
      <div>
        <input id="address" type="textbox" value="Bergen, Norway">
        <input type="button" value="Encode" onclick="codeAddress()">
        <div><span id="lat"></span>, <span id="lng"></span></div>
      </div>
  </body>
</html>