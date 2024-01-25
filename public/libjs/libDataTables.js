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

function loadDataTable(el,cFilter = null){
    //el=> element , ds=>datasource
    //el.destroy();
    //console.log('datatable called');
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
                    if(cFilter !== null){
                        data.filter = cFilter;
                    }
                    
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
                if (typeof action_btn === 'function') {
                       action_btn();
                    }
                if(typeof tableDrawCallback === 'function'){
                    tableDrawCallback();
                }
             }

        });
}

$('.ReloadBtn').click(function() {
    /* Act on the event */
    var dataLabel = $(this).data('label');
    $('#table_'+dataLabel).DataTable().ajax.reload(null,false);
    
});