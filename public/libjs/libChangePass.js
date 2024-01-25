var save_method;
$(document).ready(function() {
	
	
});




$('.SaveBtn').click(function()
{
    $(".help-block").html('');
    var dataLabel = $(this).data('label');
    var formID = 'form_'+dataLabel;
    
    
    var formData = new FormData($('#form_'+dataLabel)[0]);
        	
    	  // ajax adding data to database
	    $.ajax({
	            url: site_url+'auth/Ganti_password/update_password',
	            type: 'POST',
	            data: formData,
	          	contentType: false,
  	       		processData: false,
  	        	dataType: "JSON",
	            success: function(resp) {
	                if (resp.status == true) {
	                    
	                    $('#btnSave').text('Simpan');
	                    
	                    Swal('Berhasil', resp.msg, 'success');
	                    
                      $('#'+formID)[0].reset();
                        
	                }
	                else {
	                   console.log(resp);
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

    
  
    
});