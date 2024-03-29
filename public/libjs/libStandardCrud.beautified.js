function action_btn() {
    $(".EditBtn").click(function() {
        save_method = "update";
        var t = $(this).data("label"), e = $(this).data("value");
        formID = "form_" + t, $("#" + formID)[0].reset(), $("#" + formID + " [name=id]").val(""), 
        $(".form-group").removeClass("has-error has-success"), $(".help-block").empty(), 
        $.ajax({
            url: currentClass + "/edit_" + t + "/" + e,
            type: "GET",
            dataType: "JSON",
            success: function(e) {
                if ("function" == typeof editResponse) editResponse(e); else if (e.status) {
                    for (var a in e.data) $("#" + formID + " [name=" + a + "]").val(e.data[a]);
                    $("#modal_" + t).modal("show"), $(".modal-title").text("Edit Data");
                } else swal("Error", e.msg.error, "error"), $("#btnSave").text("Simpan"), 
                $("#btnSave").attr("disabled", !1);
            },
            error: function(e, a, t) {
                alert("Error get data from ajax");
            }
        });
    }), $(".DeleteBtn").click(function() {
        var a = $(this).data("label"), t = $(this).data("value");
        dturl = site_url + class_url + "/delete_" + a, swal({
            title: "Hapus Data",
            text: "Apakah anda yakin ingin menghapus data ini?, Data yang telah dihapus tidak dapat dikembalikan lagi",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            showLoaderOnConfirm: !0,
            preConfirm: function() {
                return new Promise(function(e) {
                    $.ajax({
                        url: dturl,
                        type: "POST",
                        dataType: "json",
                        data: {
                            id: t
                        }
                    }).done(function(e) {
                        "function" == typeof deleteResponse ? deleteResponse(e) : e.status ? (swal("Berhasil", e.msg, "success"), 
                        reloadTable($("#table_" + a))) : swal("Gagal", e.msg, "error");
                    }).fail(function() {
                        swal("Uppss...", "Terjadi kesalahan pada proses", "error");
                    });
                });
            },
            allowOutsideClick: !1
        });
    });
}

$(document).ready(function() {}), $(".AddBtn").click(function() {
    var e = $(this).data("label");
    formID = "form_" + e, urlSave = currentClass + "/add_" + e, save_method = "add", 
    $("#" + formID)[0].reset(), $("#" + formID + " [name= id]").val(""), $(".form-group").removeClass("has-error has-success"), 
    $(".help-block").empty(), $("#modal_" + e).modal("show");
}), $(".SaveBtn").click(function() {
    $(".help-block").html("");
    var t = $(this).data("label"), r = "form_" + t, e = ($("#" + r + " input[name=id]").val(), 
    new FormData($("#form_" + t)[0]));
    save_method = "add", $.ajax({
        url: currentClass + save_method + "_" + t,
        type: "POST",
        data: e,
        contentType: !1,
        processData: !1,
        dataType: "JSON",
        success: function(e) {
            if ("function" == typeof saveResponse) saveResponse(e); else if (1 == e.status) $("#modal_" + t).modal("hide"), 
            Swal("Berhasil", e.msg.success, "success"); else {
                for (var a in e.msg) $("#" + r + " [name= " + a + "] ").next("span.help-block").html(e.msg[a]);
                Swal("Error", e.msg.error, "error"), $("#btnSave").text("Simpan"), 
                $("#btnSave").attr("disabled", !1);
            }
        },
        error: function(e, a, t) {
            swal("Error", "Terjadi kesalahan pada proses", "error"), $("#btnSave").text("Simpan"), 
            $("#btnSave").attr("disabled", !1);
        }
    });
}), $(".BulkDeleteBtn").click(function() {
    var a = $(this).data("label"), e = (dturl = currentClass + "/delete_" + a, []);
    $(".data-check:checked").each(function() {
        e.push(this.value);
    }), 0 < e.length ? confirm("Are you sure delete this " + e.length + " data?") && $.ajax({
        type: "POST",
        data: {
            id: e
        },
        url: dturl,
        dataType: "JSON",
        success: function(e) {
            "function" == typeof bulkDeleteResponse ? bulkDeleteResponse(e) : e.status ? reloadTable($("#table_" + a)) : alert("Failed.");
        },
        error: function(e, a, t) {
            alert("Error deleting data");
        }
    }) : alert("no data selected");
});