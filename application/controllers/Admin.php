<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_role(['admin', 'owner']);
        $this->load->model('Pesanan_model');
        $this->load->model('Kaos_model');
        $this->load->model('Pembayaran_model');
        $this->load->model('Produksi_model');
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Admin Produksi - Gind Screen Printing';
        $data['total_pesanan'] = count($this->Pesanan_model->get_all_pesanan());
        $data['produksi_aktif'] = $this->Produksi_model->count_produksi_aktif();
        $data['pesanan_selesai'] = $this->Pesanan_model->count_pesanan_by_status_produksi('selesai');
        $data['menunggu_verifikasi'] = $this->Pesanan_model->count_pesanan_by_status_produksi('pending');

        // Pass Chart Data
        $data['chart_status'] = $this->Pesanan_model->get_chart_status_produksi();
        $data['chart_kaos'] = $this->Pesanan_model->get_chart_popular_kaos();
        $data['chart_omset'] = $this->Pesanan_model->get_chart_omset_bulanan();
        $data['user'] = get_user_session();

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('layouts/admin_footer');
    }

    public function pesanan() {
        $data['title'] = 'Kelola Pesanan & Produksi - Admin';
        $data['pesanan_list'] = $this->Pesanan_model->get_all_pesanan();
        $data['user'] = get_user_session();

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/pesanan', $data);
        $this->load->view('layouts/admin_footer');
    }

    public function detail_pesanan($pesanan_id) {
        $pesanan = $this->Pesanan_model->get_pesanan_by_id($pesanan_id);
        if (!$pesanan) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('admin/pesanan');
        }

        $data['title'] = 'Detail Pesanan ' . $pesanan['kode_pesanan'];
        $data['pesanan'] = $pesanan;
        $data['pembayaran'] = $this->Pembayaran_model->get_pembayaran_by_pesanan($pesanan_id);
        $data['logs'] = $this->Pesanan_model->get_log_produksi($pesanan_id);
        $data['stok_saat_ini'] = $this->Kaos_model->get_stok_spesifik($pesanan['kaos_id'], $pesanan['ukuran']);
        $data['user'] = get_user_session();

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/detail_pesanan', $data);
        $this->load->view('layouts/admin_footer');
    }

    public function verifikasi_pembayaran() {
        $pembayaran_id = $this->input->post('pembayaran_id', TRUE);
        $status = $this->input->post('status', TRUE); // 'valid' or 'invalid'
        $catatan_admin = $this->input->post('catatan_admin', TRUE);
        $admin_id = $this->session->userdata('user_id');
        $pesanan_id = $this->input->post('pesanan_id', TRUE);

        if ($this->Pembayaran_model->verifikasi_pembayaran($pembayaran_id, $status, $catatan_admin, $admin_id)) {
            $msg = ($status == 'valid') ? 'Pembayaran berhasil diverifikasi valid! Stok kaos telah dipotong dan pesanan masuk antrean produksi.' : 'Pembayaran ditolak.';
            $this->session->set_flashdata('success', $msg);
        } else {
            $this->session->set_flashdata('error', 'Gagal memproses verifikasi pembayaran.');
        }
        redirect('admin/detail_pesanan/' . $pesanan_id);
    }

    public function update_status_produksi() {
        $pesanan_id = $this->input->post('pesanan_id', TRUE);
        $status_produksi = $this->input->post('status_produksi', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);
        $admin_id = $this->session->userdata('user_id');

        $pesanan = $this->Pesanan_model->get_pesanan_by_id($pesanan_id);
        if (!$pesanan) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('admin/pesanan');
        }

        $sequence = ['pending', 'diverifikasi', 'desain', 'afdruk', 'sablon', 'pengeringan', 'pengemasan', 'selesai'];
        $current_status = $pesanan['status_produksi'];

        // Validasi Alur Berurutan (Strict Sequential Workflow)
        if ($status_produksi != 'dibatalkan') {
            $current_idx = array_search($current_status, $sequence);
            $target_idx = array_search($status_produksi, $sequence);

            if ($current_status == 'pending' && $status_produksi != 'diverifikasi') {
                $this->session->set_flashdata('error', 'Pembayaran belum diverifikasi! Lakukan verifikasi pembayaran terlebih dahulu sebelum memulai proses produksi.');
                redirect('admin/detail_pesanan/' . $pesanan_id);
            }

            if ($current_idx !== FALSE && $target_idx !== FALSE) {
                if ($target_idx > $current_idx + 1) {
                    $next_allowed = isset($sequence[$current_idx + 1]) ? nama_status_produksi($sequence[$current_idx + 1]) : 'Selesai';
                    $this->session->set_flashdata('error', "Gagal! Proses produksi harus dikerjakan secara berurutan dan tidak boleh melompati tahap. Tahapan berikutnya yang harus dikerjakan adalah: {$next_allowed}.");
                    redirect('admin/detail_pesanan/' . $pesanan_id);
                }
            }
        }

        if ($this->Pesanan_model->update_status_produksi($pesanan_id, $status_produksi, $keterangan, $admin_id)) {
            $this->session->set_flashdata('success', 'Status produksi real-time berhasil diperbarui secara berurutan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui status produksi.');
        }
        redirect('admin/detail_pesanan/' . $pesanan_id);
    }

    public function stok_kaos() {
        $data['title'] = 'Kelola Bahan Baku & Stok Kaos - Admin';
        $data['kaos_list'] = $this->Kaos_model->get_all_kaos();
        $data['user'] = get_user_session();

        $this->load->view('layouts/admin_header', $data);
        $this->load->view('admin/stok_kaos', $data);
        $this->load->view('layouts/admin_footer');
    }

    public function update_stok() {
        $kaos_id = $this->input->post('kaos_id', TRUE);
        $stok_ukuran = [
            'S' => $this->input->post('stok_S', TRUE),
            'M' => $this->input->post('stok_M', TRUE),
            'L' => $this->input->post('stok_L', TRUE),
            'XL' => $this->input->post('stok_XL', TRUE),
            'XXL' => $this->input->post('stok_XXL', TRUE)
        ];

        $data_kaos = [
            'nama_kaos' => $this->input->post('nama_kaos', TRUE),
            'jenis_bahan' => $this->input->post('jenis_bahan', TRUE),
            'harga_dasar' => $this->input->post('harga_dasar', TRUE),
            'deskripsi' => $this->input->post('deskripsi', TRUE),
            'kategori' => $this->input->post('kategori', TRUE)
        ];

        if (!empty($_FILES['gambar']['name'])) {
            $upload_path = './assets/images/';
            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name']     = 'kaos_' . time();
            $this->upload->initialize($config);

            if ($this->upload->do_upload('gambar')) {
                $up_data = $this->upload->data();
                $data_kaos['gambar'] = $up_data['file_name'];
            }
        }

        $this->Kaos_model->update_kaos($kaos_id, $data_kaos, $stok_ukuran);
        $this->session->set_flashdata('success', 'Data kaos & stok berhasil diperbarui!');
        redirect('admin/stok_kaos');
    }

    public function tambah_kaos() {
        $data_kaos = [
            'nama_kaos' => $this->input->post('nama_kaos', TRUE),
            'jenis_bahan' => $this->input->post('jenis_bahan', TRUE),
            'harga_dasar' => $this->input->post('harga_dasar', TRUE),
            'deskripsi' => $this->input->post('deskripsi', TRUE),
            'kategori' => $this->input->post('kategori', TRUE),
            'gambar' => 'default_kaos.jpg'
        ];

        if (!empty($_FILES['gambar']['name'])) {
            $upload_path = './assets/images/';
            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name']     = 'kaos_' . time();
            $this->upload->initialize($config);

            if ($this->upload->do_upload('gambar')) {
                $up_data = $this->upload->data();
                $data_kaos['gambar'] = $up_data['file_name'];
            }
        }

        $stok_ukuran = [
            'S' => $this->input->post('stok_S', TRUE),
            'M' => $this->input->post('stok_M', TRUE),
            'L' => $this->input->post('stok_L', TRUE),
            'XL' => $this->input->post('stok_XL', TRUE),
            'XXL' => $this->input->post('stok_XXL', TRUE)
        ];

        $this->Kaos_model->insert_kaos($data_kaos, $stok_ukuran);
        $this->session->set_flashdata('success', 'Produk kaos baru berhasil ditambahkan!');
        redirect('admin/stok_kaos');
    }

    public function hapus_kaos($kaos_id) {
        $this->Kaos_model->delete_kaos($kaos_id);
        $this->session->set_flashdata('success', 'Produk kaos berhasil dihapus!');
        redirect('admin/stok_kaos');
    }
}
