var fotoUser = $('#fotoKader');
var table = $("#table_data_relawan_tps");
var detailTable = $('#table_detail_relawan');
var save_method;
var urlSave = '';
var currentClass = site_url + class_url;
var totalAnggota = 0;


$(document).ready(function () {
    loadDataTable(table);
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

    $('.selectAkunID').load(currentClass + '/select_akun_relawan');
    $("#pekerjaan").load(currentClass + '/selectPekerjaan');
    $("#propinsi, #filter_propinsi").load(currentClass + '/selectPropinsi');
    $("#propinsi").change(function () {
        //document.getElementById('kecamatan').selectedIndex = 0;
        //document.getElementById('kelurahan').selectedIndex = 0;
        $("#kec option:not(:first), #desa option:not(:first)").remove();
        var url = currentClass + '/selectKabupaten/' + $(this).val();
        $('#kota').load(url);
        return false;
    })

    $("#kota").change(function () {
        $("#desa option:not(:first)").remove();
        var url = currentClass + '/selectKecamatan/' + $(this).val();
        $('#kec').load(url);
        return false;
    });

    $("#kec").change(function () {
        var url = currentClass + '/selectDesa/' + $(this).val();
        $('#desa').load(url);
        return false;
    });

    $("#prop_tinggal").load(currentClass + '/selectPropinsi');
    $("#prop_tinggal").change(function () {
        //document.getElementById('kecamatan').selectedIndex = 0;
        //document.getElementById('kelurahan').selectedIndex = 0;
        $("#kec_tinggal option:not(:first), #desa_tinggal option:not(:first)").remove();
        var url = currentClass + '/selectKabupaten/' + $(this).val();
        $('#kota_tinggal').load(url);
        return false;
    })

    $("#kota_tinggal").change(function () {
        $("#desa_tinggal option:not(:first)").remove();
        var url = currentClass + '/selectKecamatan/' + $(this).val();
        $('#kec_tinggal').load(url);
        return false;
    });

    $("#kec_tinggal").change(function () {
        var url = currentClass + '/selectDesa/' + $(this).val();
        $('#desa_tinggal').load(url);
        return false;
    });

    $('#filter_caleg_id').load(currentClass + 'select_caleg')

    $("#filter_propinsi").change(function () {
        //document.getElementById('kecamatan').selectedIndex = 0;
        //document.getElementById('kelurahan').selectedIndex = 0;
        $("#filter_kecamatan option:not(:first), #filter_kelurahan option:not(:first)").remove();
        var url = currentClass + '/selectKabupaten/' + $(this).val();
        $('#filter_kabupaten').load(url);
        return false;
    })

    $("#filter_kabupaten").change(function () {
        $("#filter_kelurahan option:not(:first)").remove();
        var url = currentClass + '/selectKecamatan/' + $(this).val();
        $('#filter_kecamatan').load(url);
        return false;
    });

    $("#filter_kecamatan").change(function () {
        var url = currentClass + '/selectDesa/' + $(this).val();
        $('#filter_kelurahan').load(url);
        return false;
    });


    $('.appliedFilter').on('click', function () {
        let filter = new FormData($("#form_filter_table")[0]);

        loadDataTable(table, filterToObject(filter));
        //console.log(formdata);
    })

    $('.exportExcel').on('click', function () {
        let filter = new FormData($("#form_filter_table")[0]);
        let url = currentClass + '/export_excel';
        $.ajax({
            url: url,
            type: 'POST',
            data: filter,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function (resp) {
                if (resp.status == true) {
                    swal('Berhasil', 'klik link ini untuk mengunduh file <br>' + resp.filepath, "success");
                } else { }
            }
        });
    })


});
function filterToObject(filter) {
    let filterObject = {};
    for (let [key, value] of filter.entries()) {
        filterObject[key] = value;
    }
    return filterObject;
}

function lightbox() {
    document.querySelectorAll('.my-lightbox-toggle').forEach(el => el.addEventListener('click', Lightbox.initialize));
}

$('.tasks_report').on('click', function (event) {
    event.preventDefault();
    var target = $(this).data('target');
    console.log('tasks_report cliked, target :' + target);
});

$('#pilih_biodata').select2({
    minimumInputLength: 3,
    width: 'resolve',
    allowClear: true,
    placeholder: 'Cari No.KTP/Nama',
    ajax: {
        dataType: 'json',
        url: currentClass + '/dd_biodata',
        type: 'post',
        delay: 800,
        data: function (params) {
            return {
                search: params.term
            }
        },
        processResults: function (data, page) {
            return {
                results: data
            };
        },
    }
}).on('select2:select', function (evt) {
    //initTable(tbPendidikan);
    //initTable(tbKeluarga);
    var id = $(".select2 option:selected").val();
    //LoadDataUser(id);

});

