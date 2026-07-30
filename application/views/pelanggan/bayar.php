<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-credit-card text-success me-2"></i> Konfirmasi Pembayaran</h3>
                <p class="text-muted mb-0">Pesanan: <strong class="text-primary"><?= $pesanan['kode_pesanan']; ?></strong></p>
            </div>
            <a href="<?= base_url('pelanggan/detail/' . $pesanan['id']); ?>" class="btn btn-outline-secondary rounded-pill px-3"><i class="fas fa-arrow-left me-1"></i> Batal</a>
        </div>

        <div class="card-custom p-4 p-md-5 mb-4">
            <!-- Bank Info Box -->
            <div class="p-4 bg-light rounded-4 mb-4 border border-2 border-primary border-opacity-25 text-center">
                <small class="text-muted fw-bold text-uppercase d-block mb-1">Total Tagihan Yang Harus Dibayar:</small>
                <h2 class="fw-extrabold text-success mb-3"><?= format_rupiah($pesanan['total_harga']); ?></h2>

                <div class="row justify-content-center g-3 text-start">
                    <div class="col-md-6">
                        <div class="bg-white p-3 rounded-3 shadow-sm border">
                            <span class="badge bg-primary mb-1">Transfer Bank</span>
                            <h6 class="fw-bold mb-1"><?= $pengaturan['bank_name']; ?></h6>
                            <p class="fs-5 fw-extrabold text-primary mb-0 font-monospace"><?= $pengaturan['no_rekening']; ?></p>
                            <small class="text-muted">a.n. <?= $pengaturan['atas_nama']; ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <form action="<?= base_url('pelanggan/bayar/' . $pesanan['id']); ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Bank Tujuan Transfer</label>
                    <input type="text" name="bank_tujuan" class="form-control rounded-3" value="<?= $pengaturan['bank_name'] . ' (' . $pengaturan['no_rekening'] . ')'; ?>" required readonly>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Nama Pengirim Di Rekening</label>
                        <input type="text" name="nama_pengirim" class="form-control rounded-3" placeholder="e.g. Rizky Pratama" value="<?= $user['nama_lengkap']; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Jumlah Transfer (Rp)</label>
                        <input type="number" name="jumlah_bayar" class="form-control rounded-3" value="<?= intval($pesanan['total_harga']); ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Upload Foto Bukti Transfer</label>
                    <input type="file" name="bukti_transfer" class="form-control rounded-3" accept=".jpg,.jpeg,.png,.pdf" required>
                    <small class="text-muted">Format file: JPG, PNG, PDF. Maksimal 5 MB.</small>
                </div>

                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold rounded-3 shadow"><i class="fas fa-check-circle me-1"></i> Kirim Konfirmasi Pembayaran</button>
            </form>
        </div>
    </div>
</div>
