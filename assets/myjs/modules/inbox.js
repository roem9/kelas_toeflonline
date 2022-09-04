$(".btnSendMessage").click(function() {
    var text = $("[name='text']").val();
    var id_kelas = $("[name='id_kelas']").val();
    var id_member = $("[name='id_member']").val();
    var tabel = $("[name='tabel']").val();

    if(text != ""){
        let result = ajax(url_base+"kelas/input_inbox", "POST", {
            text:text, id_kelas:id_kelas, id_member:id_member, tabel:tabel
        });
    
        if(result == 1){
            $("[name='text']").val("");
            document.getElementById("text").style.height = '55.9886px';
            
            loadData();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'terjadi kesalahan, silahkan mulai ulang halaman'
            })
        }
    }
})

setInterval(function(){ 
    var id_kelas = $("[name='id_kelas']").val();
    var id_member = $("[name='id_member']").val();
    
    let result = ajax(url_base+"kelas/check_msg", "POST", {id_kelas:id_kelas, id_member:id_member});

    if(result == 1){
        loadData();
    }
}, 1000);