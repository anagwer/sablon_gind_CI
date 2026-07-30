<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('format_rupiah')) {
    function format_rupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('badge_status_pembayaran')) {
    function badge_status_pembayaran($status) {
        switch ($status) {
            case 'lunas':
                return '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Lunas</span>';
            case 'menunggu_verifikasi':
                return '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Menunggu Verifikasi</span>';
            case 'ditolak':
                return '<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Ditolak</span>';
            default:
                return '<span class="badge bg-secondary"><i class="fas fa-wallet me-1"></i>Belum Bayar</span>';
        }
    }
}

if (!function_exists('badge_status_produksi')) {
    function badge_status_produksi($status) {
        switch ($status) {
            case 'pending':
                return '<span class="badge bg-secondary"><i class="fas fa-hourglass-start me-1"></i>Menunggu Pembayaran</span>';
            case 'diverifikasi':
                return '<span class="badge bg-info text-dark"><i class="fas fa-file-invoice-dollar me-1"></i>Pembayaran Terverifikasi</span>';
            case 'desain':
                return '<span class="badge bg-primary"><i class="fas fa-paint-brush me-1"></i>Setting & Desain Film</span>';
            case 'afdruk':
                return '<span class="badge bg-indigo text-white" style="background-color: #6610f2;"><i class="fas fa-film me-1"></i>Afdruk Screen</span>';
            case 'sablon':
                return '<span class="badge bg-warning text-dark"><i class="fas fa-tshirt me-1"></i>Proses Sablon</span>';
            case 'pengeringan':
                return '<span class="badge bg-orange text-white" style="background-color: #fd7e14;"><i class="fas fa-fire me-1"></i>Pengeringan & Curing</span>';
            case 'pengemasan':
                return '<span class="badge bg-teal text-white" style="background-color: #20c997;"><i class="fas fa-box me-1"></i>Pengemasan & QC</span>';
            case 'selesai':
                return '<span class="badge bg-success"><i class="fas fa-check-double me-1"></i>Selesai & Siap Diambil</span>';
            case 'dibatalkan':
                return '<span class="badge bg-danger"><i class="fas fa-ban me-1"></i>Dibatalkan</span>';
            default:
                return '<span class="badge bg-secondary">Unknown</span>';
        }
    }
}

if (!function_exists('nama_status_produksi')) {
    function nama_status_produksi($status) {
        $statuses = [
            'pending' => '1. Menunggu Pembayaran',
            'diverifikasi' => '2. Diverifikasi / Masuk Antrean',
            'desain' => '3. Setting & Desain Film',
            'afdruk' => '4. Afdruk Screen',
            'sablon' => '5. Proses Sablon',
            'pengeringan' => '6. Pengeringan & Curing',
            'pengemasan' => '7. Pengemasan & QC',
            'selesai' => '8. Selesai & Siap Diambil',
            'dibatalkan' => 'Pesanan Dibatalkan'
        ];
        return isset($statuses[$status]) ? $statuses[$status] : $status;
    }
}
