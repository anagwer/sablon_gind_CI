-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2026 at 10:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_gind_sablon`
--

-- --------------------------------------------------------

--
-- Table structure for table `kaos`
--

CREATE TABLE `kaos` (
  `id` int(11) NOT NULL,
  `nama_kaos` varchar(100) NOT NULL,
  `jenis_bahan` varchar(100) NOT NULL,
  `harga_dasar` decimal(12,2) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT 'default_kaos.jpg',
  `kategori` enum('murah','sedang','mahal') DEFAULT 'sedang',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kaos`
--

INSERT INTO `kaos` (`id`, `nama_kaos`, `jenis_bahan`, `harga_dasar`, `deskripsi`, `gambar`, `kategori`, `created_at`) VALUES
(1, 'Kaos Polyester (PE) Soft', 'Polyester PE 24s', 28000.00, 'Bahan kaos ekonomis dengan daya tahan tinggi, cocok untuk kaos event, promosi, atau sablon partai besar.', 'kaos_pe.png', 'murah', '2026-07-29 08:41:09'),
(2, 'Kaos Cotton Carded 24s', 'Cotton Carded 24s', 42000.00, 'Bahan katun standar, menyerap keringat dengan baik dan nyaman dipakai harian.', 'kaos_carded.jpg', 'sedang', '2026-07-29 08:41:09'),
(3, 'Kaos Cotton Combed 30s Premium', 'Cotton Combed 30s', 55000.00, 'Bahan favorit clothing line. Sangat lembut, adem, serat halus, dan pas di badan.', 'kaos_combed30s.jpeg', 'sedang', '2026-07-29 08:41:09'),
(4, 'Kaos Cotton Combed 24s Tebe', 'Cotton Combed 24s', 62000.00, 'Lebih tebal dibanding 30s namun tetap lembut dan menyerap keringat. Ideal untuk sablon kualitas tinggi.', 'kaos_combed24s.jpeg', 'mahal', '2026-07-29 08:41:09'),
(5, 'Kaos Heavyweight / Oversize 20s', 'Cotton Combed 20s Heavyweight', 85000.00, 'Potongan Oversize gaya modern street-style dengan ketebalan kain tinggi dan tidak mudah melar.', 'kaos_oversize.jpg', 'mahal', '2026-07-29 08:41:09');

-- --------------------------------------------------------

--
-- Table structure for table `log_produksi`
--

CREATE TABLE `log_produksi` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `status_produksi` enum('pending','diverifikasi','desain','afdruk','sablon','pengeringan','pengemasan','selesai','dibatalkan') NOT NULL,
  `keterangan` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_produksi`
--

INSERT INTO `log_produksi` (`id`, `pesanan_id`, `status_produksi`, `keterangan`, `created_by`, `created_at`) VALUES
(1, 1, 'pending', 'Pesanan berhasil dibuat oleh pelanggan', 3, '2026-07-28 03:15:00'),
(2, 1, 'diverifikasi', 'Pembayaran senilai Rp 1.320.000 terverifikasi valid', 2, '2026-07-28 04:30:00'),
(3, 1, 'desain', 'Setting film & pemisahan warna sablon selesai', 2, '2026-07-28 07:00:00'),
(4, 1, 'afdruk', 'Afdruk screen sablon selesai dilakukan', 2, '2026-07-29 01:00:00'),
(5, 1, 'sablon', 'Proses pengolesan tinta sablon pada kaos sedang berlangsung', 2, '2026-07-29 03:00:00'),
(6, 2, 'pending', 'Pesanan berhasil dibuat oleh pelanggan. Menunggu konfirmasi pembayaran.', 4, '2026-07-29 01:30:00'),
(7, 2, 'sablon', '-', 2, '2026-07-29 09:09:13'),
(8, 2, 'pending', '-', 2, '2026-07-29 09:10:19'),
(9, 2, 'diverifikasi', 'Pembayaran terverifikasi valid oleh Admin. Stok kaos berhasil dipotong & pesanan masuk antrean produksi.', 2, '2026-07-29 09:10:23'),
(10, 2, 'desain', '-', 2, '2026-07-29 09:10:44');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `bank_tujuan` varchar(50) NOT NULL,
  `nama_pengirim` varchar(100) NOT NULL,
  `jumlah_bayar` decimal(12,2) NOT NULL,
  `bukti_transfer` varchar(255) NOT NULL,
  `tanggal_bayar` datetime NOT NULL,
  `status` enum('pending','valid','invalid') NOT NULL DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL,
  `verified_by` int(11) DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `pesanan_id`, `bank_tujuan`, `nama_pengirim`, `jumlah_bayar`, `bukti_transfer`, `tanggal_bayar`, `status`, `catatan_admin`, `verified_by`, `verified_at`, `created_at`) VALUES
(1, 1, 'BCA (1234567890)', 'Rizky Pratama', 1320000.00, 'bukti_sample_1.png', '2026-07-28 11:00:00', 'valid', 'Transfer verified di m-BCA', 2, '2026-07-28 11:30:00', '2026-07-29 08:41:09'),
(2, 2, 'BCA (1234567890)', 'Budi Santoso', 1020000.00, 'bukti_sample_2.png', '2026-07-29 09:00:00', 'valid', '', 2, '2026-07-29 11:10:23', '2026-07-29 08:41:09');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_toko`
--

