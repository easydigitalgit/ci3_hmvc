
var tableDataWilayah  = $('#table_data_wilayah');
var tableDataTag = $('#table_data_tag');


$(document).ready(function() {
    loadDataTable(tableDataWilayah);
    loadDataTable(tableDataTag);
   
});

function saveResponse(resp, dataLabel){
    if(dataLabel == 'soal_survey'){
        
         if (resp.status == true) {

            reloadTable(tableSoalSurvey);
            $('#modal_' + dataLabel).modal('hide');
            Swal('Berhasil', resp.msg.success, 'success');
        } else {

            for (var prop in resp.msg) {

                $("#" + formID + " [name= " + prop + "] ").next('span.help-block').html(resp.msg[prop]);

            }
            Swal('Error', resp.msg.error, 'error');
            
            $('#btnSave').attr('disabled', false);
        }



    } 
}