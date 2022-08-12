<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Sertifikat extends CI_Controller {

    
    public function __construct(){
        parent::__construct();
        $this->load->model("Main_model");
    }
    
    public function no($id){
        $this->db->from("kelas_member as a");
        $this->db->join("kelas as b", "a.id_kelas = b.id_kelas");
        $this->db->join("member as c", "a.id_member = c.id_member");
        $this->db->where("md5(id)", $id);
        $member = $this->db->get()->row_array();
        $member['title'] = $member['nama'] . " - " . $member['program'];

        // var_dump($member);
        
        $this->load->view("pages/sertifikat/sertifikat", $member);
    }
}

/* End of file Sertifikat.php */
