$(document).ready(function(){

    $('.refreshCaptcha').on('click', function(){
        $.get(currentClass+'/refresh_captcha', function(data){
            $('#captImg').html(data);
        });
    });
    

});
$('.selectTingkat').change(function () {
        let unitID = $(this).val();
        $(".selectJenjangKelas").load(currentClass+'/select_jenjang_kelas/'+unitID);
        console.log(unitID);
});

$(".selectTahunAjaran").load(currentClass+'/select_tahun_ajaran');
$("#propinsi_id").load(currentClass+'/select_propinsi');
$("#negara_id").load(currentClass+'/select_country');
$("#sumber_informasi").load(currentClass+'/select_sumber_informasi');
$("#propinsi_id").change(function () {
   let propID = $(this).val();
   $("#kota_id").load(currentClass+'/select_kota/'+propID);
});

$("#sumber_informasi").change(function () {
   
    let val = $(this).val();
    let sumberLain = $('.sumberInformasiLain');

    if (val == 7) {
        sumberLain.removeClass('d-none');
    }
    else{
        sumberLain.addClass('d-none');
    } 
});

$(".riwayatSekolah").change(function () {
    let val             = $(this).val();
    let asalSekolah     = $(".asalSekolah");
    let propinsiKota    = $(".propinsiKota");
    let luarNegeri      = $(".luarNegeri");
    let unitAsal        = $(".unitAsal");
    if (val == 2){
        unitAsal.removeClass('d-none');
        asalSekolah.addClass('d-none');
        propinsiKota.addClass('d-none');
        luarNegeri.addClass('d-none');
    }
    else if (val == 3 ) {
        asalSekolah.removeClass('d-none');
        propinsiKota.removeClass('d-none');
        luarNegeri.addClass('d-none');
        unitAsal.addClass('d-none');

    }
    else if(val == 4) {
         asalSekolah.removeClass('d-none');
         luarNegeri.removeClass('d-none');
         propinsiKota.addClass('d-none');
         unitAsal.addClass('d-none');
    }
    else{
        asalSekolah.addClass('d-none');
        propinsiKota.addClass('d-none');
        luarNegeri.addClass('d-none');
        unitAsal.addClass('d-none');
    }
});





$('.SaveBtn').click(function()
{
   $('#btnSave').attr('disabled',true); 
    $(".help-block").html('');
    $(".form-control").removeClass('is-invalid');
    var dataLabel = $(this).data('label');
    var formID = 'form_'+dataLabel;
    var dataID = $('#'+formID+' input[name=id]').val();
    
    var formData = new FormData($('#form_'+dataLabel)[0]);
    save_method = 'add';
 
    
      
   if(save_method  ){
      
        $.ajax({
                url: currentClass+'/'+save_method+'_'+dataLabel,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(resp) {
                    if (resp.status == true) {
                    
                        $('#btnSave').text('Simpan');
                        $('#modal_'+dataLabel).modal('hide');
                       
                        //Swal('Berhasil', resp.msg, 'success');
                      
                        
                            $('#'+formID)[0].reset();
                            
                            $('.form-control').removeClass('is-invalid'); // clear error class
                            $('.help-block').empty();
                            window.location.replace(currentClass+'/thankyou');

                       
                    }
                    else {
                       //console.log(resp);
                        for(var prop in resp.msg) {
                            if(prop == "captcha"){
                                
                                $("#captcha").addClass('is-invalid').next('span').html(resp.msg[prop]);
                                console.log("capctha :"+resp.msg[prop])
                            }
                            else if(resp.msg[prop] !== ''){
                                
                                $("#"+formID+ " [name= "+prop+"] " ).addClass('is-invalid').next('span').html(resp.msg[prop]);
                            }

                           
                            
                        }
                        Swal('Proses Gagal', 'Terdapat kesalahan pada form', 'error');
                        //$('#btnSave').text('Simpan'); 
                        $('#btnSave').attr('disabled',false); 
                    }
                },
            error: function (jqXHR, textStatus, errorThrown)
                {
                    
                    swal("Error", "Terjadi kesalahan pada proses", "error");
                    //$('#btnSave').text('Simpan'); 
                    $('#btnSave').attr('disabled',false); 
                }

            });

    }

    else {
        swal("Error", "Terdapat kesalahan pada form", "error");
    }  

  
    
});


