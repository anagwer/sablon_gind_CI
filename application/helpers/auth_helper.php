<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        $ci =& get_instance();
        if (!$ci->session->userdata('user_id')) {
            $ci->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.');
            redirect('auth/login');
        }
    }
}

if (!function_exists('check_role')) {
    function check_role($allowed_roles = array()) {
        is_logged_in();
        $ci =& get_instance();
        $role = $ci->session->userdata('role');

        if (is_string($allowed_roles)) {
            $allowed_roles = array($allowed_roles);
        }

        if (!in_array($role, $allowed_roles)) {
            $ci->session->set_flashdata('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
            if ($role == 'owner') {
                redirect('owner/dashboard');
            } elseif ($role == 'admin') {
                redirect('admin/dashboard');
            } else {
                redirect('pelanggan/dashboard');
            }
        }
    }
}

if (!function_exists('get_user_session')) {
    function get_user_session() {
        $ci =& get_instance();
        return array(
            'id' => $ci->session->userdata('user_id'),
            'username' => $ci->session->userdata('username'),
            'nama_lengkap' => $ci->session->userdata('nama_lengkap'),
            'role' => $ci->session->userdata('role'),
            'email' => $ci->session->userdata('email'),
            'no_hp' => $ci->session->userdata('no_hp')
        );
    }
}