CREATE TABLE `pengaturan_toko` (
  `id` int(11) NOT NULL,
  `nama_toko` varchar(100) NOT NULL DEFAULT 'Gind Screen Printing',
  `tagline` varchar(255) DEFAULT 'Jasa Sablon Kaos Custom Berkualitas & Terpercaya',
  `no_wa` varchar(20) DEFAULT '081234567890',
  `alamat` text DEFAULT NULL,
  `email` varchar(100) DEFAULT 'gindscreenprinting@gmail.com',
  `bank_name` varchar(50) DEFAULT 'Bank BCA',
  `no_rekening` varchar(50) DEFAULT '1234567890',
  `atas_nama` varchar(100) DEFAULT 'Gind Screen Printing',
  `qris_image` varchar(255) DEFAULT 'qris_gind.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaturan_toko`
--

INSERT INTO `pengaturan_toko` (`id`, `nama_toko`, `tagline`, `no_wa`, `alamat`, `email`, `bank_name`, `no_rekening`, `atas_nama`, `qris_image`) VALUES
(1, 'Gind Screen Printing', 'Jasa Sablon Kaos Custom Berkualitas, Presisi & Tepat Waktu', '081234567890', 'Jl. Screen Printing No. 88, Kota Magelang, Jawa Tengah 56115', 'info@gindscreenprinting.com', 'Bank BCA', '1234567890', 'Gind Screen Printing', 'qris_gind.png');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `kode_pesanan` varchar(50) NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `kaos_id` int(11) NOT NULL,
  `ukuran` enum('S','M','L','XL','XXL') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `file_desain` varchar(255) NOT NULL,
  `posisi_sablon` varchar(100) DEFAULT 'Dada Depan',
  `catatan_pelanggan` text DEFAULT NULL,
  `catatan_admin` text DEFAULT NULL,
  `status_pembayaran` enum('belum_bayar','menunggu_verifikasi','lunas','ditolak') NOT NULL DEFAULT 'belum_bayar',
  `status_produksi` enum('pending','diverifikasi','desain','afdruk','sablon','pengeringan','pengemasan','selesai','dibatalkan') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `kode_pesanan`, `pelanggan_id`, `kaos_id`, `ukuran`, `jumlah`, `harga_satuan`, `total_harga`, `file_desain`, `posisi_sablon`, `catatan_pelanggan`, `catatan_admin`, `status_pembayaran`, `status_produksi`, `created_at`, `updated_at`) VALUES
(1, 'GIND-20260729-001', 3, 3, 'L', 24, 55000.00, 1320000.00, 'default_design.png', 'Dada Depan A3 & Punggung Belakang', 'Sablon Plastisol warna putih & merah font tegas', NULL, 'lunas', 'sablon', '2026-07-28 03:15:00', '2026-07-29 08:41:09'),
(2, 'GIND-20260729-002', 4, 5, 'XL', 12, 85000.00, 1020000.00, 'default_design.png', 'Dada Kiri & Belakang Full', 'Warna kaos hitam, tinta Discharge', NULL, 'lunas', 'desain', '2026-07-29 01:30:00', '2026-07-29 04:10:44');

-- --------------------------------------------------------

--
-- Table structure for table `stok_kaos`
--

