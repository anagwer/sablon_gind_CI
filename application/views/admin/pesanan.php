<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="fas fa-tasks text-primary me-2"></i> Kelola Pesanan & Produksi Sablon</h3>
        <p class="text-muted mb-0">Daftar seluruh pesanan masuk, verifikasi bukti pembayaran, dan pembaruan alur produksi real-time.</p>
    </div>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle w-100" id="tabelAdminPesanan">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Kode Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Detail Kaos & Ukuran</th>
                    <th>Jumlah</th>
                    <th>Total Biaya</th>
                    <th>Status Bayar</th>
                    <th>Tahap Produksi Real-Time</th>
                    <th class="text-center">Aksi Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($pesanan_list as $pesanan): ?>
                    <tr>
                        <td class="text-center fw-bold text-muted"><?= $no++; ?></td>
                        <td>
                            <strong class="text-primary d-block mb-0"><?= $pesanan['kode_pesanan']; ?></strong>
                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i><?= date('d/m/Y H:i', strtotime($pesanan['created_at'])); ?></small>
                        </td>
                        <td>
                            <strong class="text-dark d-block mb-0"><?= $pesanan['nama_pelanggan']; ?></strong>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $pesanan['no_hp']); ?>" target="_blank" class="text-success small text-decoration-none fw-semibold">
                                <i class="fab fa-whatsapp me-1"></i><?= $pesanan['no_hp']; ?>
                            </a>
                        </td>
                        <td>
                            <strong><?= $pesanan['nama_kaos']; ?></strong><br>
                            <span class="badge bg-dark">Ukuran <?= $pesanan['ukuran']; ?></span>
                        </td>
                        <td><strong><?= $pesanan['jumlah']; ?> Pcs</strong></td>
                        <td><span class="fw-bold text-success fs-6"><?= format_rupiah($pesanan['total_harga']); ?></span></td>
                        <td><?= badge_status_pembayaran($pesanan['status_pembayaran']); ?></td>
                        <td><?= badge_status_produksi($pesanan['status_produksi']); ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/detail_pesanan/' . $pesanan['id']); ?>" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold shadow-sm">
                                <i class="fas fa-edit me-1"></i> Kelola
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
