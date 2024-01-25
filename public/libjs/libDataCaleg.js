var tableDataCaleg = $('#table_data_caleg');

$(document).ready(function () {
	loadDataTable(tableDataCaleg);
	$("#wa_center_id").load(currentClass + 'select_wa_center');
	$("#id_partai").load(currentClass + 'selectpartai');

	$("#tingkat_pemilihan_id").on('change', function () {
		$("#dapil_id").val('').trigger('change');
		$("#dapil_id").load(currentClass + 'selectdapil/' + $(this).val());


	});

	$('#kordapil_akun_id').load(currentClass + 'selectkordapil', function () {
		/* Act on the event */
	});

	$("#id_akun_caleg").load(currentClass + 'select_caleg', function () {
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
});

function editResponse(resp, dataLabel, dataValue) {
	if (resp.status) {
		for (var prop in resp.data) {
			if (prop == 'small_logo' || prop == 'full_logo') {

			} else if (prop == 'tingkat_pemilihan_id') {
				$("#" + formID + " [name=" + prop + "]").val(resp.data[prop]);
				repDapil(resp.data);

			} else if (prop == 'ultah_enable') {
				if (resp.data[prop] == '1') {
					$("#" + formID + " [name=" + prop + "]").prop('checked', true);
				} else {
					$("#" + formID + " [name=" + prop + "]").prop('checked', false);
				}
			} else {
				$("#" + formID + " [name=" + prop + "]").val(resp.data[prop]);
			}

		}


		$('#modal_' + dataLabel).modal('show');


	} else {

		swal('Error', resp.msg.error, 'error');

	}
}

function deleteResponse(response) {
	if (response.status) {
		swal('Berhasil', response.msg, "success");
		reloadTable($('#table_' + dataLabel));
	} else {
		swal('Gagal', response.msg, "error");
	}
}

function overideDeletion(dataLabel, dataValue) {
	swal({
		title: 'Hapus Data?',
		text: "Apakah anda yakin ingin menghapus data ini?, Data yang telah dihapus tidak dapat dikembalikan lagi.",
		//html: '<input type="text" id="confirmText" class="swal2-input" placeholder="Type \'confirm\' to proceed">',
		html: ' <div class=" col-md-12">'
			+ '<div class="mb-3 ">'
			+ '<label for="confirmText" class="col small fw-bold col-form-label"> Menghapus data CALEG akan menghapus seluruh anggota yang terafiliasi secara permanen</label>'
			+ '<div class="col">'
			+ '<input class="form-control" type="text" placeholder="confirm" id="confirmText" >'
			+ '<span class="text-danger small">Ketik kata "confirm" untuk melanjutkan proses hapus </span>'
			+ '</div>'
			+ '</div>'
			+ '</div> ',


		type: "warning",
		showCancelButton: true,
		confirmButtonText: 'Yes',
		cancelButtonText: 'No'
	}).then((result) => {
		const confirmText = document.getElementById('confirmText').value;
		//console.log(confirmText);
		//console.log('isconfirmed :' + )
		//console.log(JSON.stringify(result))

		if (result.value && confirmText.toLowerCase() === 'confirm') {
			//swal('Confirmed!', 'Your action was successful!', 'success');
			// Perform your delete action here
			$.ajax({
				url: dturl,
				type: 'POST',
				dataType: 'json',
				data: { id: dataValue }
			})
				.done(function (response) {
					if (typeof deleteResponse === 'function') {

						deleteResponse(response);

					} else {

						if (response.status) {
							swal('Berhasil', response.msg, "success");
							reloadTable($('#table_' + dataLabel));
						} else {
							swal('Gagal', response.msg, "error");
						}
					}
				})
				.fail(function () {
					swal('Uppss...', 'Terjadi kesalahan pada proses', 'error');
				});
		} else if (result.dismiss === Swal.DismissReason.cancel) {
			swal('Dibatalkan', 'Proses hapus data telah dibatalkan', 'error');
		} else {
			swal('Incorrect Text', 'Please type \'confirm\' to proceed', 'error');
		}
	});
}

function repDapil(d) {
	if (d['tingkat_pemilihan_id'] && d['dapil_id']) {

		url = currentClass + 'selectdapil/' + d['tingkat_pemilihan_id'];
		$('#dapil_id').load(url, function () {
			$("#dapil_id").val(d['dapil_id']);
		});
	}
}