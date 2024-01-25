var table;
var save_method;
var urlSave     = ''; 
var tbReportAnggota = $('#table_data_report_anggota');


$(document).ready(function() {
loadDataTable(tbReportAnggota);
//loadTopikTes();	
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
	        "order": [], 

	      
	        "ajax": {
	            "url": site_url+class_url+'/'+ds,
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

$(".PdfBtn").click(function(event) {
  var dataValue = $(this).data('value');
  var dataLabel = $(this).data('label');
  window.open(base_url+class_url+'/'+dataLabel+'/'+dataValue,'_blank');
});

$(".ExcelBtn").click(function(event) {
  var dataValue = $(this).data('value');
  var dataLabel = $(this).data('label');
  window.open(base_url+class_url+'/export_'+dataLabel+'/'+dataValue,'_blank');
  console.log(dataValue);
  console.log(dataLabel);
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
}

$("#btnExport1").on('click', function(event) {
  event.preventDefault();
  //exporthasiltes($dbtes,$tes,$idtes){
  var tes = 'truefalse';  
  var idTes = $("#nama_tes").val();
  dbtes = $("#dbTes").val();
   window.open(base_url+class_url+'/exporthasiltes/'+dbtes+'/truefalse/'+idTes);
  /* Act on the event */
  
});
$("#btnExport2").on('click', function(event) {
  event.preventDefault();
  var idTes = $("#nama_tes").val();
  dbtes = $("#dbTes").val();
  /* Act on the event */
  window.open(base_url+class_url+'/exporthasiltes/'+dbtes+'/epps/'+idTes);
  
});

$("#btnExport3").on('click', function(event) {
  event.preventDefault();
  var idTes = $("#nama_tes").val();
  dbtes = $("#dbTes").val();
  /* Act on the event */
  window.open(base_url+class_url+'/exporthasiltes/'+dbtes+'/papi/'+idTes);
  
});

$("#dbTes").on('change',  function(event) {
  event.preventDefault();
  var dbtes = $(this).val();
  if (dbtes) {
    loadTopikTes(dbtes);
  }
});

function loadTopikTes(dbtes){
  $("#nama_tes").load(site_url+class_url+'/namaTes/'+dbtes);
}