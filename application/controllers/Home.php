<?php
    class Home extends CI_CONTROLLER{
        public function __construct(){
            parent::__construct();
            $this->load->model('Main_model');
        }

        public function index(){
            if ($this->session->userdata('id_member')) {
                redirect("profil/");
            } else {
                redirect("auth/");
            }
        }
    }
?>