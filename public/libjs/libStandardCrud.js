$(document).ready(function () { });

function action_btn() {
    $('.EditBtn').click(function () {
        save_method = 'update';

        var dataLabel = $(this).data('label');
        var dataValue = $(this).data('value');

        formID = 'form_' + dataLabel;

        /* $('#btnSave').text('Simpan'); 
         $('#btnSave').attr('disabled',false);*/

        $('#' + formID)[0].reset();
        $('#' + formID + ' [name=id]').val('');

        $('.form-group').removeClass('has-error has-success');
        $('.help-block').empty();

        //Ajax Load data from ajax
        $.ajax({
            url: currentClass + "edit_" + dataLabel + "/" + dataValue,
            type: "GET",
            dataType: "JSON",
            success: function (resp) {

                if (typeof editResponse === 'function') {

                    editResponse(resp, dataLabel, dataValue);

                } else {
                    if (resp.status) {
                        for (var prop in resp.data) {
                            $("#" + formID + " [name=" + prop + "]").val(resp.data[prop]);
                        }


                        $('#modal_' + dataLabel).modal('show');
                        $('.modal-title').text('Edit Data');

                    } else {

                        swal('Error', resp.msg.error, 'error');
                        $('#btnSave').text('Simpan');
                        $('#btnSave').attr('disabled', false);
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        }); /*end of AJAX*/
    });


    $(".DeleteBtn").click(function () {
        var dataLabel = $(this).data('label');
        var dataValue = $(this).data('value');
        dturl = currentClass + "delete_" + dataLabel;

        if (typeof overideDeletion === 'function') {

            overideDeletion(dataLabel, dataValue);

        } else {

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
                    });
                },
                allowOutsideClick: false
            });
        }
    });



} /* end of action_btn()*/


$('.AddBtn').click(function () {

    var dataLabel = $(this).data('label');
    formID = 'form_' + dataLabel;
    urlSave = currentClass + 'add_' + dataLabel;
    save_method = 'add';

    $('#' + formID)[0].reset();
    $("#" + formID + " [name= id]").val('');
    $('.form-group').removeClass('has-error has-success');
    $('.help-block').empty();
    if (typeof addProcess === 'function') {

        addProcess(dataLabel);
    } else {

        $('#modal_' + dataLabel).modal('show');
    }

});


$('.SaveBtn').click(function () {

    $(".help-block").html('');
    var dataLabel = $(this).data('label');
    var formID = 'form_' + dataLabel;
    var dataID = $('#' + formID + ' input[name=id]').val();
    var formData = new FormData($('#form_' + dataLabel)[0]);
    save_method = 'add';

    // ajax adding data to database
    $.ajax({
        url: currentClass + save_method + '_' + dataLabel,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (resp) {
            if (typeof saveResponse === 'function') {

                saveResponse(resp, dataLabel);

            } else {

                if (resp.status == true) {

                    //$('#btnSave').text('Simpan');
                    $('#modal_' + dataLabel).modal('hide');
                    Swal('Berhasil', resp.msg.success, 'success');
                } else {

                    for (var prop in resp.msg) {

                        $("#" + formID + " [name= " + prop + "] ").next('span.help-block').html(resp.msg[prop]);

                    }
                    Swal('Error', resp.msg.error, 'error');
                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);
                }

            }
        },
        error: function (jqXHR, textStatus, errorThrown) {

            swal("Error", "Terjadi kesalahan pada proses", "error");
            $('#btnSave').text('Simpan');
            $('#btnSave').attr('disabled', false);
        }

    });

});


$(".BulkDeleteBtn").click(function () {
    var dataLabel = $(this).data('label');
    dturl = currentClass + "delete_" + dataLabel
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
                success: function (resp) {

                    if (typeof bulkDeleteResponse === 'function') {

                        bulkDeleteResponse(resp, dataLabel);

                    } else {

                        if (resp.status) {

                            reloadTable($('#table_' + dataLabel));

                        } else {
                            alert('Failed.');
                        }

                    }


                },
                error: function (jqXHR, textStatus, errorThrown) {

                    alert('Error deleting data');
                }
            });
        }
    } else {
        alert('no data selected');
    }
})