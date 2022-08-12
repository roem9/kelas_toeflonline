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
                    <h2 class="page-title text-nowrap">
                        <?= $title?>
                    </h2>
                    </div>
                </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">

                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <!-- <span class="avatar avatar-xl mb-3 avatar-rounded" style="background-image: url(./assets/static/user.png)"></span> -->
                            <div class="m-0 mb-3" style="text-align: left"><?= tablerIcon("user", "me-2")?><?= $member['nama']?></div>
                            <div class="mb-3" style="text-align: left"><?= tablerIcon("phone", "me-2")?><?= $member['no_hp']?></div>
                            <div class="mb-3" style="text-align: left"><?= tablerIcon("gift", "me-2")?><?= $member['t4_lahir'] . ", " . tgl_indo($member['tgl_lahir'])?></div>
                            <div class="" style="text-align: left"><?= tablerIcon("map-pin", "me-2")?><?= $member['alamat']?></div>
                        </div>
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