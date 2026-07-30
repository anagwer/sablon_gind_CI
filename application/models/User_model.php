<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function login($username, $password) {
        $user = $this->db->get_where('users', ['username' => $username])->row_array();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return FALSE;
    }

    public function register($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['role'] = 'pelanggan';
        return $this->db->insert('users', $data);
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('users', ['id' => $id])->row_array();
    }

    public function get_all_users() {
        return $this->db->order_by('id', 'DESC')->get('users')->result_array();
    }

    public function get_users_by_role($role) {
        return $this->db->get_where('users', ['role' => $role])->result_array();
    }

    public function update_profile($id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function count_users_by_role($role) {
        return $this->db->where('role', $role)->count_all_results('users');
    }
}
