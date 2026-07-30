# 👕 Gind Screen Printing - Sistem Informasi Manajemen Produksi & Pemesanan Sablon Kaos

Sistem Informasi Manajemen Produksi & Pemesanan Sablon Kaos **Gind Screen Printing** adalah aplikasi berbasis web yang dibangun menggunakan **PHP CodeIgniter 3** dan **MySQL/MariaDB**. Aplikasi ini dirancang untuk memudahkan proses bisnis usaha percetakan/sablon kaos, mulai dari pemesanan custom oleh pelanggan, pelacakan posisi sablon & stok kaos, pengelolaan tahapan produksi oleh admin, hingga laporan keuangan & grafik statistik untuk pemilik usaha (owner).

---

## ✨ Fitur Utama Sistem

### 👑 1. Modul Owner (Pemilik Toko)
- **Dashboard Ringkasan Usaha**: Menampilkan total transaksi, omzet pendapatan, pesanan aktif, serta stok kaos yang tersedia.
- **Grafik Pendapatan & Produksi**: Visualisasi pendapatan bulanan dan tren status produksi.
- **Laporan Keuangan & Produksi**: Filter laporan berdasarkan tanggal/periode.
- **Cetak Laporan (Print Friendly)**: Fitur cetak laporan resmi untuk dokumentasi usaha.

### 🛠️ 2. Modul Admin Produksi
- **Manajemen Pesanan Masuk**: Konfirmasi pesanan, atur harga, dan verifikasi pembayaran.
- **Update Status Produksi Presisi**: Memperbarui status alur produksi:
  - `Menunggu Pembayaran` ➔ `Menunggu Konfirmasi Admin` ➔ `Desain Disetujui / Antrean Cetak` ➔ `Proses Afdruk & Sablon` ➔ `Finishing & Pressing` ➔ `Siap Diambil / Dikirim` ➔ `Selesai`
- **Manajemen Stok Kaos**: Pengelolaan stok bahan & tipe kaos berdasarkan ukuran (S, M, L, XL, XXL).
- **Log Catatan Produksi**: Mencatat setiap perubahan status produksi beserta catatan teknis dari tim bengkel sablon.

### 👤 3. Modul Pelanggan (Customer)
- **Registrasi & Login Akun**: Pendaftaran mandiri pelanggan.
- **Pemesanan Custom (Form Interactive)**:
  - Kartu pilihan bahan kaos (Cotton Combed 30s/24s, Carded, PE, Heavyweight Oversize).
  - Pilihan ukuran kaos (S-XXL) & kalkulasi estimasi harga otomatis.
  - Upload file desain custom (PNG, JPG, PDF, SVG, ZIP).
  - Pilihan posisi cetak sablon (Dada Depan, Dada Kiri, Punggung Full, dll.).
- **Upload Bukti Pembayaran**: Mengunggah bukti transfer bank atau e-wallet.
- **Pelacakan Timeline Pesanan**: Melihat progres pembuatan kaos secara real-time.

### 🔍 4. Modul Publik & Pelacakan Mandiri (Tanpa Login)
- **Landing Page Interaktif**: Menampilkan informasi layanan, daftar bahan kaos, serta keunggulan sablon Gind.
- **Lacak Pesanan Mandiri**: Memungkinkan pelanggan melacak status pesanan hanya dengan memasukkan Nomor Pesanan / Nomor HP.

---

## 🛠️ Teknologi yang Digunakan

- **Backend Framework**: PHP 7.4 / 8.x - CodeIgniter 3.1.13
- **Database**: MySQL / MariaDB (`db_gind_sablon`)
- **Frontend Framework**: HTML5, CSS3, JavaScript (ES6)
- **UI & Styling**: Bootstrap 5.3, FontAwesome 6 (Icons), Google Fonts (Plus Jakarta Sans)
- **Server Environment**: Apache / Nginx (XAMPP / Laragon / Web Hosting)

