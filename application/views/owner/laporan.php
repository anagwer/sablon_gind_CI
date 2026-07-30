<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="fas fa-file-invoice-dollar text-danger me-2"></i> Laporan Penjualan & Produksi Sablon</h3>
        <p class="text-muted mb-0">Rekapitulasi transaksi, omset pendapatan, dan penggunaan bahan kaos untuk Pemilik Toko.</p>
    </div>
    <?php 
        $query_string = http_build_query([
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'status_pembayaran' => $status_pembayaran,
            'status_produksi' => $status_produksi
        ]);
    ?>
    <a href="<?= base_url('owner/cetak_laporan?' . $query_string); ?>" target="_blank" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold">
        <i class="fas fa-print me-1"></i> Cetak Laporan (PDF / Print)
    </a>
</div>

<!-- Filter Box -->
<div class="card-custom p-4 mb-4">
    <form action="<?= base_url('owner/laporan'); ?>" method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-bold small text-secondary">Tanggal Mulai</label>
            <input type="date" name="tgl_mulai" class="form-control rounded-3" value="<?= $tgl_mulai; ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold small text-secondary">Tanggal Selesai</label>
            <input type="date" name="tgl_selesai" class="form-control rounded-3" value="<?= $tgl_selesai; ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold small text-secondary">Status Pembayaran</label>
            <select name="status_pembayaran" class="form-select rounded-3">
                <option value="">-- Semua Status Pembayaran --</option>
                <option value="lunas" <?= ($status_pembayaran == 'lunas') ? 'selected' : ''; ?>>Lunas</option>
                <option value="menunggu_verifikasi" <?= ($status_pembayaran == 'menunggu_verifikasi') ? 'selected' : ''; ?>>Menunggu Verifikasi</option>
                <option value="belum_bayar" <?= ($status_pembayaran == 'belum_bayar') ? 'selected' : ''; ?>>Belum Bayar</option>
                <option value="ditolak" <?= ($status_pembayaran == 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-bold w-100 rounded-3"><i class="fas fa-filter me-1"></i> Filter Data</button>
            <a href="<?= base_url('owner/laporan'); ?>" class="btn btn-outline-secondary rounded-3"><i class="fas fa-undo"></i></a>
        </div>
    </form>
</div>

<!-- Financial Summary Box -->
<div class="card-custom p-4 mb-4 border-start border-success border-5">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <small class="text-muted fw-bold text-uppercase d-block mb-1">Total Omset Pendapatan Terfilter (Lunas):</small>
            <h2 class="fw-extrabold text-success mb-0"><?= format_rupiah($total_omset); ?></h2>
        </div>
        <div class="text-end">
            <small class="text-muted d-block">Jumlah Pesanan Ditemukan:</small>
            <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill"><?= count($laporan_list); ?> Transaksi</span>
        </div>
    </div>
</div>

<!-- DataTables Table Laporan -->
<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle w-100" id="tabelLaporanOwner">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Kode Pesanan</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Kaos & Ukuran</th>
                    <th>Jumlah</th>
                    <th>Total Biaya</th>
                    <th>Status Bayar</th>
                    <th>Status Produksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($laporan_list as $row): ?>
                    <tr>
                        <td class="text-center fw-bold text-muted"><?= $no++; ?></td>
                        <td><strong class="text-primary"><?= $row['kode_pesanan']; ?></strong></td>
                        <td><small><?= date('d/m/Y', strtotime($row['created_at'])); ?></small></td>
                        <td>
                            <strong class="text-dark d-block mb-0"><?= $row['nama_pelanggan']; ?></strong>
                            <small class="text-muted"><?= $row['no_hp']; ?></small>
                        </td>
                        <td>
                            <strong><?= $row['nama_kaos']; ?></strong><br>
                            <span class="badge bg-dark">Ukuran <?= $row['ukuran']; ?></span>
                        </td>
                        <td><strong><?= $row['jumlah']; ?> Pcs</strong></td>
                        <td><span class="fw-bold text-success fs-6"><?= format_rupiah($row['total_harga']); ?></span></td>
                        <td><?= badge_status_pembayaran($row['status_pembayaran']); ?></td>
                        <td><?= badge_status_produksi($row['status_produksi']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
