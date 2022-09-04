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
                    <center><h3><?= $title?></h3></center>
                </div>
                <!-- Page title actions -->
                </div>
            </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    
                    <div class="row g-2 mb-3">
                        <input type="hidden" name="tabel" value="member">
                        <input type="hidden" name="id_member" value="<?= $member['id_member']?>">
                        <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas']?>">

                        <div class="col">
                            <textarea name="text" id="text" class="form-control" data-bs-toggle="autosize" placeholder="Type something…" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 55.9886px;"></textarea>
                        </div>
                        <div class="col-auto">
                            <a href="javascript:void(0)" class="btn btn-white btn-icon btnSendMessage" aria-label="Button">
                            <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                <?= tablerIcon("send")?>
                            </a>
                        </div>
                    </div>

                    <div id="dataAjax"></div>

                    <a href="<?= $member['link_back']?>" class="float bg-success" data-toggle="tooltip" data-placement="top" title="Ruang Diskusi">
                        <?= iconFloat("notebook");?>
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