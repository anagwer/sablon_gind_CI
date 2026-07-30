<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Selamat Datang, <?= $user['nama_lengkap']; ?>! 👋</h3>
        <p class="text-muted mb-0">Pantau seluruh status produksi pesanan sablon Anda secara real-time di sini.</p>
    </div>
    <a href="<?= base_url('pelanggan/buat_pesanan'); ?>" class="btn btn-gind shadow"><i class="fas fa-plus-circle me-1"></i> Buat Pesanan Baru</a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card-custom p-4 border-start border-primary border-4">
            <small class="text-muted fw-bold text-uppercase">Total Pesanan Saya</small>
            <h2 class="fw-extrabold text-primary mb-0 mt-1"><?= count($pesanan_list); ?></h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-custom p-4 border-start border-warning border-4">
            <small class="text-muted fw-bold text-uppercase">Dalam Proses Produksi</small>
            <?php 
                $dalam_proses = 0;
                foreach ($pesanan_list as $p) {
                    if (in_array($p['status_produksi'], ['pending', 'diverifikasi', 'desain', 'afdruk', 'sablon', 'pengeringan', 'pengemasan'])) {
                        $dalam_proses++;
                    }
                }
            ?>
            <h2 class="fw-extrabold text-warning mb-0 mt-1"><?= $dalam_proses; ?></h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-custom p-4 border-start border-success border-4">
            <small class="text-muted fw-bold text-uppercase">Pesanan Selesai</small>
            <?php 
                $selesai = 0;
                foreach ($pesanan_list as $p) {
                    if ($p['status_produksi'] == 'selesai') {
                        $selesai++;
                    }
                }
            ?>
            <h2 class="fw-extrabold text-success mb-0 mt-1"><?= $selesai; ?></h2>
        </div>
    </div>
</div>

<div class="card-custom p-4">
    <h5 class="fw-bold mb-3"><i class="fas fa-list-alt text-primary me-2"></i> Riwayat Pesanan Saya</h5>
    
    <?php if (empty($pesanan_list)): ?>
        <div class="text-center py-5">
            <img src="<?= base_url('assets/images/hero_sablon.png'); ?>" alt="Kosong" style="max-height: 120px; opacity: 0.5;" class="mb-3">
            <h6 class="fw-bold text-secondary">Belum Ada Pesanan</h6>
            <p class="text-muted small mb-3">Anda belum pernah membuat pesanan sablon. Mulai pesan sekarang!</p>
            <a href="<?= base_url('pelanggan/buat_pesanan'); ?>" class="btn btn-primary rounded-pill px-4"><i class="fas fa-plus me-1"></i> Buat Pesanan Baru</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Bahan Kaos</th>
                        <th>Ukuran</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status Bayar</th>
                        <th>Status Produksi Real-Time</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pesanan_list as $pesanan): ?>
                        <tr>
                            <td>
                                <strong class="text-primary d-block"><?= $pesanan['kode_pesanan']; ?></strong>
                                <small class="text-muted"><?= date('d M Y, H:i', strtotime($pesanan['created_at'])); ?></small>
                            </td>
                            <td>
                                <strong><?= $pesanan['nama_kaos']; ?></strong><br>
                                <small class="text-muted"><?= $pesanan['jenis_bahan']; ?></small>
                            </td>
                            <td><span class="badge bg-dark px-3 py-2 fs-6"><?= $pesanan['ukuran']; ?></span></td>
                            <td><strong><?= $pesanan['jumlah']; ?> Pcs</strong></td>
                            <td><span class="fw-bold text-success"><?= format_rupiah($pesanan['total_harga']); ?></span></td>
                            <td><?= badge_status_pembayaran($pesanan['status_pembayaran']); ?></td>
                            <td><?= badge_status_produksi($pesanan['status_produksi']); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= base_url('pelanggan/detail/' . $pesanan['id']); ?>" class="btn btn-sm btn-outline-primary fw-semibold"><i class="fas fa-eye me-1"></i> Detail & Tracking</a>
                                    <?php if ($pesanan['status_pembayaran'] == 'belum_bayar'): ?>
                                        <a href="<?= base_url('pelanggan/bayar/' . $pesanan['id']); ?>" class="btn btn-sm btn-success fw-semibold"><i class="fas fa-upload me-1"></i> Bayar</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
