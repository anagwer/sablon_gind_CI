<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaos_model extends CI_Model {

    public function get_all_kaos() {
        $kaos_list = $this->db->order_by('harga_dasar', 'ASC')->get('kaos')->result_array();
        foreach ($kaos_list as &$item) {
            $item['stok'] = $this->get_stok_by_kaos($item['id']);
            $item['total_stok'] = array_sum(array_column($item['stok'], 'stok'));
        }
        return $kaos_list;
    }

    public function get_kaos_by_id($id) {
        $kaos = $this->db->get_where('kaos', ['id' => $id])->row_array();
        if ($kaos) {
            $kaos['stok'] = $this->get_stok_by_kaos($id);
            $kaos['total_stok'] = array_sum(array_column($kaos['stok'], 'stok'));
        }
        return $kaos;
    }

    public function get_stok_by_kaos($kaos_id) {
        return $this->db->get_where('stok_kaos', ['kaos_id' => $kaos_id])->result_array();
    }

    public function get_stok_spesifik($kaos_id, $ukuran) {
        $stok = $this->db->get_where('stok_kaos', [
            'kaos_id' => $kaos_id,
            'ukuran' => $ukuran
        ])->row_array();
        return $stok ? intval($stok['stok']) : 0;
    }

    public function insert_kaos($data_kaos, $stok_ukuran = array()) {
        $this->db->insert('kaos', $data_kaos);
        $kaos_id = $this->db->insert_id();

        $ukuran_list = ['S', 'M', 'L', 'XL', 'XXL'];
        foreach ($ukuran_list as $uk) {
            $jumlah_stok = isset($stok_ukuran[$uk]) ? intval($stok_ukuran[$uk]) : 0;
            $this->db->insert('stok_kaos', [
                'kaos_id' => $kaos_id,
                'ukuran' => $uk,
                'stok' => $jumlah_stok
            ]);
        }
        return $kaos_id;
    }

    public function update_kaos($id, $data_kaos, $stok_ukuran = array()) {
        $this->db->where('id', $id);
        $this->db->update('kaos', $data_kaos);

        if (!empty($stok_ukuran)) {
            foreach ($stok_ukuran as $uk => $stok_val) {
                $this->db->where(['kaos_id' => $id, 'ukuran' => $uk]);
                $exists = $this->db->get('stok_kaos')->row_array();
                if ($exists) {
                    $this->db->where('id', $exists['id']);
                    $this->db->update('stok_kaos', ['stok' => intval($stok_val)]);
                } else {
                    $this->db->insert('stok_kaos', [
                        'kaos_id' => $id,
                        'ukuran' => $uk,
                        'stok' => intval($stok_val)
                    ]);
                }
            }
        }
        return TRUE;
    }

    public function delete_kaos($id) {
        $this->db->where('id', $id);
        return $this->db->delete('kaos');
    }

    public function potong_stok($kaos_id, $ukuran, $jumlah) {
        $stok_saat_ini = $this->get_stok_spesifik($kaos_id, $ukuran);
        $stok_baru = max(0, $stok_saat_ini - intval($jumlah));

        $this->db->where(['kaos_id' => $kaos_id, 'ukuran' => $ukuran]);
        return $this->db->update('stok_kaos', ['stok' => $stok_baru]);
    }

    public function kembalikan_stok($kaos_id, $ukuran, $jumlah) {
        $stok_saat_ini = $this->get_stok_spesifik($kaos_id, $ukuran);
        $stok_baru = $stok_saat_ini + intval($jumlah);

        $this->db->where(['kaos_id' => $kaos_id, 'ukuran' => $ukuran]);
        return $this->db->update('stok_kaos', ['stok' => $stok_baru]);
    }
}
