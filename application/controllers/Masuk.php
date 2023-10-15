<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('masuk_model');
    }

    public function index()
    {
        $user = $this->session->userdata('userid');
        if ($this->session->userdata('userid') == NULL or $this->session->userdata('userid') == "") {
            $this->session->sess_destroy();
            $this->load->view('login/v_login1');
        } else {
            redirect('dashboard');
        }
    }

    protected function _rules()
    {
        $this->form_validation->set_rules('userName', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('required', 'Masukan %s');
    }

    public function signin()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            redirect('masuk');
            echo "gagal";
        } else {
            $sessid = '';
            while (strlen($sessid) < 32) {
                $sessid .= mt_rand(0, mt_getrandmax());
            }

            // To make the session ID even more secure we'll combine it with the user's IP
            $sessid .= $this->input->ip_address();

            $userName = trim($this->input->post('userName'));
            $password = trim($this->input->post('password'));

            $q = $this->masuk_model->processLogin($userName, $password);

            $h = $q->row_array();
            $code_activation = $h['code_activation'];
            $kata_sandi = $h['kata_sandi'];
            $cek = $this->arr2md5(array($code_activation, $password));
            if ($cek == $kata_sandi && $cek <> '') {
                $query = $q->result();
                $user = array(
                    'userid' => $query[0]->userid,
                    'nama_user' => $query[0]->nama_user,
                    'fullname' => $query[0]->fullname,
                    'group_name' => $query[0]->group_name,
                    'group_id' => $query[0]->group_id,
                    'jurusita_id' => $query[0]->jurusita_id,
                    'session_id'    => md5(uniqid($sessid, TRUE)),
                    'ip_address'    => $this->input->ip_address(),
                    'user_agent'    => substr($this->input->user_agent(), 0, 120),
                    'last_activity'    => time(),
                );

                $group_id = $query[0]->group_id;
                $whitelist = array('30', '430', '431', '1003', '20', '1000', '1010', '1020', '500', '702');

                if (in_array($group_id, $whitelist) || $group_id <= '10') {
                    $this->session->set_userdata($user);
                    redirect('/dashboard');
                } else {
                    $this->session->set_flashdata('error_msg', '<div class="alert alert-danger alert-dismissible fade in show mt-2 text-center">Anda Tidak Memiliki Akses
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button></div>');

                    redirect('masuk');
                    return;
                }
            } else {
                $this->form_validation->set_message('validateUser', 'Username atau password salah');
                $this->session->set_flashdata('error_msg', '<div class="alert alert-danger alert-dismissible fade in show mt-2 text-center">Username atau Password salah
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button></div>');
                redirect('masuk');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('masuk');
    }

    protected function arr2md5($arrinput)
    {
        $hasil = '';
        foreach ($arrinput as $val) {
            if ($hasil == '') {
                $hasil = md5($val);
            } else {
                $code = md5($val);
                for ($hit = 0; $hit < min(array(strlen($code), strlen($hasil))); $hit++) {
                    $hasil[$hit] = chr(ord($hasil[$hit]) ^ ord($code[$hit]));
                }
            }
        }
        return (md5($hasil));
    }
}
