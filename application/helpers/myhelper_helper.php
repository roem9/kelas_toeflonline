<?php
    function tablerIcon($icon, $margin = "", $width = 24){
        return '
            <svg width="'.$width.'" height="'.$width.'" class="'.$margin.'">
                <use xlink:href="'.base_url().'assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-'.$icon.'" />
            </svg>';
    }

    function iconFloat($icon, $margin = "", $width = 30){
        return '
            <svg width="'.$width.'" height="'.$width.'">
                <use xlink:href="'.base_url().'assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-'.$icon.'" />
            </svg>';
    }

    function hari_indo($hari){
        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
            break;

            case 'Mon':			
                $hari_ini = "Senin";
            break;
    
            case 'Tue':
                $hari_ini = "Selasa";
            break;
    
            case 'Wed':
                $hari_ini = "Rabu";
            break;
    
            case 'Thu':
                $hari_ini = "Kamis";
            break;
    
            case 'Fri':
                $hari_ini = "Jumat";
            break;
    
            case 'Sat':
                $hari_ini = "Sabtu";
            break;
            
            default:
                $hari_ini = "Tidak di ketahui";
            break;
        }
        return $hari_ini;
    }

    function tgl_indo($tgl, $day = ""){
        $data = explode("-", $tgl);
        $hari = $data[2];
        $bulan = $data[1];
        $tahun = $data[0];

        if($bulan == "01") $bulan = "Januari";
        if($bulan == "02") $bulan = "Februari";
        if($bulan == "03") $bulan = "Maret";
        if($bulan == "04") $bulan = "April";
        if($bulan == "05") $bulan = "Mei";
        if($bulan == "06") $bulan = "Juni";
        if($bulan == "07") $bulan = "Juli";
        if($bulan == "08") $bulan = "Agustus";
        if($bulan == "09") $bulan = "September";
        if($bulan == "10") $bulan = "Oktober";
        if($bulan == "11") $bulan = "November";
        if($bulan == "12") $bulan = "Desember";

        if($day == TRUE){
            $hari_indo = hari_indo(date("D", strtotime($tgl)));

            return $hari_indo . ", " . $hari . " " . $bulan . " " . $tahun;
        } else {
            return $hari . " " . $bulan . " " . $tahun;
        }
    }

    function tgl_sertifikat($tgl){
        $data = explode("-", $tgl);
        $hari = $data[2];
        $bulan = $data[1];
        $tahun = $data[0];

        if($bulan == "01") $bulan = "January";
        if($bulan == "02") $bulan = "February";
        if($bulan == "03") $bulan = "March";
        if($bulan == "04") $bulan = "April";
        if($bulan == "05") $bulan = "May";
        if($bulan == "06") $bulan = "June";
        if($bulan == "07") $bulan = "July";
        if($bulan == "08") $bulan = "August";
        if($bulan == "09") $bulan = "September";
        if($bulan == "10") $bulan = "October";
        if($bulan == "11") $bulan = "November";
        if($bulan == "12") $bulan = "December";

        
        return $bulan . " " . $hari . ", " . $tahun;
    }

    function listProgram(){
        $CI =& get_instance();
        $CI->db->from("program");
        $CI->db->where(["hapus" => 0]);
        $CI->db->order_by("nama_program");
        $program = $CI->db->get()->result_array();
        
        $text = "";
        foreach ($program as $program) {
            $text .= "<option value=\"{$program['nama_program']}\">{$program['nama_program']}</option>";
        }

        return $text;
    }

    function nilai_latihan($id_kelas, $id_pertemuan, $id_member){
        $CI =& get_instance();
        $CI->db->from("latihan_member");
        $CI->db->where(["id_kelas" => $id_kelas, "id_pertemuan" => $id_pertemuan, "id_member" => $id_member]);
        $data = $CI->db->get()->row_array();

        if($data) return $data['nilai'];
        else return "<span class='text-danger'>".tablerIcon('circle-x')."</span>";

    }

    function jumlah_soal($id_pertemuan){
        $CI =& get_instance();
        $CI->db->from("latihan_pertemuan");
        $CI->db->where("id_pertemuan = '$id_pertemuan' AND (item = 'soal' OR item = 'soal esai')");
        
        $soal = $CI->db->get()->result_array();
        return COUNT($soal);
    }

    function link_materi($id_kelas, $id_pertemuan){
        $CI =& get_instance();

        $id_member = $CI->session->userdata("id_member");

        $CI->db->from("pertemuan")->where(["id_pertemuan" => $id_pertemuan]);
        $pertemuan = $CI->db->get()->row_array();

        $CI->db->from("pertemuan as a");
        $CI->db->join("pertemuan_kelas_member as b", "a.id_pertemuan = b.id_pertemuan");
        $CI->db->where(["id_program" => $pertemuan['id_program'], "urutan" => $pertemuan['urutan']-1, "id_member" => $id_member, "id_kelas" => $id_kelas]);
        $data['link_back'] = $CI->db->get()->row_array();

        $CI->db->from("pertemuan as a");
        $CI->db->join("pertemuan_kelas_member as b", "a.id_pertemuan = b.id_pertemuan");
        $CI->db->where(["id_program" => $pertemuan['id_program'], "urutan" => $pertemuan['urutan']+1, "id_member" => $id_member, "id_kelas" => $id_kelas]);
        $data['link_next'] = $CI->db->get()->row_array();

        $html = "";

        if(!empty($data['link_back']) && !empty($data['link_next'])){
            $html .= "
                <div class='d-flex justify-content-between'>
                    <a href='".base_url()."kelas/pertemuan/".md5($id_kelas)."/".md5($data['link_back']['id_pertemuan'])."' class='btn btn-info'>".tablerIcon('arrow-left', '')."</a>
                    <a href='".base_url()."kelas/pertemuan/".md5($id_kelas)."/".md5($data['link_next']['id_pertemuan'])."' class='btn btn-info'>".tablerIcon('arrow-right', '')."</a>
                </div>
            ";
        } else if(!empty($data['link_back']) && empty($data['link_next'])){
            $html .= "
                <div class='d-flex justify-content-between'>
                    <a href='".base_url()."kelas/pertemuan/".md5($id_kelas)."/".md5($data['link_back']['id_pertemuan'])."' class='btn btn-info'>".tablerIcon('arrow-left', '')."</a>
                    <span></span>
                </div>
            ";
        } else if(empty($data['link_back']) && !empty($data['link_next'])){
            $html .= "
                <div class='d-flex justify-content-between'>
                    <span></span>
                    <a href='".base_url()."kelas/pertemuan/".md5($id_kelas)."/".md5($data['link_next']['id_pertemuan'])."' class='btn btn-info'>".tablerIcon('arrow-right', '')."</a>
                </div>
            ";
        } else if(empty($data['link_back']) && empty($data['link_next'])){
            $html = "";
        }
        return $html;
    }

    function poin_toefl($tipe, $soal){
        $CI =& get_instance();
        $CI->db->from("nilai_toefl");
        $CI->db->where(["tipe" => $tipe, "soal" => $soal]);
        $data = $CI->db->get()->row_array();
        return $data['poin'];
    }

    function no_doc(){
        $CI =& get_instance();
        $CI->db->from("kelas_member");
        $CI->db->where(["hapus" => 0]);
        $CI->db->order_by("no_doc", "DESC");
        $data = $CI->db->get()->row_array();
        return $data['no_doc'] + 1;
    }