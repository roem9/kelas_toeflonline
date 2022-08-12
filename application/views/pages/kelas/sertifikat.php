<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        @page :first {
            background-image: url("<?= base_url()?>assets/img/sertifikat.jpg");
            background-image-resize: 6;
        }

        .name {
            width: 700px;
            /* background-color: red; */
			position: absolute;
            left: 47px;
			top: 210px;
            font-size: 35px;
            word-spacing: 3px;
            font-family: 'Roboto', sans-serif;
        }

        .narasi {
            width: 700px;
            /* background-color: red; */
			position: absolute;
            left: 47px;
			top: 270px;
            font-size: 20px;
            font-family: arial;
            word-spacing: 3px;
        }

        .qrcode{
            width: 210px;
			position: absolute;
            right: 225px;
			bottom: 50px;
            font-size: 35px;
            word-spacing: 3px;
        }

        .periode-kelas {
			position: absolute;
            left: 412px;
			bottom: 174px;
            font-size: 12px;
            word-spacing: 3px;
            font-family: 'Roboto', sans-serif;
        }

        .test-date {
			position: absolute;
            left: 110px;
			bottom: 51px;
            font-size: 10px;
            word-spacing: 3px;
            font-family: 'Roboto', sans-serif;
        }

        .no-doc {
			position: absolute;
            left: 625px;
			top: 61px;
            font-size: 13px;
            word-spacing: 3px;
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>
    <div class="no-doc">
        <?= date("Y/m/d/", strtotime($tgl_tes)) . $no_doc;?>
    </div>
    <div class="name" style="text-align: center">
        <b><?= $nama?></b>
    </div>
    <div class="qrcode">
        <img src="<?= base_url()?>assets/qrcode/<?= $id?>.png" width=90 alt="">
    </div>
    <div class="periode-kelas">
        <b><?= tgl_sertifikat($tgl_mulai);?></b>
    </div>
    <div class="test-date">
        <?php if($tgl_tes != NULL) :?>
            <b><?= tgl_sertifikat($tgl_tes);?></b>
        <?php endif;?>
    </div>
    <div class="narasi" style="text-align: center">
        <?php if($program == "TOEFL LISTENING") :?>
            <p><b><i>TOEFL Listening Class</i></b></p>
            <p><b>Listening Score : <?= $nilai?></b></p>
        <?php elseif($program == "TOEFL STRUCTURE") :?>
            <p><b><i>TOEFL Structure Class</i></b></p>
            <p><b>Structure Score : <?= $nilai?></b></p>
        <?php elseif($program == "TOEFL READING") :?>
            <p><b><i>TOEFL Reading Class</i></b></p>
            <p><b>Reading Score : <?= $nilai?></b></p>
        <?php endif;?>
    </div>
</body>
</html>