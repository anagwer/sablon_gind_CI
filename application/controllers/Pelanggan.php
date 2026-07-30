<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_role('pelanggan');
        $this->load->model('Pesanan_model');
        $this->load->model('Kaos_model');
        $this->load->model('Pembayaran_model');
    }

    public function dashboard() {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = 'Dashboard Pelanggan - Gind Screen Printing';
        $data['pesanan_list'] = $this->Pesanan_model->get_pesanan_by_pelanggan($user_id);
        $data['user'] = get_user_session();

        $this->load->view('layouts/header', $data);
        $this->load->view('pelanggan/dashboard', $data);
        $this->load->view('layouts/footer');
    }

    public function buat_pesanan() {
        $this->form_validation->set_rules('kaos_id', 'Jenis Kaos', 'required');
        $this->form_validation->set_rules('ukuran', 'Ukuran Kaos', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Pcs', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Buat Pesanan Baru - Gind Screen Printing';
            $data['kaos_list'] = $this->Kaos_model->get_all_kaos();
            $data['user'] = get_user_session();

            $this->load->view('layouts/header', $data);
            $this->load->view('pelanggan/buat_pesanan', $data);
            $this->load->view('layouts/footer');
        } else {
            $kaos_id = $this->input->post('kaos_id', TRUE);
            $ukuran = $this->input->post('ukuran', TRUE);
            $jumlah = intval($this->input->post('jumlah', TRUE));

            $kaos = $this->Kaos_model->get_kaos_by_id($kaos_id);
            if (!$kaos) {
                $this->session->set_flashdata('error', 'Jenis kaos tidak valid.');
                redirect('pelanggan/buat_pesanan');
            }

            // Periksa stok ketersediaan bahan kaos
            $stok_tersedia = $this->Kaos_model->get_stok_spesifik($kaos_id, $ukuran);
            if ($jumlah > $stok_tersedia) {
                $this->session->set_flashdata('error', "Stok kaos {$kaos['nama_kaos']} ukuran {$ukuran} hanya tersisa {$stok_tersedia} pcs. Silakan kurangi jumlah atau pilih ukuran/tipe kaos lain.");
                redirect('pelanggan/buat_pesanan');
            }

            // Config upload desain mandiri
            $upload_path = './assets/uploads/desain/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf|zip|svg|psd|ai';
            $config['max_size']      = 20480; // 20MB
            $config['file_name']     = 'desain_' . time() . '_' . rand(100,999);

            $this->upload->initialize($config);

            $file_desain_name = 'default_design.png';
            if ($this->upload->do_upload('file_desain')) {
                $upload_data = $this->upload->data();
                $file_desain_name = $upload_data['file_name'];
            } else {
                if (!empty($_FILES['file_desain']['name'])) {
                    $this->session->set_flashdata('error', 'Gagal mengunggah file desain: ' . $this->upload->display_errors('', ''));
                    redirect('pelanggan/buat_pesanan');
                }
            }

            $harga_satuan = $kaos['harga_dasar'];
            $total_harga = $harga_satuan * $jumlah;
            $kode_pesanan = $this->Pesanan_model->generate_kode_pesanan();

            $data_pesanan = [
                'kode_pesanan' => $kode_pesanan,
                'pelanggan_id' => $this->session->userdata('user_id'),
                'kaos_id' => $kaos_id,
                'ukuran' => $ukuran,
                'jumlah' => $jumlah,
                'harga_satuan' => $harga_satuan,
                'total_harga' => $total_harga,
                'file_desain' => $file_desain_name,
                'posisi_sablon' => $this->input->post('posisi_sablon', TRUE),
                'catatan_pelanggan' => $this->input->post('catatan_pelanggan', TRUE),
                'status_pembayaran' => 'belum_bayar',
                'status_produksi' => 'pending'
            ];

            $pesanan_id = $this->Pesanan_model->create_pesanan($data_pesanan);

            if ($pesanan_id) {
                $this->session->set_flashdata('success', "Pesanan {$kode_pesanan} berhasil dibuat! Silakan lanjutkan pembayaran.");
                redirect('pelanggan/detail/' . $pesanan_id);
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat pesanan. Silakan coba lagi.');
                redirect('pelanggan/buat_pesanan');
            }
        }
    }

    public function detail($pesanan_id) {
        $user_id = $this->session->userdata('user_id');
        $pesanan = $this->Pesanan_model->get_pesanan_by_id($pesanan_id);

        if (!$pesanan || $pesanan['pelanggan_id'] != $user_id) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('pelanggan/dashboard');
        }

        $data['title'] = 'Detail & Tracking Pesanan ' . $pesanan['kode_pesanan'];
        $data['pesanan'] = $pesanan;
        $data['pembayaran'] = $this->Pembayaran_model->get_pembayaran_by_pesanan($pesanan_id);
        $data['logs'] = $this->Pesanan_model->get_log_produksi($pesanan_id);
        $data['pengaturan'] = $this->db->get_where('pengaturan_toko', ['id' => 1])->row_array();
        $data['user'] = get_user_session();

        $this->load->view('layouts/header', $data);
        $this->load->view('pelanggan/detail_pesanan', $data);
        $this->load->view('layouts/footer');
    }

    public function bayar($pesanan_id) {
        $user_id = $this->session->userdata('user_id');
        $pesanan = $this->Pesanan_model->get_pesanan_by_id($pesanan_id);

        if (!$pesanan || $pesanan['pelanggan_id'] != $user_id) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('pelanggan/dashboard');
        }

        $this->form_validation->set_rules('bank_tujuan', 'Bank Tujuan', 'required');
        $this->form_validation->set_rules('nama_pengirim', 'Nama Pengirim', 'required');
        $this->form_validation->set_rules('jumlah_bayar', 'Jumlah Bayar', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Konfirmasi Pembayaran - ' . $pesanan['kode_pesanan'];
            $data['pesanan'] = $pesanan;
            $data['pengaturan'] = $this->db->get_where('pengaturan_toko', ['id' => 1])->row_array();
            $data['user'] = get_user_session();

            $this->load->view('layouts/header', $data);
            $this->load->view('pelanggan/bayar', $data);
            $this->load->view('layouts/footer');
        } else {
            $upload_path = './assets/uploads/bukti/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 5120; // 5MB
            $config['file_name']     = 'bukti_' . $pesanan['kode_pesanan'] . '_' . time();

            $this->upload->initialize($config);

            if ($this->upload->do_upload('bukti_transfer')) {
                $upload_data = $this->upload->data();
                $data_bayar = [
                    'pesanan_id' => $pesanan_id,
                    'bank_tujuan' => $this->input->post('bank_tujuan', TRUE),
                    'nama_pengirim' => $this->input->post('nama_pengirim', TRUE),
                    'jumlah_bayar' => $this->input->post('jumlah_bayar', TRUE),
                    'bukti_transfer' => $upload_data['file_name'],
                    'tanggal_bayar' => date('Y-m-d H:i:s'),
                    'status' => 'pending'
                ];

                $this->Pembayaran_model->insert_pembayaran($data_bayar);
                $this->session->set_flashdata('success', 'Bukti pembayaran berhasil dikirim! Menunggu verifikasi admin.');
                redirect('pelanggan/detail/' . $pesanan_id);
            } else {
                $this->session->set_flashdata('error', 'Gagal upload bukti bayar: ' . $this->upload->display_errors('', ''));
                redirect('pelanggan/bayar/' . $pesanan_id);
            }
        }
    }
}
