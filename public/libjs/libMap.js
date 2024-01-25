var maxBounds = L.latLngBounds(
	L.latLng(4.4768973, 97.9345395),
	L.latLng(-0.9342298, 100.1206317));

var map = L.map('map', {
	closePopupOnClick: false
}).setView([3.6051948, 98.7177819], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	attribution: '© <a href="http://osm.org/copyright">OpenStreetMap</a> ecaleg.com'
}).addTo(map);

//map.setMaxBounds(maxBounds);
map.fitBounds(maxBounds);

const generatePulsatingMarker = function (radius, color) {
	const cssStyle = `
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
	iconUrl: site_url + 'vendor/assets/icons/marker.svg',
	iconSize: [20, 20], // size of the icon
	popupAnchor: [0, -15]
});

var cssIcon = L.divIcon({
	// Specify a class name we can refer to in CSS.
	className: 'css-icon',
	html: '<div class="gps_ring"></div>'
	// Set marker width and height
	, iconSize: [22, 22]
	// ,iconAnchor: [11,11]
});

var customOptions = {
	maxWidth: "auto",
	'className': 'custom',
	closeButton: true,
	autoClose: true
}


$(document).ready(function () {
	setmarker();

});





$(".resetMap").on('click', function (event) {
	event.preventDefault();
	/*map.eachLayer((layer) => {
	  layer.remove();
  });*/


	$("#filter_kabupaten option:not(:first), #filter_kecamatan option:not(:first), #filter_kelurahan option:not(:first)").remove();
	$('#form_filter_map')[0].reset();
	setmarker();
});

$(".refreshMap").on('click', function () {

	let url = currentClass + 'filtermap';
	let formdata = new FormData($('#form_filter_map')[0]);

	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'JSON',
		contentType: false,
		processData: false,
		data: formdata,
	})
		.done(function (resp) {
			if (resp.status) {
				$(".leaflet-marker-icon").remove(); $(".leaflet-popup").remove();

				var markers = L.markerClusterGroup();
				map.eachLayer(function (layer) {
					if (layer instanceof L.MarkerClusterGroup) {
						map.removeLayer(layer)
					}
				})




				for (var i = 0; i < resp.data.length; i++) {


					Lat = resp.data[i].latitude;
					Long = resp.data[i].longitude;
					if (Lat && Long) {
						var marker = L.marker([Lat, Long], {
							icon: markerIcon
						}).bindPopup(setPopUpCluster(resp.data[i]), customOptions)
					}
					markers.addLayer(marker);
					//console.log(Lat,Long);


				}
				map.addLayer(markers);
			} else {
				$(".leaflet-marker-icon").remove(); $(".leaflet-popup").remove();
			}
		})
		.fail(function () {
			console.log("error");
		})
		.always(function () {
			console.log("complete");
		});

});

function setmarker() {
	$.ajax({
		url: currentClass + '/setmarker',
		type: 'POST',
		dataType: 'JSON',

	})
		.done(function (response) {
			//console.log("success");
			if (response.status) {
				$(".leaflet-marker-icon").remove(); $(".leaflet-popup").remove();
				var markers = L.markerClusterGroup();
				for (var i = 0; i < response.data.length; i++) {


					Lat = response.data[i].latitude;
					Long = response.data[i].longitude;
					if (Lat && Long) {
						var marker = L.marker([Lat, Long], {
							icon: markerIcon
						}).bindPopup(setPopUpCluster(response.data[i]), customOptions)
					}
					markers.addLayer(marker);
					//console.log(Lat,Long);


				}
				map.addLayer(markers);


			}
		})
		.fail(function () {
			console.log("error");
		})
		.always(function () {
			console.log("complete");
		});

}
function setPopUp(data) {
	let popUP = '';
	popUP = '<table class="table table-hover" width="auto">' +
		'<tr>' +
		'<td colspan="4"><strong>' + data.desa + ', </strong><br>' + data.kecamatan + ', <br>' + data.kabupaten + ' </td>' +
		'</tr>' +
		'<tr>' +
		'<td class="bg-primary" >&nbsp;</td>' +
		'<td>Anggota Pria</td>' +
		'<td>' + data.pria + '</td>' +
		'</tr>' +
		'<tr>' +
		'<td class="bg-warning" >&nbsp;</td>' +
		'<td>Anggota Wanita</td>' +
		'<td>' + data.wanita + '</td>' +
		'</tr>' +
		'<tr>' +
		'<td class="bg-success"></td>' +
		'<td>Total Anggota</td>' +
		'<td>' + data.jumlah + '</td>' +
		'</tr>' +

		'</table>';

	var popup = L.responsivePopup().setContent(popUP);

	return popup;
}
function setPopUpCluster(data) {
	let popUP = '';
	popUP = '<table class="table table-hover" width="auto">' +
		'<tr>' +
		'<td colspan="4"><strong>' + data.desa + ', </strong><br>' + data.kecamatan + ', <br>' + data.kabupaten + ' </td>' +
		'</tr>' +
		'<tr>' +
		'<td class="bg-primary" >&nbsp;</td>' +
		'<td>Nama</td>' +
		'<td>' + data.nama + '</td>' +
		'</tr>' +
		'<tr>' +
		'<td class="bg-warning" >&nbsp;</td>' +
		'<td>Gender</td>' +
		'<td>' + data.gender + '</td>' +
		'</tr>' +
		'<tr>' +
		'<td class="bg-success"></td>' +
		'<td>Usia</td>' +
		'<td>' + data.age + '</td>' +
		'</tr>' +

		'</table>';

	var popup = L.responsivePopup().setContent(popUP);

	return popup;
}



function formated_number(number) {
	return new Intl.NumberFormat(['id']).format(number);
}