$("#viewBiodata").on('click', function (event) {
    event.preventDefault();
    kaderId = $("#pilih_biodata option:selected").val();
    /* Act on the event */
    //console.log($("#pilih_biodata option:selected").val())
    kaderId > 0 ? loadBiodata(kaderId) : '';

});

function loadBiodata(id) {
    $.get(currentClass + '/get_biodata/' + id, function (d) {
        if (d.status == true) {
            //console.log(d.data);
            for (var prop in d.data) {
                if (prop == 'foto' && d.data[prop] != null) {
                    $("#fotoKader").attr("src", base_url + 'kaderDoc/' + d.data[prop]);
                }
                else if (prop == 'scan_ktp' && d.data[prop] != null) {

                }
                else {
                    $("#form_data_biodata [name=" + prop + "]").val(d.data[prop]);
                }

            }
            $("#namaAnggota").html('<strong>' + d.data['nama_lengkap'] + '</strong>');
            $("#strukturKader").html('<strong>' + d.data['nama_struktur'] + '</strong>')
            repChained(d.data);
        }
    }, 'json');
}

function repChained(d) {
    var url;
    if (d.desa) {


        url = currentClass + '/selectKabupaten/' + d.propinsi;
        $('#kota').load(url, function () {
            $("#kota").val(d.kota);
        });

        url = currentClass + '/selectKecamatan/' + d.kota;
        $('#kec').load(url, function () {
            $('#kec').val(d.kec);
        });
        url = currentClass + '/selectDesa/' + d.kec;
        $('#desa').load(url, function () {
            $('#desa').val(d.desa);
        });
    }

}

function reloadTable(el) {
    return el.DataTable().ajax.reload(null, false);
}

function initTable(el) {
    el.DataTable({
        "retrieve": true,
        "processing": true,
        "order": [],
        "columnDefs": []

    });
}

function loadDataTable(el, filterData = null, dataReturn = null) {
    //el=> element , ds=>datasource
    //el.destroy();
    //console.log('datatable called');
    var ds = el.data("source");
    el.DataTable().destroy();
    el.DataTable({

        "retrieve": true,
        "processing": true,
        "serverSide": true,
        "ordering": false,


        "ajax": {
            "url": currentClass + '/' + ds,
            "type": "POST",
            "data":
                function (data) {
                    //data.dfilter = 'id_anggota = 123';

                    if (filterData) {
                        //console.log('filterData = ' + filterData);
                        data.dfilter = filterData
                    }

                },
            "dataSrc": function (json) {
                //Make your callback here.
                //alert("Done!");

                //dataReturn(json.totalAnggota) ;
                //console.log(totalAnggota);
                return json.data;

            },

        },


        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },

            {
                "targets": [-1],
                "orderable": false,
            }

        ],
        "fnDrawCallback": function (d) {
            action_btn();
            lightbox();
            data_return(d);
        }

    });
}


function data_return(d) {
    console.log(d.json['adminEntry']);

    for (var prop in d.json) {
        $("#" + prop).val(d.json[prop]);
    }
}



$('.AddBtn').click(function () {

    var dataLabel = $(this).data('label');
    formID = 'form_' + dataLabel;
    //console.log(dataLabel);
    urlSave = currentClass + '/add_' + dataLabel;
    save_method = 'add';

    $('#' + formID)[0].reset();
    $("#" + formID + ' [name=id]').val('');
    //$(this).attr('disabled',false);

    $('.form-group').removeClass('has-error has-success');
    $('.help-block').empty();


    $('#modal_' + dataLabel).modal('show');


    //$('.modal-title').text('Tambah data'); 
});


