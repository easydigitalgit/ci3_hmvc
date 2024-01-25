var table  = $(".table");
var save_method;
var urlSave  = ''; 



$(document).ready(function() {

    loadDataTable(table);
    
    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });
    /* $('.parentStruktur').exists(function(){
         loadParentStruktur('add') ;   
    })*/

    
});

$(".daftarHadir").click(function () {
    console.log('hadir gan');

     var dataLabel = $(this).data('label');
    dturl = currentClass+"delete_"+dataLabel;
    var list_id = [];
    $(".data-check:checked").each(function() {
            list_id.push(this.value);
    });
    if(list_id.length > 0){
        console.log(list_id);
        $.ajax({
                url: currentClass+'/set_hadir',
                type: 'post',
                dataType: 'json',
                data: {id : list_id },
                success: function (resp) {
                    //console.log(resp);
                    if (resp.status) {
                         Swal('Berhasil', resp.row + ' peserta telah hadir', 'success');
                        reloadTable(table);
                    }
                    else{
                        Swal('Gagal', 'tidak berhasil mengubah status', 'error');
                        reloadTable(table);
                    }
                }
            });

    }
    else{
        //console.log('show modal');
       $("#modal_absensi_tes").modal('show');  

    }
});

$('#pendaftaran_id').select2({
 dropdownParent: $('#modal_absensi_tes'),
  minimumInputLength: 3,
  width: 'resolve',
  allowClear: true,
  placeholder: 'Cari No.Pendaftaran/Nama',
  ajax: {
     dataType   : 'json',
     url        :  currentClass+'/select2_noreg',
     type       :'post',
     delay      : 800,
     data       : function(params) {
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
        var id = $("#pendaftaran_id option:selected").val();
        loadDataSeleksi(id);

        //LoadDataUser(id);

});

function loadDataSeleksi(id){
    console.log('id = '+id);
    let url = currentClass+'get_data_seleksi';
    let formID = 'form_absensi_tes';
    $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            data: {pendaftaran_id:id},
            success: function (resp) {
                //console.log(resp)
                if(resp.status){
                    for(var prop in resp.data){
                       $("#"+formID+' [name='+prop+']').val(resp.data[prop]);
                    }
                }
                else{
                    swal('Error','Data tidak ditemukan','error');
                }
            }
        });
}

$('.dateTimePicker').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour: true,
        applyClass: 'bg-slate-600',
        cancelClass: 'btn-light',
        drops: 'down',
        locale: {
            format: 'DD-MM-YYYY h:mm '
        }
    });

$(".nilaiTes").click(function () {
   // console.log('Input nIlai Tes');
    $("#modal_nilai_tes").modal('show');  

});

function addNilaiTes(){

}

