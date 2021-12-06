/*jQuery(document).ready(function() {

	jQuery(".axgmap p").each(function(){
		var context = jQuery(this);
		var latlng = context.data("latlng");
		var title = context.data("title");
		console.log(latlng+ ' ' + title);
	});
	
});*/
(function($) {
    // generate map
    function new_map($el) {
        // var
        var $markers = $el.find('.marker');
        // vars
        var args = {
            zoom: 13,
            center: new google.maps.LatLng(0, 0),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        // create map	        	
        var map = new google.maps.Map($el[0], args);
        // add a markers reference
        map.markers = [];
        // add markers
        $markers.each(function() {
            add_marker($(this), map);
        });
        // center map
        center_map(map);
        return map;
    }
    // add the marker
    function add_marker($marker, map) {
        // var
        var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
        // create marker
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
			icon: $marker.data('icon'),
			title: $marker.data('title')
        });
        // add to array
        map.markers.push(marker);
        // if marker contains HTML, add it to an infoWindow
        if ($marker.html()) {
            // create info window
            var infowindow = new google.maps.InfoWindow({
				//title: $marker.data('title'),
                content: $marker.html(),
				maxWidth: 300 ,
				maxHeight: 'auto'
            });
            // show info window when marker is clicked
            google.maps.event.addListener(marker, 'click', function() {
               infowindow.open(map, marker);
            });
			
			google.maps.event.addDomListener(document.getElementById(name), 'click', function() {
			  infowindow.open(map,marker);
			});
			
        }
		
		$('.open_infowindow').on('click', function () {
		var markers = new Array();
		var args = {
            zoom: 13,
            center: new google.maps.LatLng(parseFloat($(this).attr('data-lat')), parseFloat($(this).attr('data-lng'))),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

		var map = new google.maps.Map($('.acf-map'), args);
		
		var latlng = new google.maps.LatLng(parseFloat($(this).attr('data-lat')), parseFloat($(this).attr('data-lng')));
        
		// create marker
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
			icon: $(this).data('icon'),
			title: $(this).data('title')
        });


            // create info window
            var infowindow = new google.maps.InfoWindow({
				//title: $marker.data('title'),
                content: "Hehleooe",
				maxWidth: 300 ,
				maxHeight: 'auto'
            });
            // show info window when marker is clicked
            google.maps.event.addListener(marker, 'click', function() {
               infowindow.open(map, marker);
            });
       
        // add to array
		markers.push(marker);
		
		//google.maps.event.trigger(marker[$(this).data('title')], 'click');
			
		});
		
    }
    // center the map
    function center_map(map) {
        // vars
        var bounds = new google.maps.LatLngBounds();
        // loop through all markers and create bounds
        $.each(map.markers, function(i, marker) {
            var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
            bounds.extend(latlng);
        });
        // only 1 marker?
        if (map.markers.length == 1) {
            // set center of map
            map.setCenter(bounds.getCenter());
            map.setZoom(13);
        } else {
            // fit to bounds
            map.fitBounds(bounds);
        }
    }
    // embed it
    var map = null;
    $(document).ready(function() {
        $('.acf-map').each(function() {
            // create map
            map = new_map($(this));
        
		});
		
    });
})(jQuery);