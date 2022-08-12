var datatable = $('#dataTable').DataTable({ 
    initComplete: function() {
        var api = this.api();
        $('#mytable_filter input')
            .off('.DT')
            .on('input.DT', function() {
                api.search(this.value).draw();
        });
    },
    oLanguage: {
    sProcessing: "loading..."
    },
    processing: true,
    serverSide: true,
    ajax: {"url": url_base+"user/load_user", "type": "POST"},
    columns: [
        {"data": "hapus", render : function(row, data, iDisplayIndex){
            if(iDisplayIndex.hapus == 0) return "Aktif"
            else return "Nonaktif"
        }},
        {"data": "nama"},
        {"data": "username"},
        {"data": "level"},
        {"data": "menu"},
    ],
    order: [[1, 'asc']],
    rowCallback: function(row, data, iDisplayIndex) {
        var info = this.fnPagingInfo();
        var page = info.iPage;
        var length = info.iLength;
        $('td:eq(0)', row).html();
    },
    "columnDefs": [
    { "searchable": false, "targets": [""] },  // Disable search on first and last columns
    { "targets": [3, 2], "orderable": false},
    ],
    "rowReorder": {
        "selector": 'td:nth-child(0)'
    },
    "responsive": true,
});