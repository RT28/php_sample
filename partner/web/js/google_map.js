function initGoogleMap() {

	//Run this code only on create and update university pages.
	var mapContainer = document.getElementById('google-map-container');
	if (mapContainer) {

		//create a default map.
    	//add a click listener to map for the use to pick a location.
		/*map.addListener('click', function(e){
			updateMapMarker(map, e);
		});*/	

		//If co-ordinates are already available, plot them on the map.
		var coords = $('#university-location').val();
		var temp = $('#map-search').val();
		if (coords && temp=='') {
			coords = coords.replace(/\(|\)/g, '');
			coords = coords.split(',');
			var lat = Number(coords[0]);
			var lng = Number(coords[1]);
			var map = new google.maps.Map(mapContainer, {
        		center: {lat: lat, lng: lng},
        		zoom: 15
    		}); 		
			var marker = new google.maps.Marker({
				map: map,
				draggable: true, 
				position: {
					lat: lat,
					lng: lng
				}
			});

			google.maps.event.addListener(marker, 'dragend', function(e){   
				updateMapMarker(map, e);
		    }); 

		}	    
	    else {
	    	var url = "https://maps.googleapis.com/maps/api/geocode/json?address="+getAddress();
	    	if(temp!=''){
	    		url = "https://maps.googleapis.com/maps/api/geocode/json?address="+temp;
	    	}			 
			$.ajax({ 
				url:url, 
				type: "POST", 
				success:function(results){ 
					//map.setCenter(results.results[0].geometry.location);
					if(results.results[0]) {
						var map = new google.maps.Map(mapContainer, {
							center: results.results[0].geometry.location,
							zoom: 15
						}); 					
						var marker = new google.maps.Marker({
							map: map,
							draggable: true, 
							position: results.results[0].geometry.location
						});

						var latLng = '(' + results.results[0].geometry.location.lat + ',' + results.results[0].geometry.location.lng + ')';
						$('#university-location').val(latLng);
						google.maps.event.addListener(marker, 'dragend', function(e){   
							updateMapMarker(map, e);
						});
						} 			
				} 
			});	    		
	    }		
	}	
}

function getAddress() {
	var university = $('#university-name').val();
	var country = $("#country_id option:selected").html();
	var state = $("#state_id option:selected").html();
	var city = $("#city_id option:selected").html();
	var address = $("#university-address").val();

	var searchString = university ? university + ', ' : '';
	searchString += address ? address + ', ' : '';
	searchString += city ? city + ', ' : '';
	searchString += state ? state + ', ' : '';
	searchString += country ? country : '';
	
	return searchString;
	//return '450 Serra Mall Stanford, CA 94305';
}

function updateMapMarker(map, e) {
	$('#university-location').val(e.latLng);
} 