$('.selectNoPendaftaran').select2({
 dropdownParent: $('#modal_nilai_tes'),
  minimumInputLength: 3,
  width: 'resolve',
  allowClear: true,
  placeholder: 'Cari No.Pendaftaran/Nama',
  ajax: {
     dataType   : 'json',
     url        :  currentClass+'/select2_noreg',
     type       : 'post',
     delay      : 800,
     data       : function(params) {
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
        //var id = $("#form_nilai_tes [name = pendaftaran_id] option:selected").val();
        let id = $(this).val();
        loadDataSeleksi(id);
        loadDataNilai(id);
        //LoadDataUser(id);

});

function loadDataNilai(id){
    let url = currentClass+'/form_nilai_tes';
    $.ajax({
            url: url,
            type: 'post',
            dataType: "JSON",
            data: {pendaftaran_id:id},
            success: function (resp) {
                if (resp.status) {
                    let element = $(".formNilai");
                    let fieldNilai = '';
                    console.log(resp.data);
                    let i = 0;
                    for(var prop in resp.data){
                        console.log(resp.data[i]['nama_tes']);
                    fieldNilai =  fieldNilai+  ' <div class="mb-1 row ">'
                            + '<label for="tingkat" class="col-md-4  col-form-label">'+resp.data[i]['nama_tes']+' </label>'
                            + '<div class="col-md-6">'
                           
                            + ' <input class="form-control " name="nilai['+resp.data[i]['tes_id']+']" id="nilai_tes_id_"'+resp.data[i]['tes_id']+' value="'+resp.data[i]['nilai']+'" placeholder="Nilai Tes">'
                            +   '<span class="help-block"></span>'
                            + '</div>'
                        + '</div>';

                        i++;
                    }

                    element.append(fieldNilai);
                }
                else{
                    swal('error', 'Data tidak ditemukan', 'error');
                }
            }
        });
}

function reloadTable(el){
    return el.DataTable().ajax.reload(null,false);
}

function initTable(el){
    el.DataTable({ 
            "retrieve": true,
            "processing": true, 
            "order": [], 
            "columnDefs": []

        });
}

function loadDataTable(el){
//el=> element , ds=>datasource
    //el.destroy();
    console.log('datatable called');
    var ds = el.data("source");
    el.DataTable().destroy();
    el.DataTable({ 
        
            "retrieve": true,
            "processing": true, 
            "serverSide": true,
            "ordering": false, 

          
            "ajax": {
                "url": currentClass+ds,
                "type": "POST",
                "data": 
                function ( data ) {
                    
                }
            },

            "columnDefs": [
                { 
                    "targets": [ 0 ], 
                    "orderable": false, 
                },
                
                { 
                    "targets": [ -1 ], 
                    "orderable": false, 
                }

            ],
             "fnDrawCallback": function() {
            action_btn(); }

        });
}



$('.AddBtn').click(function(){
    
    var dataLabel = $(this).data('label');
    formID = 'form_'+dataLabel;
    console.log(dataLabel);
    urlSave = site_url+class_url+'/add_'+dataLabel;
    save_method = 'add';
   
    $('#'+formID)[0].reset();
    $("#"+formID+' [name="id"]').val()
    
    //$(this).attr('disabled',false);
       
    $('.form-group').removeClass('has-error has-success'); 
    $('.help-block').empty();
   
    
    $('#modal_'+dataLabel).modal('show') ;  
    
     
    //$('.modal-title').text('Tambah data'); 
});

$('.AddNilai').click(function () {
        var dataLabel = $(this).data('label');
        var dataValue = $(this).data('value');
       

        var list_id = [];
        $(".data-check:checked").each(function() {
                list_id.push(this.value);
        });
    
       $.ajax({
             url: currentClass + 'get_form_nilai',
             type: 'POST',
             dataType: 'JSON',
             data: {id_jadwal: list_id, id_kategori: dataValue},
         })
         .done(function(resp) {
            console.log(resp);
            if (resp.status) {
                let fieldTes = $('#fieldTes');
                let formElement = '';
                for(let item in resp.data){
                    console.log('prop = ' +resp.data[item].nama_tes);
                    formElement  = formElement + ' <div class="mb-3 row">'
                    +'<label for="tingkat" class="col-md-2 col-form-label"> '+resp.data[item].nama_tes+' </label>'
                    +'<div class="col-md-10">'
                      +  '<input class="form-control" name="idtes['+resp.data[item].id+']" id="idtes_'+resp.data[item].nama_tes+'">'
                        
                      +  '<span class="help-block"></span>'
                    + '</div> </div> ';

                }
                fieldTes.empty().append(formElement);
                $('#modal_hasil_tes').modal('show') ; 
               //console.log('prop = ' +resp.data[0].id);

            }


         })
         .fail(function() {
            
         })
         .always(function() {
             
         });
           
        //console.log(list_id);
        //console.log(dataValue);
});


function action_btn(){
    $('.EditBtn').click(function() {
    save_method = 'update';
   

    console.log('edit cliked');
    console.log(save_method);
    var dataLabel = $(this).data('label');
    var dataValue = $(this).data('value');
    
    $('.parentStruktur').exists(function(){
         loadParentStruktur('edit',dataValue)    
    })

    formID = 'form_'+dataLabel;
    
    $('#btnSave').text('Simpan'); 
    $('#btnSave').attr('disabled',false); 
    
    
    $('#'+formID)[0].reset();
   
    
    $('.form-group').removeClass('has-error has-success'); // clear error class
    $('.help-block').empty(); // clear error string
    //Ajax Load data from ajax
    $.ajax({
        url : site_url+ class_url +"/edit_"+dataLabel+"/"+dataValue,
        type: "GET",
        dataType: "JSON",
        success: function(resp)
        {
            if (resp.status) {
                for(var prop in resp.data) {
                    $("#"+formID+' [name='+prop+']').val(resp.data[prop]);        
                    }
            $('#modal_'+dataLabel).modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title  

            }
            else {
                    console.log(resp.status);
                    swal('Error','Data tidak ditemukan','error');
                    $('#btnSave').text('Simpan'); 
                    $('#btnSave').attr('disabled',false); 
            }
    
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
     });
    });


$(".DeleteBtn").click(function() {
    var dataLabel = $(this).data('label');
    var dataValue = $(this).data('value');
    dturl = currentClass+"delete_"+dataLabel;
    console.log(dturl);
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
       preConfirm: function() {
          return new Promise(function(resolve) {
      $.ajax({
         url: dturl,
         data: {id:dataValue},
         type: 'POST',
         dataType: 'json'
      })
      .done(function(response){
        if (response.status) {
              swal('Berhasil', response.msg, "success");
              reloadTable($('#table_'+dataLabel)); 
        }
        else {
          swal('Gagal', response.msg, "error");
        }
           
        })
      .fail(function(){
         swal('Uppss...', 'Terjadi kesalahan pada proses', 'error');
      });
          });
       },
       allowOutsideClick: false     
       }); 
    });
}


$('.ReloadBtn').click(function() {
    /* Act on the event */
    var dataLabel = $(this).data('label');
    //var dataValue = $(this).data('value');
    console.log('reload '+ dataLabel);
    $('#table_'+dataLabel).DataTable().ajax.reload(null,false);
    
});

$('.SaveBtn').click(function()
{
   
    $(".help-block").html('');
    var dataLabel = $(this).data('label');
    var formID = 'form_'+dataLabel;
    var dataID = $('#'+formID+' input[name=id]').val();
    console.log('dataID = '+dataID);
    console.log('formID = '+formID);
    var formData = new FormData($('#form_'+dataLabel)[0]);
    save_method = dataID > 0 ? 'update' : 'add';
 
  
      
   if(save_method  ){
        console.log('savemethod = '+save_method);
       
        //$('#btnSave').text('saving...'); //change button text
        //$('#btnSave').attr('disabled',true); //set button disable 
        
          // ajax adding data to database
        $.ajax({
                url: currentClass+save_method+"_"+dataLabel,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(resp) {
                    if (resp.status == true) {
                        
                        $('#btnSave').text('Simpan');
                        $('#modal_'+dataLabel).modal('hide');
                        Swal('Berhasil', resp.msg, 'success');
                        reloadTable($('#table_'+dataLabel));
                        $('#'+formID)[0].reset();
                       
                    }
                    else {
                       //console.log(resp);
                        for(var prop in resp.msg) {
                                  $("#"+formID+ " [name= "+prop+"] " ).next('span').html(resp.msg[prop]);
                            
                                }
                        Swal('Proses Gagal', 'Terdapat kesalahan pada form', 'error');
                        $('#btnSave').text('Simpan'); 
                        $('#btnSave').attr('disabled',false); 
                    }
                },
            error: function (jqXHR, textStatus, errorThrown)
                {
                    
                    swal("Error", "Terjadi kesalahan pada proses", "error");
                    $('#btnSave').text('Simpan'); 
                    $('#btnSave').attr('disabled',false); 
                }

            });

    }

    else {
        swal("Error", "Terdapat kesalahan pada form", "error");
    }  

  
    
});


$(".BulkDeleteBtn").click(function() 
{
    var dataLabel = $(this).data('label');
    dturl = currentClass+"delete_"+dataLabel;
    var list_id = [];
    $(".data-check:checked").each(function() {
            list_id.push(this.value);
    });
    if(list_id.length > 0)
    {
        if(confirm('Are you sure delete this '+list_id.length+' data?'))
        {
            $.ajax({
                type: "POST",
                data: {id:list_id},
                url: dturl,
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status)
                    {
                       reloadTable($('#table_'+dataLabel));
                    }
                    else
                    {
                        alert('Failed.');
                    }
                    
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                   
                    alert('Error deleting data');
                }
            });
        }
    }
    else
    {
        alert('no data selected');
    }
})



