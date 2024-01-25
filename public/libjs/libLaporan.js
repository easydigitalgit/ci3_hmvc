
var table;
var save_method;
var urlSave  = ''; 
var tblLaporanKelurahan = $('#table_laporan_kelurahan');
var tblLaporanRelawan = $('#table_laporan_relawan');


$(document).ready(function() {
   
    loadDataTable(tblLaporanKelurahan);
    loadDataTable(tblLaporanRelawan);
    
    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });
 
});



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
                    //data.extra_search = $("#pilih_biodata option:selected").val();
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
    console.log('ADD '+dataLabel);

    
    	urlSave = currentClass+'add_'+dataLabel;
	    save_method = 'add';
	   
	    $('#'+formID)[0].reset();
	    $('#'+formID + ' [name="id"]').val('');
        $('#foto_armada').attr('src','');
	    //$(this).attr('disabled',false);
	       
	    $('.form-group').removeClass('is-invalid'); 
	    $('.help-block').empty();
	    $('.modal-title').text('Tambah data armada');
	    
	    $('#modal_'+dataLabel).modal('show') ;
   
    
     
    //$('.modal-title').text('Tambah data'); 
});


function action_btn(){
    $('.EditBtn').click(function() {
    save_method = 'update';
   

    console.log('edit cliked');
    console.log(save_method);
    var dataLabel = $(this).data('label');
    var dataValue = $(this).data('value');
  

    formID = 'form_'+dataLabel;
    
    $('#btnSave').text('Simpan'); 
    $('#btnSave').attr('disabled',false); 
    
    
    $('#'+formID)[0].reset();
    
    $('input').removeClass('is-invalid'); // clear error class
    $('.help-block').empty(); // clear error string
    //Ajax Load data from ajax
    $.ajax({
        url : currentClass +"edit_"+dataLabel+"/"+dataValue,
        type: "GET",
        dataType: "JSON",
        success: function(resp)
        {
            if (resp.status) {
                for(var prop in resp.data) {

                    if(prop == 'foto'){
                         $("#foto_armada").attr("src",base_url+'AppDoc/foto_armada/'+resp.data[prop]);
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
    dturl = currentClass+"delete_"+dataLabel;
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
    
    var formData = new FormData($('#form_'+dataLabel)[0]);
    save_method = dataID > 0 ? 'update' : 'add';
 
  
      
   if(save_method  ){
        console.log('savemethod = '+save_method);
        console.log('urlSave = '+urlSave);
        //$('#btnSave').text('saving...'); //change button text
        //$('#btnSave').attr('disabled',true); //set button disable 
        
          // ajax adding data to database
        $.ajax({
                url: currentClass+save_method+'_'+dataLabel,
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
                            if(resp.msg[prop] !== ''){
                                
                                $("#"+formID+ " [name= "+prop+"] " ).addClass('is-invalid').next('span').html(resp.msg[prop]);
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
        swal("Error", "Terdapat kesalahan pada form", "error");
    }  

  
    
});


$(".BulkDeleteBtn").click(function() 
{
    var dataLabel = $(this).data('label');
    dturl = currentClass+"bulkdelete_"+dataLabel
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


$('.ExportexcelBtn').click(function () {
    //console.log('export klik');
    let dataLabel = $(this).data('label');
    //console.log('data label = '+dataLabel);
    window.open(currentClass+dataLabel,'_blank');
});