function action_btn() {
    //console.log(d);
    $('.EditBtn').click(function () {
        save_method = 'update';
        console.log('edit cliked');
        var dataLabel = $(this).data('label');
        var dataValue = $(this).data('value');

        formID = 'form_' + dataLabel;

        $('#btnSave').text('Simpan');
        $('#btnSave').attr('disabled', false);


        $('#' + formID)[0].reset();
        $("#" + formID + ' [name=id]').val('');

        $('.form-group').removeClass('has-error has-success'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url: site_url + class_url + "/edit_" + dataLabel + "/" + dataValue,
            type: "GET",
            dataType: "JSON",
            success: function (resp) {
                if (resp.status) {
                    for (var prop in resp.data) {
                        if (prop == 'foto' || prop == 'scan_ktp') {

                        }
                        else if (prop == 'gender') {
                            $('#' + prop + '_' + resp.data[prop]).prop('checked', true);
                        }
                        else {
                            $("#" + formID + ' [name=' + prop + ']').val(resp.data[prop]);
                        }
                    }
                    repChained(resp.data);
                    $('#modal_' + dataLabel).modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title  

                }
                else {
                    //console.log(resp.status);
                    swal('Error', 'Data tidak ditemukan', 'error');
                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    });


    $(".DeleteBtn").click(function () {
        var dataLabel = $(this).data('label');
        var dataValue = $(this).data('value');
        dturl = site_url + class_url + "/delete_" + dataLabel;
        swal({
            title: 'Hapus Data',
            text: "Apakah anda yakin ingin menghapus data ini?, Data yang telah dihapus tidak dapat dikembalikan lagi",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url: dturl,
                        type: 'POST',
                        data: { id: dataValue },
                        dataType: 'json'
                    })
                        .done(function (response) {
                            if (response.status) {
                                swal('Berhasil', response.msg, "success");
                                reloadTable($('#table_' + dataLabel));
                            }
                            else {
                                swal('Gagal', response.msg, "error");
                            }

                        })
                        .fail(function () {
                            swal('Uppss...', 'Terjadi kesalahan pada proses', 'error');
                        });
                });
            },
            allowOutsideClick: false
        });
    });



    $(".detailBtn").click(function () {
        console.log('Detail Button Klik');
        let val = $(this).data('value');
        let label = 'detail_relawan';
        let dataFilter;
        dataFilter = { id_relawan: val };
        loadDataTable(detailTable, dataFilter);
        $("#modal_detail_relawan").modal('show');
        console.log('return totalAnggota = ' + totalAnggota);

    });

}


$('.ReloadBtn').click(function () {
    /* Act on the event */
    var dataLabel = $(this).data('label');
    //var dataValue = $(this).data('value');
    console.log('reload ' + dataLabel);
    $('#table_' + dataLabel).DataTable().ajax.reload(null, false);

});

