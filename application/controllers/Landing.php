<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kaos_model');
        $this->load->model('Pesanan_model');
    }

    public function index() {
        $data['title'] = 'Gind Screen Printing - Jasa Sablon Kaos Custom';
        $data['kaos_list'] = $this->Kaos_model->get_all_kaos();
        $data['pengaturan'] = $this->db->get_where('pengaturan_toko', ['id' => 1])->row_array();

        $this->load->view('landing/index', $data);
    }

    public function lacak() {
        $kode_pesanan = $this->input->get('kode_pesanan', TRUE);
        $data['title'] = 'Lacak Status Pesanan - Gind Screen Printing';
        $data['kode_pesanan'] = $kode_pesanan;
        $data['pesanan'] = NULL;
        $data['logs'] = array();

        if (!empty($kode_pesanan)) {
            $pesanan = $this->Pesanan_model->get_pesanan_by_kode($kode_pesanan);
            if ($pesanan) {
                $data['pesanan'] = $pesanan;
                $data['logs'] = $this->Pesanan_model->get_log_produksi($pesanan['id']);
            } else {
                $this->session->set_flashdata('error_tracking', 'Kode Pesanan tidak ditemukan. Harap periksa kembali kode Anda.');
            }
        }

        $this->load->view('landing/lacak', $data);
    }
}
