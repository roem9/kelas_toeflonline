<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends MY_Model {
    public function get_all_kelas(){
        $id_member = $this->session->userdata("id_member");
        $teks = $this->input->post("teks");
        
        $this->db->select("nama_kelas, a.id_kelas, tgl_mulai, tgl_selesai, b.status, b.program, nilai, a.id_member, a.id, a.hapus");
        $this->db->from("kelas_member as a");
        $this->db->join("kelas as b", "a.id_kelas = b.id_kelas");
        $this->db->where(["a.id_member" => $id_member, "a.hapus" => 0]);
        $this->db->group_start();
        $this->db->like(["b.nama_kelas" => $teks]);
        $this->db->or_like(["b.program" => $teks]);
        $this->db->group_end();
        $query = $this->db->get()->result_array();

        $data = [];
        foreach ($query as $i => $query) {
            $data[$i] = $query;
            $data[$i]['tgl_mulai'] = tgl_indo($query['tgl_mulai']);
            $data[$i]['tgl_selesai'] = tgl_indo($query['tgl_selesai']);
            $data[$i]['link_kelas'] = md5($query['id_kelas']);
            $data[$i]['id'] = md5($query['id']);
        }

        return $data;
    }

    public function id($id_kelas){
        $id_member = $this->session->userdata("id_member");
        $kelas = $this->kelas->get_one("kelas", ["md5(id_kelas)" => $id_kelas]);
        $program = $this->kelas->get_one("program", ["nama_program" => $kelas['program']]);

        $data['menu'] = "kelas";
        $data['title'] = "{$kelas['nama_kelas']}";
        
        $this->db->select("b.nama_pertemuan, a.id_pertemuan, latihan, b.presensi, a.presensi as status_presensi, catatan");
        $this->db->from("pertemuan_kelas_member as a");
        $this->db->join("pertemuan as b", "a.id_pertemuan = b.id_pertemuan");
        $this->db->where(["a.id_kelas" => $kelas['id_kelas'], "id_member" => $id_member]);
        $query = $this->db->get()->result_array();

        $data['pertemuan'] = [];
        foreach ($query as $i => $query) {
            $data['pertemuan'][$i] = $query;
        }
        
        $data['kelas'] = $kelas;
        $data['program'] = $program;

        $data['kelas_member'] = $this->get_one("kelas_member", ["md5(id_kelas)" => $id_kelas, "id_member" => $id_member, "hapus" => 0]);

        return $data;
    }

    public function input_presensi(){
        $id_member = $this->session->userdata("id_member");
        $id_kelas = $this->input->post("id_kelas");
        $id_pertemuan = $this->input->post("id_pertemuan");
        $data = [
            "id_member" => $id_member,
            "id_kelas" => $id_kelas,
            "id_pertemuan" => $id_pertemuan,
        ];

        $query = $this->get_one("presensi_member", $data);
        if(!$query) $query = $this->add_data("presensi_member", $data);
        return $query;
    }
}