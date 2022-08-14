<?php $this->load->view("_partials/header")?>
    <div id="soal_tes">
        <div class="wrapper" id="elementtoScrollToID">
            <div class="sticky-top">
                <?php $this->load->view("_partials/navbar-header")?>
                <?php $this->load->view("_partials/navbar")?>
            </div>
            <div class="page-wrapper" id="">
                <div class="page-body">
                    <div class="container-xl">
                        <?php if($this->session->flashdata("pesan")):?>
                            <a href="<?= base_url()?>kelas/pertemuan/<?= md5($kelas['id_kelas'])?>/<?= md5($pertemuan['id_pertemuan'])?>" class="btn btn-success"><?= tablerIcon("chevrons-left", "me-1")?> Kembali</a>
                        <?php else :?>
                            <a href="javascript:void(0)" class="btn btn-danger btnClose"><?= tablerIcon("circle-x", "me-1")?> Keluar</a>
                        <?php endif;?>
                        <div class="page-header d-print-none">
                            <div class="row align-items-center">
                                <div class="col">
                                    <center>
                                        <h3>
                                            <?= $title?>
                                        </h3>
                                    </center>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row row-cards FieldContainer" data-masonry='{"percentPosition": true }'>
                            <form action="<?= base_url()?>kelas/add_jawaban_manual" method="post" id="formSoal">
                                <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas']?>" class="form">
                                <input type="hidden" name="id_pertemuan" value="<?= $pertemuan['id_pertemuan']?>" class="form">

                                <div class="form-floating mb-3 mt-3">
                                    <select name="fontSize" class="form-control required">
                                        <option value="">Pilih Ukuran Tulisan</option>
                                        <option value="">Default</option>
                                        <option value="20px">20px</option>
                                        <option value="25px">25px</option>
                                        <option value="30px">30px</option>
                                    </select>
                                    <label>Ukuran Tulisan</label>
                                </div>

                                <?php if(isset($jawaban)) :?>
                                    <?php foreach ($jawaban as $i => $data) :
                                        $item = "";
                                        ?>
                                        <?php if($data['item'] == "soal") :?>
                                            <?php $soal = '<div dir="'.$data['penulisan'].'" class="mb-3 soal-'.$i.'">'.$data['soal'].'</div>' ?>
                                            <?php $jawaban_soal = '
                                                <div class="form-floating mb-3">
                                                    <textarea name="jawaban[]" class="form form-control" '.$readonly.' data-id_item="'.$data['id_item'].'" data-tipe="soal" data-id="'.$i.'" data-bs-toggle="autosize">'.$data['jawaban'].'</textarea>
                                                    <label for="jawaban">Jawaban</label>
                                                </div>';?>
                                            <?php $item = $soal.$jawaban_soal;?>
                                        <?php elseif($data['item'] == "petunjuk") :
                                            $item = '<div dir="'.$data['penulisan'].'" class="mb-3 form" data-id_item="'.$data['id_item'].'" data-tipe="petunjuk">'.$data['data'].'</div>';
                                        ?>
                                        <?php elseif($data['item'] == "audio") :
                                            $item = '
                                                <input type="hidden" class="form" value="'.$data['data'].'" data-id_item="'.$data['id_item'].'" data-tipe="audio">
                                                <center><audio controls controlsList="nodownload"><source src="../../../../'.$folder_admin['value'].'/assets/media/'.$data['data'].'?t='.time().'" type="audio/mpeg"></audio></center>';
                                        ?>
                                        <?php elseif($data['item'] == "gambar") :
                                            $item = '
                                                <input type="hidden" class="form" value="'.$data['data'].'" data-id_item="'.$data['id_item'].'" data-tipe="gambar">
                                                <img data-enlargeable src="../../../../'.$folder_admin['value'].'/assets/media/'.$data["data"].'" onerror="this.onerror=null; this.src=\''.base_url().'assets/tabler-icons-1.39.1/icons/x.svg\'" class="img-fluid" height="auto" width="100%">';
                                        ?>
                                        <?php endif;?>
                                        <div class="shadow card mb-3 soal">
                                            <div class="card-body" id="soal-<?= $i?>">
                                                <?= $item?>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                <?php else :?>
                                    <?php foreach ($soal as $i => $data) :
                                        $item = "";
                                        ?>
                                        <?php if($data['item'] == "soal esai") :?>
                                            <?php $soal = '<div dir="'.$data['penulisan'].'" class="mb-3 soal-'.$i.'">'.$data['data']['soal'].'</div>' ?>
                                            <?php if(isset($jawaban)) :?>
                                                <?php $jawaban_soal = '
                                                    <div class="form-floating mb-3">
                                                        <textarea name="jawaban[]" class="form form-control" '.$readonly.' data-id_item="'.$data['id_item'].'" data-tipe="soal" data-id="'.$i.'" data-bs-toggle="autosize">'.$jawaban[$i]['jawaban'].'</textarea>
                                                        <label for="jawaban">Jawaban</label>
                                                    </div>';?>
                                            <?php else :?>
                                                <?php $jawaban_soal = '
                                                    <div class="form-floating mb-3">
                                                        <textarea name="jawaban[]" class="form form-control" '.$readonly.' data-id_item="'.$data['id_item'].'" data-tipe="soal" data-id="'.$i.'" data-bs-toggle="autosize"></textarea>
                                                        <label for="jawaban">Jawaban</label>
                                                    </div>';?>
                                            <?php endif;?>
                                            <?php $item = $soal.$jawaban_soal;?>
                                        <?php elseif($data['item'] == "petunjuk") :
                                                $item = '<div dir="'.$data['penulisan'].'" class="mb-3 form" data-id_item="'.$data['id_item'].'" data-tipe="petunjuk">'.$data['data'].'</div>';
                                        ?>
                                        <?php elseif($data['item'] == "audio") :
                                            $item = '
                                                <input type="hidden" class="form" value="'.$data['data'].'" data-id_item="'.$data['id_item'].'" data-tipe="audio">
                                                <center><audio controls controlsList="nodownload"><source src="../../../../'.$folder_admin['value'].'/assets/media/'.$data['data'].'?t='.time().'" type="audio/mpeg"></audio></center>';
                                        ?>
                                        <?php elseif($data['item'] == "gambar") :
                                            $item = '
                                                <input type="hidden" class="form" value="'.$data['data'].'" data-id_item="'.$data['id_item'].'" data-tipe="gambar">
                                                <img data-enlargeable src="../../../../'.$folder_admin['value'].'/assets/media/'.$data["data"].'" onerror="this.onerror=null; this.src=\''.base_url().'assets/tabler-icons-1.39.1/icons/x.svg\'" class="img-fluid" height="auto" width="100%">';
                                        ?>
                                        <?php endif;?>
                                        <div class="shadow card mb-3 soal">
                                            <div class="card-body" id="soal-<?= $i?>">
                                                <?= $item?>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                <?php endif;?>
                                
                                <div class="mb-3">
                                    <small><span class="msg_status text-danger"><i>*<?= $periksa['text']?></i></span></small>
                                </div>
                                
                                <?php if(!isset($periksa['status']) || $periksa['status'] == "mengisi" || $periksa['status'] == "") :?>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-md btn-primary btn_kumpul w-100" id="btn_kumpul">
                                            <?= tablerIcon("device-floppy", "me-1");?>
                                            Kumpulkan Jawaban
                                        </button>
                                    </div>
                                <?php elseif($periksa['status'] == "mengumpul") :?>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-md btn-success btn_edit w-100" id="btn_edit">
                                            <?= tablerIcon("edit", "me-1");?>
                                            Edit Jawaban
                                        </button>
                                    </div>
                                <?php endif;?>
                            </form>
                        </div>


                    </div>
                </div>
                <?php $this->load->view("_partials/footer-bar")?>
            </div>
        </div>
    </div>

    <script>
        $("select[name='fontSize']").change(function(){
            let size = $(this).val();
            $(".soal").css("font-size",size);
            $(this).val(size)
        })
    </script>

    <?php  
        if(isset($js)) :
            foreach ($js as $i => $js) :?>
                <script src="<?= base_url()?>assets/myjs/<?= $js?>"></script>
                <?php 
            endforeach;
        endif;    
    ?>

    <script>
        $(".btnClose").click(function(){
            Swal.fire({
                icon: 'question',
                html: 'Yakin akan keluar dari latihan?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    window.location.href = '<?= base_url()?>kelas/pertemuan/<?= md5($kelas['id_kelas'])?>/<?= md5($pertemuan['id_pertemuan'])?>';
                }
            })
        })

        $('input:radio').click(function () {
            let id = $(this).data("id");
            let value = $(this).val();
            $("#jawaban"+id).val(value);
        });

        $("[name='jawaban[]']").on("change keyup", function(){
            $("#btn_save").addClass("text-danger");
        })

        $("#btn_save").click(function(){
            let form = "#formSoal";

            Swal.fire({
                icon: 'question',
                html: 'Yakin menyimpan jawaban Kamu?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    let id_pertemuan = $("[name='id_pertemuan']").val();
                    let id_kelas = $("[name='id_kelas']").val();
                    let soal = "";

                    // $(form+" [name='jawaban[]']").each(function(){
                    $(form+" .form").each(function(){
                        tipe = $(this).data("tipe");
                        id_item = $(this).data("id_item");

                        data_soal = "";
                        if(tipe == "soal"){
                            id = $(this).data("id");
                            data_soal = $(".soal-"+id).html();
                            data_soal = data_soal.replace(/"/g, "&quot;");
                            soal += `{"id_item":"`+id_item+`","item":"`+tipe+`","penulisan":"`+$(".soal-"+id).attr("dir")+`","soal":"`+data_soal+`","jawaban":"`+$(this).val()+`","pembahasan":"","status":""},`;
                        } else if(tipe == "petunjuk"){
                            data_soal = $(this).html()
                            data_soal = data_soal.replace(/"/g, "&quot;");
                            soal += `{"id_item":"`+id_item+`","item":"`+tipe+`","penulisan":"`+$(this).attr("dir")+`","data":"`+data_soal+`"},`;
                        } else if(tipe == "audio"){
                            soal += `{"id_item":"`+id_item+`","item":"`+tipe+`","data":"`+$(this).val()+`"},`;
                        } else if(tipe == "gambar"){
                            soal += `{"id_item":"`+id_item+`","item":"`+tipe+`","data":"`+$(this).val()+`"},`;
                        }
                    });
                    soal = soal.slice(0, -1)
                    data = {id_pertemuan:id_pertemuan, id_kelas:id_kelas, data:soal, periksa:"mengisi"};

                    let result = ajax(url_base+"kelas/simpan_jawaban_manual", "POST", data);
                    
                    if(result == 1){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menyimpan jawaban',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        
                        $("#btn_save").removeClass("text-danger");
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Terjadi kesalahan, silakan refresh ulang halaman',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            })
        })

        $("#btn_kumpul").click(function(){
            let form = "#formSoal";

            Swal.fire({
                icon: 'question',
                html: 'Yakin mengumpulkan jawaban Kamu?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    let id_pertemuan = $("[name='id_pertemuan']").val();
                    let id_kelas = $("[name='id_kelas']").val();
                    let soal = "";

                    $(form+" .form").each(function(){
                        tipe = $(this).data("tipe");
                        id_item = $(this).data("id_item");

                        data_soal = "";
                        if(tipe == "soal"){
                            id = $(this).data("id");
                            data_soal = $(".soal-"+id).html();
                            data_soal = data_soal.replace(/"/g, "&quot;");
                            soal += `{"id_item":"`+id_item+`","item":"`+tipe+`","penulisan":"`+$(".soal-"+id).attr("dir")+`","soal":"`+data_soal+`","jawaban":"`+$(this).val()+`","pembahasan":"","status":""},`;
                        } else if(tipe == "petunjuk"){
                            data_soal = $(this).html()
                            data_soal = data_soal.replace(/"/g, "&quot;");
                            soal += `{"id_item":"`+id_item+`","item":"`+tipe+`","penulisan":"`+$(this).attr("dir")+`","data":"`+data_soal+`"},`;
                        } else if(tipe == "audio"){
                            soal += `{"id_item":"`+id_item+`","item":"`+tipe+`","data":"`+$(this).val()+`"},`;
                        } else if(tipe == "gambar"){
                            soal += `{"id_item":"`+id_item+`","item":"`+tipe+`","data":"`+$(this).val()+`"},`;
                        }
                    });
                    soal = soal.slice(0, -1)
                    data = {id_pertemuan:id_pertemuan, id_kelas:id_kelas, data:soal, periksa:"mengumpul"};

                    let result = ajax(url_base+"kelas/simpan_jawaban_manual", "POST", data);
                    
                    if(result == 1){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil mengumpulkan jawaban kamu',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            $("#btn_save").removeClass("text-danger");
                            $("#btn_kumpul").attr("disabled",true);
                            location.reload();
                        })
                        
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            text: 'Terjadi kesalahan, silakan refresh ulang halaman',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            })
        })

        $("#btn_edit").click(function(){
            let form = "#formSoal";

            Swal.fire({
                icon: 'question',
                html: 'Ingin mengubah jawaban Kamu?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    let id_pertemuan = $("[name='id_pertemuan']").val();
                    let id_kelas = $("[name='id_kelas']").val();
                    
                    data = {id_pertemuan:id_pertemuan, id_kelas:id_kelas, periksa:"mengisi"};

                    let result = ajax(url_base+"kelas/edit_jawaban_manual", "POST", data);
                    
                    if(result == 1){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Silakan mengubah jawaban Kamu',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            $("#btn_save").removeClass("text-danger");
                            $("#btn_edit").attr("disabled",true);
                            location.reload();
                        })
                        
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            text: 'Kamu tidak dapat mengubah jawaban Kamu, karena jawaban kamu sedang diperiksa',
                            showConfirmButton: true
                        }).then(function () {
                            $("#btn_edit").attr("disabled",true);
                            location.reload();
                        })
                    }
                }
            })
        })


    </script>

<?php $this->load->view("_partials/footer")?>