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
                        <a href="<?= base_url()?>kelas/pertemuan/<?= md5($kelas['id_kelas'])?>/<?= md5($pertemuan['id_pertemuan'])?>" class="btn btn-success"><?= tablerIcon("chevrons-left", "me-1")?> Kembali</a>
                        <div class="page-header d-print-none">
                            <div class="row align-items-center">
                                <div class="col">
                                <h3>
                                    <?= $title?>
                                </h3>
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
                                            <?php if($pertemuan['latihan'] == "Pre / Mid Test Listening" || $pertemuan['latihan'] == "Post Test Listening") :?>
                                                <span class='text-center' style='font-size: 5em;'><b><?= $jawaban['nilai']?> / <?= poin_toefl("Listening", jumlah_soal($pertemuan['id_pertemuan']))?></b></span>
                                            <?php elseif($pertemuan['latihan'] == "Pre / Mid Test Structure" || $pertemuan['latihan'] == "Post Test Structure") :?>
                                                <span class='text-center' style='font-size: 5em;'><b><?= $jawaban['nilai']?> / <?= poin_toefl("Structure", jumlah_soal($pertemuan['id_pertemuan']))?></b></span>
                                            <?php elseif($pertemuan['latihan'] == "Pre / Mid Test Reading" || $pertemuan['latihan'] == "Post Test Reading") :?>
                                                <span class='text-center' style='font-size: 5em;'><b><?= $jawaban['nilai']?> / <?= poin_toefl("Reading", jumlah_soal($pertemuan['id_pertemuan']))?></b></span>
                                            <?php endif;?>
                                        </p>
                                    </div>
                                </div>
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
        $(".btnPembahasan").click(function(){
            $(".pembahasan").show();
            $(".btnPembahasan").hide();
        })

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

        $(".btnSimpan").click(function(){
            let form = "#formSoal";

            Swal.fire({
                icon: 'question',
                html: 'Yakin telah menyelesaikan latihan Kamu?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then(function (result) {
                if (result.value) {
                    
                    swal.fire({
                        html: '<h4>Menyimpan Jawaban Kamu ...</h4>',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                    
                    $(form).submit();
                }
            })
        })

        $('input:radio').click(function () {
            let id = $(this).data("id");
            let value = $(this).val();
            $("#jawaban"+id).val(value);
        });
    </script>

<?php $this->load->view("_partials/footer")?>