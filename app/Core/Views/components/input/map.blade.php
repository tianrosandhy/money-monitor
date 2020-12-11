@if(env('GOOGLE_MAP_API_KEY'))
<?php
$cleaned_name = str_replace('[]', '', $name);
$old_name = $cleaned_name;
if(!isset($multi_language)){
  $multi_language = false;
}

if($multi_language){
  $name = $cleaned_name.'['.def_lang().']';
  $old_name = $cleaned_name.'.'.def_lang();
}

if(is_array($value)){
  if(array_key_exists(def_lang(), $value)){
    $value = $value[def_lang()];
  }
}
$value_array = json_decode($value, true);
$latitude = $value_array['latitude'] ?? -8.6816681;
$longitude = $value_array['longitude'] ?? 115.2036338;
?>
<div>
	<input name="{{ $name }}[human_address]" id="pac-input" class="form-control controls" type="text" placeholder="Search Location Box" value="{{ $value_array['human_address'] ?? null }}" />
</div>
<div class="row" style="{!! isset($show_value) ? '' : 'display:none;' !!}">
	<div class="col-sm-6">
		<input type="tel" name="{{ $name }}[latitude]" id="map-latitude" value="{{ $latitude }}" class="form-control" placeholder="Latitude">
	</div>
	<div class="col-sm-6">
		<input type="tel" name="{{ $name }}[longitude]" id="map-longitude" value="{{ $longitude }}" class="form-control" placeholder="Longitude">
	</div>
</div>

<div id="map" style="width:100%; height:300px;"></div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&libraries=places&callback=initMap"></script>
<script>
function initMap(){
	var ctr = {
		lat : parseFloat(document.getElementById('map-latitude').value), 
		lng : parseFloat(document.getElementById('map-longitude').value), 
	};
	var map = new google.maps.Map(
			document.getElementById('map'), {
				zoom : 16,
				center : ctr,
				mapType : 'roadmap'
			}
		);

	var input = document.getElementById('pac-input');
	var searchBox = new google.maps.places.SearchBox(input);

	map.addListener('bounds_changed', function(){
		searchBox.setBounds(map.getBounds());
	});

	var marker = new google.maps.Marker({
		draggable : true,
		position : ctr, 
		map : map,
		title : 'Your location'
	});
	var markers = [];

	searchBox.addListener('places_changed', function(){
		var places = searchBox.getPlaces();
		if(places.length == 0){
			return;
		}
		markers.forEach(function(mk){
			mk.setMap(null);
		});
		markers = [];

		var bounds = new google.maps.LatLngBounds();
		places.forEach(function(place){
			if(!place.geometry){
				return;
			}
			marker.setPosition(place.geometry.location);
			map.setCenter(place.geometry.location);
			document.getElementById('map-latitude').value = place.geometry.location.lat();
			document.getElementById('map-longitude').value = place.geometry.location.lng();
			return;
		});
	});

	google.maps.event.addListener(marker, 'dragend', function(e){
		document.getElementById('map-latitude').value = e.latLng.lat();
		document.getElementById('map-longitude').value = e.latLng.lng();
	});
}

$(function(){
	$("#pac-input").on('keydown', function(e){
		if(e.which == 13){
			$(".pac-container .pac-item:first").click();
			return false;
		}
	});
});
</script>
@else
<div class="alert alert-danger">You need to define the valid <strong>GOOGLE_MAP_API_KEY</strong> .env first.</div>
@endif
