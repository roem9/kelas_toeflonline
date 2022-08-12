<?php
    class Profil extends MY_CONTROLLER{
        public function index(){
            $data['title'] = "Profil Peserta";
            $data['menu'] = "profil";
            $data['member'] = $this->profil->get_one("member", ["id_member" => $this->session->userdata("id_member")]);

            $data['js'] = [
                "ajax.js",
                "function.js",
                "helper.js"
            ];

            $this->load->view("pages/profil/index", $data);
        }
    }
?>