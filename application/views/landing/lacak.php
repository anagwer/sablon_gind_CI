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
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .tracking-header { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 4rem 0 5rem; }
        .card-custom { border: none; border-radius: 16px; box-shadow: 0 4px 25px rgba(0,0,0,0.06); background: white; }
        
        .timeline-box { position: relative; padding-left: 2rem; border-left: 3px solid #e2e8f0; }
        .timeline-item { position: relative; margin-bottom: 2rem; }
        .timeline-item::before {
            content: ''; position: absolute; left: -2.6rem; top: 2px; width: 20px; height: 20px; border-radius: 50%;
            background: #ffffff; border: 4px solid #cbd5e1;
        }
        .timeline-item.active::before { border-color: #2563eb; background: #2563eb; box-shadow: 0 0 0 4px rgba(37,99,235,0.2); }
        .timeline-item.done::before { border-color: #10b981; background: #10b981; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url(); ?>">
            <img src="<?= base_url('assets/images/gind_logo.png'); ?>" alt="Gind Logo" height="36" class="me-2" onerror="this.src='<?= base_url('assets/images/hero_sablon.png'); ?>'">
            <span class="fw-bold text-white fs-5">GIND SCREEN PRINTING</span>
        </a>
        <a href="<?= base_url(); ?>" class="btn btn-outline-light rounded-pill px-3"><i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda</a>
    </div>
</nav>

<div class="tracking-header text-center">
    <div class="container">
        <h2 class="fw-extrabold mb-2"><i class="fas fa-search-location text-info me-2"></i> Lacak Status Pesanan Real-Time</h2>
        <p class="text-light opacity-90">Pantau perkembangan pengerjaan sablon kaos Anda secara langsung tanpa perlu login.</p>
        
        <div class="row justify-content-center mt-4">
            <div class="col-md-7 col-lg-6">
                <form action="<?= base_url('lacak'); ?>" method="GET" class="d-flex gap-2">
                    <input type="text" name="kode_pesanan" value="<?= htmlspecialchars($kode_pesanan); ?>" class="form-control form-control-lg rounded-pill px-4 shadow" placeholder="Ketik Kode Pesanan (e.g. GIND-20260729-001)..." required>
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow"><i class="fas fa-search me-1"></i> Cari</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container py-5 mt-n4">
    <?php if ($this->session->flashdata('error_tracking')): ?>
        <div class="alert alert-danger rounded-3 shadow-sm text-center p-4">
            <i class="fas fa-exclamation-circle fs-1 text-danger mb-3 d-block"></i>
            <h5 class="fw-bold"><?= $this->session->flashdata('error_tracking'); ?></h5>
            <p class="text-muted mb-0">Pastikan Anda telah memasukkan Kode Pesanan yang benar dari nota atau akun pelanggan Anda.</p>
        </div>
    <?php endif; ?>

    <?php if ($pesanan): ?>
        <div class="row g-4">
            <!-- Details Card -->
            <div class="col-lg-5">
                <div class="card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill"><?= $pesanan['kode_pesanan']; ?></span>
                        <div><?= badge_status_produksi($pesanan['status_produksi']); ?></div>
                    </div>

                    <h5 class="fw-bold mb-3"><?= $pesanan['nama_kaos']; ?></h5>
                    <ul class="list-group list-group-flush mb-3 fs-7">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Pelanggan:</span>
                            <strong class="text-dark"><?= $pesanan['nama_pelanggan']; ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Bahan Kaos:</span>
                            <strong><?= $pesanan['jenis_bahan']; ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Ukuran Kaos (P & L):</span>
                            <span class="badge bg-dark fs-6 px-3"><?= $pesanan['ukuran']; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Jumlah Pesanan:</span>
                            <strong><?= $pesanan['jumlah']; ?> Pcs</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Posisi Sablon:</span>
                            <span><?= $pesanan['posisi_sablon']; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Total Pembayaran:</span>
                            <strong class="text-success fs-5"><?= format_rupiah($pesanan['total_harga']); ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Status Pembayaran:</span>
                            <div><?= badge_status_pembayaran($pesanan['status_pembayaran']); ?></div>
                        </li>
                    </ul>

                    <div class="p-3 bg-light rounded-3 text-center">
                        <small class="text-muted d-block mb-1">Status Produksi Saat Ini:</small>
                        <h6 class="fw-extrabold text-primary mb-0"><?= nama_status_produksi($pesanan['status_produksi']); ?></h6>
                    </div>
                </div>
            </div>

            <!-- Timeline Log Card -->
            <div class="col-lg-7">
                <div class="card-custom p-4">
                    <h5 class="fw-bold mb-4"><i class="fas fa-history text-primary me-2"></i> Timeline Histori Produksi Real-Time</h5>

                    <div class="timeline-box ps-4 ms-2">
                        <?php if (empty($logs)): ?>
                            <p class="text-muted">Belum ada catatan aktivitas produksi.</p>
                        <?php else: ?>
                            <?php foreach ($logs as $log): ?>
                                <div class="timeline-item done">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold mb-1"><?= nama_status_produksi($log['status_produksi']); ?></h6>
                                        <small class="text-muted"><i class="far fa-clock me-1"></i><?= date('d M Y, H:i', strtotime($log['created_at'])); ?> WIB</small>
                                    </div>
                                    <p class="text-secondary small mb-1"><?= $log['keterangan']; ?></p>
                                    <?php if (!empty($log['updated_by_name'])): ?>
                                        <small class="text-muted fst-italic">Diperbarui oleh: <?= $log['updated_by_name']; ?></small>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
