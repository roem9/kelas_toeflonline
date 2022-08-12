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
                        
                        
                        <?php if($this->session->flashdata("pesan")):?>
                            <div class="row row-cards FieldContainer" data-masonry='{"percentPosition": true }'>
                                <div class="shadow card mb-3 soal">
                                    <div class="card-body">
                                        <?= $this->session->flashdata('pesan');?>
                                    </div>
                                </div>
                            </div>
                        <?php else :?>
                            <div class="row row-cards FieldContainer" data-masonry='{"percentPosition": true }'>
                                <form action="<?= base_url()?>kelas/add_jawaban_kosakata" method="post" id="formSoal">
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
    
                                    <?php
                                        foreach ($soal as $i => $data) :
                                        $item = "";
                                            if($data['data']['bahasa'] == "Asing") $dir = $data['penulisan'];
                                            else $dir = "ltr";
                                    ?>
                                        <?php $soal = '<div dir="'.$dir.'" class="mb-3">'.$data['data']['soal'].'</div>' ?>
                                        <input type="hidden" name="kunci[]" data-id="kunci-<?= $i?>" id="kunci<?= $i?>" value="<?= $data['data']['jawaban']?>">
                                        <input type="hidden" name="status[]" data-id="status-<?= $i?>" id="status<?= $i?>" value="null">
                                        <input type="hidden" name="jawaban[]" data-id="jawaban-<?= $i?>" id="jawaban<?= $i?>" value="null">
                                        
                                        <?php $pilihan = "";?>
                                        <?php foreach ($data['data']['pilihan'] as $k => $choice) :?>
                                            <?php $pilihan .= '
                                                <div class="mb-3" dir="'.$dir.'">
                                                    <label>
                                                        <input type="radio" data-id="'.$i.'"  name="radio['.$i.']" value="'.$choice.'"> 
                                                        '.$choice.'
                                                    </label>
                                                </div>' ?>
                                        <?php endforeach;?>

                                        <?php $item = $soal.$pilihan;?>
                                        <div class="shadow card mb-3 soal">
                                            <div class="card-body" id="soal-<?= $i?>">
                                                
                                                <?= $item?>
                            
                                            </div>
                                        </div>
                                        <textarea type="text" name="soal[]" style="display:none"><?= $data['soal']?></textarea>
                                    <?php endforeach;?>
    
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-md btn-primary btnSimpan">
                                            <svg width="20" height="20">
                                                <use xlink:href="<?= base_url()?>assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-device-floppy" />
                                            </svg>
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        <?php endif;?>


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
            console.log(id);
            let value = $(this).val();
            console.log(value)
            if(value == $("#kunci"+id).val()) $("#status"+id).val("benar");
            else $("#status"+id).val("salah");
            $("#jawaban"+id).val(value);
        });
    </script>

<?php $this->load->view("_partials/footer")?>