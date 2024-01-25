var maxBounds =  L.latLngBounds(
  L.latLng(4.4768973,97.9345395),
  L.latLng(-8.377202, 144.422545));
 
/*var maxBounds =  L.latLngBounds(
  L.latLng(4.5237086,95.9481692),
  L.latLng(141.03385176, 5.47982086834));*/

var map = L.map('map', {
    closePopupOnClick: false
  }).setView([-6.1630935,106.8090196], 6);
 
//[3.6051948,98.7177819]
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  	
    attribution: '© <a href="http://osm.org/copyright">OpenStreetMap</a> ecaleg.com'
  }).addTo(map);

/*map.setMaxBounds(maxBounds);
map.fitBounds(maxBounds);*/
$('#modal_data_agenda').on('shown.bs.modal', function() {
  map.invalidateSize();
});
const generatePulsatingMarker = function (radius, color) {
  const cssStyle =`
    width: ${radius}px;
    height: ${radius}px;
    background: ${color};
    color: ${color};
    box-shadow: 0 0 0 ${color};
  `
  return L.divIcon({
    html: `<span style="${cssStyle}" class="pulse"/>`,
    className: ''
  })
}

const pulseRedIcon = generatePulsatingMarker(10, 'red');
const pulseGreenIcon = generatePulsatingMarker(10, 'green');
  var markerIcon = L.icon({
    iconUrl: site_url+'vendor/assets/icons/marker.svg',
    iconSize: [20, 20], // size of the icon
    popupAnchor: [0, -15]
  });

  var cssIcon = L.divIcon({
		  // Specify a class name we can refer to in CSS.
		  className: 'css-icon',
		  html: '<div class="gps_ring"></div>'
		  // Set marker width and height
		  ,iconSize: [22,22]
		  // ,iconAnchor: [11,11]
		});
  
  var customOptions = {
   maxWidth: "auto",
    'className': 'custom',
    closeButton: true,
    autoClose: true
  }
  

  $(document).ready(function() {
  	//setmarker();	

  });

/*$('#map').on('shown.bs.modal', function(){
    setTimeout(function() {
        map.invalidateSize();
    }, 10);
});*/



 $(".resetMap").on('click',  function(event) {
 	event.preventDefault();
	 	/*map.eachLayer((layer) => {
	  	layer.remove();
		});*/


 	$("#filter_kabupaten option:not(:first), #filter_kecamatan option:not(:first), #filter_kelurahan option:not(:first)").remove();
 	$('#form_filter_map')[0].reset();
 	setmarker();
 });

 $(".refreshMap").on('click', function() {
	 	
	 	let url = currentClass+'filtermap';
	 	let formdata = new FormData( $('#form_filter_map')[0] );
	 	
	 	$.ajax({
	 		url: url,
	 		type: 'POST',
	 		dataType: 'JSON',
	 		contentType: false,
  	  		processData: false,
	 		data: formdata,
	 	})
	 	.done(function(resp) {
		 		if(resp.status){
		   			$(".leaflet-marker-icon").remove(); $(".leaflet-popup").remove();

		   			var markers = L.markerClusterGroup();
		   			map.eachLayer(function(layer) {
						    if (layer instanceof L.MarkerClusterGroup)
						    {
						        map.removeLayer(layer)
						    }
						})


		   			for(var i= 0; i<resp.data.length;i++){
		           					
		           					
									Lat = resp.data[i].latitude ; 
									Long = resp.data[i].longitude;
									if(Lat && Long){
									var marker =		L.marker([Lat, Long], {
			            			icon: markerIcon
								  		}).bindPopup(setPopUpCluster(resp.data[i]), customOptions)
									}
								markers.addLayer(marker);
									//console.log(Lat,Long);
		        						
						            		
		        }	
		        map.addLayer(markers);
		  	}else{
		  		$(".leaflet-marker-icon").remove(); $(".leaflet-popup").remove();
		  	}
	 	})
	 	.fail(function() {
	 		console.log("error");
	 	})
	 	.always(function() {
	 		console.log("complete");
	 	});
 	
 });

 function setmarker() {
 	$.ajax({
 		url: currentClass+'/setmarker',
 		type: 'POST',
 		dataType: 'JSON',
 		
 	})
 	.done(function(response) {
 		//console.log("success");
 		if(response.status){
	   			$(".leaflet-marker-icon").remove(); $(".leaflet-popup").remove();
	   			var markers = L.markerClusterGroup();
	   			for(var i= 0; i<response.data.length;i++){
	           					
	           					
								Lat = response.data[i].latitude ; 
								Long = response.data[i].longitude;
								if(Lat && Long){
								var marker =		L.marker([Lat, Long], {
		            			icon: markerIcon
							  		}).bindPopup(setPopUpCluster(response.data[i]), customOptions)
								}
							markers.addLayer(marker);
								//console.log(Lat,Long);
	        						
					            		
	        }	
	        map.addLayer(markers);


	  }
 	})
 	.fail(function() {
 		console.log("error");
 	})
 	.always(function() {
 		console.log("complete");
 	});
 	
 }
 function setPopUp(data){
 	let popUP = '';
 	popUP =	'<table class="table table-hover" width="auto">'+
					'<tr>'+
						'<td colspan="4"><strong>'+data.desa+', </strong><br>'+data.kecamatan+', <br>'+data.kabupaten+' </td>'+
					'</tr>'+
					'<tr>'+
						'<td class="bg-primary" >&nbsp;</td>'+
						'<td>Anggota Pria</td>'+
						'<td>'+data.pria+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td class="bg-warning" >&nbsp;</td>'+
						'<td>Anggota Wanita</td>'+
						'<td>'+data.wanita+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td class="bg-success"></td>'+
						'<td>Total Anggota</td>'+
						'<td>'+data.jumlah+'</td>'+
					'</tr>'+
					
					'</table>';

					var popup = L.responsivePopup().setContent(popUP);
	
	return popup;
 }
 function setPopUpCluster(data){
 	let popUP = '';
 	popUP =	'<table class="table table-hover" width="auto">'+
					'<tr>'+
						'<td colspan="4"><strong>'+data.desa+', </strong><br>'+data.kecamatan+', <br>'+data.kabupaten+' </td>'+
					'</tr>'+
					'<tr>'+
						'<td class="bg-primary" >&nbsp;</td>'+
						'<td>Nama</td>'+
						'<td>'+data.nama+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td class="bg-warning" >&nbsp;</td>'+
						'<td>Gender</td>'+
						'<td>'+data.gender+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td class="bg-success"></td>'+
						'<td>Usia</td>'+
						'<td>'+data.age+'</td>'+
					'</tr>'+
					
					'</table>';

					var popup = L.responsivePopup().setContent(popUP);
	
	return popup;
 }

