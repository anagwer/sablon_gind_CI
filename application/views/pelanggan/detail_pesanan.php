<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Detail & Monitoring Real-Time Pesanan</h3>
        <p class="text-muted mb-0">Kode Pesanan: <strong class="text-primary"><?= $pesanan['kode_pesanan']; ?></strong></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('pelanggan/dashboard'); ?>" class="btn btn-outline-secondary rounded-pill px-3"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
        <?php if ($pesanan['status_pembayaran'] == 'belum_bayar'): ?>
            <a href="<?= base_url('pelanggan/bayar/' . $pesanan['id']); ?>" class="btn btn-success rounded-pill px-3 fw-bold"><i class="fas fa-upload me-1"></i> Konfirmasi Pembayaran</a>
        <?php endif; ?>
    </div>
</div>

<!-- Real-time Production Tracker Bar -->
<div class="card-custom p-4 mb-4">
    <h5 class="fw-bold mb-1"><i class="fas fa-tasks text-primary me-2"></i> Progress Produksi Real-Time</h5>
    <small class="text-muted d-block mb-3">Status produksi saat ini: <strong class="text-dark"><?= nama_status_produksi($pesanan['status_produksi']); ?></strong></small>

    <?php 
        $steps = ['diverifikasi', 'desain', 'afdruk', 'sablon', 'pengeringan', 'pengemasan', 'selesai'];
        $current_idx = array_search($pesanan['status_produksi'], $steps);
        if ($current_idx === FALSE) $current_idx = -1;
    ?>

    <div class="timeline-steps">
        <div class="timeline-step <?= ($current_idx >= 0) ? 'completed' : 'active'; ?>">
            <div class="timeline-icon"><i class="fas fa-check"></i></div>
            <div class="timeline-label">Verifikasi</div>
        </div>
        <div class="timeline-step <?= ($current_idx > 1) ? 'completed' : (($current_idx == 1) ? 'active' : ''); ?>">
            <div class="timeline-icon"><i class="fas fa-paint-brush"></i></div>
            <div class="timeline-label">Desain Film</div>
        </div>
        <div class="timeline-step <?= ($current_idx > 2) ? 'completed' : (($current_idx == 2) ? 'active' : ''); ?>">
            <div class="timeline-icon"><i class="fas fa-film"></i></div>
            <div class="timeline-label">Afdruk</div>
        </div>
        <div class="timeline-step <?= ($current_idx > 3) ? 'completed' : (($current_idx == 3) ? 'active' : ''); ?>">
            <div class="timeline-icon"><i class="fas fa-tshirt"></i></div>
            <div class="timeline-label">Sablon</div>
        </div>
        <div class="timeline-step <?= ($current_idx > 4) ? 'completed' : (($current_idx == 4) ? 'active' : ''); ?>">
            <div class="timeline-icon"><i class="fas fa-fire"></i></div>
            <div class="timeline-label">Pengeringan</div>
        </div>
        <div class="timeline-step <?= ($current_idx > 5) ? 'completed' : (($current_idx == 5) ? 'active' : ''); ?>">
            <div class="timeline-icon"><i class="fas fa-box"></i></div>
            <div class="timeline-label">Pengemasan</div>
        </div>
        <div class="timeline-step <?= ($current_idx == 6) ? 'completed' : ''; ?>">
            <div class="timeline-icon"><i class="fas fa-flag-checkered"></i></div>
            <div class="timeline-label">Selesai</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Main Order Info -->
    <div class="col-lg-6">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold border-bottom pb-2 mb-3 text-primary"><i class="fas fa-info-circle me-2"></i> Rincian Pesanan</h5>
            
            <table class="table table-borderless fs-7 mb-0">
                <tr>
                    <td class="text-muted" style="width: 35%;">Kode Pesanan</td>
                    <td>: <strong class="text-primary"><?= $pesanan['kode_pesanan']; ?></strong></td>
                </tr>
                <tr>
                    <td class="text-muted">Tanggal Pesan</td>
                    <td>: <?= date('d M Y, H:i', strtotime($pesanan['created_at'])); ?> WIB</td>
                </tr>
                <tr>
                    <td class="text-muted">Bahan Kaos</td>
                    <td>: <strong><?= $pesanan['nama_kaos']; ?></strong> (<?= $pesanan['jenis_bahan']; ?>)</td>
                </tr>
                <tr>
                    <td class="text-muted">Ukuran Kaos (P & L)</td>
                    <td>: <span class="badge bg-dark px-3 py-1 fs-6"><?= $pesanan['ukuran']; ?></span></td>
                </tr>
                <tr>
                    <td class="text-muted">Jumlah Pesanan</td>
                    <td>: <strong><?= $pesanan['jumlah']; ?> Pcs</strong> (@ <?= format_rupiah($pesanan['harga_satuan']); ?>)</td>
                </tr>
                <tr>
                    <td class="text-muted">Posisi Sablon</td>
                    <td>: <?= $pesanan['posisi_sablon']; ?></td>
                </tr>
                <tr>
                    <td class="text-muted">File Desain Upload</td>
                    <td>: 
                        <?php 
                            $desain_file = $pesanan['file_desain'];
                            $file_path = base_url('assets/uploads/desain/' . $desain_file);
                            if ($desain_file == 'default_design.png') {
                                $file_path = base_url('assets/images/default_design.png');
                            }
                        ?>
                        <a href="<?= $file_path; ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2 py-0">
                            <i class="fas fa-download me-1"></i> Unduh Desain (<?= $desain_file; ?>)
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted">Catatan Pelanggan</td>
                    <td>: <em><?= !empty($pesanan['catatan_pelanggan']) ? $pesanan['catatan_pelanggan'] : '-'; ?></em></td>
                </tr>
                <tr>
                    <td class="text-muted">Total Pembayaran</td>
                    <td>: <strong class="text-success fs-5"><?= format_rupiah($pesanan['total_harga']); ?></strong></td>
                </tr>
                <tr>
                    <td class="text-muted">Status Pembayaran</td>
                    <td>: <?= badge_status_pembayaran($pesanan['status_pembayaran']); ?></td>
                </tr>
            </table>

            <?php if ($pesanan['status_pembayaran'] == 'belum_bayar'): ?>
                <div class="mt-4 p-3 bg-warning bg-opacity-10 border border-warning rounded-3 text-center">
                    <p class="small text-dark mb-2"><i class="fas fa-info-circle me-1"></i> Pesanan Anda belum dibayar. Harap lakukan pembayaran agar pesanan dapat diproses oleh Admin.</p>
                    <a href="<?= base_url('pelanggan/bayar/' . $pesanan['id']); ?>" class="btn btn-success fw-bold rounded-pill px-4"><i class="fas fa-upload me-1"></i> Upload Bukti Transfer</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- History Log Timeline -->
    <div class="col-lg-6">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold border-bottom pb-2 mb-3 text-primary"><i class="fas fa-history me-2"></i> Log Produksi Real-Time</h5>

            <?php if (empty($logs)): ?>
                <p class="text-muted">Belum ada riwayat aktivitas produksi.</p>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($logs as $log): ?>
                        <div class="list-group-item px-0 py-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark"><?= nama_status_produksi($log['status_produksi']); ?></span>
                                <small class="text-muted"><i class="far fa-clock me-1"></i><?= date('d/m/Y H:i', strtotime($log['created_at'])); ?></small>
                            </div>
                            <p class="text-secondary small mb-0"><?= $log['keterangan']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