$(".ImportexcelBtn").click(function(e) {
    e.preventDefault();
    var dataLabel = $(this).data('label');
    var importUrl = site_url+class_url+'/import_excel/'+dataLabel;
    $('#form_import_'+dataLabel)[0].reset(); // reset form on modals
    $('#form_import_'+dataLabel)[0].style.display = 'block';
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); 
    $("#upload_result").empty();
    $('#berkas').attr('disabled', false);

             $('#btncancel').text('Cancel');
             $('#berkas').removeClass('d-none');
             $('#btnUpload').removeClass('d-none');
             $("#processing").addClass('d-none').empty();
     
     $('#btnUpload').text('Unggah'); //change button text
     $('#btnUpload').attr('disabled',false); //set button disable


    $("#modal_import_"+dataLabel).modal('show');

});

 $('#btnUpload').click(function(e) {
        e.preventDefault();
        var dataLabel = $(this).data('label');
        var importUrl = site_url+class_url+'/import_excel/'+dataLabel;
        $(this).text('Meng-Unggah...'); //change button text
        $(this).attr('disabled',true); //set button disable
        var formData = new FormData($('#form_import_'+dataLabel)[0]);
            $.ajax({
                url: importUrl,
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData:false,
                contentType:false,
                cache:false,
                async:true,
            })
            .done(function(resp) {
                console.log("success");
                if (resp.status == true) {
                                
                        //$('#btnUpload').text('Unggah');
                        //$('#modal_'+dataLabel).modal('hide');
                        Swal('Berhasil', resp.msg, 'success');
                        //reloadTable(table);
                        $('#berkas').addClass('d-none');
                        $('#btnUpload').addClass('d-none');
                        $('#form_import_'+dataLabel)[0].reset();
                        $('#form_import_'+dataLabel)[0].style.display = 'none';
                        //$('#berkasId').val(resp.fileName);
                        $("#upload_result").empty();   
                        $("#upload_result").html('<div class="alert alert-success"> <span> File ID :  '+resp.fileName+ ' berhasil diupload  </span> <span style="float:right;" > <button class="btn btn-sm btn-primary" data-file="'+resp.fileName+'" id="btnproses" onclick="proses()"> Proses Data </button> </span> </div>');
                    }
                    else {
                       
                        for(var prop in resp.msg) {
                        $("#"+prop+"").next('span').html(resp.msg[prop]);       
                        }

                        $(this).text('Unggah'); //change button text
                        $(this).attr('disabled',false); //set button disable 
                    }
            })
            .fail(function() {
                console.log("error");
                Swal('Gagal', 'Ada sesuatu yang salah diantara kita', 'error');
                $(this).text('Unggah'); //change button text
                $(this).attr('disabled',false); //set button disable 
            })
            .always(function() {
                console.log("complete");
                formData = null;
            });
        });

function proses(e){
    
var fileName = $("#btnproses").data('file');
var dataLabel = $('.ImportexcelBtn').data('label');
var dturl = site_url +class_url+'/proses_file_data/'+dataLabel+'/'+fileName;
//$("#btnproses").text('Processing').attr('disabled',true);
$("#processing").removeClass('d-none');
$("#btnCancel").text('Tutup');
//$.post( dturl, { v: "10"} );
var w = new EventSource(dturl);

   w.onopen = function(e) {
               console.log("The connection to your server has been opened");       
            }
    console.log('-- START --');
     
   w.addEventListener("message", function(e) {
       var r=document.getElementById("processing");
            r.innerHTML +=  e.data + '<br>';   
            r.scrollTop = r.scrollHeight;               
    }, false);

   w.addEventListener("ending", function(e) {
       var object= JSON.parse(e.data);
       if (e.data == '1'){
            w.close();
            $("#btnproses").attr('disabled', true);
            reloadTable($("#table_"+dataLabel));
        }               
    }, false);

    w.onerror = function(e) {
       console.log("The server connection has been closed due to some errors");
       var r=document.getElementById("processing");
            r.innerHTML += 'The server connection has been closed due to some errors <br>';
     w.close();
    }
    
}