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
                            <div class="shadow card mb-3 soal">
                                <div class="card-body">
                                    <h2 class='text-center'>&#128079 SELAMAT &#128079</h2>
                                    <p class='text-center'>Kamu Telah Berhasil Menyelesaikan <br>&quot;Latihan <?= $pertemuan['nama_pertemuan']?>&quot; <br>Kelas <?= $kelas['nama_kelas']?></p>
                                    <p class='text-center'>
                                        Nilai Kamu Adalah : <br>
                                        <span class='text-center' style='font-size: 5em;'><b><?= $latihan['nilai']?></b></span>
                                    </p>
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

                                <?php foreach ($jawaban as $i => $data) :
                                    $item = "";
                                    ?>
                                    <?php if($data['item'] == "soal") :?>
                                        <?php 
                                            if($data['status'] == "Benar") :
                                                $icon = '<span>Status : '.tablerIcon("circle-check", "text-success").' '.$data['status'].'</span>';
                                            else :
                                                $icon = '<span>Status : '.tablerIcon("circle-x", "text-danger").' '.$data['status'].'</span>';
                                            endif;
                                        ?>
                                        <?php $soal = '<div dir="'.$data['penulisan'].'" class="mb-3 mt-3">'.$data['soal'].'</div>' ?>
                                        <?php $jawaban_soal = '<p><b>Jawaban</b><br>'.$data['jawaban'].'</p>';?>

                                        <?php $pembahasan_soal = "";?>
                                        <?php if($data['pembahasan'] != "") :?>
                                            <?php $pembahasan_soal = '<p><b>Pembahasan</b><br>'.$data['pembahasan'].'</p>';?>
                                        <?php endif;?>

                                        <?php $item = $icon.$soal.$jawaban_soal.$pembahasan_soal;?>
                                    <?php elseif($data['item'] == "petunjuk") :
                                            $item = '<div dir="'.$data['penulisan'].'" class="mb-3">'.$data['data'].'</div>';
                                    ?>
                                    <?php elseif($data['item'] == "audio") :
                                        $item = '<center><audio controls controlsList="nodownload"><source src="../../../../'.$folder_admin['value'].'/assets/media/'.$data['data'].'?t='.time().'" type="audio/mpeg"></audio></center>';
                                    ?>
                                    <?php elseif($data['item'] == "gambar") :
                                        $item = '<img data-enlargeable src="../../../../'.$folder_admin['value'].'/assets/media/'.$data["data"].'" onerror="this.onerror=null; this.src=\''.base_url().'assets/tabler-icons-1.39.1/icons/x.svg\'" class="img-fluid" height="auto" width="100%">';
                                    ?>
                                    <?php endif;?>
                                    <div class="shadow card mb-3 soal">
                                        <div class="card-body" id="soal-<?= $i?>">
                                            <?= $item?>
                                        </div>
                                    </div>
                                <?php endforeach;?>
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

        // $(".btnSimpan").click(function(){
        //     let form = "#formSoal";

        //     Swal.fire({
        //         icon: 'question',
        //         html: 'Yakin akan mengumpulkan Jawaban Kamu?',
        //         showCloseButton: true,
        //         showCancelButton: true,
        //         confirmButtonText: 'Ya',
        //         cancelButtonText: 'Tidak'
        //     }).then(function (result) {
        //         if (result.value) {
                    
        //             swal.fire({
        //                 html: '<h4>Mengumpulkan Jawaban Kamu ...</h4>',
        //                 allowOutsideClick: false,
        //                 showConfirmButton: false,
        //                 onBeforeOpen: () => {
        //                     Swal.showLoading()
        //                 },
        //             });
                    
        //             $(form).submit();
        //         }
        //     })
        // })

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

                    $(form+" [name='jawaban[]']").each(function(){
                        soal += `{"jawaban":"`+$(this).val()+`","pembahasan":"","status":""},`;
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
                            text: 'Terjadi kesalahan, silakan refresh ulang page',
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

                    $(form+" [name='jawaban[]']").each(function(){
                        soal += `{"jawaban":"`+$(this).val()+`","pembahasan":"","status":""},`;
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
                            icon: 'success',
                            text: 'Terjadi kesalahan, silakan refresh ulang page',
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
                            icon: 'success',
                            text: 'Kamu tidak dapat mengubah jawaban Kamu, karena jawaban kamu sedang diperiksa',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            })
        })


    </script>

<?php $this->load->view("_partials/footer")?>