---

## 🔑 Akun Login Demo

Gunakan akun berikut untuk mencoba fitur sesuai role masing-masing:

| Role | Username | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| **👑 Owner** | `owner` | `owner123` | Dashboard Keuangan, Grafis & Laporan |
| **🛠️ Admin** | `admin` | `admin123` | Kelola Pesanan, Update Status Sablon & Stok Kaos |
| **👤 Pelanggan** | `pelanggan` | `pelanggan123` | Buat Pesanan Baru, Upload Bukti Bayar & Cek Status |

---

## 🚀 Panduan Instalasi & Cara Menjalankan Project

Ikuti langkah-langkah di bawah ini untuk menjalankan project di lingkungan lokal (XAMPP):

### 1. Prasyarat Sistem
- **XAMPP** (disarankan versi PHP 7.4 ke atas) atau web server sejenis (Laragon/WAMP).
- Web Browser (Google Chrome, Mozilla Firefox, Microsoft Edge, dll).

### 2. Penempatan Folder Project
1. Unduh atau clone repository ini.
2. Salin folder project ke dalam direktori web server lokal Anda:
   - **XAMPP**: `C:\xampp\htdocs\sablon` (atau `C:\xampp\htdocs\project\sablon`)

### 3. Import Database MySQL
1. Buka XAMPP Control Panel dan jalankan service **Apache** dan **MySQL**.
2. Buka browser dan akses **phpMyAdmin** (`http://localhost/phpmyadmin`).
3. Buat database baru dengan nama: `db_gind_sablon`.
4. Pilih database `db_gind_sablon`, kemudian klik tab **Import**.
5. Pilih file `database.sql` yang berada di dalam folder utama project ini, lalu klik **Go / Kirim**.

### 4. Konfigurasi CodeIgniter (Optional)
Jika nama folder atau port XAMPP Anda berbeda, sesuaikan pengaturan berikut:
- **Base URL**: Cek pada file `application/config/config.php`
  ```php
  $config['base_url'] = 'http://localhost/sablon/'; // Sesuaikan dengan path folder Anda
  ```
- **Koneksi Database**: Cek pada file `application/config/database.php`
  ```php
  'hostname' => 'localhost',
  'username' => 'root',
  'password' => '',
  'database' => 'db_gind_sablon',
  'dbdriver' => 'mysqli',
  ```

### 5. Akses Aplikasi
Buka web browser Anda dan ketikkan alamat berikut:
- **Halaman Utama / Landing Page**: `http://localhost/sablon/`
- **Halaman Login**: `http://localhost/sablon/login`
- **Halaman Lacak Pesanan**: `http://localhost/sablon/lacak`

---

## 📂 Struktur Utama Project

```text
sablon/
├── application/
│   ├── config/             # Konfigurasi CodeIgniter (routes, database, config)
│   ├── controllers/        # Controller utama (Admin, Auth, Landing, Owner, Pelanggan)
│   ├── models/             # Model database (Kaos, Laporan, Pembayaran, Pesanan, Produksi, Profil, User)
│   └── views/              # View tampilan (admin, auth, landing, layouts, owner, pelanggan)
├── assets/
│   ├── css/                # Styling khusus
│   ├── images/             # Gambar pendukung & foto sampel produk kaos
│   ├── js/                 # Script JavaScript
│   └── uploads/            # Direktori simpan file desain & bukti pembayaran
├── database.sql            # Dump file database MySQL awal
├── index.php               # Entry point CodeIgniter
└── README.md               # Dokumentasi petunjuk & instalasi
```

---

## 📞 Dukungan & Lisensi

Sistem ini dikembangkan khusus untuk **Gind Screen Printing**. Jika terdapat pertanyaan atau kebutuhan penyesuaian fitur lebih lanjut, silakan hubungi tim pengembang.

**© 2026 Gind Screen Printing. All Rights Reserved.**