CREATE TABLE `stok_kaos` (
  `id` int(11) NOT NULL,
  `kaos_id` int(11) NOT NULL,
  `ukuran` enum('S','M','L','XL','XXL') NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_kaos`
--

INSERT INTO `stok_kaos` (`id`, `kaos_id`, `ukuran`, `stok`, `updated_at`) VALUES
(1, 1, 'S', 50, '2026-07-29 08:41:09'),
(2, 1, 'M', 100, '2026-07-29 08:41:09'),
(3, 1, 'L', 120, '2026-07-29 08:41:09'),
(4, 1, 'XL', 80, '2026-07-29 08:41:09'),
(5, 1, 'XXL', 40, '2026-07-29 08:41:09'),
(6, 2, 'S', 30, '2026-07-29 08:41:09'),
(7, 2, 'M', 75, '2026-07-29 08:41:09'),
(8, 2, 'L', 90, '2026-07-29 08:41:09'),
(9, 2, 'XL', 60, '2026-07-29 08:41:09'),
(10, 2, 'XXL', 25, '2026-07-29 08:41:09'),
(11, 3, 'S', 60, '2026-07-29 08:41:09'),
(12, 3, 'M', 150, '2026-07-29 08:41:09'),
(13, 3, 'L', 200, '2026-07-29 08:41:09'),
(14, 3, 'XL', 110, '2026-07-29 08:41:09'),
(15, 3, 'XXL', 50, '2026-07-29 08:41:09'),
(16, 4, 'S', 40, '2026-07-29 08:41:09'),
(17, 4, 'M', 80, '2026-07-29 08:41:09'),
(18, 4, 'L', 100, '2026-07-29 08:41:09'),
(19, 4, 'XL', 70, '2026-07-29 08:41:09'),
(20, 4, 'XXL', 35, '2026-07-29 08:41:09'),
(21, 5, 'S', 20, '2026-07-29 08:41:09'),
(22, 5, 'M', 50, '2026-07-29 08:41:09'),
(23, 5, 'L', 60, '2026-07-29 08:41:09'),
(24, 5, 'XL', 28, '2026-07-29 09:10:23'),
(25, 5, 'XXL', 20, '2026-07-29 08:41:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text DEFAULT NULL,
  `role` enum('owner','admin','pelanggan') NOT NULL DEFAULT 'pelanggan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `no_hp`, `alamat`, `role`, `created_at`) VALUES
(1, 'owner', '$2y$10$EEITFg4TGjkTXm2L2QB8aeoeD7zlB5yDCupmzilHbtjiMBonMy7hS', 'Bpk. Gind (Pemilik Toko)', 'owner@gindscreenprinting.com', '081234567890', 'Jl. Screen Printing No. 88, Magelang', 'owner', '2026-07-29 08:41:09'),
(2, 'admin', '$2y$10$jh21stfCcWqdzhxhHuwBx.1h.Ec.TllUiZMjRJlzqNPnsG1muXouS', 'Admin Produksi Gind', 'admin@gindscreenprinting.com', '081298765432', 'Jl. Screen Printing No. 88, Magelang', 'admin', '2026-07-29 08:41:09'),
(3, 'pelanggan', '$2y$10$1l7BhtZlscUvRXhCi1hEle9EYh3QQUqgM6Yas0suDjkoRLI3DmdLC', 'Rizky Pratama', 'rizky@gmail.com', '085712345678', 'Jl. Merdeka Barat No. 12, Magelang', 'pelanggan', '2026-07-29 08:41:09'),
(4, 'budi', '$2y$10$84OkjixFGRCzr6WpT/yZ4e44Ju4kspb99aREaxDavqkLOB4JyFYZ6', 'Budi Santoso', 'budi@gmail.com', '081399887766', 'Muntilan, Magelang', 'pelanggan', '2026-07-29 08:41:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kaos`
--
ALTER TABLE `kaos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_produksi`
--
ALTER TABLE `log_produksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_pesanan` (`pesanan_id`),
  ADD KEY `fk_log_user` (`created_by`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pembayaran_pesanan` (`pesanan_id`),
  ADD KEY `fk_pembayaran_verifier` (`verified_by`);

--
-- Indexes for table `pengaturan_toko`
--
ALTER TABLE `pengaturan_toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pesanan` (`kode_pesanan`),
  ADD KEY `fk_pesanan_pelanggan` (`pelanggan_id`),
  ADD KEY `fk_pesanan_kaos` (`kaos_id`);

--
-- Indexes for table `stok_kaos`
--
ALTER TABLE `stok_kaos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kaos_ukuran` (`kaos_id`,`ukuran`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kaos`
--
ALTER TABLE `kaos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `log_produksi`
--
ALTER TABLE `log_produksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengaturan_toko`
--
ALTER TABLE `pengaturan_toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stok_kaos`
--
ALTER TABLE `stok_kaos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log_produksi`
--
ALTER TABLE `log_produksi`
  ADD CONSTRAINT `fk_log_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pembayaran_verifier` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_kaos` FOREIGN KEY (`kaos_id`) REFERENCES `kaos` (`id`),
  ADD CONSTRAINT `fk_pesanan_pelanggan` FOREIGN KEY (`pelanggan_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `stok_kaos`
--
ALTER TABLE `stok_kaos`
  ADD CONSTRAINT `fk_stok_kaos` FOREIGN KEY (`kaos_id`) REFERENCES `kaos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
