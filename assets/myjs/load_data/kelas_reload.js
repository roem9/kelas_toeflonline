load_item("");

function load_item(teks = ""){
    let result = ajax(url_base+"kelas/get_all_kelas", "POST", {teks:teks});

    html = ""

    if(result.length != 0) {
        
        result.forEach(kelas => {
            if(kelas.status == "aktif") status = "Berjalan"
            else status = "Selesai"

            if(kelas.nilai != ""){
                btn_kelas = `<div class="d-flex justify-content-between">
                    <a href="`+url_base+`kelas/sertifikat/`+kelas.id+`" target="_blank" class="btn btn-success">`+kelas.nilai+` `+icon('award', 'ms-1')+`</a>
                    <a href="`+url_base+`kelas/id/`+kelas.link_kelas+`" class="btn btn-primary btnLoading">masuk `+icon('chevrons-right')+`</a>
                </div>`
            } else {
                btn_kelas = `<div class="d-flex justify-content-end">
                    <a href="`+url_base+`kelas/id/`+kelas.link_kelas+`" class="btn btn-primary btnLoading">masuk `+icon('chevrons-right')+`</a>
                </div>`
            }

            html += `
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 class="mb-3">`+kelas.nama_kelas+`</h3>
                        <p class="mb-2">`+icon("book", "me-2")+``+kelas.program+`</p>
                        <p class="mb-2">`+icon("calendar", "me-2")+``+kelas.tgl_mulai+`</p>
                        `+btn_kelas+`
                    </div>
                </div>
            `;
        });
    } else {
        html = `
        <div class="d-flex flex-column justify-content-center">
            <div class="empty">
                <div class="empty-img"><img src="`+url_base+`assets/static/illustrations/undraw_printing_invoices_5r4r.svg" height="128"  alt="">
                </div>
                <p class="empty-title">Data kosong</p>
            </div>
        </div>`;

    }

    $("#dataAjax").html(html);
}
