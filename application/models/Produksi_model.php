<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi_model extends CI_Model {

    public function get_antrean_produksi() {
        $this->db->select('pesanan.*, users.nama_lengkap as nama_pelanggan, kaos.nama_kaos');
        $this->db->from('pesanan');
        $this->db->join('users', 'users.id = pesanan.pelanggan_id');
        $this->db->join('kaos', 'kaos.id = pesanan.kaos_id');
        $this->db->where_in('pesanan.status_produksi', ['diverifikasi', 'desain', 'afdruk', 'sablon', 'pengeringan', 'pengemasan']);
        $this->db->order_by('pesanan.id', 'ASC');
        return $this->db->get()->result_array();
    }

    public function count_produksi_aktif() {
        $this->db->where_in('status_produksi', ['diverifikasi', 'desain', 'afdruk', 'sablon', 'pengeringan', 'pengemasan']);
        return $this->db->count_all_results('pesanan');
    }
}
