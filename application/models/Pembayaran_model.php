<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends CI_Model {

    public function get_pembayaran_by_pesanan($pesanan_id) {
        return $this->db->get_where('pembayaran', ['pesanan_id' => $pesanan_id])->row_array();
    }

    public function insert_pembayaran($data) {
        $this->db->insert('pembayaran', $data);

        // Update status pembayaran di tabel pesanan menjadi 'menunggu_verifikasi'
        $this->db->where('id', $data['pesanan_id']);
        $this->db->update('pesanan', ['status_pembayaran' => 'menunggu_verifikasi']);

        return TRUE;
    }

    public function verifikasi_pembayaran($pembayaran_id, $status, $catatan_admin = '', $admin_id = NULL) {
        $pembayaran = $this->db->get_where('pembayaran', ['id' => $pembayaran_id])->row_array();
        if (!$pembayaran) return FALSE;

        $pesanan_id = $pembayaran['pesanan_id'];

        $this->db->where('id', $pembayaran_id);
        $this->db->update('pembayaran', [
            'status' => $status,
            'catatan_admin' => $catatan_admin,
            'verified_by' => $admin_id,
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        if ($status == 'valid') {
            // Update pesanan
            $this->db->where('id', $pesanan_id);
            $this->db->update('pesanan', [
                'status_pembayaran' => 'lunas',
                'status_produksi' => 'diverifikasi'
            ]);

            // Potong stok kaos
            $pesanan = $this->db->get_where('pesanan', ['id' => $pesanan_id])->row_array();
            $this->load->model('Kaos_model');
            $this->Kaos_model->potong_stok($pesanan['kaos_id'], $pesanan['ukuran'], $pesanan['jumlah']);

            // Tambahkan log produksi
            $this->db->insert('log_produksi', [
                'pesanan_id' => $pesanan_id,
                'status_produksi' => 'diverifikasi',
                'keterangan' => 'Pembayaran terverifikasi valid oleh Admin. Stok kaos berhasil dipotong & pesanan masuk antrean produksi.',
                'created_by' => $admin_id
            ]);

        } else if ($status == 'invalid') {
            $this->db->where('id', $pesanan_id);
            $this->db->update('pesanan', [
                'status_pembayaran' => 'ditolak'
            ]);

            $this->db->insert('log_produksi', [
                'pesanan_id' => $pesanan_id,
                'status_produksi' => 'pending',
                'keterangan' => 'Konfirmasi pembayaran ditolak oleh Admin: ' . $catatan_admin,
                'created_by' => $admin_id
            ]);
        }

        return TRUE;
    }
}
