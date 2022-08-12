<?php
    class Registrasi extends CI_CONTROLLER {
        public function __construct(){
            parent::__construct();
            $this->load->model('Main_model');
        }

        public function index(){
            // for title and header 
            $data['title'] = "Form Registrasi Member";

            // javascript 
            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js"
            ];

            $data['program'] = $this->Main_model->get_all("program", ["hapus" => 0], "nama_program", "ASC");

            $this->load->view("pages/registrasi/form", $data);
        }
   
        public function add_member(){
            $tgl_masuk = date("Y-m-d");
            $program = $this->input->post("program");
            
            $catatan = "";
            foreach ($program as $pro) {
                $catatan .= "{$pro}, ";
            }

            $data = [
                "nama" => $this->input->post("nama", TRUE),
                "no_hp" => $this->input->post("no_hp", TRUE),
                "alamat" => $this->input->post("alamat", TRUE),
                "tgl_lahir" => $this->input->post("tgl_lahir", TRUE),
                "tgl_masuk" => $tgl_masuk,
                "t4_lahir" => $this->input->post("t4_lahir", TRUE),
                "email" => $this->input->post("email", TRUE),
                "username" => "",
                "konfirm" => 0,
                "catatan" => $catatan,
            ];
            $id = $this->Main_model->add_data("member", $data);

            // $peserta = $this->Main_model->get_one("member", ["id_member" => $id]);
            // $this->Main_model->edit_data("member", ["id_member" => $id], ["password" => md5(date('His', strtotime($peserta['tgl_input'])))]);

            // foreach ($program as $program) {
            //     $data = [
            //         "id_member" => $id,
            //         "program" => $program,
            //         "nama" => $this->input->post("nama", TRUE),
            //         "alamat" => $this->input->post("alamat", TRUE),
            //         "tgl_lahir" => $this->input->post("tgl_lahir", TRUE),
            //         "t4_lahir" => $this->input->post("t4_lahir", TRUE),
            //     ];

            //     $this->Main_model->add_data("kelas_member", $data);
            // }
            
            $msg = $this->Main_model->get_one("config", ["field" => "pesan_registrasi"]);

            $this->session->set_flashdata('pesan', '
                <div class="alert alert-important alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                    <div>
                        <svg width="24" height="24" class="alert-icon">
                            <use xlink:href="'.base_url().'assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-circle-check" />
                        </svg>
                    </div>
                    <div>
                        Berhasil Mendaftarkan Data Anda
                    </div>
                    </div>
                    <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
                <div class="mt-3">
                    '.$msg["value"].'
                </div>
                ');
            redirect("registrasi");
        }

        
        public function username($tgl){
            $username = $this->Main_model->get_username_terakhir($tgl);
            if($username){
                $id = $username['id'] + 1;
            } else {
                $id = 1;
            }

            if($id >= 1 && $id < 10){
                $user = date('ym', strtotime($tgl))."000".$id;
            } else if($id >= 10 && $id < 100){
                $user = date('ym', strtotime($tgl))."00".$id;
            } else if($id >= 100 && $id < 1000){
                $user = date('ym', strtotime($tgl))."0".$id;
            } else {
                $user = date('ym', strtotime($tgl)).$id;
            }
            return $user;
        }
    }