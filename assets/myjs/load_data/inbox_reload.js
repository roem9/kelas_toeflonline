var url = window.location.href;
var id_kelas = url.substring(url.indexOf("inbox/") + 6);

loadData();

function loadData(){
    let result = ajax(url_base+"kelas/get_all_inbox", "POST", {id_kelas:id_kelas});

    html = ""

    if(result.length != 0) {
        
        result.forEach(inbox => {
            if(inbox.tabel == "member"){
                html += `
                    <div class="d-flex justify-content-end mb-2">
                        <div class="card w-75">
                            <div class="card-body">
                                <div style="text-align: left">
                                    `+inbox.text+`
                                </div>
                                <div class="d-flex justify-content-end">
                                    <small>`+inbox.tgl_input+`</small>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            } else if(inbox.tabel == "admin"){
                html += `
                    <div class="d-flex justify-content-start mb-2">
                        <div class="card w-75">
                            <div class="card-body">
                                <div style="text-align: left">
                                    `+inbox.text+`
                                </div>
                                <div class="d-flex justify-content-end">
                                    <small>`+inbox.tgl_input+`</small>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            }
        });
    } else {
        html = ``;
    }

    $("#dataAjax").html(html);
}
