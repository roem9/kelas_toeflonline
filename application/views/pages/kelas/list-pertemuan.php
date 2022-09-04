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
                        <h3>
                            <?= $title?>
                        </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <a href="<?= base_url()?>kelas/" class="btn btn-secondary mb-3 btnLoading"><?= tablerIcon("chevrons-left", "me-1")?> Kembali</a>

                    <!-- <?= $link?> -->
                    
                    <!-- sertifikat  -->
                    <?php if($kelas_member['sertifikat'] == 1) :?>
                        <a href="<?= base_url()?>kelas/sertifikat/<?= md5($kelas_member['id'])?>" target="_blank" class="btn btn-md btn-success w-100 mb-3"><?= tablerIcon("certificate", "me-1")?> Cetak Sertifikat</a>
                    <?php endif;?>

                    <?php if($pertemuan) :?>
                        <?php foreach ($pertemuan as $i => $pertemuan) :?>
                            <div class="card mb-3 shadow-md">
                                <div class="card-body">
                                    <h3 class="mb-3"><?= $pertemuan['nama_pertemuan']?></h3>
                                    
                                    <?php if($pertemuan['catatan'] != "") :?>
                                        <p><b>isi materi</b> : <?= $pertemuan['catatan']?></p>
                                    <?php endif;?>

                                    <div class="d-flex justify-content-end">
                                        <a href="<?= base_url()?>kelas/pertemuan/<?= md5($kelas['id_kelas'])?>/<?= md5($pertemuan['id_pertemuan'])?>" class="btn btn-primary btnLoading"><?= tablerIcon("notebook", "me-1")?> Mulai</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    <?php else :?>
                        <div class="text-center mt-3">
                            <img src="<?= base_url()?>assets/tabler-icons-1.39.1/icons-png/mood-sad.png" alt="">
                            <h3>maaf materi belum diupload</h3>
                        </div>
                    <?php endif;?>
                </div>
                
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