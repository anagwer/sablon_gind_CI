<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function get_laporan_pesanan($tgl_mulai = NULL, $tgl_selesai = NULL, $status_pembayaran = NULL, $status_produksi = NULL) {
        $this->db->select('pesanan.*, users.nama_lengkap as nama_pelanggan, users.no_hp, kaos.nama_kaos, kaos.jenis_bahan');
        $this->db->from('pesanan');
        $this->db->join('users', 'users.id = pesanan.pelanggan_id');
        $this->db->join('kaos', 'kaos.id = pesanan.kaos_id');

        if (!empty($tgl_mulai)) {
            $this->db->where('DATE(pesanan.created_at) >=', $tgl_mulai);
        }
        if (!empty($tgl_selesai)) {
            $this->db->where('DATE(pesanan.created_at) <=', $tgl_selesai);
        }
        if (!empty($status_pembayaran)) {
            $this->db->where('pesanan.status_pembayaran', $status_pembayaran);
        }
        if (!empty($status_produksi)) {
            $this->db->where('pesanan.status_produksi', $status_produksi);
        }

        $this->db->order_by('pesanan.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_total_omset($tgl_mulai = NULL, $tgl_selesai = NULL) {
        $this->db->select_sum('total_harga');
        $this->db->where('status_pembayaran', 'lunas');
        if (!empty($tgl_mulai)) {
            $this->db->where('DATE(created_at) >=', $tgl_mulai);
        }
        if (!empty($tgl_selesai)) {
            $this->db->where('DATE(created_at) <=', $tgl_selesai);
        }
        $query = $this->db->get('pesanan')->row_array();
        return $query['total_harga'] ? $query['total_harga'] : 0;
    }

    public function get_rekap_stok_kaos() {
        $this->db->select('kaos.nama_kaos, kaos.jenis_bahan, stok_kaos.ukuran, stok_kaos.stok');
        $this->db->from('stok_kaos');
        $this->db->join('kaos', 'kaos.id = stok_kaos.kaos_id');
        $this->db->order_by('kaos.id', 'ASC');
        $this->db->order_by('stok_kaos.ukuran', 'ASC');
        return $this->db->get()->result_array();
    }
}
