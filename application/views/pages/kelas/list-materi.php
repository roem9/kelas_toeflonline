<?php $this->load->view("_partials/header")?>
    <div class="wrapper">
        <div class="sticky-top">
            <?php $this->load->view("_partials/navbar-header")?>
            <?php $this->load->view("_partials/navbar")?>
        </div>
        <div class="page-wrapper">
        <div class="container-xl">
                <!-- Page title -->
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
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <a href="<?= base_url()?>kelas/id/<?= md5($kelas['id_kelas'])?>" class="btn btn-secondary mb-3 btnLoading"><?= tablerIcon("chevrons-left", "me-1")?> Kembali</a>
                    <?php if($materi || $pertemuan['latihan'] != "Tidak Ada Latihan") :
                        $audio = 1;
                        $image = 1;
                    ?>
                        <?php if($materi) :?>
                            <div class="mb-3">
                                <a href="javascript:void(0)" class="btn bg-blue-lt w-100 text-light">Materi</a>
                            </div>
                        <?php endif;?>

                        <?php foreach ($materi as $materi) :?>
                            <?php if($materi['item'] == "petunjuk") :?>
                                <?php if($materi['penulisan'] == "RTL") :
                                    $item = '<div dir="rtl" class="mb-3">'.$materi["data"].'</div>';
                                ?><?php else :
                                    $item = '<div dir="ltr" class="mb-3">'.$materi["data"].'</div>'
                                ?><?php endif;?>
                            <?php elseif($materi['item'] == "audio") :
                                $item = '<center><audio controls><source src="../../../../'.$folder_admin['value'].'/assets/media/'.$materi["data"].'" type="audio/mpeg"></audio></center>
                                        <div class="d-flex justify-content-end">
                                            <a class="btn btn-md btn-success" href="../../../../'.$folder_admin['value'].'/assets/media/'.$materi["data"].'" download="'.$kelas['program'].' - '.$pertemuan['nama_pertemuan'].' - audio '.$audio.'">'.tablerIcon("file-download", "me-1", "24").'Download</a>
                                        </div>
                                ';
                                $audio ++;
                            ?><?php elseif($materi['item'] == "gambar") :
                                $item = '
                                    <div class="d-flex justify-content-center">
                                        <img data-enlargeable style="cursor: zoom-in" src="../../../../'.$folder_admin['value'].'/assets/media/'.$materi["data"].'" onerror="this.onerror=null; this.src=\''.base_url().'assets/tabler-icons-1.39.1/icons/x.svg\'" class="img-fluid" height="auto" width="100%">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a class="btn btn-md btn-success" href="../../../../'.$folder_admin['value'].'/assets/media/'.$materi["data"].'" download="'.$kelas['program'].' - '.$pertemuan['nama_pertemuan'].' - gambar '.$image.'">'.tablerIcon("file-download", "me-1", "24").'Download</a>
                                    </div>
                                    ';
                                $image++;
                            ?><?php elseif($materi['item'] == "video") :
                                $item = '
                                    <div class="d-flex justify-content-center">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" src="'.$materi["data"].'" allowfullscreen></iframe>
                                        </div>
                                    </div>'
                            ?><?php elseif($materi['item'] == "video pembahasan") :
                                $item = '
                                    <div class="d-flex justify-content-center">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" src="'.$materi["data"].'" allowfullscreen></iframe>
                                        </div>
                                    </div>'
                            ?><?php endif;?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <?= $item;?>
                                </div>
                            </div>
                        <?php endforeach;?>

                        <?php if($pertemuan['latihan'] != "Tidak Ada Latihan") :?>

                            <?php $nilai = nilai_latihan($kelas['id_kelas'], $pertemuan['id_pertemuan'], $this->session->userdata("id_member"))?>
                            <?php if($pertemuan['latihan'] == "Input Manual") :?>
                                <div class="mb-3">
                                    <a href="javascript:void(0)" class="btn bg-yellow-lt w-100 text-light">Latihan</a>
                                </div>

                                <?php if(is_numeric($nilai) == 1) :?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <p>Berikut Ini Nilai Anda</p>
                                            <div class="d-flex justify-content-center">
                                                <a href="javascript:void(0)" class="btn btn-success w-100"><?= $nilai?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php else :?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <p>Nilai Anda Belum Diinput Oleh Pengajar</p>
                                            <div class="d-flex justify-content-center">
                                                <a href="javascript:void(0)" class="btn btn-outline-success w-100"><?= $nilai?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php elseif($pertemuan['latihan'] == "Post Test Listening" || $pertemuan['latihan'] == "Post Test Structure" || $pertemuan['latihan'] == "Post Test Reading" || $pertemuan['latihan'] == "Pre / Mid Test Listening" || $pertemuan['latihan'] == "Pre / Mid Test Structure" || $pertemuan['latihan'] == "Pre / Mid Test Reading") :?>
                                <div class="mb-3">
                                    <a href="javascript:void(0)" class="btn bg-yellow-lt w-100 text-light">Tes</a>
                                </div>

                                <?php
                                    if($pertemuan['latihan'] == "Pre / Mid Test Listening" || $pertemuan['latihan'] == "Post Test Listening"){
                                        $poin_maksimal = poin_toefl("Listening", jumlah_soal($pertemuan['id_pertemuan']));
                                    } else if($pertemuan['latihan'] == "Pre / Mid Test Structure" || $pertemuan['latihan'] == "Post Test Structure"){
                                        $poin_maksimal = poin_toefl("Structure", jumlah_soal($pertemuan['id_pertemuan']));
                                    } else if($pertemuan['latihan'] == "Pre / Mid Test Reading" || $pertemuan['latihan'] == "Post Test Reading"){
                                        $poin_maksimal = poin_toefl("Reading", jumlah_soal($pertemuan['id_pertemuan']));
                                    }
                                ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <p>kerjakan tes melalui link berikut</p>
                                        <div class="d-flex justify-content-center">
                                            <a href="<?= base_url()?>kelas/latihan/<?= md5($kelas['id_kelas'])?>/<?= md5($pertemuan['id_pertemuan'])?>" class="btn bg-yellow text-light w-100 me-2 btnLoading">Mulai Tes</a>
                                            <a href="javascript:void(0)" class="btn btn-outline-success"><?= $nilai?> / <?= $poin_maksimal?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php if(is_numeric($nilai) == 1) :?>
                                    <?php if($pembahasan) :?>
                                        <!-- <div class="card mb-3">
                                            <div class="card-body">
                                                <h3>Pembahasan</h3>
                                            </div>
                                        </div> -->
                                        <div class="mb-3">
                                            <a href="javascript:void(0)" class="btn bg-green-lt w-100 text-light">Materi</a>
                                        </div>
                                        <?php foreach ($pembahasan as $pembahasan) :?>
                                            <?php if($pembahasan['item'] == "video pembahasan") :
                                                $item = '
                                                    <div class="d-flex justify-content-center">
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <iframe class="embed-responsive-item" src="'.$pembahasan["data"].'" allowfullscreen></iframe>
                                                        </div>
                                                    </div>'
                                            ?><?php endif;?>
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <?= $item;?>
                                                </div>
                                            </div>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                    
                                    <?php if($pertemuan_kelas['selesai'] == "Belum Selesai") :?>
                                        <?php if($pertemuan_kelas['pertemuan_terakhir'] == "Tidak") :?>
                                            <a href="<?= base_url()?>kelas/tandai_selesai/<?= $kelas['id_kelas']?>/<?= md5($pertemuan['id_pertemuan'])?>" class="btn btn-md btn-primary w-100 mb-3">Materi Berikutnya</a>
                                        <?php else :?>
                                            <a href="<?= base_url()?>kelas/tandai_selesai/<?= $kelas['id_kelas']?>/<?= md5($pertemuan['id_pertemuan'])?>" class="btn btn-md btn-primary w-100 mb-3">Klaim Sertifikat</a>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php endif;?>
                            <?php else :?>
                                <div class="mb-3">
                                    <a href="javascript:void(0)" class="btn bg-yellow-lt w-100 text-light">Latihan</a>
                                </div>
                                
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <p>kerjakan latihan melalui link berikut</p>
                                        <div class="d-flex justify-content-center">
                                            <a href="<?= base_url()?>kelas/latihan/<?= md5($kelas['id_kelas'])?>/<?= md5($pertemuan['id_pertemuan'])?>" class="btn bg-yellow text-light w-100 me-2 btnLoading">Mulai Latihan</a>
                                            <a href="javascript:void(0)" class="btn btn-outline-success"><?= $nilai?> / <?= jumlah_soal($pertemuan['id_pertemuan'])?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php if(is_numeric($nilai) == 1) :?>
                                    <?php if($pembahasan) :?>
                                        <!-- <div class="card mb-3">
                                            <div class="card-body">
                                                <h3>Pembahasan</h3>
                                            </div>
                                        </div> -->
                                        
                                        <div class="mb-3">
                                            <a href="javascript:void(0)" class="btn bg-green-lt w-100 text-light">Pembahasan</a>
                                        </div>
                                        <?php foreach ($pembahasan as $pembahasan) :?>
                                            <?php if($pembahasan['item'] == "video pembahasan") :
                                                $item = '
                                                    <div class="d-flex justify-content-center">
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <iframe class="embed-responsive-item" src="'.$pembahasan["data"].'" allowfullscreen></iframe>
                                                        </div>
                                                    </div>'
                                            ?><?php endif;?>
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <?= $item;?>
                                                </div>
                                            </div>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                    
                                    <?php if($pertemuan_kelas['selesai'] == "Belum Selesai") :?>
                                        <?php if($pertemuan_kelas['pertemuan_terakhir'] == "Tidak") :?>
                                            <a href="<?= base_url()?>kelas/tandai_selesai/<?= $kelas['id_kelas']?>/<?= md5($pertemuan['id_pertemuan'])?>" class="btn btn-md btn-primary w-100 mb-3">Materi Berikutnya</a>
                                        <?php else :?>
                                            <a href="<?= base_url()?>kelas/tandai_selesai/<?= $kelas['id_kelas']?>/<?= md5($pertemuan['id_pertemuan'])?>" class="btn btn-md btn-primary w-100 mb-3">Klaim Sertifikat</a>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php endif;?>
                            <?php endif;?>
                            <!-- <h3>Link Latihan</h3> -->
                        <?php endif;?>
                        <?= link_materi($kelas['id_kelas'], $pertemuan['id_pertemuan']);?>
                    <?php else :?>
                        <div class="text-center mt-3">
                            <img src="<?= base_url()?>assets/tabler-icons-1.39.1/icons-png/mood-sad.png" alt="">
                            <h3>maaf materi belum diupload</h3>
                        </div>
                    <?php endif;?>

                    <?php 
                        if($kelas_member['baca_member'] == 0) $class = "blink_me";
                        else $class = "";
                    ?>

                    <div class="<?= $class;?>">
                        <a href="<?= base_url()?>kelas/inbox/<?= md5($kelas['id_kelas'])?>" class="float" data-toggle="tooltip" data-placement="top" title="Ruang Diskusi">
                            <?= iconFloat("message");?>
                        </a>
                    </div>
                </div>
            </div>
            <?php $this->load->view("_partials/footer-bar")?>
        </div>
    </div>

    <!-- load modal -->
    <?php 
        if(isset($modal)) :
            foreach ($modal as $i => $modal) {
                $this->load->view("_partials/modal/".$modal);
            }
        endif;
    ?>

    <script>
        $("#<?= $menu?>").addClass("active")

        $('img[data-enlargeable]').addClass('img-enlargeable').click(function() {
            var src = $(this).attr('src');
            var modal;

            function removeModal() {
                modal.remove();
                $('body').off('keyup.modal-close');
            }

            modal = $('<div>').css({
                background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
                backgroundSize: 'contain',
                width: '100%',
                height: '100%',
                position: 'fixed',
                zIndex: '10000',
                top: '0',
                left: '0',
                cursor: 'zoom-out'
            }).click(function() {
                removeModal();
            }).appendTo('body');

            //handling ESC
            $('body').on('keyup.modal-close', function(e) {
                if (e.key === 'Escape') {
                    removeModal();
                }
            });
        });
    </script>

    <!-- load javascript -->
    <?php  
        if(isset($js)) :
            foreach ($js as $i => $js) :?>
                <script src="<?= base_url()?>assets/myjs/<?= $js?>"></script>
                <?php 
            endforeach;
        endif;    
    ?>

    
<?php $this->load->view("_partials/footer")?>