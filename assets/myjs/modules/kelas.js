$("[name='search']").on("keyup change", function(){
    load_item($(this).val());
})

// $(document).on("click", ".btnLoading", function(){
//     swal.fire({
//         html: '<h4>Loading...</h4>',
//         showConfirmButton: false,
//         onRender: function() {
//             Swal.showLoading()
//             $(".swal2-modal").css({'background-color':'white', "box-shadow" : "rgba(0, 0, 0, 0.35) 0px 5px 15px"});//Optional changes the color of the sweetalert 
//         }
//     });
// })

$(".btnInputPresensi").on("click", function(){
    let id = $(this).data("id");
    let id_kelas = $(this).data("id_kelas");
    let id_pertemuan = $(this).data("id_pertemuan");

    let result = ajax(url_base+"kelas/input_presensi", "POST", {id_kelas:id_kelas, id_pertemuan:id_pertemuan});

    if(result) {
        Swal.fire({
            position: 'center',
            icon: 'success',
            text: 'Berhasil menginputkan kehadiran',
            showConfirmButton: false,
            timer: 1500
        })
        $("."+id).html(icon("circle-check", "text-success"));
    } else {
        Swal.fire({
            position: 'center',
            icon: 'error',
            text: 'Gagal menginputkan kehadiran, Silakan muat ulang halaman',
            showConfirmButton: false,
            timer: 1500
        })
    }

})