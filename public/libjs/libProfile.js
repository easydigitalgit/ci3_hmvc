var currentClass = site_url + class_url; 
jQuery(document).ready(function($) {

	$('.SaveBtn').click(function(){
    
    $(".help-block").html('');
    var dataLabel = $(this).data('label');
    var formID = 'form_'+dataLabel;
    var dataID = $('#'+formID+' input[name=id]').val();
    
    var formData = new FormData($('#form_'+dataLabel)[0]);
    save_method = 'update';
  
 
      
   if(save_method  ){
    
    	//$('#btnSave').text('saving...'); //change button text
    	//$('#btnSave').attr('disabled',true); //set button disable 
    	
    	  // ajax adding data to database
	    $.ajax({
	            url:  currentClass+'/'+save_method+'_'+dataLabel,
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
	                    reloadTable($('#tabel_'+dataLabel));
                        $('#'+formID)[0].reset();
                        if(dataLabel == 'data_biodata'){
                          //loadBiodata();
                        }
	                }
	                else {
	                   console.log(resp);
	                    for(var prop in resp.msg) {
          						  //$("#"+formID+ " [name= "+prop+"] " ).next('span').html(resp.msg[prop]);
                        $("#"+formID+ " [name= "+prop+"] " ).parent().parent().append('<span class="help-block">'+resp.msg[prop]+'</span>');
                       		
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





});