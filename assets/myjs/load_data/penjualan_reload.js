var pathArray = window.location.pathname.split("/").pop()

if(pathArray == "arsip"){
    var url = url_base+"penjualan/load_penjualan/arsip";
} else {
    var url = url_base+"penjualan/load_penjualan";
}

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
    ajax: {"url": url, "type": "POST"},
    columns: [
        {"data": "tgl_penjualan", render : function(row, data, iDisplayIndex){
            return iDisplayIndex.tgl
        }},
        {"data": "keterangan"},
        {"data": "stok", render : function(row, data, iDisplayIndex){
            if(jQuery.browser.mobile == true) return iDisplayIndex.stok
            else return "<center>"+iDisplayIndex.stok+"</center>"
        }},
        {"data": "total", render : function(data){
            return formatRupiah(data, "Rp.");
        }, className : "text-nowrap"},
        {"data": "menu"},
    ],
    order: [[0, 'desc']],
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