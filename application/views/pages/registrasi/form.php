<?php $this->load->view("_partials/header-signin");?>

    <div class="page page-center">
        <div class="container-tight py-4">
            <form class="card card-md" action="<?= base_url()?>registrasi/add_member" method="post" autocomplete="off" id="formMember">

                <div class="card-body">
                    <div class="text-center mb-4">
                        <a href="javascript:void(0)"><img src="<?= base_url()?>assets/static/logo.png" height="90" alt=""></a>
                    </div>
                    <h2 class="card-title text-center mb-4">Form Registrasi Member</h2>

                    <?php if( $this->session->flashdata('pesan') ) : ?>
                        <div class="col-12">
                            <?=$this->session->flashdata('pesan')?>
                        </div>
                    <?php else :?>
                        <div class="form-floating mb-3">
                            <input type="text" name="nama" class="form form-control form-control-sm required">
                            <label class="col-form-label">Nama Member</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="t4_lahir" class="form form-control form-control-sm required">
                            <label class="col-form-label">Tempat Lahir</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" name="tgl_lahir" class="form form-control form-control-sm required">
                            <label class="col-form-label">Tanggal Lahir</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="alamat" class="form form-control required" style="height: 100px"></textarea>
                            <label for="" class="col-form-label">Alamat</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="no_hp" class="form form-control form-control-sm required number">
                            <label class="col-form-label">No WA</label>
                            <small class="text-danger">* Harap mengisi nomor whatsapp dengan kode negara, contoh : 6281xxxxx</small>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="email" class="form form-control form-control-sm">
                            <label class="col-form-label">Email</label>
                            <small class="text-danger">* email tidak wajib diisi</small>
                        </div>
                        <div class="mb-3" id="listProgram">
                            <label class="form-label">Pilih Program Yang Diambil</label>
                            <div class="form-floating mb-3">
                                <select name="program[]" class="form form-control required">
                                    <option value="">Pilih Program</option>
                                    <?= listProgram()?>
                                </select>
                                <label for="">Program 1</label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mb-3">
                            <span>
                                <button type="button" class="btn btn-sm btn-danger btnRemoveProgram me-3">
                                    <svg width="24" height="24">
                                        <use xlink:href="<?= base_url()?>assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-circle-minus" />
                                    </svg>
                                </button>
                            </span>
                            <span>
                                <button type="button" class="btn btn-sm btn-success btnAddProgram">
                                    <svg width="24" height="24">
                                        <use xlink:href="<?= base_url()?>assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-circle-plus" />
                                    </svg>
                                </button>
                            </span>
                        </div>
                        <div class="form-footer">
                            <button type="button" class="btn btn-primary w-100 btnSimpan">Simpan</button>
                        </div>
                    <?php endif; ?>

                </div>
            </form>
        </div>
    </div>
    
    
    <?php  
        if(isset($js)) :
            foreach ($js as $i => $js) :?>
                <script src="<?= base_url()?>assets/myjs/<?= $js?>"></script>
                <?php 
            endforeach;
        endif;    
    ?>

    <script>
        $(".btnSimpan").click(function(){
            let form = "#formMember";
            let formData = {};
            $(form+" .form").each(function(index){
                formData = Object.assign(formData, {[$(this).attr("name")]: $(this).val()})
            })

            let eror = required(form);
            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                Swal.fire({
                    icon: 'question',
                    html: 'Yakin akan menyimpan data Anda?',
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then(function (result) {
                    if (result.value) {
                        
                        swal.fire({
                            html: '<h4>Menyimpan Data Anda ...</h4>',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                        });

                        $(form).submit();
                    }
                })
            }
        })

        i = 1;

        $(document).on("click", ".btnRemoveProgram", function() {
            if(i >= 2) {
                i--;
                $('#listProgram').children().last().remove();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oopss...",
                    text: "Pilihan minimal adalah 1"
                })
            }
        })

        $(document).on("click", ".btnAddProgram", function() {
            i++;

            html = `
                <div class="form-floating mb-3" id="program`+i+`">
                    <select name="program[]" class="form form-control required">
                        <option value="">Pilih Program</option>
                        <?= listProgram()?>
                    </select>
                    <label for="">Program `+i+`</label>
                </div>`;
            $("#listProgram").append(html);
        })
    </script>

<?php $this->load->view("_partials/footer-signin");?>