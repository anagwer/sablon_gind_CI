<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Owner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_role('owner');
        $this->load->model('Pesanan_model');
        $this->load->model('Kaos_model');
        $this->load->model('Laporan_model');
        $this->load->model('Produksi_model');
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Pemilik - Gind Screen Printing';
        $data['total_omset'] = $this->Laporan_model->get_total_omset();
        $data['total_pesanan'] = count($this->Pesanan_model->get_all_pesanan());
        $data['pesanan_selesai'] = $this->Pesanan_model->count_pesanan_by_status_produksi('selesai');
        $data['produksi_aktif'] = $this->Produksi_model->count_produksi_aktif();

        // Chart Data
        $data['chart_status'] = $this->Pesanan_model->get_chart_status_produksi();
        $data['chart_kaos'] = $this->Pesanan_model->get_chart_popular_kaos();
        $data['chart_omset'] = $this->Pesanan_model->get_chart_omset_bulanan();
        $data['user'] = get_user_session();

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('owner/dashboard', $data);
        $this->load->view('layouts/admin_footer');
    }

    public function laporan() {
        $tgl_mulai = $this->input->get('tgl_mulai', TRUE);
        $tgl_selesai = $this->input->get('tgl_selesai', TRUE);
        $status_pembayaran = $this->input->get('status_pembayaran', TRUE);
        $status_produksi = $this->input->get('status_produksi', TRUE);

        $data['title'] = 'Laporan Produksi & Penjualan - Pemilik Toko';
        $data['tgl_mulai'] = $tgl_mulai;
        $data['tgl_selesai'] = $tgl_selesai;
        $data['status_pembayaran'] = $status_pembayaran;
        $data['status_produksi'] = $status_produksi;

        $data['laporan_list'] = $this->Laporan_model->get_laporan_pesanan($tgl_mulai, $tgl_selesai, $status_pembayaran, $status_produksi);
        $data['total_omset'] = $this->Laporan_model->get_total_omset($tgl_mulai, $tgl_selesai);
        $data['user'] = get_user_session();

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('owner/laporan', $data);
        $this->load->view('layouts/admin_footer');
    }

    public function cetak_laporan() {
        $tgl_mulai = $this->input->get('tgl_mulai', TRUE);
        $tgl_selesai = $this->input->get('tgl_selesai', TRUE);
        $status_pembayaran = $this->input->get('status_pembayaran', TRUE);
        $status_produksi = $this->input->get('status_produksi', TRUE);

        $data['title'] = 'Cetak Laporan - Gind Screen Printing';
        $data['tgl_mulai'] = $tgl_mulai;
        $data['tgl_selesai'] = $tgl_selesai;
        $data['laporan_list'] = $this->Laporan_model->get_laporan_pesanan($tgl_mulai, $tgl_selesai, $status_pembayaran, $status_produksi);
        $data['total_omset'] = $this->Laporan_model->get_total_omset($tgl_mulai, $tgl_selesai);
        $data['pengaturan'] = $this->db->get_where('pengaturan_toko', ['id' => 1])->row_array();

        $this->load->view('owner/cetak_laporan', $data);
    }
}
