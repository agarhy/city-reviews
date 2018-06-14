function initMap() {

        var locations = [];
        var map = new google.maps.Map(document.getElementById('map-container'), {
        zoom: 10,        
        mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        var markers = new Array();

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
                console.log('clicked');
                google.maps.event.trigger(markers[i], 'click');
            });

            entry=[html,lat,lng,sentiment];
            console.log(entry);
            locations.push(entry);
        
        });



        for (i = 0; i < locations.length; i++) {  
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
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