var pin;
map.on('click', function(e) {
	if (pin) {
		map.removeLayer(pin);
	}
	 pin = new L.Marker([e.latlng.lat, e.latlng.lng],{icon: markerIcon}).addTo(map);
	//alert('koordinat : '+e.latlng.lat +'-'+ e.latlng.lng)
	 	$('#pin_lat').val(e.latlng.lat);
  	$('#pin_long').val(e.latlng.lng);
	 reverseGeocoding(e.latlng.lat, e.latlng.lng);
});


$('.getLokasi').on('click',  function(event) {
	event.preventDefault();
	if (navigator.geolocation) {
          // getCurrentPosition digunakan untuk mendapatkan lokasi pengguna
          //showPosition adalah fungsi yang akan dijalankan
		const positionOptions = {
			  enableHighAccuracy: true,
			  timeout: 5000,
			  maximumAge: 0,
			};
          navigator.geolocation.getCurrentPosition(showPosition, positionError, positionOptions);
    } else {
    	alert('browser not support geolocation');
    }
});

function showPosition(pos){
  const crd = pos.coords;
  $('#pin_lat').val(crd.latitude);
  $('#pin_long').val(crd.longitude);
  console.log("Your current position is:");
  console.log(`Latitude : ${crd.latitude}`);
  console.log(`Longitude: ${crd.longitude}`);
  console.log(`More or less ${crd.accuracy} meters.`);

  if (pin) {
		map.removeLayer(pin);
	}
	 pin = new L.Marker([crd.latitude, crd.longitude],{icon: markerIcon}).addTo(map);
	 map.flyTo([crd.latitude, crd.longitude], 15);
	//alert('koordinat : '+e.latlng.lat +'-'+ e.latlng.lng)
	 reverseGeocoding(crd.latitude, crd.longitude);

}

function pinMap(lat, long){
 
  $('#pin_lat').val(lat);
  $('#pin_long').val(long);
 

  if (pin) {
		map.removeLayer(pin);
	}

	if(lat && long){
		pin = new L.Marker([lat, long],{icon: markerIcon}).addTo(map);
	 	map.flyTo([lat, long], 15);
	
	 	reverseGeocoding(lat, long);
	
	}
	 
}

function positionError(err) {
  console.warn(`ERROR(${err.code}): ${err.message}`);
}

function reverseGeocoding(lat, long){
	

$.ajax({
		url: "https://api.geoapify.com/v1/geocode/reverse?lat="+lat+"&lon="+long+"&apiKey=e90099741fec4e54a3fe44af3aec0877",
		type: 'GET',
		
		dataType: 'json',
		contentType: false,
  	  	processData: false,
		success: function (resp) {
			//console.log(resp);
			let addressLine1 = resp.features[0].properties.address_line1;
			let addressLine2 = resp.features[0].properties.address_line2;
			let formatedLine = resp.features[0].properties.formatted;
;
			$('.mapResult').html(
				'koordinat : '+lat+','+long + '  &#10;'+
				'alamat   : '+ formatedLine + ' &#10;'
				
				);
		}
	});

}


function formated_number(number) {
	return new Intl.NumberFormat(['id']).format(number);
}
