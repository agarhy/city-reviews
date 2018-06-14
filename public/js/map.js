function initMap() {

        var locations = [];
        var map,
            infowindow, marker, i,
            mc;
        var markers = new Array();
        var mcOptions = {gridSize: 20, maxZoom: 17};
        var max=20,min=20;

        var iconBase = '/img/';
        var icons = {
          positive: {
            icon: iconBase + 'map-marker-g.png'
          },
          negative: {
            icon: iconBase + 'map-marker-r.png'
          },
          neutral: {
            icon: iconBase + 'map-marker-b.png'
          }
        };

        jQuery.each( $('#review-list ul li'), function( i, val ) {
            lat=$(val).attr('data-lat');
            lng=$(val).attr('data-lng');
            id = $(val).attr('id');
            sentiment = $(val).attr('data-sentiment');
            html = $(val).html();
            
            $(val).click(function() {
                google.maps.event.trigger(markers[i], 'click');
            });

            entry=[html,lat,lng,sentiment];
            
            locations.push(entry);
        
        });

        
        map = new google.maps.Map(document.getElementById('map-container'), {
        zoom: 10,        
        mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        infowindow = new google.maps.InfoWindow();
        mc = new MarkerClusterer(map, [], mcOptions);
        

        for (i = 0; i < locations.length; i++) {                     
            ///get array of markers currently in cluster
            var allMarkers = mc.getMarkers();
            var latlng=new google.maps.LatLng(locations[i][1], locations[i][2]);
            //final position for marker, could be updated if another marker already exists in same position
            var finalLatLng = latlng;

            //check to see if any of the existing markers match the latlng of the new marker
            if (allMarkers.length != 0) {
                for (i=0; i < allMarkers.length; i++) {
                    var existingMarker = allMarkers[i];
                    var pos = existingMarker.getPosition();

                    //if a marker already exists in the same position as this marker
                    if (latlng.equals(pos) || latlng.getBounds().contains(pos)) {
                        console.log('overlapping detect');
                        //update the position of the coincident marker by applying a small multipler to its coordinates
                        var newLat = latlng.lat() * (Math.random() * (max - min) + min);
                        var newLng = latlng.lng() * (Math.random() * (max - min) + min);

                        finalLatLng = new google.maps.LatLng(newLat,newLng);

                    }                   
                }
            }

            marker = new google.maps.Marker({
                position: finalLatLng,
                map: map,
                icon: icons[locations[i][3]].icon,
            });
            markers.push(marker);
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
                }
            })(marker, i));
     
        }

        function AutoCenter() {
            //  Create a new viewpoint bound
            var bounds = new google.maps.LatLngBounds();
            //  Go through each...
            $.each(markers, function (index, marker) {
            bounds.extend(marker.position);
            });
            //  Fit these bounds to the map
            map.fitBounds(bounds);
        }

        AutoCenter();
}

