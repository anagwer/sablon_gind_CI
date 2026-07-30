<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        $this->login();
    }

    public function login() {
        if ($this->session->userdata('user_id')) {
            $role = $this->session->userdata('role');
            if ($role == 'owner') redirect('owner/dashboard');
            if ($role == 'admin') redirect('admin/dashboard');
            redirect('pelanggan/dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login - Gind Screen Printing';
            $this->load->view('auth/login', $data);
        } else {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->User_model->login($username, $password);

            if ($user) {
                $session_data = array(
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'role' => $user['role'],
                    'email' => $user['email'],
                    'no_hp' => $user['no_hp']
                );
                $this->session->set_userdata($session_data);
                $this->session->set_flashdata('success', 'Selamat datang kembali, ' . $user['nama_lengkap'] . '!');

                if ($user['role'] == 'owner') {
                    redirect('owner/dashboard');
                } elseif ($user['role'] == 'admin') {
                    redirect('admin/dashboard');
                } else {
                    redirect('pelanggan/dashboard');
                }
            } else {
                $this->session->set_flashdata('error', 'Username atau Password salah!');
                redirect('auth/login');
            }
        }
    }

    public function register() {
        if ($this->session->userdata('user_id')) {
            redirect('pelanggan/dashboard');
        }

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]', [
            'is_unique' => 'Username ini sudah terdaftar. Silakan pilih username lain.'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('no_hp', 'No. WhatsApp', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]', [
            'matches' => 'Konfirmasi password tidak sesuai.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Pendaftaran Pelanggan - Gind Screen Printing';
            $this->load->view('auth/register', $data);
        } else {
            $data_register = [
                'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                'username' => $this->input->post('username', TRUE),
                'email' => $this->input->post('email', TRUE),
                'no_hp' => $this->input->post('no_hp', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'password' => $this->input->post('password', TRUE)
            ];

            if ($this->User_model->register($data_register)) {
                $this->session->set_flashdata('success', 'Pendaftaran akun berhasil! Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Gagal mendaftar. Silakan coba lagi.');
                redirect('auth/register');
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
