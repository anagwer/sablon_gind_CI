<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan_model extends CI_Model {

    public function generate_kode_pesanan() {
        $prefix = 'GIND-' . date('Ymd') . '-';
        $this->db->like('kode_pesanan', $prefix, 'after');
        $this->db->select_max('kode_pesanan');
        $query = $this->db->get('pesanan')->row_array();

        if ($query && !empty($query['kode_pesanan'])) {
            $last_num = intval(substr($query['kode_pesanan'], -3));
            $next_num = str_pad($last_num + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $next_num = '001';
        }
        return $prefix . $next_num;
    }

    public function create_pesanan($data) {
        $this->db->insert('pesanan', $data);
        $pesanan_id = $this->db->insert_id();

        // Tambahkan log produksi awal
        $this->db->insert('log_produksi', [
            'pesanan_id' => $pesanan_id,
            'status_produksi' => 'pending',
            'keterangan' => 'Pesanan berhasil dibuat oleh pelanggan. Menunggu pembayaran.',
            'created_by' => $data['pelanggan_id']
        ]);

        return $pesanan_id;
    }

    public function get_all_pesanan($limit = NULL) {
        $this->db->select('pesanan.*, users.nama_lengkap as nama_pelanggan, users.no_hp, kaos.nama_kaos, kaos.jenis_bahan');
        $this->db->from('pesanan');
        $this->db->join('users', 'users.id = pesanan.pelanggan_id');
        $this->db->join('kaos', 'kaos.id = pesanan.kaos_id');
        $this->db->order_by('pesanan.id', 'DESC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }

    public function get_pesanan_by_pelanggan($pelanggan_id) {
        $this->db->select('pesanan.*, kaos.nama_kaos, kaos.jenis_bahan, kaos.gambar as gambar_kaos');
        $this->db->from('pesanan');
        $this->db->join('kaos', 'kaos.id = pesanan.kaos_id');
        $this->db->where('pesanan.pelanggan_id', $pelanggan_id);
        $this->db->order_by('pesanan.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_pesanan_by_id($id) {
        $this->db->select('pesanan.*, users.nama_lengkap as nama_pelanggan, users.email, users.no_hp, users.alamat, kaos.nama_kaos, kaos.jenis_bahan, kaos.harga_dasar, kaos.gambar as gambar_kaos');
        $this->db->from('pesanan');
        $this->db->join('users', 'users.id = pesanan.pelanggan_id');
        $this->db->join('kaos', 'kaos.id = pesanan.kaos_id');
        $this->db->where('pesanan.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_pesanan_by_kode($kode_pesanan) {
        $this->db->select('pesanan.*, users.nama_lengkap as nama_pelanggan, users.no_hp, kaos.nama_kaos, kaos.jenis_bahan, kaos.gambar as gambar_kaos');
        $this->db->from('pesanan');
        $this->db->join('users', 'users.id = pesanan.pelanggan_id');
        $this->db->join('kaos', 'kaos.id = pesanan.kaos_id');
        $this->db->where('pesanan.kode_pesanan', trim($kode_pesanan));
        return $this->db->get()->row_array();
    }

    public function update_status_produksi($pesanan_id, $status_produksi, $keterangan = '', $user_id = NULL) {
        $this->db->where('id', $pesanan_id);
        $this->db->update('pesanan', [
            'status_produksi' => $status_produksi,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Masukkan log produksi
        $this->db->insert('log_produksi', [
            'pesanan_id' => $pesanan_id,
            'status_produksi' => $status_produksi,
            'keterangan' => !empty($keterangan) ? $keterangan : 'Status produksi diperbarui menjadi: ' . nama_status_produksi($status_produksi),
            'created_by' => $user_id
        ]);

        return TRUE;
    }

    public function get_log_produksi($pesanan_id) {
        $this->db->select('log_produksi.*, users.nama_lengkap as updated_by_name');
        $this->db->from('log_produksi');
        $this->db->join('users', 'users.id = log_produksi.created_by', 'left');
        $this->db->where('log_produksi.pesanan_id', $pesanan_id);
        $this->db->order_by('log_produksi.id', 'ASC');
        return $this->db->get()->result_array();
    }

    public function count_pesanan_by_status_produksi($status) {
        return $this->db->where('status_produksi', $status)->count_all_results('pesanan');
    }

    // Chart Data Helpers
    public function get_chart_status_produksi() {
        $statuses = ['pending', 'diverifikasi', 'desain', 'afdruk', 'sablon', 'pengeringan', 'pengemasan', 'selesai'];
        $labels = [];
        $counts = [];

        foreach ($statuses as $st) {
            $labels[] = nama_status_produksi($st);
            $counts[] = $this->db->where('status_produksi', $st)->count_all_results('pesanan');
        }

        return [
            'labels' => $labels,
            'data' => $counts
        ];
    }

    public function get_chart_popular_kaos() {
        $this->db->select('kaos.nama_kaos, SUM(pesanan.jumlah) as total_pcs');
        $this->db->from('pesanan');
        $this->db->join('kaos', 'kaos.id = pesanan.kaos_id');
        $this->db->group_by('pesanan.kaos_id');
        $this->db->order_by('total_pcs', 'DESC');
        $query = $this->db->get()->result_array();

        $labels = [];
        $data = [];
        foreach ($query as $row) {
            $labels[] = $row['nama_kaos'];
            $data[] = intval($row['total_pcs']);
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    public function get_chart_omset_bulanan() {
        $this->db->select('DATE_FORMAT(created_at, "%d %b") as tanggal, SUM(total_harga) as total_omset');
        $this->db->from('pesanan');
        $this->db->where('status_pembayaran', 'lunas');
        $this->db->group_by('DATE(created_at)');
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit(10);
        $query = $this->db->get()->result_array();

        $labels = [];
        $data = [];
        foreach ($query as $row) {
            $labels[] = $row['tanggal'];
            $data[] = floatval($row['total_omset']);
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
