var fotoUser        = $('#fotoKader');
var table           = $('.table');
var save_method;
var urlSave         = ''; 
var loadMode = 'add';

$(document).ready(function() {
    loadDataTable(table);
    $('.dateTimePicker').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        timePicker24Hour: false,
        showDropdowns: true,
        minYear: 1940,
        maxYear: parseInt(moment().format('YYYY'),10),
        applyClass: 'bg-slate-600',
        cancelClass: 'btn-light',
        drops: 'auto',
        locale: {
            format: 'DD-MM-YYYY'
        }
    });


$("#tingkat_pemilihan").on('change', function() {
   $("#dapil_id").val('').trigger('change');
   $("#dapil_id").load(currentClass+'selectdapil/'+$(this).val());
        
       
});
    

    $("#wa_center_id").load(currentClass+'select_wa_center');
    $("#id_partai").load(currentClass+'/selectpartai');
    $("#pekerjaan").load( currentClass+'/selectPekerjaan');
    $("#prop_dapil").load( currentClass+'/selectPropinsi');
    $("#prop_dapil").change(function (){
        loadMode = 'add';
            //document.getElementById('kecamatan').selectedIndex = 0;
            //document.getElementById('kelurahan').selectedIndex = 0;
           /* $("#kec_dapil option:not(:first), #desa_dapil option:not(:first)").remove();
            var url =  currentClass+'/selectKabupaten/'+$(this).val();
            $('#kab_dapil').load(url);*/

            $.post(currentClass+'selectKabDapil', {prop_dapil: $(this).val() }, function(data, textStatus, xhr) {
                   console.log(data);
                    var settings3 = {
                        "groupDataArray": data.data,
                        "groupItemName": "groupName",
                        "groupArrayName": "groupData",
                        "itemName": "nama",
                        "valueName": "kode",
                        "callable": function (items) {
                            console.dir(items)

                            $('#kec_dapil').val( JSON.stringify( items) );
                        }
                    };
                    $("#SelectKabDapil").empty();
                    $("#SelectKabDapil").transfer(settings3);
                });
    

    });

    $("#kab_dapil").change(function (){
        $("#desa_dapil option:not(:first)").remove();
        
       // console.log( $(this).val()   );
        var url =  currentClass+'/selectKecamatan/'+$(this).val();
        console.log()
        if($("#tingkat_pemilihan").val() > 1 && loadMode == 'add'){
                 $.post(currentClass+'selectKecDapil', {kab_dapil: $(this).val() }, function(data, textStatus, xhr) {
                   console.log(data);
                    var settings3 = {
                        "groupDataArray": data.data,
                        "groupItemName": "groupName",
                        "groupArrayName": "groupData",
                        "itemName": "nama",
                        "valueName": "kode",
                        "callable": function (items) {
                            console.dir(items)

                            $('#kec_dapil').val( JSON.stringify( items) );
                        }
                    };
                    $("#kecamatandapil").empty();
                    $("#kecamatandapil").transfer(settings3);
                });

        }
        else{
             $("#kecamatandapil").empty();
        }
       
        
        return false;
    });
   
    $("#kec_dapil").change(function (){
        var url =  currentClass+'/selectDesa/'+$(this).val();
        $('#desa_dapil').load(url);
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

    $("#kab_dapil").select2();
   
	//loadKonfigurasi();
});

 


function lightbox(){
    document.querySelectorAll('.my-lightbox-toggle').forEach(el => el.addEventListener('click', Lightbox.initialize));
}

$('.tasks_report').on('click', function(event) {
    event.preventDefault();
    var target = $(this).data('target');
    console.log('tasks_report cliked, target :'+target);
});

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

$("#viewBiodata").on('click',  function(event) {
    event.preventDefault();
    kaderId = $("#pilih_biodata option:selected").val();
    /* Act on the event */
    //console.log($("#pilih_biodata option:selected").val())
    kaderId > 0 ? loadBiodata(kaderId) : '';

});

function loadKonfigurasi(){
    $.get( currentClass+'get_konfig', function(d) {
        if(d.status == true){
          //console.log(d.data);
           for(var prop in d.data) {
                
                if(prop == 'small_logo' || prop == 'full_logo'){

                }
                else{
                    $("#form_konfigurasi [name="+prop+"]").val(d.data[prop]);
                }
                
                
              }

              if(d.ultah){
                $("#form_konfigurasi [name=ultah]").prop('checked', true);
              }
              else{
               $("#form_konfigurasi [name=ultah]").prop('checked', false); 
              }

              $("#namaAnggota").html('<strong>'+ d.data['nama_lengkap'] +'</strong>');
              //$("#strukturKader").html('<strong>'+ d.data['nama_struktur'] +'</strong>')
          //repChained(d.data);
          reloadDapil(d.data['id']);
        }
  },'json');
}

