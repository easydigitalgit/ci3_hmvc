var table;
var save_method;
var urlSave         = ''; 


$(document).ready(function() {
 loadKonfig();
});



function loadKonfig(){
   
    $.ajax({
        url: currentClass+'/get_konfig_apps',
        type: 'GET',
        dataType: 'json',
        
    })
    .done(function(resp) {
        //console.log("success");
        if(resp.status){

            $('#judul_tab').val(resp.data['judul_tab']);
            $('#imglogin_logo').attr('src', base_url+ 'vendor/assets/images/' + resp.data['login_logo']);
            $('#loginLogoImg').val(resp.data['login_logo']);

        } else {

        }
       
    })   
}

$('.previewLogin').on('click', function(){
    let img = $('#loginLogoImg').val();
    $('#imgPreviewLoginLogo').attr('src', base_url+ 'vendor/assets/images/' + img);
    $('#modal_preview_login').modal('show');
});

function sebaranLevel(){
     tbl = '<table class="table table-hover table-responsive" id="table_sebaran_level" width="100%">'  
         +  ' <th width="10%">#</th>'
         +  ' <th width="70%">Jenis Keanggotaan</th>'
         +  ' <th width="20%">Jumlah</th>'
         + '<tbody>';

                
    $.get( currentClass+'/table_sebaran_level_keanggotaan', function(d) {
    if(d.status){
        var no = 0;
        for (var prop in d.data) {
            no++;
           tbl += '<tr>'
                + '<td>'+ no +'</td>' 
                + '<td>'+prop+'</td>'
                + '<td>'+d.data[prop]+'</td>'  
                +    '</tr>'
        }
        tbl += '</tbody> </table>';
    }
    else{
            tbl += '</tbody> </table>';
    }

    $("#tableSebaran").html(tbl);
    
    })
}

