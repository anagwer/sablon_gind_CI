<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Kelola Pesanan: <span class="text-primary"><?= $pesanan['kode_pesanan']; ?></span></h3>
        <p class="text-muted mb-0">Verifikasi Pembayaran & Perbarui Status Produksi Sablon Real-Time</p>
    </div>
    <a href="<?= base_url('admin/pesanan'); ?>" class="btn btn-outline-secondary rounded-pill px-3"><i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Pesanan</a>
</div>

<!-- Progress Bar Produksi -->
<div class="card-custom p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-tasks text-primary me-2"></i> Progress Alur Produksi Real-Time (Berurutan Bertahap)</h6>
        <span class="badge bg-primary fs-6 rounded-pill px-3"><?= nama_status_produksi($pesanan['status_produksi']); ?></span>
    </div>

    <?php 
        $steps = ['diverifikasi', 'desain', 'afdruk', 'sablon', 'pengeringan', 'pengemasan', 'selesai'];
        $current_idx = array_search($pesanan['status_produksi'], $steps);
        if ($current_idx === FALSE) $current_idx = -1;
    ?>

    <div class="progress mb-2" style="height: 12px; border-radius: 10px;">
        <?php 
            $perc = 0;
            if ($current_idx >= 0) {
                $perc = intval(($current_idx + 1) / count($steps) * 100);
            }
        ?>
        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?= $perc; ?>%;"></div>
    </div>
    <div class="d-flex justify-content-between text-muted small fw-semibold">
        <span>1. Diverifikasi</span>
        <span>2. Desain Film</span>
        <span>3. Afdruk Screen</span>
        <span>4. Sablon</span>
        <span>5. Curing</span>
        <span>6. QC</span>
        <span>7. Selesai</span>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Form Action 1: Verifikasi Pembayaran -->
    <div class="col-lg-6">
        <div class="card-custom p-4 h-100 border-start border-warning border-4">
            <h5 class="fw-bold mb-3 text-warning"><i class="fas fa-file-invoice-dollar me-2"></i> 1. Verifikasi Pembayaran</h5>
            
            <?php if (!$pembayaran): ?>
                <div class="p-4 bg-light rounded-3 text-center border">
                    <i class="fas fa-clock fs-1 text-secondary mb-2 d-block"></i>
                    <h6 class="fw-bold text-dark mb-1">Belum Ada Pembayaran</h6>
                    <p class="text-muted small mb-0">Pelanggan belum melakukan konfirmasi/upload bukti pembayaran.</p>
                </div>
            <?php else: ?>
                <table class="table table-borderless no-datatable fs-7 mb-3">
                    <tr><td class="text-muted" style="width: 35%;">Bank Tujuan</td><td>: <strong><?= $pembayaran['bank_tujuan']; ?></strong></td></tr>
                    <tr><td class="text-muted">Nama Pengirim</td><td>: <strong><?= $pembayaran['nama_pengirim']; ?></strong></td></tr>
                    <tr><td class="text-muted">Jumlah Ditransfer</td><td>: <strong class="text-success fs-6"><?= format_rupiah($pembayaran['jumlah_bayar']); ?></strong></td></tr>
                    <tr><td class="text-muted">Tanggal Bayar</td><td>: <?= date('d M Y, H:i', strtotime($pembayaran['tanggal_bayar'])); ?> WIB</td></tr>
                    <tr>
                        <td class="text-muted">Bukti Transfer</td>
                        <td>: 
                            <a href="<?= base_url('assets/uploads/bukti/' . $pembayaran['bukti_transfer']); ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                <i class="fas fa-image me-1"></i> Lihat Bukti Transfer
                            </a>
                        </td>
                    </tr>
                    <tr><td class="text-muted">Status Pembayaran</td><td>: <?= badge_status_pembayaran($pesanan['status_pembayaran']); ?></td></tr>
                </table>

                <?php if ($pembayaran['status'] == 'pending'): ?>
                    <form action="<?= base_url('admin/verifikasi_pembayaran'); ?>" method="POST" class="p-3 bg-light rounded-3 border">
                        <input type="hidden" name="pembayaran_id" value="<?= $pembayaran['id']; ?>">
                        <input type="hidden" name="pesanan_id" value="<?= $pesanan['id']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Keputusan Verifikasi</label>
                            <select name="status" class="form-select rounded-3" required>
                                <option value="valid">TERIMA / VALID (Potong Stok Kaos & Masuk Antrean)</option>
                                <option value="invalid">TOLAK / INVALID (Bukti Tidak Sesuai)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Catatan Admin</label>
                            <input type="text" name="catatan_admin" class="form-control rounded-3" placeholder="Catatan opsional...">
                        </div>

                        <button type="submit" class="btn btn-warning text-dark fw-bold w-100 rounded-3 shadow-sm"><i class="fas fa-check-circle me-1"></i> Simpan Verifikasi Pembayaran</button>
                    </form>
                <?php else: ?>
                    <div class="p-3 bg-light rounded-3 border">
                        <small class="text-muted d-block">Catatan Verifikasi Admin:</small>
                        <p class="fw-bold mb-0 text-dark"><?= !empty($pembayaran['catatan_admin']) ? $pembayaran['catatan_admin'] : 'Pembayaran telah diverifikasi lunas.'; ?></p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Form Action 2: Update Status Produksi Real-Time (Strict Sequential Workflow) -->
    <div class="col-lg-6">
        <div class="card-custom p-4 h-100 border-start border-primary border-4">
            <h5 class="fw-bold mb-3 text-primary"><i class="fas fa-cogs me-2"></i> 2. Update Status Produksi (Berurutan)</h5>
            
            <?php 
                $sequence = ['pending', 'diverifikasi', 'desain', 'afdruk', 'sablon', 'pengeringan', 'pengemasan', 'selesai'];
                $current_status = $pesanan['status_produksi'];
                $current_seq_idx = array_search($current_status, $sequence);

                $next_seq_status = NULL;
                if ($current_seq_idx !== FALSE && isset($sequence[$current_seq_idx + 1])) {
                    $next_seq_status = $sequence[$current_seq_idx + 1];
                }
            ?>

            <?php if ($current_status == 'pending'): ?>
                <div class="p-4 bg-warning bg-opacity-10 border border-warning rounded-3 text-center">
                    <i class="fas fa-exclamation-triangle fs-1 text-warning mb-2 d-block"></i>
                    <h6 class="fw-bold text-dark mb-1">Pembayaran Belum Diverifikasi</h6>
                    <p class="text-muted small mb-0">Status produksi belum dapat diperbarui karena pembayaran belum diverifikasi. Silakan lakukan verifikasi pada panel <strong>1. Verifikasi Pembayaran</strong> terlebih dahulu.</p>
                </div>
            <?php elseif ($current_status == 'selesai'): ?>
                <div class="p-4 bg-success bg-opacity-10 border border-success rounded-3 text-center">
                    <i class="fas fa-check-double fs-1 text-success mb-2 d-block"></i>
                    <h6 class="fw-bold text-success mb-1">Produksi Telah Selesai!</h6>
                    <p class="text-muted small mb-0">Seluruh tahapan produksi pengerjaan sablon kaos ini telah selesai 100%.</p>
                </div>
            <?php elseif ($current_status == 'dibatalkan'): ?>
                <div class="p-4 bg-danger bg-opacity-10 border border-danger rounded-3 text-center">
                    <i class="fas fa-ban fs-1 text-danger mb-2 d-block"></i>
                    <h6 class="fw-bold text-danger mb-1">Pesanan Dibatalkan</h6>
                    <p class="text-muted small mb-0">Pesanan ini telah dibatalkan.</p>
                </div>
            <?php else: ?>
                <form action="<?= base_url('admin/update_status_produksi'); ?>" method="POST" class="p-3 bg-light rounded-3 mb-3 border">
                    <input type="hidden" name="pesanan_id" value="<?= $pesanan['id']; ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Tahap Produksi Saat Ini & Tahap Selanjutnya</label>
                        <select name="status_produksi" class="form-select form-select-lg rounded-3" required>
                            <option value="<?= $current_status; ?>" selected disabled>
                                📌 Tahap Saat Ini: <?= nama_status_produksi($current_status); ?>
                            </option>
                            <?php if ($next_seq_status): ?>
                                <option value="<?= $next_seq_status; ?>">
                                    ▶ Lanjut ke Tahap Berikutnya: <?= nama_status_produksi($next_seq_status); ?>
                                </option>
                            <?php endif; ?>
                            <option value="dibatalkan">❌ Batalkan Pesanan Ini</option>
                        </select>
                        <small class="text-muted d-block mt-1"><i class="fas fa-info-circle me-1"></i> Proses produksi hanya dapat dilanjutkan secara berurutan per 1 tahapan.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Catatan Progress / Deskripsi Pengerjaan</label>
                        <textarea name="keterangan" class="form-control rounded-3" rows="3" placeholder="Contoh: Proses pengolesan tinta sablon warna ke-2 sedang dikeringkan..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary fw-bold w-100 rounded-3 shadow-sm"><i class="fas fa-arrow-right me-1"></i> Lanjut Tahap Berikutnya</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Info Detail & File Desain -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold border-bottom pb-2 mb-3 text-dark"><i class="fas fa-info-circle me-2"></i> Rincian Pesanan Pelanggan</h5>
            <table class="table table-borderless no-datatable fs-7 mb-0">
                <tr><td class="text-muted" style="width: 35%;">Pelanggan</td><td>: <strong><?= $pesanan['nama_pelanggan']; ?></strong> (HP: <?= $pesanan['no_hp']; ?>)</td></tr>
                <tr><td class="text-muted">Alamat Pengiriman</td><td>: <?= $pesanan['alamat']; ?></td></tr>
                <tr><td class="text-muted">Bahan Kaos</td><td>: <strong><?= $pesanan['nama_kaos']; ?></strong></td></tr>
                <tr><td class="text-muted">Ukuran Kaos (P & L)</td><td>: <span class="badge bg-dark fs-6 px-3"><?= $pesanan['ukuran']; ?></span> (Stok Gudang: <strong><?= $stok_saat_ini; ?> pcs</strong>)</td></tr>
                <tr><td class="text-muted">Jumlah Pcs</td><td>: <strong><?= $pesanan['jumlah']; ?> Pcs</strong></td></tr>
                <tr><td class="text-muted">Posisi Sablon</td><td>: <?= $pesanan['posisi_sablon']; ?></td></tr>
                <tr>
                    <td class="text-muted">File Desain Custom</td>
                    <td>: 
                        <?php 
                            $desain_file = $pesanan['file_desain'];
                            $file_path = base_url('assets/uploads/desain/' . $desain_file);
                            if ($desain_file == 'default_design.png') {
                                $file_path = base_url('assets/images/default_design.png');
                            }
                        ?>
                        <a href="<?= $file_path; ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="fas fa-download me-1"></i> Unduh File Desain
                        </a>
                    </td>
                </tr>
                <tr><td class="text-muted">Catatan Pelanggan</td><td>: <em><?= !empty($pesanan['catatan_pelanggan']) ? $pesanan['catatan_pelanggan'] : '-'; ?></em></td></tr>
            </table>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold border-bottom pb-2 mb-3 text-dark"><i class="fas fa-history me-2"></i> Log Histori Real-Time Produksi</h5>
            <div class="list-group list-group-flush">
                <?php foreach ($logs as $log): ?>
                    <div class="list-group-item px-0 py-2 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold text-dark"><?= nama_status_produksi($log['status_produksi']); ?></span>
                            <small class="text-muted"><?= date('d/m/Y H:i', strtotime($log['created_at'])); ?></small>
                        </div>
                        <p class="text-secondary small mb-0"><?= $log['keterangan']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