$('.SaveBtn').click(function () {

    $(".help-block").html('');
    var dataLabel = $(this).data('label');
    var formID = 'form_' + dataLabel;
    var dataID = $('#' + formID + ' input[name=id]').val();

    var formData = new FormData($('#form_' + dataLabel)[0]);
    save_method = dataID > 0 ? 'update' : 'add';



    if (save_method) {
        console.log('savemethod = ' + save_method);
        console.log('urlSave = ' + urlSave);
        //$('#btnSave').text('saving...'); //change button text
        //$('#btnSave').attr('disabled',true); //set button disable 

        // ajax adding data to database
        $.ajax({
            url: currentClass + '/' + save_method + '_' + dataLabel,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (resp) {
                if (resp.status == true) {

                    $('#btnSave').text('Simpan');
                    $('#modal_' + dataLabel).modal('hide');
                    Swal('Berhasil', resp.msg, 'success');
                    reloadTable($('#table_' + dataLabel));
                    $('#' + formID)[0].reset();
                    if (dataLabel == 'data_biodata') {
                        //loadBiodata();
                    }
                }
                else {
                    console.log(resp);
                    for (var prop in resp.msg) {
                        //$("#"+formID+ " [name= "+prop+"] " ).next('span').html(resp.msg[prop]);
                        $("#" + formID + " [name= " + prop + "] ").parent().parent().append('<span class="help-block">' + resp.msg[prop] + '</span>');

                    }
                    Swal('Proses Gagal', 'Terdapat kesalahan pada form', 'error');
                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

                swal("Error", "Terjadi kesalahan pada proses", "error");
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
            }

        });

    }

    else {
        swal("Error", "Terdapat kesalahan pada form", "error");
    }



});


$(".BulkDeleteBtn").click(function () {
    var dataLabel = $(this).data('label');
    dturl = site_url + class_url + "/delete_" + dataLabel
    var list_id = [];
    $(".data-check:checked").each(function () {
        list_id.push(this.value);
    });
    if (list_id.length > 0) {
        if (confirm('Are you sure delete this ' + list_id.length + ' data?')) {
            $.ajax({
                type: "POST",
                data: { id: list_id },
                url: dturl,
                dataType: "JSON",
                success: function (data) {
                    if (data.status) {
                        reloadTable($('#table_' + dataLabel));
                    }
                    else {
                        alert('Failed.');
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {

                    alert('Error deleting data');
                }
            });
        }
    }
    else {
        alert('no data selected');
    }
})

$(".transferAnggota").click(function (event) {
    var dataLabel = $(this).data('label');
    $("#boxAnggota").empty();
    $("#to_koord").val('');
    $("#from_koord").val('');
    $('#anggota_id').val('');
    console.log('transferAnggota klik');
    $('#modal_transfer_' + dataLabel).modal('show');

});


$('#from_koord').select2({
    dropdownParent: $('#modal_transfer_relawan'),
    minimumInputLength: 3,

    allowClear: true,
    theme: 'bootstrap-5',
    width: 'resolve',
    allowClear: true,
    placeholder: 'Cari No.KTP/Nama',
    ajax: {
        dataType: 'json',
        url: currentClass + '/select_koord_relawan',
        type: 'post',
        delay: 800,
        data: function (params) {
            return {
                search: params.term
            }
        },
        processResults: function (data, page) {
            return {
                results: data
            };
        },
    }
}).on('select2:select', function (evt) {
    //initTable(tbPendidikan);
    //initTable(tbKeluarga);
    let idKoord = $("#from_koord option:selected").val();
    loadListBoxAnggota(idKoord);
    //LoadDataUser(id);

});

$('#to_koord').select2({
    dropdownParent: $('#modal_transfer_relawan'),
    minimumInputLength: 3,

    allowClear: true,
    theme: 'bootstrap-5',
    width: 'resolve',
    allowClear: true,
    placeholder: 'Cari No.KTP/Nama',
    ajax: {
        dataType: 'json',
        url: currentClass + '/select_koord_relawan',
        type: 'post',
        delay: 800,
        data: function (params) {
            return {
                search: params.term
            }
        },
        processResults: function (data, page) {
            return {
                results: data
            };
        },
    }
}).on('select2:select', function (evt) {
    //initTable(tbPendidikan);
    //initTable(tbKeluarga);
    var toIDkoord = $("#to_koord option:selected").val();
    //LoadDataUser(id);

});

function loadListBoxAnggota(idkoord) {

    if (idkoord) {
        console.log('idkoord = ' + idkoord);

        $("#boxAnggota").empty();
        $.post(currentClass + '/selectanggota', { filter: idkoord }, function (data, textStatus, xhr) {
            //console.log(data);
            if (data.status) {
                var settings3 = {
                    "dataArray": data.data,
                    "itemName": "nama",
                    "valueName": "id",
                    "callable": function (items) {
                        //console.dir(items)
                        console.log(items);
                        if (items.length > 0) {
                            $("#anggota_id").val(JSON.stringify(items));
                        }
                        else {
                            $("#anggota_id").val('');
                        }

                    }
                };

                $("#boxAnggota").transfer(settings3);

            }

        });
    }
}

$('#transferBtn').click(function () {
    let toIDkoord = $("#to_koord option:selected").val();
    let fromIDKoord = $("#from_koord option:selected").val();
    let anggotaID = $('#anggota_id').val();
    let dataLabel = $(this).data('label')
    if (toIDkoord && fromIDKoord) {
        console.log('id koord ok');
        if (anggotaID.length > 0) {
            console.log('idAnggota = ' + anggotaID);
            var formData = new FormData($('#form_transfer_' + dataLabel)[0]);

            $.ajax({
                url: currentClass + '/dotransfer',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function (resp) {
                    if (resp.status == true) {


                        $('#modal_transfer_' + dataLabel).modal('hide');
                        Swal('Berhasil', resp.msg, 'success');

                        $('#form_transfer' + dataLabel)[0].reset();
                        $("#boxAnggota").empty();
                        $("#to_koord ").val('');
                        $("#from_koord ").val('');
                        $('#anggota_id').val('');
                    }
                    else {
                        console.log(resp);
                        for (var prop in resp.msg) {
                            //$("#"+formID+ " [name= "+prop+"] " ).next('span').html(resp.msg[prop]);
                            $("#" + formID + " [name= " + prop + "] ").parent().parent().append('<span class="help-block">' + resp.msg[prop] + '</span>');

                        }
                        Swal('Proses Gagal', 'Terdapat kesalahan pada form', 'error');
                        $('#btnSave').text('Simpan');
                        $('#btnSave').attr('disabled', false);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                    swal("Error", "Terjadi kesalahan pada proses", "error");
                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);
                }

            });


        }
        else {
            swal("Error", "Data Sahabat Belum Dipilih", "error");
        }
    }
    else {
        swal("Error", "Data Koordinator Belum Dipilih", "error");
    }

});