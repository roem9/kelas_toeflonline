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
                    <h2 class="page-title"><?= $title?></h2>
                </div>
                <!-- Page title actions -->
                </div>
            </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <input type="search" name="search" class="form-control d-inline-block mb-3" placeholder="Cari kelas ..."/>
                    
                    <div id="dataAjax"></div>

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