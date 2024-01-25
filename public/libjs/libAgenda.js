var tableDataAgenda = $('#table_data_agenda');

$(document).ready(function () {
	loadDataTable(tableDataAgenda);
	$("#wa_center_id").load(currentClass + 'select_wa_center');
	$("#id_partai").load(currentClass + 'selectpartai');

	$("#tingkat_pemilihan_id").on('change', function () {
		$("#dapil_id").val('').trigger('change');
		$("#dapil_id").load(currentClass + 'selectdapil/' + $(this).val());


	});

	$("#jenis_agenda_id").load(currentClass + 'select_jenis_agenda', function () {
		/* Act on the event */
	});



	/*  $('#createdbyName').load(currentClass+'currentsessionname', function(d){
		  $('#createdbyName').val(d['nama']);
		  console.log(d['nama']);
	  });*/

	$('#kordapil_akun_id').load(currentClass + 'selectkordapil', function () {
		/* Act on the event */
	});

	$("#caleg_akun_id").load(currentClass + 'select_caleg', function () {
		/* Act on the event */
	});

	$("#dapil_id").on('change', function () {
		console.log('dapil id = ' + $(this).val());
		let jumlahDPT = $('#jumlah_dpt');
		let jumlahTPS = $('#jumlah_tps')
		let url = currentClass + 'data_dapil/' + $(this).val();
		$.ajax({
			url: url,
			type: 'post',
			data: {},
			success: function (resp) {
				if (resp.status) {
					jumlahDPT.val(resp.data.jumlahDPT);
					jumlahTPS.val(resp.data.jumlahTPS);
				} else {
					jumlahDPT.val('-');
					jumlahTPS.val('-');
				}
			}
		});
	});

	$('.dateTimePicker').daterangepicker({
		singleDatePicker: true,
		timePicker: false,
		timePicker24Hour: false,
		showDropdowns: true,
		minYear: 1940,
		maxYear: parseInt(moment().format('YYYY'), 10),
		applyClass: 'bg-slate-600',
		cancelClass: 'btn-light',
		drops: 'auto',
		locale: {
			format: 'DD-MM-YYYY'
		}
	});


	$("#prop_kode").load(currentClass + '/selectPropinsi');
	$("#prop_kode").change(function () {
		//document.getElementById('kecamatan').selectedIndex = 0;
		//document.getElementById('kelurahan').selectedIndex = 0;
		$("#kec_kode option:not(:first), #desa_kode option:not(:first)").remove();
		var url = currentClass + '/selectKabupaten/' + $(this).val();
		$('#kab_kode').load(url);
		return false;
	})

	$("#kab_kode").change(function () {
		$("#desa_kode option:not(:first)").remove();
		var url = currentClass + '/selectKecamatan/' + $(this).val();
		$('#kec_kode').load(url);
		return false;
	});

	$("#kec_kode").change(function () {
		var url = currentClass + '/selectDesa/' + $(this).val();
		$('#desa_kode').load(url);
		return false;
	});



	$(document).on('click', '.laporBtn', function (event) {
		event.preventDefault();
		$("#form_data_laporan_agenda [name=id] ").val('');
		$("#form_data_laporan_agenda [name=catatan_kegiatan] ").val('');
		$("#form_data_laporan_agenda [name=status_agenda] ").val('');

		$('.imgUpload').empty();
		let agendaID = $(this).data('value');
		let url = currentClass + 'edit_data_agenda/' + agendaID;
		let textRingkasan = '';
		let ringkasan = $('#ringkasan_agenda');
		$.ajax({
			url: url,
			type: "GET",
			dataType: "JSON",
			success: function (resp) {
				if (resp.status) {
					textRingkasan += "Nama Agenda  :  " + resp.data['nama_agenda'] + '\n'
						+ "Deskripsi : " + resp.data['deskripsi'];

					ringkasan.text(textRingkasan);
					$("#form_data_laporan_agenda [name=id] ").val(resp.data['id']);
					$("#nama_caleg").val(resp.data['nama_caleg']);
					$('#modal_data_laporan_agenda').modal('show');
				}
			}
		});
	});
});


