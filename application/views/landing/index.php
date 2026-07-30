<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .hero-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%);
            color: white;
            padding: 5rem 0 6rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            left: 0;
            height: 50px;
            background: #f8fafc;
            clip-path: polygon(0 100%, 100% 100%, 100% 0);
        }

        .hero-img-box {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            border: 4px solid rgba(255,255,255,0.1);
        }

        .tracking-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-top: -3rem;
            position: relative;
            z-index: 10;
            padding: 2rem;
        }

        .kaos-card {
            border: none;
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
        }

        .kaos-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        .kaos-img {
            height: 220px;
            object-fit: cover;
            border-radius: 16px 16px 0 0;
        }

        .badge-kategori-murah { background-color: #10b981; color: white; }
        .badge-kategori-sedang { background-color: #3b82f6; color: white; }
        .badge-kategori-mahal { background-color: #8b5cf6; color: white; }

        .step-box {
            text-align: center;
            padding: 1.5rem;
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            height: 100%;
        }

        .step-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #eff6ff;
            color: #2563eb;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 3px;
            color: #1e293b;
            font-weight: 600;
        }
        .pagination .page-item.active .page-link {
            background-color: #2563eb;
            border-color: #2563eb;
            color: white;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url(); ?>">
            <img src="<?= base_url('assets/images/gind_logo.png'); ?>" alt="Gind Logo" height="40" class="me-2" onerror="this.src='<?= base_url('assets/images/hero_sablon.png'); ?>'">
            <div class="lh-1">
                <span class="fw-bold fs-4 text-white d-block">GIND</span>
                <small class="text-info fs-7 fw-semibold">SCREEN PRINTING</small>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navLanding">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navLanding">
            <ul class="navbar-nav me-auto ms-4">
                <li class="nav-item"><a class="nav-link active" href="#hero">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#katalog">Katalog Kaos</a></li>
                <li class="nav-item"><a class="nav-link" href="#alur">Alur Produksi</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('lacak'); ?>">Lacak Pesanan</a></li>
            </ul>
            <div class="d-flex gap-2">
                <?php if ($this->session->userdata('user_id')): ?>
                    <?php 
                        $r = $this->session->userdata('role');
                        $target_url = ($r == 'owner') ? 'owner/dashboard' : (($r == 'admin') ? 'admin/dashboard' : 'pelanggan/dashboard');
                    ?>
                    <a href="<?= base_url($target_url); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold"><i class="fas fa-tachometer-alt me-1"></i> Dashboard (<?= ucfirst($r); ?>)</a>
                <?php else: ?>
                    <a href="<?= base_url('login'); ?>" class="btn btn-outline-light rounded-pill px-4">Login</a>
                    <a href="<?= base_url('register'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold">Register Pelanggan</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="hero" class="hero-section">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <span class="badge bg-info text-dark px-3 py-2 rounded-pill fw-bold mb-3"><i class="fas fa-certificate me-1"></i> Gind Screen Printing Professional</span>
                <h1 class="display-4 fw-extrabold mb-3">Sistem Informasi Manajemen Produksi Sablon Real-Time</h1>
                <p class="lead text-light opacity-90 mb-4">Pesan kaos custom dengan file desain Anda sendiri, pilih jenis bahan terbaik (dari PE hemat hingga Cotton Combed & Heavyweight Oversize), dan pantau tahapan alur produksi sablon Anda secara transparan dan real-time!</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= base_url('register'); ?>" class="btn btn-primary btn-lg rounded-pill px-4 py-3 fw-bold shadow"><i class="fas fa-shopping-cart me-2"></i> Buat Pesanan Sekarang</a>
                    <a href="#katalog" class="btn btn-outline-light btn-lg rounded-pill px-4 py-3 fw-bold"><i class="fas fa-tshirt me-2"></i> Lihat Katalog Kaos</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="hero-img-box">
                    <img src="<?= base_url('assets/images/hero_sablon.png'); ?>" alt="Sablon Banner" class="img-fluid w-100">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tracking Bar (Tanpa Login) -->
<div class="container">
    <div class="tracking-card">
        <div class="row align-items-center">
            <div class="col-lg-4 mb-3 mb-lg-0">
                <h5 class="fw-bold mb-1"><i class="fas fa-search-location text-primary me-2"></i> Lacak Pesanan Tanpa Login</h5>
                <p class="text-muted small mb-0">Masukkan Kode Pesanan Anda (contoh: GIND-20260729-001) untuk cek status produksi real-time.</p>
            </div>
            <div class="col-lg-8">
                <form action="<?= base_url('lacak'); ?>" method="GET" class="d-flex gap-2">
                    <input type="text" name="kode_pesanan" class="form-control form-control-lg rounded-pill px-4" placeholder="Masukkan Kode Pesanan (e.g. GIND-20260729-001)..." required>
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold"><i class="fas fa-search me-1"></i> Lacak</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Katalog Kaos Section with Pagination -->
<section id="katalog" class="py-5 my-4">
    <div class="container">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="text-primary fw-bold text-uppercase tracking-wider">Katalog Produk</span>
            <h2 class="fw-extrabold fs-1 mt-1">Pilihan Bahan Kaos Sablon</h2>
            <p class="text-muted">Tersedia berbagai pilihan tipe kaos dari harga murah/ekonomis sampai kualitas premium, lengkap dengan pilihan ukuran P & L (S - XXL).</p>
        </div>

        <div class="row g-4" id="katalog-container">
            <?php foreach ($kaos_list as $k): ?>
                <div class="col-md-6 col-lg-4 katalog-item">
                    <div class="kaos-card">
                        <div class="position-relative">
                            <img src="<?= base_url('assets/images/' . $k['gambar']); ?>" alt="<?= $k['nama_kaos']; ?>" class="kaos-img w-100" onerror="this.src='<?= base_url('assets/images/hero_sablon.png'); ?>'">
                            <span class="position-absolute top-0 end-0 m-3 badge rounded-pill badge-kategori-<?= $k['kategori']; ?> px-3 py-2 fw-semibold">
                                Tipe <?= ucfirst($k['kategori']); ?>
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-1"><?= $k['nama_kaos']; ?></h5>
                            <p class="text-secondary small mb-2"><i class="fas fa-layer-group me-1"></i> Bahan: <strong><?= $k['jenis_bahan']; ?></strong></p>
                            <p class="text-muted small mb-3"><?= $k['deskripsi']; ?></p>
                            
                            <div class="bg-light p-3 rounded-3 mb-3">
                                <span class="d-block text-muted small fw-semibold mb-1"><i class="fas fa-ruler-combined me-1"></i> Stok Ukuran Tersedia (S - XXL):</span>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php foreach ($k['stok'] as $st): ?>
                                        <span class="badge bg-white text-dark border px-2 py-1 fs-7">
                                            <?= $st['ukuran']; ?>: <strong><?= $st['stok']; ?></strong> Pcs
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                <div>
                                    <small class="text-muted d-block">Harga Polos + Sablon:</small>
                                    <span class="fw-extrabold fs-4 text-primary"><?= format_rupiah($k['harga_dasar']); ?></span> <small class="text-muted">/pcs</small>
                                </div>
                                <a href="<?= base_url('pelanggan/buat_pesanan'); ?>" class="btn btn-outline-primary rounded-pill fw-semibold px-3"><i class="fas fa-cart-plus me-1"></i> Pesan</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination Bar -->
        <div class="d-flex justify-content-center align-items-center mt-5">
            <nav>
                <ul class="pagination pagination-lg mb-0" id="katalog-pagination"></ul>
            </nav>
        </div>
    </div>
</section>

<!-- Alur Produksi Real-Time -->
<section id="alur" class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-primary fw-bold text-uppercase">Transparansi Produksi</span>
            <h2 class="fw-extrabold fs-1 mt-1">Alur Proses Produksi Sablon Real-Time</h2>
            <p class="text-muted">Setiap tahapan pengerjaan sablon dicatat secara langsung oleh tim Admin produksi kami.</p>
        </div>

        <div class="row g-3">
            <div class="col-md-4 col-lg-2">
                <div class="step-box">
                    <div class="step-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <h6 class="fw-bold">1. Verifikasi</h6>
                    <small class="text-muted">Pengecekan pembayaran oleh Admin</small>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="step-box">
                    <div class="step-icon"><i class="fas fa-paint-brush"></i></div>
                    <h6 class="fw-bold">2. Desain Film</h6>
                    <small class="text-muted">Setting & pemisahan warna film</small>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="step-box">
                    <div class="step-icon"><i class="fas fa-film"></i></div>
                    <h6 class="fw-bold">3. Afdruk Screen</h6>
                    <small class="text-muted">Pemindahan gambar ke screen sablon</small>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="step-box">
                    <div class="step-icon"><i class="fas fa-tshirt"></i></div>
                    <h6 class="fw-bold">4. Proses Sablon</h6>
                    <small class="text-muted">Penyablonan tinta ke media kaos</small>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="step-box">
                    <div class="step-icon"><i class="fas fa-fire"></i></div>
                    <h6 class="fw-bold">5. Pengeringan</h6>
                    <small class="text-muted">Proses curing & pres panas</small>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="step-box">
                    <div class="step-icon"><i class="fas fa-box-open"></i></div>
                    <h6 class="fw-bold">6. QC & Pengemasan</h6>
                    <small class="text-muted">Pemeriksaan & Siap Diambil/Kirim</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <p class="mb-1 fw-bold">GIND SCREEN PRINTING &copy; <?= date('Y'); ?></p>
        <p class="text-secondary small mb-0">Jl. Screen Printing No. 88, Kota Magelang, Jawa Tengah | WhatsApp: 0812-3456-7890</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Pagination Katalog Landing Page -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const itemsPerPage = 3; // Tampilkan 3 produk kaos per halaman
    const items = document.querySelectorAll(".katalog-item");
    const paginationContainer = document.getElementById("katalog-pagination");

    if (items.length <= itemsPerPage) return;

    let totalPages = Math.ceil(items.length / itemsPerPage);

    function showPage(page) {
        let start = (page - 1) * itemsPerPage;
        let end = start + itemsPerPage;

        items.forEach((item, index) => {
            if (index >= start && index < end) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });

        renderPagination(page);
    }

    function renderPagination(currentPage) {
        let html = '';
        
        // Prev
        html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#katalog" onclick="changeCatalogPage(${currentPage - 1})">&laquo; Sebelum</a>
                 </li>`;

        for (let i = 1; i <= totalPages; i++) {
            html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#katalog" onclick="changeCatalogPage(${i})">${i}</a>
                     </li>`;
        }

        // Next
        html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#katalog" onclick="changeCatalogPage(${currentPage + 1})">Berikut &raquo;</a>
                 </li>`;

        paginationContainer.innerHTML = html;
    }

    window.changeCatalogPage = function(page) {
        if (page < 1 || page > totalPages) return;
        showPage(page);
    };

    showPage(1);
});
</script>
</body>
</html>
