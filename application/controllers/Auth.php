<?php
    class Auth extends CI_CONTROLLER{
        public function __construct(){
            parent::__construct();
            $this->load->model('Main_model');
            $this->load->helper(array('Form', 'Cookie', 'String'));
        }

        public function index(){
            // ambil cookie
            $cookie = get_cookie('peserta_toefl_online');
            // cek session
            if ($this->session->userdata('id_member')) {
                redirect("profil/");
            } else if($cookie <> '') {
                // cek cookie
                $row = $this->Main_model->get_one("member", ["cookie" => $cookie]);

                if ($row) {
                    $this->_daftarkan_session($row);
                } else {
                    $data['header'] = 'Login Member';
                    $data['title'] = 'Login Member';
                    $this->load->view("pages/auth/sign-in", $data);
                }
            } else {
                $data['header'] = 'Login Member';
                $data['title'] = 'Login Member';
                $this->load->view("pages/auth/sign-in", $data);
            }
        }

        public function login(){
            $username = $this->input->post('username');
            $password = $this->input->post("password", TRUE);
            $remember = $this->input->post('remember');
            $row = $this->Main_model->get_one("member", ["username" => $username, "password" => md5($password)]);
            
            if(!$row){
                $password = substr($password, 4, 4)."-".substr($password, 2, 2)."-".substr($password, 0, 2);
                $row = $this->Main_model->get_one("member", ["username" => $username, "tgl_lahir" => $password]);
            }

            if ($row) {
                // login berhasil
                // 1. Buat Cookies jika remember di check
                if ($remember) {
                    $key = random_string('alnum', 64);
                    set_cookie('peserta_toefl_online', $key, 3600*24*30); // set expired 30 hari kedepan
                    // simpan key di database
                    
                    $this->Main_model->edit_data("member", ["id_member" => $row['id_member']], ["cookie" => $key]);
                }
                $this->_daftarkan_session($row);
            } else {
                // login gagal
                $this->session->set_flashdata('pesan', '
                <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                    <div class="d-flex">
                    <div>
                        <svg width="24" height="24" class="alert-icon">
                            <use xlink:href="'.base_url().'assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-alert-circle" />
                        </svg>
                    </div>
                    <div>
                        Kombinasi username dan password salah
                    </div>
                    </div>
                    <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
                ');
                
                $data['title'] = 'Login';
                $this->load->view("pages/auth/sign-in", $data);
            }
        }

        public function _daftarkan_session($row) {
            // 1. Daftarkan Session
            $sess = array(
                'logged' => TRUE,
                'peserta' => $row['username'],
                'nama' => $row['nama'],
                'id_member' => $row['id_member'],
            );
            $this->session->set_userdata($sess);
            // 2. Redirect ke home
            redirect("profil/");
        }

        public function logout(){
            // delete cookie dan session
            delete_cookie('peserta');
            $this->session->sess_destroy();
            redirect('auth');
        }
    }