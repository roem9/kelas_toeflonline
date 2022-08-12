<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends MY_Controller {
    
    public function index(){
        $id_member = $this->session->userdata("id_member");
        $data['title'] = "Kelas";
        $data['menu'] = "Kelas";

        $data['js'] = [
            "ajax.js",
            "function.js",
            "helper.js",
            "load_data/kelas_reload.js",
            "modules/kelas.js",
        ];

        $this->load->view("pages/kelas/list-kelas", $data);
    }

    public function id($id_kelas){
        $data = $this->kelas->id($id_kelas);

        $data['js'] = [
            "ajax.js",
            "function.js",
            "helper.js",
            "modules/kelas.js",
        ];

        $this->load->view("pages/kelas/list-pertemuan", $data);
    }

    public function pertemuan($id_kelas, $id_pertemuan){
        $id_member = $this->session->userdata("id_member");

        $kelas = $this->kelas->get_one("kelas", ["md5(id_kelas)" => $id_kelas]);
        $pertemuan = $this->kelas->get_one("pertemuan", ["md5(id_pertemuan)" => $id_pertemuan]);

        $data['materi'] = $this->kelas->get_all("materi_pertemuan", ["id_pertemuan" => $pertemuan['id_pertemuan'], "item !=" => "video pembahasan"]);
        $data['pembahasan'] = $this->kelas->get_all("materi_pertemuan", ["id_pertemuan" => $pertemuan['id_pertemuan'], "item" => "video pembahasan"]);
        $data['menu'] = "kelas";
        $data['title'] = "{$kelas['nama_kelas']} <br> {$pertemuan['nama_pertemuan']} ";

        $data['kelas'] = $kelas;
        $data['pertemuan'] = $pertemuan;
        $data['pertemuan_kelas'] = $this->kelas->get_one("pertemuan_kelas_member", ["md5(id_kelas)" => $id_kelas, "md5(id_pertemuan)" => $id_pertemuan, "id_member" => $id_member]);

        $data['folder_admin'] = $this->kelas->get_one("config", ["field" => "folder_admin"]);
        

        $data['js'] = [
            "ajax.js",
            "function.js",
            "helper.js",
        ];

        $this->load->view("pages/kelas/list-materi", $data);
        // var_dump($kelas, $pertemuan);
    }

    public function latihan($id_kelas, $id_pertemuan){
        ini_set('xdebug.var_display_max_depth', 10);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);

        $data['js'] = [
            "ajax.js",
            "function.js",
            "helper.js"
        ];

        $pertemuan = $this->kelas->get_one("pertemuan", ["md5(id_pertemuan)" => $id_pertemuan]);
        $kelas = $this->kelas->get_one("kelas", ["md5(id_kelas)" => $id_kelas]);

        $data['title'] = "Latihan {$kelas['program']} <br> {$pertemuan['nama_pertemuan']}";
        $data['kelas'] = $kelas;
        $data['pertemuan'] = $pertemuan;

        $data['folder_admin'] = $this->kelas->get_one("config", ["field" => "folder_admin"]);
        $id_member = $this->session->userdata("id_member");
        
        // latihan koreksi otomatis 
        if($pertemuan['latihan'] == "Koreksi Otomatis"){
            $jawaban = $this->kelas->get_one("latihan_member", ["md5(id_kelas)" => $id_kelas, "md5(id_pertemuan)" => $id_pertemuan, "id_member" => $id_member]);
            if(!empty($jawaban) && $pertemuan['perulangan'] == "Sekali"){
                $number = 1;
                $string = trim(preg_replace('/\s+/', ' ', $jawaban['data']));
                $data_soal = json_decode($string, true);
                foreach ($data_soal as $j => $soal) {
                    if($soal['item'] == "soal"){
                        $no = $number.". ";
                        $soal['data']['soal'] = str_replace("{no}", $no, $soal['data']['soal']);
    
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $soal['data']['soal'];
                        $data['soal'][$j]['data']['pilihan'] = $soal['data']['pilihan'];
                        $data['soal'][$j]['data']['jawaban'] = $soal['data']['jawaban'];
                        $data['soal'][$j]['data']['status'] = $soal['data']['status'];
                        $data['soal'][$j]['data']['key'] = $soal['data']['key'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
            
                    } else if($soal['item'] == "soal esai"){
                        $no = $number.". ";
                        $soal['data']['soal'] = str_replace("{no}", $no, $soal['data']['soal']);
    
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $soal['data']['soal'];
                        $data['soal'][$j]['data']['jawaban'] = $soal['data']['jawaban'];
                        $data['soal'][$j]['data']['status'] = $soal['data']['status'];
                        $data['soal'][$j]['data']['key'] = $soal['data']['key'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
    
                    } else if($soal['item'] == "petunjuk" || $soal['item'] == "audio" || $soal['item'] == "gambar"){
                        $data['soal'][$j] = $soal;
                    }
                }

                $data['jawaban'] = $jawaban;
                $data['pertemuan'] = $this->kelas->get_one("pertemuan", ["md5(id_pertemuan)" => $id_pertemuan]);
                $data['kelas'] = $this->kelas->get_one("kelas", ["md5(id_kelas)" => $id_kelas]);

                $this->load->view("pages/latihan/koreksi-otomatis-pembahasan-sekali", $data);
            } else if($pertemuan['pembahasan'] == "Ya" && $this->session->flashdata("pesan")){
                $number = 1;
                $string = trim(preg_replace('/\s+/', ' ', $jawaban['data']));
                $data_soal = json_decode($string, true);
                foreach ($data_soal as $j => $soal) {
                    if($soal['item'] == "soal"){
                        $no = $number.". ";
                        $soal['data']['soal'] = str_replace("{no}", $no, $soal['data']['soal']);
    
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $soal['data']['soal'];
                        $data['soal'][$j]['data']['pilihan'] = $soal['data']['pilihan'];
                        $data['soal'][$j]['data']['jawaban'] = $soal['data']['jawaban'];
                        $data['soal'][$j]['data']['status'] = $soal['data']['status'];
                        $data['soal'][$j]['data']['key'] = $soal['data']['key'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
            
                    } else if($soal['item'] == "soal esai"){
                        $no = $number.". ";
                        $soal['data']['soal'] = str_replace("{no}", $no, $soal['data']['soal']);
    
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $soal['data']['soal'];
                        $data['soal'][$j]['data']['jawaban'] = $soal['data']['jawaban'];
                        $data['soal'][$j]['data']['status'] = $soal['data']['status'];
                        $data['soal'][$j]['data']['key'] = $soal['data']['key'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
    
                    } else if($soal['item'] == "petunjuk" || $soal['item'] == "audio" || $soal['item'] == "gambar"){
                        $data['soal'][$j] = $soal;
                    }
                }

                $data['jawaban'] = $jawaban;
                $data['pertemuan'] = $this->kelas->get_one("pertemuan", ["md5(id_pertemuan)" => $id_pertemuan]);
                $data['kelas'] = $this->kelas->get_one("kelas", ["md5(id_kelas)" => $id_kelas]);

                $this->load->view("pages/latihan/koreksi-otomatis-pembahasan", $data);
            } else {
                $soal = $this->kelas->get_all("latihan_pertemuan", ["md5(id_pertemuan)" => $id_pertemuan], "urutan", "asc");
                $number = 1;
                foreach ($soal as $j => $soal) {
                    if($soal['item'] == "soal"){
                        // from json to array 
                        $string = trim(preg_replace('/\s+/', ' ', $soal['data']));
                        $txt_soal = json_decode($string, true );

                        $no = $number.". ";
                        $txt_soal['soal'] = str_replace("{no}", $no, $txt_soal['soal']);
            
                        $data['soal'][$j]['id_item'] = $soal['id_item'];
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $txt_soal['soal'];
                        $data['soal'][$j]['data']['pilihan'] = $txt_soal['pilihan'];
                        $data['soal'][$j]['data']['jawaban'] = $txt_soal['jawaban'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
            
                    } else if($soal['item'] == "soal esai"){
                        // from json to array 
                        $string = trim(preg_replace('/\s+/', ' ', $soal['data']));
                        $txt_soal = json_decode($string, true );
                        
                        $no = $number.". ";
                        $txt_soal['soal'] = str_replace("{no}", $no, $txt_soal['soal']);
    
                        $data['soal'][$j]['id_item'] = $soal['id_item'];
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $txt_soal['soal'];
                        $data['soal'][$j]['data']['jawaban'] = $txt_soal['jawaban'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
    
                    } else if($soal['item'] == "petunjuk" || $soal['item'] == "audio" || $soal['item'] == "gambar"){
                        $data['soal'][$j] = $soal;
                    }
                }
                $this->load->view("pages/latihan/koreksi-otomatis", $data);
            }
        } else if($pertemuan['latihan'] == "Latihan Kosa Kata"){
            if($pertemuan['pembahasan'] == "Ya" && $this->session->userdata("pesan")){
                    $jawaban = $this->kelas->get_one("latihan_member", ["md5(id_kelas)" => $id_kelas, "md5(id_pertemuan)" => $id_pertemuan, "id_member" => $id_member]);
                    $string = trim(preg_replace('/\s+/', ' ', $jawaban['data']));
                    $data_soal = json_decode($string, true);
                    foreach ($data_soal as $i => $soal) {
                        $data['soal'][$i]['data']['soal'] = $soal['data']['soal'];
                        $data['soal'][$i]['data']['pilihan'] = $soal['data']['pilihan'];
                        $data['soal'][$i]['data']['jawaban'] = $soal['data']['jawaban'];
                        $data['soal'][$i]['data']['key'] = $soal['data']['key'];
                        $data['soal'][$i]['data']['status'] = $soal['data']['status'];
                        $data['soal'][$i]['penulisan'] = $soal['penulisan'];
                        $data['soal'][$i]['bahasa'] = $soal['bahasa'];
                    }
                
                $this->load->view("pages/latihan/kosakata-pembahasan", $data);
            } else {
                $soal = $this->kelas->get_all("latihan_pertemuan", ["md5(id_pertemuan)" => $id_pertemuan], "urutan", "asc");
                shuffle($soal);
    
                $pilihan_indo = [];
                $pilihan_asing = [];
                
                if(COUNT($soal) >= $pertemuan['jumlah_soal']){
                    $loop = $pertemuan['jumlah_soal'];
                } else {
                    $loop = COUNT($soal);
                }
    
                for ($i=0; $i < $loop; $i++) { 
                    $string = trim(preg_replace('/\s+/', ' ', $soal[$i]['data']));
                    $txt_soal = json_decode($string, true );
                    array_push($pilihan_indo, $txt_soal['kata_indo']);
                    array_push($pilihan_asing, $txt_soal['kata_asing']);
                }
    
                for ($i=0; $i < $loop; $i++) { 
                    $string = trim(preg_replace('/\s+/', ' ', $soal[$i]['data']));
                    $txt_soal = json_decode($string, true );
                    $number = $i + 1;
                    $no = $number.". ";
                    
                    if($i % 2 == 0){
                        $data_pilihan = $pilihan_asing;
                        shuffle($data_pilihan);
    
                        foreach (array_keys($data_pilihan, $txt_soal['kata_asing'], true) as $key) {
                            unset($data_pilihan[$key]);
                        }
    
                        $data_pilihan = array_values($data_pilihan);
                        $array_pilihan = [$txt_soal['kata_asing'], $data_pilihan[0], $data_pilihan[1], $data_pilihan[2]];
                        shuffle($array_pilihan);
    
                        $data['soal'][$i]['data']['bahasa'] = "Indonesia";
                        $data['soal'][$i]['data']['soal'] = $no."{$pertemuan['text_soal_indo']} &quot;".$txt_soal['kata_indo']."&quot;";
                        $data['soal'][$i]['data']['pilihan'] = $array_pilihan;
                        $data['soal'][$i]['data']['jawaban'] = $txt_soal['kata_asing'];
                        $data['soal'][$i]['penulisan'] = $soal[$i]['penulisan'];
                        $data['soal'][$i]['soal'] = htmlspecialchars('{"bahasa":"'.$data['soal'][$i]['data']['bahasa'].'","penulisan":"'.$soal[$i]["penulisan"].'","data":{"soal":"'.$data['soal'][$i]['data']['soal'].'","pilihan":["'.$array_pilihan[0].'","'.$array_pilihan[1].'","'.$array_pilihan[2].'","'.$array_pilihan[3].'"],"jawaban":"'.$data['soal'][$i]['data']['jawaban'].'",');
                    } else {
                        $data_pilihan = $pilihan_indo;
                        shuffle($data_pilihan);
    
                        foreach (array_keys($data_pilihan, $txt_soal['kata_indo'], true) as $key) {
                            unset($data_pilihan[$key]);
                        }
    
                        $data_pilihan = array_values($data_pilihan);
                        $array_pilihan = [$txt_soal['kata_indo'], $data_pilihan[0], $data_pilihan[1], $data_pilihan[2]];
                        shuffle($array_pilihan);
    
                        $data['soal'][$i]['data']['bahasa'] = "Asing";
                        $data['soal'][$i]['data']['soal'] = $no."{$pertemuan['text_soal_asing']} &quot;".$txt_soal['kata_asing']."&quot;";
                        $data['soal'][$i]['data']['pilihan'] = $array_pilihan;
                        $data['soal'][$i]['data']['jawaban'] = $txt_soal['kata_indo'];
                        $data['soal'][$i]['penulisan'] = $soal[$i]['penulisan'];
                        $data['soal'][$i]['soal'] = htmlspecialchars('{"bahasa":"'.$data['soal'][$i]['data']['bahasa'].'","penulisan":"'.$soal[$i]["penulisan"].'","data":{"soal":"'.$data['soal'][$i]['data']['soal'].'","pilihan":["'.$array_pilihan[0].'","'.$array_pilihan[1].'","'.$array_pilihan[2].'","'.$array_pilihan[3].'"],"jawaban":"'.$data['soal'][$i]['data']['jawaban'].'",');
                    }
                }
                $this->load->view("pages/latihan/kosakata", $data);
            }
        } else if($pertemuan['latihan'] == "Koreksi Manual"){
            $data['btn_save'] = true;
            $soal = $this->kelas->get_all("latihan_pertemuan", ["md5(id_pertemuan)" => $id_pertemuan], "urutan", "asc");
            $number = 1;
            foreach ($soal as $j => $soal) {
                if($soal['item'] == "soal"){
                    // from json to array 
                    $string = trim(preg_replace('/\s+/', ' ', $soal['data']));
                    $txt_soal = json_decode($string, true );

                    $no = $number.". ";
                    $txt_soal['soal'] = str_replace("{no}", $no, $txt_soal['soal']);
        
                    $data['soal'][$j]['id_item'] = $soal['id_item'];
                    $data['soal'][$j]['item'] = $soal['item'];
                    $data['soal'][$j]['data']['soal'] = $txt_soal['soal'];
                    $data['soal'][$j]['data']['pilihan'] = $txt_soal['pilihan'];
                    $data['soal'][$j]['data']['jawaban'] = $txt_soal['jawaban'];
                    $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                    
                    $number++;
        
                } else if($soal['item'] == "soal esai"){
                    // from json to array 
                    $string = trim(preg_replace('/\s+/', ' ', $soal['data']));
                    $txt_soal = json_decode($string, true );
                    
                    $no = $number.". ";
                    $txt_soal['soal'] = str_replace("{no}", $no, $txt_soal['soal']);

                    $data['soal'][$j]['id_item'] = $soal['id_item'];
                    $data['soal'][$j]['item'] = $soal['item'];
                    $data['soal'][$j]['data']['soal'] = $txt_soal['soal'];
                    $data['soal'][$j]['data']['jawaban'] = $txt_soal['jawaban'];
                    $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                    
                    $number++;

                } else if($soal['item'] == "petunjuk" || $soal['item'] == "audio" || $soal['item'] == "gambar"){
                    $data['soal'][$j]['id_item'] = $soal['id_item'];
                    $data['soal'][$j] = $soal;
                }
            }

            // $data['periksa']['text'] = "";
            // $data['periksa']['status'] = "";
            $jawaban = $this->kelas->get_one("latihan_member", ["md5(id_kelas)" => $id_kelas, "md5(id_pertemuan)" => $id_pertemuan, "id_member" => $id_member]);
            $data['readonly'] = "";

            if($jawaban){
                $data['latihan'] = $jawaban;
                $string = trim(preg_replace('/\s+/', ' ', $jawaban['data']));
                $data_soal = json_decode($string, true);
                $data['jawaban'] = $data_soal;
                // var_dump($data['jawaban']);
                // exit();
                if($jawaban['periksa'] == "mengisi") {
                    $data['periksa']['status'] = "mengisi";
                    $data['periksa']['text'] = "tekan tombol &quot;kumpulkan jawaban&quot; untuk mengumpulkan jawaban Kamu";
                } else if($jawaban['periksa'] == "mengumpul"){
                    $data['readonly'] = "readonly";
                    unset($data['btn_save']);
                    $data['periksa']['status'] = "mengumpul";
                    $data['periksa']['text'] = "Kamu telah mengumpulkan jawaban. Jawaban Kamu akan segera diperiksa. Jika ingin mengubah jawaban silakan tekan tombol &quot;edit jawaban&quot;";
                } else if($jawaban['periksa'] == "memeriksa"){
                    $data['readonly'] = "readonly";
                    unset($data['btn_save']);
                    $data['periksa']['status'] = "memeriksa";
                    $data['periksa']['text'] = "Jawaban Kamu sedang diperiksa";
                } else if($jawaban['periksa'] == "selesai"){
                    $data['readonly'] = "readonly";
                    unset($data['btn_save']);
                    $data['periksa']['status'] = "selesai";
                    $data['periksa']['text'] = "";
                }
            } else {
                $data['periksa']['status'] = "mengisi";
                $data['periksa']['text'] = "tekan tombol &quot;kumpulkan jawaban&quot; untuk mengumpulkan jawaban Kamu";
            }

            if($data['periksa']['status'] == "selesai"){
                $this->load->view("pages/latihan/koreksi-manual-pembahasan", $data);
            } else {
                $this->load->view("pages/latihan/koreksi-manual", $data);
            }
        } else if($pertemuan['latihan'] == "Pre / Mid Test Listening" || $pertemuan['latihan'] == "Post Test Listening" || $pertemuan['latihan'] == "Pre / Mid Test Structure" || $pertemuan['latihan'] == "Post Test Structure" || $pertemuan['latihan'] == "Pre / Mid Test Reading" || $pertemuan['latihan'] == "Post Test Reading"){
            $jawaban = $this->kelas->get_one("latihan_member", ["md5(id_kelas)" => $id_kelas, "md5(id_pertemuan)" => $id_pertemuan, "id_member" => $id_member]);
            if(!empty($jawaban) && $pertemuan['perulangan'] == "Sekali"){
                $number = 1;
                $string = trim(preg_replace('/\s+/', ' ', $jawaban['data']));
                $data_soal = json_decode($string, true);
                foreach ($data_soal as $j => $soal) {
                    if($soal['item'] == "soal"){
                        $no = $number.". ";
                        $soal['data']['soal'] = str_replace("{no}", $no, $soal['data']['soal']);
    
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $soal['data']['soal'];
                        $data['soal'][$j]['data']['pilihan'] = $soal['data']['pilihan'];
                        $data['soal'][$j]['data']['jawaban'] = $soal['data']['jawaban'];
                        $data['soal'][$j]['data']['status'] = $soal['data']['status'];
                        $data['soal'][$j]['data']['key'] = $soal['data']['key'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
            
                    } else if($soal['item'] == "soal esai"){
                        $no = $number.". ";
                        $soal['data']['soal'] = str_replace("{no}", $no, $soal['data']['soal']);
    
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $soal['data']['soal'];
                        $data['soal'][$j]['data']['jawaban'] = $soal['data']['jawaban'];
                        $data['soal'][$j]['data']['status'] = $soal['data']['status'];
                        $data['soal'][$j]['data']['key'] = $soal['data']['key'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
    
                    } else if($soal['item'] == "petunjuk" || $soal['item'] == "audio" || $soal['item'] == "gambar"){
                        $data['soal'][$j] = $soal;
                    }
                }

                $data['jawaban'] = $jawaban;
                $data['pertemuan'] = $this->kelas->get_one("pertemuan", ["md5(id_pertemuan)" => $id_pertemuan]);
                $data['kelas'] = $this->kelas->get_one("kelas", ["md5(id_kelas)" => $id_kelas]);

                $this->load->view("pages/latihan/koreksi-test-pembahasan-sekali", $data);
            } else if($pertemuan['pembahasan'] == "Ya" && $this->session->flashdata("pesan")){
                $number = 1;
                $string = trim(preg_replace('/\s+/', ' ', $jawaban['data']));
                $data_soal = json_decode($string, true);
                foreach ($data_soal as $j => $soal) {
                    if($soal['item'] == "soal"){
                        $no = $number.". ";
                        $soal['data']['soal'] = str_replace("{no}", $no, $soal['data']['soal']);
    
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $soal['data']['soal'];
                        $data['soal'][$j]['data']['pilihan'] = $soal['data']['pilihan'];
                        $data['soal'][$j]['data']['jawaban'] = $soal['data']['jawaban'];
                        $data['soal'][$j]['data']['status'] = $soal['data']['status'];
                        $data['soal'][$j]['data']['key'] = $soal['data']['key'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
            
                    } else if($soal['item'] == "soal esai"){
                        $no = $number.". ";
                        $soal['data']['soal'] = str_replace("{no}", $no, $soal['data']['soal']);
    
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $soal['data']['soal'];
                        $data['soal'][$j]['data']['jawaban'] = $soal['data']['jawaban'];
                        $data['soal'][$j]['data']['status'] = $soal['data']['status'];
                        $data['soal'][$j]['data']['key'] = $soal['data']['key'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
    
                    } else if($soal['item'] == "petunjuk" || $soal['item'] == "audio" || $soal['item'] == "gambar"){
                        $data['soal'][$j] = $soal;
                    }
                }

                $data['jawaban'] = $jawaban;
                $data['pertemuan'] = $this->kelas->get_one("pertemuan", ["md5(id_pertemuan)" => $id_pertemuan]);
                $data['kelas'] = $this->kelas->get_one("kelas", ["md5(id_kelas)" => $id_kelas]);

                $this->load->view("pages/latihan/koreksi-test-pembahasan-sekali", $data);
            } else {
                $soal = $this->kelas->get_all("latihan_pertemuan", ["md5(id_pertemuan)" => $id_pertemuan], "urutan", "asc");
                $number = 1;
                foreach ($soal as $j => $soal) {
                    if($soal['item'] == "soal"){
                        // from json to array 
                        $string = trim(preg_replace('/\s+/', ' ', $soal['data']));
                        $txt_soal = json_decode($string, true );

                        $no = $number.". ";
                        $txt_soal['soal'] = str_replace("{no}", $no, $txt_soal['soal']);
            
                        $data['soal'][$j]['id_item'] = $soal['id_item'];
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $txt_soal['soal'];
                        $data['soal'][$j]['data']['pilihan'] = $txt_soal['pilihan'];
                        $data['soal'][$j]['data']['jawaban'] = $txt_soal['jawaban'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
            
                    } else if($soal['item'] == "soal esai"){
                        // from json to array 
                        $string = trim(preg_replace('/\s+/', ' ', $soal['data']));
                        $txt_soal = json_decode($string, true );
                        
                        $no = $number.". ";
                        $txt_soal['soal'] = str_replace("{no}", $no, $txt_soal['soal']);
    
                        $data['soal'][$j]['id_item'] = $soal['id_item'];
                        $data['soal'][$j]['item'] = $soal['item'];
                        $data['soal'][$j]['data']['soal'] = $txt_soal['soal'];
                        $data['soal'][$j]['data']['jawaban'] = $txt_soal['jawaban'];
                        $data['soal'][$j]['penulisan'] = $soal['penulisan'];
                        
                        $number++;
    
                    } else if($soal['item'] == "petunjuk" || $soal['item'] == "audio" || $soal['item'] == "gambar"){
                        $data['soal'][$j] = $soal;
                    }
                }
                $this->load->view("pages/latihan/koreksi-test", $data);
            }
        }
    }

    public function get_all_kelas(){
        $data = $this->kelas->get_all_kelas();
        echo json_encode($data);
    }

    public function add_jawaban_test(){
        $id_pertemuan = $this->input->post("id_pertemuan");
        $id_kelas = $this->input->post("id_kelas");
        $id_member = $this->session->userdata("id_member");
        $jawaban = $this->input->post("jawaban");
        $pertemuan = $this->kelas->get_one("pertemuan", ["id_pertemuan" => $id_pertemuan]);
        $kelas = $this->kelas->get_one("kelas", ["id_kelas" => $id_kelas]);

        $latihan = $this->kelas->get_one("latihan_member", ["id_pertemuan" => $id_pertemuan, "id_kelas" => $id_kelas, "id_member" => $id_member]);

        $benar = 0;
        $salah = 0;

        $data_soal = "";
        $text = "";

        // $soal = $this->kelas->get_all("latihan_pertemuan", ["id_pertemuan" => $id_pertemuan, "item = 'soal' OR item = 'soal esai'"], 'urutan');
        $soal = $this->kelas->get_all("latihan_pertemuan", ["id_pertemuan" => $id_pertemuan], 'urutan');

        $index = 0;
        foreach ($soal as $j => $soal) {
            if($soal['item'] == "soal" || $soal['item'] == "soal esai"){
                $string = trim(preg_replace('/\s+/', ' ', $soal['data']));
                $txt_soal = json_decode($string, true );

                $jawaban_soal = $txt_soal['jawaban'];
                if($soal['item'] == "soal"){
                    if($jawaban_soal == $jawaban[$index]){
                        $status = "benar";
                        $benar++;
                    } else {
                        $status = "salah";
                        $salah++;
                    }
                    
                    $no = $j+1;
                    $pilihan = "[";
                    foreach ($txt_soal['pilihan'] as $value) {
                        $pilihan .= "\"{$value}\",";
                    }
                    $pilihan = substr($pilihan, 0, -1);
                    $pilihan .= "]";

                    $text .= '{"item":"'.$soal['item'].'","penulisan":"'.$soal['penulisan'].'","urutan":"'.$soal['urutan'].'","data":{"no":"'.$no.'","soal":"'.$txt_soal['soal'].'","pilihan":'.$pilihan.',"jawaban":"'.$txt_soal['jawaban'].'","key":"'.$jawaban[$index].'","status":"'.$status.'"}},';
                } else if($soal['item'] == "soal esai"){
                    if(trim(preg_replace('/\s+/', ' ', strtolower($jawaban_soal))) == trim(preg_replace('/\s+/', ' ', strtolower($jawaban[$index])))){
                        $status = "benar";
                        $benar++;
                    } else {
                        $status = "salah";
                        $salah++;
                    }
                    $text .= '{"item":"'.$soal['item'].'","penulisan":"'.$soal['penulisan'].'","urutan":"'.$soal['urutan'].'","data":{"no":"'.$no.'","soal":"'.$txt_soal['soal'].'","jawaban":"'.$txt_soal['jawaban'].'","key":"'.$jawaban[$index].'","status":"'.$status.'"}},';
                }

                $index++;

            } else {
                $text .= '{"item":"'.$soal['item'].'","penulisan":"'.$soal['penulisan'].'","urutan":"'.$soal['urutan'].'","data":"'.$soal['data'].'"},';
            }
        }

        $text = substr($text, 0, -1);
        $text = '['.$text.']';

        // nilai toefl sesuai sesi 
        if($pertemuan['latihan'] == "Pre / Mid Test Listening" || $pertemuan['latihan'] == "Post Test Listening"){
            $poin = poin_toefl("Listening", $benar);
        } else if($pertemuan['latihan'] == "Pre / Mid Test Structure" || $pertemuan['latihan'] == "Post Test Structure"){
            $poin = poin_toefl("Structure", $benar);
        } else if($pertemuan['latihan'] == "Pre / Mid Test Reading" || $pertemuan['latihan'] == "Post Test Reading"){
            $poin = poin_toefl("Reading", $benar);
        }

        if($latihan) {
            if($latihan['nilai'] < $poin){
                $data = [
                    "data" => $text,
                    "nilai" => $poin,
                    "periksa" => 0
                ];
            } else {
                $data['data'] = $text;
            }

            $this->kelas->edit_data("latihan_member", ["id" => $latihan['id']], $data);

            // jika post test maka ubah tambahkan sertifikat dan nilainya
            if($pertemuan['latihan'] == "Post Test Listening" || $pertemuan['latihan'] == "Post Test Structure" || $pertemuan['latihan'] == "Post Test Reading"){
                $sertifikat = [
                    "nilai" => $poin,
                    "sertifikat" => 1,
                    "no_doc" => no_doc(),
                    "tgl_tes" => date("Y-m-d")
                ];
    
                $this->kelas->edit_data("kelas_member", ["id_kelas" => $id_kelas, "id_member" => $id_member], $sertifikat);
            }
        } else{
            $data = [
                "id_kelas" => $id_kelas,
                "id_pertemuan" => $id_pertemuan,
                "id_member" => $id_member,
                "data" => $text,
                "nilai" => $poin,
                "periksa" => 0,
            ];
    
            $this->kelas->add_data("latihan_member", $data);

            // jika post test maka ubah tambahkan sertifikat dan nilainya
            if($pertemuan['latihan'] == "Post Test Listening" || $pertemuan['latihan'] == "Post Test Structure" || $pertemuan['latihan'] == "Post Test Reading"){
                $sertifikat = [
                    "nilai" => $poin,
                    "sertifikat" => 1,
                    "no_doc" => no_doc(),
                    "tgl_tes" => date("Y-m-d")
                ];
    
                $this->kelas->edit_data("kelas_member", ["id_kelas" => $id_kelas, "id_member" => $id_member], $sertifikat);
            }
        }

        // poin maksimal 
        if($pertemuan['latihan'] == "Pre / Mid Test Listening" || $pertemuan['latihan'] == "Post Test Listening"){
            $poin_maksimal = poin_toefl("Listening", jumlah_soal($pertemuan['id_pertemuan']));
        } else if($pertemuan['latihan'] == "Pre / Mid Test Structure" || $pertemuan['latihan'] == "Post Test Structure"){
            $poin_maksimal = poin_toefl("Structure", jumlah_soal($pertemuan['id_pertemuan']));
        } else if($pertemuan['latihan'] == "Pre / Mid Test Reading" || $pertemuan['latihan'] == "Post Test Reading"){
            $poin_maksimal = poin_toefl("Reading", jumlah_soal($pertemuan['id_pertemuan']));
        }

        if($pertemuan['pembahasan'] == "Ya"){
            $msg = "
                <h2 class='text-center'>&#128079 SELAMAT &#128079</h2>
                <p class='text-center'>Kamu Telah Berhasil Menyelesaikan <br>&quot;Latihan {$pertemuan['nama_pertemuan']}&quot; <br>Kelas {$kelas['nama_kelas']}</p>
                <p class='text-center'>
                    Nilai Kamu Adalah : <br>
                    <span class='text-center' style='font-size: 5em;'><b>{$poin} / ".$poin_maksimal."</b></span>
                </p>
                <div class='d-flex justify-content-between'>
                    <a href='".base_url()."kelas/latihan/".md5($kelas['id_kelas'])."/".md5($pertemuan['id_pertemuan'])."' class='btn btn-warning'>".tablerIcon('repeat', 'me-1')." ulangi</a>
                    <a href='javascript:void(0)' class='btn btn-success btnPembahasan'>pembahasan".tablerIcon('chevrons-right')."</a>
                </div>
            ";
        } else {
            $msg = "
                <h2 class='text-center'>&#128079 SELAMAT &#128079</h2>
                <p class='text-center'>Kamu Telah Berhasil Menyelesaikan <br>&quot;Latihan {$pertemuan['nama_pertemuan']}&quot; <br>Kelas {$kelas['nama_kelas']}</p>
                <p class='text-center'>
                    Nilai Kamu Adalah : <br>
                    <span class='text-center' style='font-size: 5em;'><b>{$poin} / ".$poin_maksimal."</b></span>
                </p>
                <div class='d-flex justify-content-center'>
                    <a href='".base_url()."kelas/latihan/".md5($kelas['id_kelas'])."/".md5($pertemuan['id_pertemuan'])."' class='btn btn-warning'>".tablerIcon('repeat', 'me-1')." ulangi</a>
                </div>
            ";
        }

        $this->session->set_flashdata('pesan', $msg);
        
        redirect(base_url("kelas/latihan/".md5($id_kelas)."/".md5($id_pertemuan)));
    }

    public function add_jawaban_otomatis(){
        $id_pertemuan = $this->input->post("id_pertemuan");
        $id_kelas = $this->input->post("id_kelas");
        $id_member = $this->session->userdata("id_member");
        $jawaban = $this->input->post("jawaban");
        $pertemuan = $this->kelas->get_one("pertemuan", ["id_pertemuan" => $id_pertemuan]);
        $kelas = $this->kelas->get_one("kelas", ["id_kelas" => $id_kelas]);

        $latihan = $this->kelas->get_one("latihan_member", ["id_pertemuan" => $id_pertemuan, "id_kelas" => $id_kelas, "id_member" => $id_member]);

        $benar = 0;
        $salah = 0;

        $data_soal = "";
        $text = "";

        // $soal = $this->kelas->get_all("latihan_pertemuan", ["id_pertemuan" => $id_pertemuan, "item = 'soal' OR item = 'soal esai'"], 'urutan');
        $soal = $this->kelas->get_all("latihan_pertemuan", ["id_pertemuan" => $id_pertemuan], 'urutan');

        $index = 0;
        foreach ($soal as $j => $soal) {
            if($soal['item'] == "soal" || $soal['item'] == "soal esai"){
                $string = trim(preg_replace('/\s+/', ' ', $soal['data']));
                $txt_soal = json_decode($string, true );

                $jawaban_soal = $txt_soal['jawaban'];
                if($soal['item'] == "soal"){
                    if($jawaban_soal == $jawaban[$index]){
                        $status = "benar";
                        $benar++;
                    } else {
                        $status = "salah";
                        $salah++;
                    }
                    
                    $no = $j+1;
                    $pilihan = "[";
                    foreach ($txt_soal['pilihan'] as $value) {
                        $pilihan .= "\"{$value}\",";
                    }
                    $pilihan = substr($pilihan, 0, -1);
                    $pilihan .= "]";

                    $text .= '{"item":"'.$soal['item'].'","penulisan":"'.$soal['penulisan'].'","urutan":"'.$soal['urutan'].'","data":{"no":"'.$no.'","soal":"'.$txt_soal['soal'].'","pilihan":'.$pilihan.',"jawaban":"'.$txt_soal['jawaban'].'","key":"'.$jawaban[$index].'","status":"'.$status.'"}},';
                } else if($soal['item'] == "soal esai"){
                    if(trim(preg_replace('/\s+/', ' ', strtolower($jawaban_soal))) == trim(preg_replace('/\s+/', ' ', strtolower($jawaban[$index])))){
                        $status = "benar";
                        $benar++;
                    } else {
                        $status = "salah";
                        $salah++;
                    }
                    $text .= '{"item":"'.$soal['item'].'","penulisan":"'.$soal['penulisan'].'","urutan":"'.$soal['urutan'].'","data":{"no":"'.$no.'","soal":"'.$txt_soal['soal'].'","jawaban":"'.$txt_soal['jawaban'].'","key":"'.$jawaban[$index].'","status":"'.$status.'"}},';
                }

                $index++;

            } else {
                $text .= '{"item":"'.$soal['item'].'","penulisan":"'.$soal['penulisan'].'","urutan":"'.$soal['urutan'].'","data":"'.$soal['data'].'"},';
            }
        }

        $text = substr($text, 0, -1);
        $text = '['.$text.']';

        $poin = $benar * $pertemuan['poin'];

        if($latihan) {
            if($latihan['nilai'] < $poin){
                $data = [
                    "data" => $text,
                    "nilai" => $poin,
                    "periksa" => 0
                ];
            } else {
                $data['data'] = $text;
            }

            $this->kelas->edit_data("latihan_member", ["id" => $latihan['id']], $data);
        } else{
            $data = [
                "id_kelas" => $id_kelas,
                "id_pertemuan" => $id_pertemuan,
                "id_member" => $id_member,
                "data" => $text,
                "nilai" => $poin,
                "periksa" => 0,
            ];
    
            $this->kelas->add_data("latihan_member", $data);
        }

        if($pertemuan['pembahasan'] == "Ya"){
            $msg = "
                <h2 class='text-center'>&#128079 SELAMAT &#128079</h2>
                <p class='text-center'>Kamu Telah Berhasil Menyelesaikan <br>&quot;Latihan {$pertemuan['nama_pertemuan']}&quot; <br>Kelas {$kelas['nama_kelas']}</p>
                <p class='text-center'>
                    Nilai Kamu Adalah : <br>
                    <span class='text-center' style='font-size: 5em;'><b>{$poin} / ".jumlah_soal($pertemuan['id_pertemuan'])."</b></span>
                </p>
                <div class='d-flex justify-content-between'>
                    <a href='".base_url()."kelas/latihan/".md5($kelas['id_kelas'])."/".md5($pertemuan['id_pertemuan'])."' class='btn btn-warning'>".tablerIcon('repeat', 'me-1')." ulangi</a>
                    <a href='javascript:void(0)' class='btn btn-success btnPembahasan'>pembahasan".tablerIcon('chevrons-right')."</a>
                </div>
            ";
        } else {
            $msg = "
                <h2 class='text-center'>&#128079 SELAMAT &#128079</h2>
                <p class='text-center'>Kamu Telah Berhasil Menyelesaikan <br>&quot;Latihan {$pertemuan['nama_pertemuan']}&quot; <br>Kelas {$kelas['nama_kelas']}</p>
                <p class='text-center'>
                    Nilai Kamu Adalah : <br>
                    <span class='text-center' style='font-size: 5em;'><b>{$poin} / ".jumlah_soal($pertemuan['id_pertemuan'])."</b></span>
                </p>
                <div class='d-flex justify-content-center'>
                    <a href='".base_url()."kelas/latihan/".md5($kelas['id_kelas'])."/".md5($pertemuan['id_pertemuan'])."' class='btn btn-warning'>".tablerIcon('repeat', 'me-1')." ulangi</a>
                </div>
            ";
        }

        $this->session->set_flashdata('pesan', $msg);
        
        redirect(base_url("kelas/latihan/".md5($id_kelas)."/".md5($id_pertemuan)));
    }

    public function add_jawaban_kosakata(){
        $id_pertemuan = $this->input->post("id_pertemuan");
        $id_kelas = $this->input->post("id_kelas");
        $id_member = $this->session->userdata("id_member");
        $jawaban = $this->input->post("jawaban");
        $pertemuan = $this->kelas->get_one("pertemuan", ["id_pertemuan" => $id_pertemuan]);
        $kelas = $this->kelas->get_one("kelas", ["id_kelas" => $id_kelas]);
        $latihan = $this->kelas->get_one("latihan_member", ["id_pertemuan" => $id_pertemuan, "id_kelas" => $id_kelas, "id_member" => $id_member]);

        $text = "";
        foreach ($_POST['soal'] as $i => $soal) {
            $text .= $soal.'"key":"'.$_POST["jawaban"][$i].'","status":"'.$_POST["status"][$i].'"}},';
        }

        $text = substr($text, 0, -1);
        $text = "[".$text."]";

        $benar = 0;
        $salah = 0;
        foreach ($_POST['status'] as $status) {
            if($status == "benar") $benar++;
            else $salah++;
        }

        $poin = round(($benar / COUNT($_POST['status'])) * 100);

        if($latihan) {
            if($latihan['nilai'] < $poin){
                $data = [
                    "data" => $text,
                    "nilai" => $poin,
                    "periksa" => 0
                ];
            } else {
                $data['data'] = $text;
            }

            $this->kelas->edit_data("latihan_member", ["id" => $latihan['id']], $data);
        } else{
            $data = [
                "id_kelas" => $id_kelas,
                "id_pertemuan" => $id_pertemuan,
                "id_member" => $id_member,
                "data" => $text,
                "nilai" => $poin,
                "periksa" => 0,
            ];
    
            $this->kelas->add_data("latihan_member", $data);
        }

        if($pertemuan['pembahasan'] == "Ya"){
            $msg = "
                <h2 class='text-center'>&#128079 SELAMAT &#128079</h2>
                <p class='text-center'>Kamu Telah Berhasil Menyelesaikan <br>&quot;Latihan {$pertemuan['nama_pertemuan']}&quot; <br>Kelas {$kelas['nama_kelas']}</p>
                <p class='text-center'>
                    Nilai Kamu Adalah : <br>
                    <span class='text-center' style='font-size: 5em;'><b>{$poin}</b></span>
                </p>
                <div class='d-flex justify-content-between'>
                    <a href='".base_url()."kelas/latihan/".md5($kelas['id_kelas'])."/".md5($pertemuan['id_pertemuan'])."' class='btn btn-warning'>".tablerIcon('repeat', 'me-1')." ulangi</a>
                    <a href='javascript:void(0)' class='btn btn-success btnPembahasan'>pembahasan".tablerIcon('chevrons-right')."</a>
                </div>
            ";
        } else {
            $msg = "
                <h2 class='text-center'>&#128079 SELAMAT &#128079</h2>
                <p class='text-center'>Kamu Telah Berhasil Menyelesaikan <br>&quot;Latihan {$pertemuan['nama_pertemuan']}&quot; <br>Kelas {$kelas['nama_kelas']}</p>
                <p class='text-center'>
                    Nilai Kamu Adalah : <br>
                    <span class='text-center' style='font-size: 5em;'><b>{$poin}</b></span>
                </p>
                <div class='d-flex justify-content-center'>
                    <a href='".base_url()."kelas/latihan/".md5($kelas['id_kelas'])."/".md5($pertemuan['id_pertemuan'])."' class='btn btn-warning'>".tablerIcon('repeat', 'me-1')." ulangi</a>
                </div>
            ";
        }

        // var_dump($text);
        $this->session->set_flashdata('pesan', $msg);
        
        redirect(base_url("kelas/latihan/".md5($id_kelas)."/".md5($id_pertemuan)));
    }

    public function simpan_jawaban_manual(){
        $id_kelas = $this->input->post("id_kelas");
        $id_pertemuan = $this->input->post("id_pertemuan");
        $id_member = $this->session->userdata("id_member");
        $text = "[".$this->input->post("data")."]";

        $latihan = $this->kelas->get_one("latihan_member", ["id_kelas" => $id_kelas, "id_pertemuan" => $id_pertemuan, "id_member" => $id_member]);
        if($latihan){
            $data = [
                "data" => $text,
                "periksa" => $this->input->post("periksa"),
            ];

            $query = $this->kelas->edit_data("latihan_member", ["id" => $latihan['id']], $data);
            if($query) $query = 1;
            else $query = 0;
        } else {
            $data = [
                "id_kelas" => $id_kelas,
                "id_pertemuan" => $id_pertemuan,
                "id_member" => $id_member,
                "data" => $text,
                "periksa" => $this->input->post("periksa"),
            ];
            
            $query = $this->kelas->add_data("latihan_member", $data);
            if($query) $query = 1;
            else $query = 0;
        }

        echo json_encode(1);
    }

    public function edit_jawaban_manual(){
        $id_kelas = $this->input->post("id_kelas");
        $id_pertemuan = $this->input->post("id_pertemuan");
        $id_member = $this->session->userdata("id_member");

        $latihan = $this->kelas->get_one("latihan_member", ["id_kelas" => $id_kelas, "id_pertemuan" => $id_pertemuan, "id_member" => $id_member]);
        if($latihan['periksa'] != "memeriksa"){
            $data = [
                "periksa" => $this->input->post("periksa"),
            ];

            $query = $this->kelas->edit_data("latihan_member", ["id" => $latihan['id']], $data);
            if($query) $query = 1;
            else $query = 0;
            echo json_encode(1);
        } else {
            echo json_encode(2);
        }

    }

    public function input_presensi(){
        $data = $this->kelas->input_presensi();
        echo json_encode($data);
    }
    
    public function tandai_selesai($id_kelas, $id_pertemuan){
        $id_member = $this->session->userdata("id_member");
        
        $pertemuan = $this->kelas->get_one("pertemuan", ["md5(id_pertemuan)" => $id_pertemuan]);

        // tandai materi selesai 
        $this->kelas->edit_data("pertemuan_kelas_member", ["md5(id_pertemuan)" => $id_pertemuan, "id_kelas" => $id_kelas, "id_member" => $id_member], [
            "selesai" => "Selesai"
        ]);

        $pertemuan_selanjutnya = $this->kelas->get_one("pertemuan", ["id_program" => $pertemuan['id_program'], "urutan" => $pertemuan['urutan']+1]);

        $this->kelas->add_data("pertemuan_kelas_member",[
            "id_kelas" => $id_kelas,
            "id_pertemuan" => $pertemuan_selanjutnya['id_pertemuan'],
            "id_member" => $id_member,
            "selesai" => "Belum Selesai"
        ]);

        $this->pertemuan(md5($id_kelas), $id_pertemuan);
    }

    public function sertifikat($id){
        $this->db->from("kelas_member as a");
        $this->db->join("member as b", "a.id_member = b.id_member");
        $this->db->join("kelas as c", "a.id_kelas = c.id_kelas");
        $this->db->where("md5(id)", $id);
        $member = $this->db->get()->row_array();
        // $member = $this->kelas->get_one("kelas_member", ["md5(id)" => $id]);
        
        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [148, 210], 'orientation' => 'L',
        // , 'margin_top' => '43', 'margin_left' => '25', 'margin_right' => '25', 'margin_bottom' => '35',
            'fontdata' => $fontData + [
                'rockb' => [
                    'R' => 'ROCKB.TTF',
                ],'rock' => [
                    'R' => 'ROCK.TTF',
                ],
                'arial' => [
                    'R' => 'arial.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ],
                'bodoni' => [
                    'R' => 'BOD_R.TTF',
                ],
                'calibri' => [
                    'R' => 'CALIBRI.TTF',
                ],
                'cambria' => [
                    'R' => 'CAMBRIAB.TTF',
                ],
                'montserrat' => [
                    'R' => 'Montserrat-Regular.ttf',
                ]
            ], 
        ]);

        // var_dump($member);
        $mpdf->SetTitle("{$member['nama']}");
        $mpdf->WriteHTML($this->load->view('pages/kelas/sertifikat', $member, TRUE));
        $mpdf->Output("{$member['nama']}.pdf", "I");
    }
}

/* End of file Program.php */
