<?php $this->load->view("_partials/header")?>
    
    <div class="wrapper" id="elementtoScrollToID">
        <div class="page-wrapper" id="">
            <div class="page-body">
                <div class="container-xl">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6">
                                <?php if(isset($nama)) :?>
                                    <div class="card shadow mb-4">
                                        <div class="card-body text-gray-900">
                                            <center>
                                                <img src="<?= base_url()?>/assets/static/logo.png?t=<?= time()?>" width=150 class="img-fluid mb-3" alt="">
                                            </center>
                                            <table>
                                                <tr>
                                                    <td><b>SK DIKNAS</b></td>
                                                    <td><b>: 421.9/578/418.20/2020</b></td>
                                                </tr>
                                                <tr>
                                                    <td>No. Sertifikat</td>
                                                    <td>: <?= date("Y/m/d/", strtotime($tgl_tes)) . $no_doc;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama </td>
                                                    <td>: <?= ucwords(strtolower($nama))?></td>
                                                </tr>
                                                <tr>
                                                    <td>Kelas</td>
                                                    
                                                    <?php
                                                        if($program == "TOEFL LISTENING") $kelas = "Listening";
                                                        else if($program == "TOEFL STRUCTURE") $kelas = "Structure";
                                                        else if($program == "TOEFL READING") $kelas = "Reading";
                                                    ?>

                                                    <td>: <?= $kelas?></td>
                                                </tr>
                                                <tr>
                                                    <td>Periode</td>
                                                    <td>: <?= tgl_indo($tgl_mulai)?></td>
                                                </tr>
                                                <tr>
                                                    <?php
                                                        if($program == "TOEFL LISTENING"){
                                                            $text_nilai = "Skor Listening";
                                                            $nilai_maksimal = poin_toefl('Listening', "50");
                                                        } 
                                                        else if($program == "TOEFL STRUCTURE"){
                                                            $text_nilai = "Skor Structure";
                                                            $nilai_maksimal = poin_toefl('Structure', "40");
                                                        } 
                                                        else if($program == "TOEFL READING"){
                                                            $text_nilai = "Skor Reading";
                                                            $nilai_maksimal = poin_toefl('Reading', "50");
                                                        } 
                                                    ?>
                                                    <td><?= $text_nilai?></td>
                                                    <td>: <?= $nilai?> / <?= $nilai_maksimal?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tgl. Tes</td>
                                                    <td>: <?= tgl_indo($tgl_tes)?></td>
                                                </tr>
                                            </table>
                                            <br>
                                            <p>Catatan: Skor diatas hanya <?= $text_nilai?> Section, dan bukan skor TOEFL secara keseluruhan. Sertifikat ini tidak bisa digunakan sebagai pengganti sertifikat TOEFL.</p>
                                            <p>Mau belajar kelas TOEFL lainnya? Daftar aja di <a href="http://toeflpare.com" target="_blank">toeflpare.com</a></p>
                                        </div>
                                    </div>
                                <?php else :?>
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-dark">Sertifikat Tidak Tersedia</i></h6>
                                        </div>
                                        <div class="card-body text-gray-900">
                                            <div class="alert alert-warning"><i class="fa fa-exclamation-circle text-warning mr-3"></i>Maaf Sertifikat Anda Tidak Ditemukan</div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view("_partials/footer")?>