function reloadDapil(id){
    loadMode = 'edit';
     $.get( currentClass+'reload_dapil/'+id, function(d) {
        if(d.status == true){
          //console.log(d.data);
           // $(".KecDapil").empty();
            let khtml = '<input type="hidden" name="kec_dapil[]" id="kec_dapil">'+ 
                        '<div class="form-control" id="kecamatandapil"> </div>'+
                        '<span class="help-block"></span>';


            $("#prop_dapil").val(d['propDapil']) ;
                
           /* $('.SelectKabDapil').select2({ data: d['kabDapil'] });
            $(".SelectKabDapil option:not(:first)").prop("selected","selected").trigger('change');*/
                
                var settings4 = {
                    "groupDataArray"    : d['kecDapil'],
                    "groupItemName"     : "groupName",
                    "groupArrayName"    : "groupData",
                    "itemName"          : "nama",
                    "valueName"         : "kode",
                    "callable": function (items) {
                        console.dir(items)
                        }
                    }
           

                $("#kecamatandapil").empty();
                $("#kecamatandapil").transfer(settings4);
            };
            
         
        }
  ,'json');
}

function loadBiodata(id){
  $.get( currentClass+'/get_biodata/'+id, function(d) {
    if(d.status == true){
      //console.log(d.data);
       for(var prop in d.data) {
            if(prop == 'foto' && d.data[prop] != null){
                $("#fotoKader").attr("src",base_url+'kaderDoc/'+d.data[prop]);
            }
            else if(prop == 'scan_ktp' && d.data[prop] != null){

            }
            else{
                 $("#form_data_biodata [name="+prop+"]").val(d.data[prop]);
            }
            
          }
          $("#namaAnggota").html('<strong>'+ d.data['nama_lengkap'] +'</strong>');
          $("#strukturKader").html('<strong>'+ d.data['nama_struktur'] +'</strong>')
      repChained(d.data);
    }
  },'json');
}

function repChained(d){
    var url;
    if(d.desa){
        
    
        url =  currentClass+'/selectKabupaten/'+d.propinsi;
        $('#kota').load(url,function() {
            $("#kota").val(d.kota);
        });

        url =  currentClass+'/selectKecamatan/'+d.kota;
        $('#kec').load(url,function(){
            $('#kec').val(d.kec);
        });
        url =  currentClass+'/selectDesa/'+d.kec;
        $('#desa').load(url,function(){
            $('#desa').val(d.desa);
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
	            "url":  currentClass+'/'+ds,
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
                action_btn(); 
                lightbox();

        }

	    });
}



$('.AddBtn').click(function(){
	
	var dataLabel = $(this).data('label');
    formID = 'form_'+dataLabel;
	//console.log(dataLabel);
	urlSave =  currentClass+'/add_'+dataLabel;
	save_method = 'add';
   
    $('#'+formID)[0].reset();
    $("#"+formID+" [name= id]").val('');
    //$(this).attr('disabled',false);
       
    $('.form-group').removeClass('has-error has-success'); 
    $('.help-block').empty();
  
    
    $('#modal_'+dataLabel).modal('show') ;  
    
     
    //$('.modal-title').text('Tambah data'); 
});


function action_btn(){
    $('.EditBtn').click(function() {
    save_method = 'update';
    //console.log('edit cliked');
    var dataLabel = $(this).data('label');
    var dataValue = $(this).data('value');
    
    formID = 'form_'+dataLabel;
    
    $('#btnSave').text('Simpan'); 
    $('#btnSave').attr('disabled',false); 
    
    
    $('#'+formID)[0].reset();
    //console.log(formID);
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
               
                        if(prop == 'small_logo' || prop == 'full_logo'){

                        }
                        else{
                            $("#"+formID+" [name="+prop+"]").val(resp.data[prop]);
                        }
                        
                }

                  if(resp.ultah){
                    $("#"+formID+" [name=ultah]").prop('checked', true);
                  }
                  else{
                   $("#"+formID+ " [name=ultah]").prop('checked', false); 
                  }

                
                     
                  repChained(resp.data);
                

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
    dturl = site_url +class_url+"/delete_"+dataLabel;
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
         dataType: 'json',
         data: {id:dataValue}
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

    $(".testMsgBtn").click(function () {
        var dataLabel = $(this).data('label');
        var dataValue = $(this).data('value');
        $('#form_test_pesan [name = id_center]').val(dataValue);
        $('#modal_test_pesan').modal('show');
       
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
    let ultah = 0;
    $(".help-block").html('');
    var dataLabel = $(this).data('label');
    var formID = 'form_'+dataLabel;
    var dataID = $('#'+formID+' input[name=id]').val();
    
    var formData = new FormData($('#form_'+dataLabel)[0]);
    save_method =  'add';
  
    
    if($('#'+formID+' input[name=ultah').is(':checked')){
        ultah = 1;
    }
    formData.append("ultah",ultah);
      
   if(save_method  ){
    	console.log('savemethod = '+save_method);
    	console.log('urlSave = '+urlSave);
    	//$('#btnSave').text('saving...'); //change button text
    	//$('#btnSave').attr('disabled',true); //set button disable 
    	
    	  // ajax adding data to database
	    $.ajax({
	            url:  currentClass+save_method+'_'+dataLabel,
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
	                   
                      
                         loadKonfigurasi();
                        
	                }
	                else {
	                   console.log(resp);
	                    for(var prop in resp.msg) {
          						  //$("#"+formID+ " [name= "+prop+"] " ).next('span').html(resp.msg[prop]);
                                    $("#"+formID+ " [name= "+prop+"] " ).next('span.help-block').html(resp.msg[prop]);
                       		
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
    dturl = site_url +class_url+"/delete_"+dataLabel
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

