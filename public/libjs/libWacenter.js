var table           = $('.table');

jQuery(document).ready(function($) {
	/* let cFilter = {filter1:'val1', filter2:'val2'};
	 loadDataTable(table, cFilter);*/
	loadDataTable(table);
	
});

function tableDrawCallback(){
	$(".testMsgBtn").click(function () {
        var dataLabel = $(this).data('label');
        var dataValue = $(this).data('value');
        $('#form_test_pesan [name = id_center]').val(dataValue);
        $('#modal_test_pesan').modal('show');
       
    });
}
 