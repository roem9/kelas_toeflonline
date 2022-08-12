load_item(id);

function load_item(id){
    let data = {id_pertemuan: id};

    let result = ajax(url_base+"program/get_all_materi_pertemuan", "POST", data);

    html = ""
    // result = 1;
    if(result.item.length != 0) {
        result.item.forEach(data => {
            if(data.item == "petunjuk"){

                if(data.penulisan == "RTL"){
                    item = `<div dir="rtl" class="mb-3">`+data.data+`</div>`
                } else {
                    item = `<div dir="ltr" class="mb-3">`+data.data+`</div>`
                }

            }
            else if(data.item == "audio"){

                item = `<center><audio controls><source src="`+url_base+`assets/media/`+data.data+`" type='audio/mpeg'></audio></center>`

            } else if(data.item == "gambar"){
                item = `<img src="`+url_base+`assets/media/`+data.data+`?t=`+Math.random()+`" onerror="this.onerror=null; this.src='`+url_base+`assets/tabler-icons-1.39.1/icons/x.svg'" class="card-img-top" width=100%>`
            } else if(data.item == "video"){
                item = `
                    <div class="d-flex justify-content-center">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="`+data.data+`" allowfullscreen></iframe>
                        </div>
                    </div>
                `
            }

            if(data.item != 'gambar' && data.item != 'audio'){
                edit = `
                <a class="dropdown-item editMateri" href="#editMateri" data-bs-toggle="modal" data-id="`+data.id_materi+`">
                    `+icon("me-1", "edit")+`
                    Edit
                </a>
                <div class="dropdown-divider"></div>
                `
            } else {
                edit = '';
            }

            html += `
            <div class="OrderingField">
                <div class="card mb-3">
                    <div class="card-body">

                        <input type="hidden" name="id_materi" value="`+data.id_materi+`">
                        
                        `+item+`
    
                    </div>
                    <div class="RightFloat Commands d-flex justify-content-between mb-3">
                        <div>
                        </div>
                        <div>
                            <button value='up' class="btn btn-sm btn-success me-3">
                                <svg width="24" height="24">
                                    <use xlink:href="`+url_base+`assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-arrow-big-top" />
                                </svg>
                            </button>
                            <button value='down' class="btn btn-sm btn-success">
                                <svg width="24" height="24">
                                    <use xlink:href="`+url_base+`assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-arrow-big-down" />
                                </svg> 
                            </button>
                        </div>
                        <div class="me-3">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <svg width="24" height="24">
                                    <use xlink:href="`+url_base+`assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-settings" />
                                </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                `+edit+`
                                <a class="dropdown-item hapusMateri" href="javascript:void(0)" data-id="`+data.id_materi+`">
                                    `+icon("me-1", "trash")+`
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`

        })

    } else {
        html = `
        <div class="d-flex flex-column justify-content-center">
            <div class="empty">
                <div class="empty-img"><img src="`+url_base+`assets/static/illustrations/undraw_printing_invoices_5r4r.svg" height="128"  alt="">
                </div>
                <p class="empty-title">Data kosong</p>
                <p class="empty-subtitle text-muted">
                    Silahkan tambahkan data
                </p>
            </div>
        </div>`;

    }

    $("#dataAjax").html(html);
}