$(document).on('change', '#lampiran', function () {
	let file = this.files[0];
	let id = $("#form_data_laporan_agenda [name=id] ").val();
	let label = $(this).data('label');
	let img = $(this).prop('files')[0];

	if (id) {

		var form_data = new FormData();
		form_data.append('lampiranAgenda', img);
		form_data.append('id', id);
		//form_data.append('nik', nik);
		//form_data.append('idMobil', idMobil);
		$.ajax({
			url: currentClass + '/upload_foto',
			type: 'post',
			data: form_data,
			contentType: false,
			cache: false,
			processData: false,
			success: function (resp) {
				//console.log(resp);
				if (resp.status) {
					// set nama file di value file input;
					// display img preview
					//$('#' + label).val(resp.data.fileName);
					//$('.' + id).attr('src', resp.data.fileUrl);
					//var image = new Image(100, 135);
					//image.src = resp.data.fileUrl;
					//$('.imgUpload').append(image);

					let cardImg = '<li class="img col-auto ">'
						+ '<div class="alert"> '
						+ '<img src="' + resp.data.fileUrl + '" class="img-responsive " width="100px" height="auto">'
						+ '<input type="hidden" name="lampiran_foto[]" value="' + resp.data.fileName + '" >'
						+ '<div class="btn  btn-danger btn-close m-2 closeCard"></div>'
						+ '</div>'
						+ ' </li> '
					$('.imgUpload').append(cardImg);
					$('#inputFile').html('<input type="file" class="form-control" name="lampiran" id="lampiran" accept="image/*"> ');
				}
				else {
					swal('Error', resp.msg.error, 'error');
				}
			}
		});
	} else {
		swal('Warning', 'Silakan isi 16 Digit NIK, dan pilih file kembali', 'warning');
		$(this).val('');
	}

});
$(document).on('click', '.closeCard', function () {
	var target = $(this).parents('li');
	console.log('klik = closeCard');
	target.hide('slow', function () { target.remove(); });
})




function addProcess(dataLabel) {
	$('#modal_' + dataLabel).modal('show');
	$("#modal_data_agenda").on('shown.bs.modal', function () {

		$.get(currentClass + 'currentsessionname', function (d) {
			$('#createdbyName').val(d['nama']);

		});
	});
}

function editResponse(resp, dataLabel, dataValue) {
	if (resp.status) {
		for (var prop in resp.data) {

			$("#" + formID + " [name=" + prop + "]").val(resp.data[prop]);


		}
		reSelectDetail(resp.data['prop_kode'], resp.data['kab_kode'], resp.data['kec_kode'], resp.data['desa_kode']);
		pinMap(resp.data['pin_lat'], resp.data['pin_long']);

		$('#modal_' + dataLabel).modal('show');


	} else {

		swal('Error', resp.msg.error, 'error');

	}
}


function reSelectDetail(prop, kab, kec, desa) {
	$('#prop_kode').val(prop);
	$('#kab_kode').load(currentClass + '/selectKabupaten/' + prop, function () {
		$('#kab_kode').val(kab);
	});
	$('#kec_kode').load(currentClass + '/selectKecamatan/' + kab, function () {
		$('#kec_kode').val(kec);
	});
	$('#desa_kode').load(currentClass + '/selectDesa/' + kec, function () {
		$('#desa_kode').val(desa)
	});
}
function deleteResponse(response) {

}

function repDapil(d) {
	if (d['tingkat_pemilihan_id'] && d['dapil_id']) {

		url = currentClass + 'selectdapil/' + d['tingkat_pemilihan_id'];
		$('#dapil_id').load(url, function () {
			$("#dapil_id").val(d['dapil_id']);
		});
	}
}