$('#pilih_biodata').select2({
  minimumInputLength: 3,
  width: 'resolve',
  allowClear: true,
  placeholder: 'Cari No.KTP/Nama',
  ajax: {
     dataType   : 'json',
     url        :  currentClass+'/dd_biodata',
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
        var id = $(".select2 option:selected").val();
        //LoadDataUser(id);

});



    $("#pekerjaan").load( currentClass+'/selectPekerjaan');
    $("#prop_ktp").load( currentClass+'/selectPropinsi');
    $("#prop_ktp").change(function (){
                    //document.getElementById('kecamatan').selectedIndex = 0;
                    //document.getElementById('kelurahan').selectedIndex = 0;
                    $("#kec_ktp option:not(:first), #desa_ktp option:not(:first)").remove();
                    var url =  currentClass+'/selectKabupaten/'+$(this).val();
                    $('#kota_ktp').load(url);
                    return false;
                })
       
    $("#kota_ktp").change(function (){
        $("#desa_ktp option:not(:first)").remove();
        var url =  currentClass+'/selectKecamatan/'+$(this).val();
        $('#kec_ktp').load(url);
        return false;
    });
   
    $("#kec_ktp").change(function (){
        var url =  currentClass+'/selectDesa/'+$(this).val();
        $('#desa_ktp').load(url);
        return false;
    });

    $("#prop_tinggal").load( currentClass+'/selectPropinsi');
    $("#prop_tinggal").change(function (){
                    //document.getElementById('kecamatan').selectedIndex = 0;
                    //document.getElementById('kelurahan').selectedIndex = 0;
                    $("#kec_tinggal option:not(:first), #desa_tinggal option:not(:first)").remove();
                    var url =  currentClass+'/selectKabupaten/'+$(this).val();
                    $('#kota_tinggal').load(url);
                    return false;
                })
       
    $("#kota_tinggal").change(function (){
        $("#desa_tinggal option:not(:first)").remove();
        var url =  currentClass+'/selectKecamatan/'+$(this).val();
        $('#kec_tinggal').load(url);
        return false;
    });
   
    $("#kec_tinggal").change(function (){
        var url =  currentClass+'/selectDesa/'+$(this).val();
        $('#desa_tinggal').load(url);
        return false;
    });


function repChained(d){
    var url;
    if(d.desa_ktp){
        
    
        url =  currentClass+'/selectKabupaten/'+d.prop_ktp;
        $('#kota_ktp').load(url,function() {
            $("#kota_ktp").val(d.kota_ktp);
        });

        url =  currentClass+'/selectKecamatan/'+d.kota_ktp;
        $('#kec_ktp').load(url,function(){
            $('#kec_ktp').val(d.kec_ktp);
        });
        url =  currentClass+'/selectDesa/'+d.kec_ktp;
        $('#desa_ktp').load(url,function(){
            $('#desa_ktp').val(d.desa_ktp);
        });
    }
    if(d.desa_tinggal){
        
    
        url =  currentClass+'/selectKabupaten/'+d.prop_tinggal;
        $('#kota_tinggal').load(url,function() {
            $("#kota_tinggal").val(d.kota_tinggal);
        });
        
        url =  currentClass+'/selectKecamatan/'+d.kota_tinggal;
        $('#kec_tinggal').load(url,function(){
            $('#kec_tinggal').val(d.kec_tinggal);
        });
        url =  currentClass+'/selectDesa/'+d.kec_tinggal;
        $('#desa_tinggal').load(url,function(){
            $('#desa_tinggal').val(d.desa_tinggal);
        });
    }
      
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

function loadDataTable(el,filterData){
//el=> element , ds=>datasource
	//el.destroy();
	console.log('datatable called');
    var ds = el.data("source");
	el.DataTable().destroy();
	el.DataTable({ 
		
	        "retrieve": true,
	        "processing": true, 
	        "serverSide": true,
	        "order": [], 

	      
	        "ajax": {
	            "url": site_url+class_url+'/'+ds,
	            "type": "POST",
	            "data": 
	            function ( data ) {
                	data.extra_search = '123';
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
    
    //$(this).attr('disabled',false);
    if(dataLabel == 'data_peserta'){
      $("#cbt_group").load(site_url+class_url+'/getcbtgroup');
    }   
    $('.form-group').removeClass('has-error has-success'); 
    $('.help-block').empty();
    if(dataLabel == 'data_ppds' && $("#pernah_ppds").val() !== '1' ){
      swal('Error','Pilihan "Pernah PPDS" belum dipilih atau pilihan = "tidak pernah" ','error');
    }
    else{
    $('#modal_'+dataLabel).modal('show') ;  
    }
     
    //$('.modal-title').text('Tambah data'); 
});


function action_btn(){
    $('.EditBtn').click(function() {
    save_method = 'update';
    console.log('edit cliked');
    var dataLabel = $(this).data('label');
    var dataValue = $(this).data('value');
    
    formID = 'form_'+dataLabel;
    
    $('#btnSave').text('Simpan'); 
    $('#btnSave').attr('disabled',false); 
    
    
    $('#'+formID)[0].reset();
    
    $('.form-group').removeClass('has-error has-success'); // clear error class
    $('.help-block').empty(); // clear error string
    //Ajax Load data from ajax
    $.ajax({
        url : site_url+ class_url +"/edit_"+ dataLabel+"/"+dataValue,
        type: "GET",
        dataType: "JSON",
        success: function(resp)
        {
            if (resp.status) {
                for(var prop in resp.data) {
                    if (prop == 'akun_id') {
                        $("#akun_id").select2("trigger", "select", { data: { id:resp.data[prop], text:resp.data['nama_lengkap'] } });
                         $("#akun_id").trigger('select');
                        //$("#"+formID+' [name='+prop+']').val(resp.data[prop]).trigger('change');
                    }
                    else{
                        $("#"+formID+' [name='+prop+']').val(resp.data[prop]);  
                    }
                          
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
    dturl = site_url +class_url+"/delete_"+dataLabel+'/'+dataValue;
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

    $('.SendMsg').click(function (e) {
        e.preventDefault();
            var dataLabel = $(this).data('label');
            var dataValue = $(this).data('value');
            
            formID = 'form_'+dataLabel;
            $('#'+formID+' [name = template_id]').load(currentClass+'/select_wa_template');
            $.ajax({
                    url: currentClass+'msg_data/'+dataValue,
                    type: 'get',
                    dataType: "JSON",
                    success: function (d) {
                        if(d.status){
                            $('#'+formID+' [name = id]').val(d.id);
                            $('#'+formID+' [name = nama]').val(d.nama);
                            $('#'+formID+' [name = no_hp]').val(d.hp);
                        }
                        else{
                            Swal('data Error', d.msg, 'error');
                        }
                    }
                });

      
         $('#modal_send_msg').modal('show');

    });
}
$('.msgPreview').click(function (e) {
    e.preventDefault();
    formID = 'form_send_msg';
    templateID = $('#'+formID+' [name = template_id]').val();
    dataID = $('#'+formID+' [name = id]').val();
    msgPreview(templateID,dataID,formID)
});
$('.msgSend').click(function (e) {
    e.preventDefault();
    formID = 'form_send_msg';
    templateID = $('#'+formID+' [name = template_id]').val();
    dataID = $('#'+formID+' [name = id]').val();
    $.ajax({
            url: currentClass+'msg_send',
            type: 'post',
            data: {id:dataID, template_id:templateID},
            success: function (d) {
                if(d.status){
                    Swal('Berhasil', d.msg, 'success');
                    reloadTable(tblDataLayanan); 
                }
                else{
                    Swal('Proses Gagal', d.msg, 'error');
                }
            }
        });
});

$(".bulkSend").click(function (e) {
    e.preventDefault();
    $('#preview').text('');
    $("#template_id").load(currentClass+'/select_wa_template');
    var list_id = [];
    $(".data-check:checked").each(function() {
            list_id.push(this.value);
    });
    console.log(list_id);

    $('#totalSelected').text(list_id.length + ' data dipilih');
    $('#modal_send_bulk').modal('show');
});

$(".btnPreview").click(function (e) {
    e.preventDefault();
     var list_id = [];
    $(".data-check:checked").each(function() {
            list_id.push(this.value);
    });
    var templateID = $('#template_id').val();
    $.ajax({
            url: currentClass+'preview_template',
            type: 'post',
            data: {id:list_id, template_id:templateID},
            success: function (d) {
                if(d.status){
                    $('#preview').text(d.msg);
                }
                else{
                    Swal('Proses Gagal', d.msg, 'error');
                }
            }
        });
});

$('.SendBtn').click(function (e) {
    e.preventDefault();
      var list_id = [];
    $(".data-check:checked").each(function() {
            list_id.push(this.value);
    });
    var templateID = $('#template_id').val();
    $.ajax({
            url: currentClass+'que_msg',
            type: 'post',
            data: {id:list_id, template_id:templateID},
            success: function (d) {
                if(d.status){
                    Swal('Berhasil', d.msg, 'success');
                    reloadTable(tblDataLayanan); 
                }
                else{
                    Swal('Proses Gagal', d.msg, 'error');
                }
            }
        });

});

function msgPreview(templateID,dataID,FormID){
     $.ajax({
            url: currentClass+'preview_template',
            type: 'post',
            data: {id:dataID, template_id:templateID},
            success: function (d) {
                if(d.status){
                    $('#'+formID+' [name = preview]').text(d.msg);
                }
                else{
                    Swal('Proses Gagal', d.msg, 'error');
                }
            }
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


    var formData = new FormData($('#form_'+dataLabel)[0]);
    save_method = dataID > 0 ? 'update' : 'add';
  
  
      
   if(save_method ){
    	console.log('savemethod = '+save_method);
    	console.log('urlSave = '+urlSave);
    
	    $.ajax({
	            url: site_url+class_url+'/'+save_method+'_'+dataLabel,
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
                        if(dataLabel == 'data_biodata'){
                          loadBiodata();
                        }
	                }
	                else {
	                   console.log(resp);
	                    for(var prop in resp.msg) {
          						  $("#"+formID+ " [name= "+prop+"] " ).next('span').html(resp.msg[prop]);
                        
                        if(dataLabel == 'data_biodata'){
                          if(prop == 'valid_agreement'){
                            $("#"+prop+"").parent().siblings('span').html(resp.msg[prop]);
                          } 
                        } 		
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
    	swal("Error", "URL target belum diset", "error");
    }  

  
    
});


$(".BulkDeleteBtn").click(function(){
    var dataLabel = $(this).data('label');
    dturl = site_url +class_url+"/bulkdelete_"+dataLabel
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

$('.imgUpload').on('change',  function() {
    let file = this.files[0];
    let id   = $(this).attr('id');
    let label = $(this).data('label');
    let img  = $(this).prop('files')[0];
   // let idMobil = $('#nopol').val();
   // $('.foto_'+id).remove();

    var form_data = new FormData();                  
        form_data.append('fileFoto', img);
        form_data.append('idFile', id);
        //form_data.append('idMobil', idMobil);
        $.ajax({
                url: currentClass+'upload_foto',
                type: 'post',
                data: form_data,
                contentType: false,
                cache: false,
                processData:false,
                success: function (resp) {
                    //console.log(resp);
                    if (resp.status) {
                        // set nama file di value file input;
                        // display img preview
                        $('#'+label).val(resp.data.fileName);
                        $('.'+id).attr('src',resp.data.fileUrl);

                    }
                    else{
                        swal('Error', resp.msg.error, 'error');
                    }
                }
            });

});

$(".sendMailBtn").click(function(event) {
  $("#modal_send_mail").modal('show');

});

$(".sendMail").click(function(event) {
  kirimMail();
});

$(".syncBtn").click(function(event) {
 console.log('syncBtn click');
 var dataLabel = $(this).data('label');
    dturl = site_url +class_url+"/sync_"+dataLabel
    $.get(dturl, function(data) {
      if(data.status){
        swal('Berhasil',data.msg,'success');
      }
      else{
        swal('Gagal',data.msg,'error');
      }
    });


});


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
            reloadTable(table);
        }               
    }, false);

    w.onerror = function(e) {
       console.log("The server connection has been closed due to some errors");
       var r=document.getElementById("processing");
            r.innerHTML += 'The server connection has been closed due to some errors <br>';
     w.close();
    }
    
}

function kirimMail(){
  var dturl = site_url +class_url+'/mailq';
  //$("#btnproses").text('Processing').attr('disabled',true);
  $("#mailprocessing").removeClass('d-none');
  $("#btnCancel").text('Tutup');
  //$.post( dturl, { v: "10"} );
  var w = new EventSource(dturl);

     w.onopen = function(e) {
                 console.log("The connection to your server has been opened");       
              }
      console.log('-- START --');
       
     w.addEventListener("message", function(e) {
         var r=document.getElementById("mailprocessing");
              r.innerHTML +=  e.data + '<br>';   
              r.scrollTop = r.scrollHeight;               
      }, false);

     w.addEventListener("ending", function(e) {
         var object= JSON.parse(e.data);
         if (e.data == '1'){
              w.close();
              $("#btnproses").attr('disabled', true);
              
          }               
      }, false);

      w.onerror = function(e) {
         console.log("The server connection has been closed due to some errors");
         var r=document.getElementById("processing");
              r.innerHTML += 'The server connection has been closed due to some errors <br>';
       w.close();
      }
}





function chart() {

    // Bar chart
new Chart(document.getElementById("chart"), {
    type: 'bar',
    data: {
      labels: ["17-25", "26-35", "36-45", "46-55", "56-65",">65"],
      datasets: [
        {
          label: "Wanita",
          //backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#c45870"],
          data: [50,35,60,25,35,30],
            borderColor:  'rgb(54, 162, 235)',
          backgroundColor: 'rgba(54, 162, 235,0.1)',
          borderWidth: 2,
          borderRadius: 5
        },
        {
          label: "Pria",
          //backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#c45870"],
          data: [70,50,45,38,54,46],
           borderColor:'rgb(255, 99, 132)',
          backgroundColor: 'rgba(255, 99, 132,0.1)',
          
          borderWidth: 2,
          borderRadius: 10,
          borderSkipped:'start',
          
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Sebaran Usia Anggota'
      }
    }
});

    // body...
}