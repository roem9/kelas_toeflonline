<?php $this->load->view("_partials/header")?>
    <div class="sticky-top">
        <?php $this->load->view("_partials/navbar-header")?>
        <?php $this->load->view("_partials/navbar")?>
    </div>
    cek
    
    <?php  
        if(isset($js)) :
            foreach ($js as $i => $js) :?>
                <script src="<?= base_url()?>assets/myjs/<?= $js?>"></script>
                <?php 
            endforeach;
        endif;    
    ?>

    <script>
        $("#<?= $menu?>").addClass("active");
    </script>

<?php $this->load->view("_partials/footer")?>