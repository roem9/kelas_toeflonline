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
                                <h3>
                                    <?= $title?>
                                </h3>
                                </div>
                            </div>
                        </div>
                        
                            <div class="row row-cards FieldContainer" data-masonry='{"percentPosition": true }'>
                                <div class="shadow card mb-3 soal">
                                    <div class="card-body">
                                        <?= $this->session->flashdata('pesan');?>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-cards FieldContainer pembahasan" data-masonry='{"percentPosition": true }' style="display:none">
                                <form action="<?= base_url()?>kelas/add_jawaban_otomatis" method="post" id="formSoal">
                                    <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas']?>">
                                    <input type="hidden" name="id_pertemuan" value="<?= $pertemuan['id_pertemuan']?>">
    
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
    
                                    <?php foreach ($soal as $i => $data) :
                                        $item = "";
                                        $background = "";
                                        ?>
                                        <?php if($data['item'] == "soal") :
                                            if($data['data']['status'] == "salah") $background = "list-group-item-danger";
                                        ?>
                                            <?php $soal = '<div dir="'.$data['penulisan'].'" class="mb-3">'.$data['data']['soal'].'</div>' ?>
                                            <input type="hidden" name="jawaban[]" data-id="soal-<?= $i?>" id="jawaban<?= $i?>" value="null">
                                            <?php $pilihan = "";?>
                                            <?php foreach ($data['data']['pilihan'] as $k => $choice) :?>
                                                <?php if($data['data']['status'] == "salah" && $choice == $data['data']['key']) :?>
                                                    <?php $pilihan .= '
                                                        <div class="mb-3" dir="'.$data['penulisan'].'">
                                                            <label>
                                                                <input type="radio" data-id="'.$i.'"  name="radio-['.$i.']" value="'.$choice.'" disabled> 
                                                                '.$choice.' '.tablerIcon("circle-x", "text-danger").'
                                                            </label>
                                                        </div>' ?>
                                                <?php elseif($data['data']['status'] == "benar" && $choice == $data['data']['key']) :?>
                                                    <?php $pilihan .= '
                                                        <div class="mb-3" dir="'.$data['penulisan'].'">
                                                            <label>
                                                                <input type="radio" data-id="'.$i.'"  name="radio-['.$i.']" value="'.$choice.'" disabled> 
                                                                '.$choice.' '.tablerIcon("circle-check", "text-success").'
                                                            </label>
                                                        </div>' ?>
                                                <?php elseif($choice == $data['data']['jawaban']) :?>
                                                    <?php $pilihan .= '
                                                        <div class="mb-3" dir="'.$data['penulisan'].'">
                                                            <label>
                                                                <input type="radio" data-id="'.$i.'"  name="radio-['.$i.']" value="'.$choice.'" disabled> 
                                                                '.$choice.' '.tablerIcon("circle-check", "text-success").'
                                                            </label>
                                                        </div>' ?>
                                                <?php else :?>
                                                    <?php $pilihan .= '
                                                        <div class="mb-3" dir="'.$data['penulisan'].'">
                                                            <label>
                                                                <input type="radio" data-id="'.$i.'"  name="radio-['.$i.']" value="'.$choice.'" disabled> 
                                                                '.$choice.'
                                                            </label>
                                                        </div>' ?>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                            <?php $item = $soal.$pilihan;?>
                                        <?php elseif($data['item'] == "soal esai") :
                                            if($data['data']['status'] == "salah") $background = "list-group-item-danger";
                                        ?>
                                            <?php $soal = '<div dir="'.$data['penulisan'].'" class="mb-3">'.$data['data']['soal'].'</div>' ?>
                                            <?php if($data['data']['status'] == "benar") :?>
                                                <?php $jawaban = '
                                                                <div class="form-floating mb-3">
                                                                    <textarea name="jawaban[]" class="form form-control" data-id="'.$i.'" data-bs-toggle="autosize" readonly>'.$data['data']['key'].'</textarea>
                                                                    <label for="jawaban">Jawaban</label>
                                                                </div>';?>
                                            <?php elseif($data['data']['status'] == "salah") :?>
                                                <?php $jawaban = '
                                                                <div class="form-floating mb-3">
                                                                    <textarea name="jawaban[]" class="form form-control" data-id="'.$i.'" data-bs-toggle="autosize" readonly>'.$data['data']['key'].'</textarea>
                                                                    <label for="jawaban">Jawaban</label>
                                                                </div>
                                                                <div class="form-floating mb-3">
                                                                    <textarea name="jawaban[]" class="form form-control" data-id="'.$i.'" data-bs-toggle="autosize" readonly>'.$data['data']['jawaban'].'</textarea>
                                                                    <label for="jawaban">Jawaban Benar</label>
                                                                </div>';?>
                                            <?php endif;?>
                                            <?php $item = $soal.$jawaban;?>
                                        <?php elseif($data['item'] == "petunjuk") :
                                                if($data['penulisan'] == "RTL"){
                                                    $item = '<div dir="rtl" class="mb-3">'.$data['data'].'</div>';
                                                } else {
                                                    $item = '<div dir="ltr" class="mb-3">'.$data['data'].'</div>';
                                                }?>
                                        <?php elseif($data['item'] == "audio") :
                                            $item = '<center><audio controls controlsList="nodownload"><source src="../../../../'.$folder_admin['value'].'/assets/media/'.$data['data'].'?t='.time().'" type="audio/mpeg"></audio></center>';
                                        ?>
                                        <?php elseif($data['item'] == "gambar") :
                                            $item = '<img data-enlargeable src="../../../../'.$folder_admin['value'].'/assets/media/'.$data["data"].'" onerror="this.onerror=null; this.src=\''.base_url().'assets/tabler-icons-1.39.1/icons/x.svg\'" class="img-fluid" height="auto" width="100%">';
                                        ?>
                                        <?php endif;?>
                                        <div class="shadow card mb-3 soal <?= $background;?>">
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