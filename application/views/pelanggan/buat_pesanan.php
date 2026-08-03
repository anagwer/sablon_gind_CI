<style>
    .kaos-card-option {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.25rem;
        transition: all 0.25s ease;
        cursor: pointer;
        background-color: #ffffff;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .kaos-card-option:hover {
        border-color: #93c5fd;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }

    .kaos-card-option.selected {
        border-color: #2563eb !important;
        background: linear-gradient(145deg, #f0f7ff 0%, #e0f2fe 100%) !important;
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.18) !important;
    }

    .kaos-card-option .kaos-radio {
        width: 18px;
        height: 18px;
        cursor: pointer;
        border-color: #94a3b8;
        margin-top: 2px;
    }

    .kaos-card-option.selected .kaos-radio {
        background-color: #2563eb;
        border-color: #2563eb;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-plus-circle text-primary me-2"></i> Buat Pesanan Sablon Baru</h3>
                <p class="text-muted mb-0">Pilih bahan kaos, ukuran (S-XXL), dan unggah file desain buatan Anda sendiri.</p>
            </div>
            <a href="<?= base_url('pelanggan/dashboard'); ?>" class="btn btn-outline-secondary rounded-pill px-3"><i class="fas fa-arrow-left me-1"></i> Batal</a>
        </div>

        <div class="card-custom p-4 p-md-5">
            <form action="<?= base_url('pelanggan/buat_pesanan'); ?>" method="POST" enctype="multipart/form-data">
                
                <!-- Section 1: Pilih Bahan Kaos -->
                <h5 class="fw-bold border-bottom pb-2 mb-4 text-primary"><i class="fas fa-tshirt me-2"></i> 1. Pilih Bahan & Tipe Kaos</h5>
                
                <div class="row g-3 mb-4">
                    <?php foreach ($kaos_list as $k): ?>
                        <div class="col-md-6 col-lg-4">
                            <label class="kaos-card-option h-100">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-3 gap-2">
                                        <div class="d-flex align-items-start gap-2 flex-grow-1">
                                            <input class="form-check-input kaos-radio flex-shrink-0" type="radio" name="kaos_id" value="<?= $k['id']; ?>" data-harga="<?= $k['harga_dasar']; ?>" data-nama="<?= htmlspecialchars($k['nama_kaos']); ?>" required <?= ($k['id'] == 3) ? 'checked' : ''; ?>>
                                            <span class="fw-bold text-dark fs-6 lh-sm"><?= $k['nama_kaos']; ?></span>
                                        </div>
                                        <span class="badge rounded-pill bg-primary px-2 py-1 fw-bold text-nowrap flex-shrink-0" style="font-size: 0.75rem;"><?= format_rupiah($k['harga_dasar']); ?></span>
                                    </div>
                                    <img src="<?= base_url('assets/images/' . $k['gambar']); ?>" alt="<?= $k['nama_kaos']; ?>" class="img-fluid rounded-3 mb-3 w-100 shadow-sm" style="height: 140px; object-fit: cover;" onerror="this.src='<?= base_url('assets/images/hero_sablon.png'); ?>'">
                                    <small class="text-secondary d-block fw-semibold mb-2"><i class="fas fa-layer-group me-1 text-primary"></i> <?= $k['jenis_bahan']; ?></small>
                                </div>
                                <div class="pt-2 border-top d-flex justify-content-between align-items-center mt-auto">
                                    <small class="text-muted">Stok Tersedia (S-XXL):</small>
                                    <span class="badge bg-white text-dark border fw-bold px-2 py-1"><?= $k['total_stok']; ?> Pcs</span>
                                </div>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Section 2: Ukuran & Jumlah -->
                <h5 class="fw-bold border-bottom pb-2 mb-4 text-primary"><i class="fas fa-ruler-combined me-2"></i> 2. Ukuran Kaos (P & L) & Jumlah Pcs</h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Pilih Ukuran Kaos (P & L)</label>
                        <select name="ukuran" class="form-select form-select-lg rounded-3" required>
                            <option value="" disabled selected>-- Pilih Ukuran (S - XXL) --</option>
                            <option value="S">Ukuran S (Panjang 66cm x Lebar 47cm)</option>
                            <option value="M">Ukuran M (Panjang 69cm x Lebar 50cm)</option>
                            <option value="L">Ukuran L (Panjang 72cm x Lebar 53cm)</option>
                            <option value="XL">Ukuran XL (Panjang 74cm x Lebar 56cm)</option>
                            <option value="XXL">Ukuran XXL (Panjang 76cm x Lebar 59cm)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Jumlah Pesanan (Pcs)</label>
                        <input type="number" name="jumlah" id="jumlah_input" class="form-control form-control-lg rounded-3" value="12" min="12" required>
                        <small class="text-muted">Masukkan jumlah kaos yang ingin disablon (<strong>Minimal 12 Pcs</strong>).</small>
                    </div>
                </div>

                <!-- Section 3: Layout Terpisah (Kiri: Preview Gambar Default Besar, Kanan: Form Upload) -->
                <h5 class="fw-bold border-bottom pb-2 mb-4 text-primary"><i class="fas fa-upload me-2"></i> 3. Upload File Desain Mandiri & Posisi Sablon</h5>

                <div class="row g-4 mb-4 align-items-center">
                    <!-- Kiri: Gambar Acuan Sablon Default (Besar & Jelas) -->
                    <div class="col-lg-5">
                        <div class="p-4 bg-light rounded-4 border text-center h-100 d-flex flex-column justify-content-center align-items-center shadow-sm">
                            <span class="badge bg-info text-dark px-3 py-2 rounded-pill fw-bold mb-3"><i class="fas fa-image me-1"></i> Desain Sampel Default</span>
                            <div class="p-2 bg-white rounded-3 border mb-3 shadow-sm" style="max-width: 100%;">
                                <img src="<?= base_url('assets/images/default_design.png'); ?>" alt="Desain Sampel Default Sablon" class="img-fluid rounded" style="max-height: 240px; object-fit: contain;">
                            </div>
                            <h6 class="fw-bold text-dark mb-1">Acuan Peletakan Sablon Default</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">
                                Kosongkan input upload file desain jika Anda ingin menggunakan acuan sampel peletakan posisi sablon default seperti pada gambar di atas.
                            </p>
                        </div>
                    </div>

                    <!-- Kanan: Form Isian Khusus Upload Desain -->
                    <div class="col-lg-7">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Upload File Desain Custom Anda (Opsional)</label>
                            <input type="file" name="file_desain" class="form-control form-control-lg rounded-3" accept=".png,.jpg,.jpeg,.pdf,.zip,.svg,.psd,.ai">
                            <small class="text-muted d-block mt-1">Format file: PNG, JPG, PDF, SVG, ZIP. Maksimal 20 MB. Kosongkan jika memakai sampel default.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Posisi Cetak Sablon</label>
                            <select name="posisi_sablon" class="form-select form-select-lg rounded-3">
                                <option value="Dada Depan A3">Dada Depan (A3)</option>
                                <option value="Dada Kiri Logo">Dada Kiri (Logo)</option>
                                <option value="Punggung Belakang Full">Punggung Belakang (Full A3)</option>
                                <option value="Dada Depan & Punggung Belakang" selected>Dada Depan & Punggung Belakang</option>
                                <option value="Dada + Punggung + Lengan">Dada + Punggung + Lengan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Catatan Khusus untuk Produksi / Warna Kaos</label>
                            <textarea name="catatan_pelanggan" class="form-control rounded-3" rows="3" placeholder="Contoh: Kaos warna Hitam, tinta Plastisol warna Putih & Merah presisi..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Estimasi Biaya -->
                <div class="p-4 bg-light rounded-4 mb-4 border border-2 border-primary border-opacity-25">
                    <div class="row align-items-center">
                        <div class="col-md-7 mb-2 mb-md-0">
                            <small class="text-muted d-block fw-bold text-uppercase">Estimasi Total Pembayaran:</small>
                            <h3 class="fw-extrabold text-primary mb-0" id="total_estimasi_text">Rp 0</h3>
                            <small class="text-muted" id="detail_hitung_text">Pilih tipe kaos & tentukan jumlah.</small>
                        </div>
                        <div class="col-md-5 text-md-end">
                            <button type="submit" class="btn btn-gind btn-lg w-100 shadow"><i class="fas fa-paper-plane me-2"></i> Kirim Pesanan Sekarang</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const kaosRadios = document.querySelectorAll(".kaos-radio");
    const jumlahInput = document.getElementById("jumlah_input");
    const totalText = document.getElementById("total_estimasi_text");
    const detailText = document.getElementById("detail_hitung_text");

    function updateKaosSelectionUI() {
        document.querySelectorAll(".kaos-card-option").forEach(card => {
            const radio = card.querySelector(".kaos-radio");
            if (radio && radio.checked) {
                card.classList.add("selected");
            } else {
                card.classList.remove("selected");
            }
        });
    }

    function hitungTotal() {
        let selectedKaos = document.querySelector(".kaos-radio:checked");
        if (!selectedKaos) return;

        let harga = parseFloat(selectedKaos.getAttribute("data-harga")) || 0;
        let nama = selectedKaos.getAttribute("data-nama");
        let jumlah = parseInt(jumlahInput.value) || 0;
        let total = harga * jumlah;

        totalText.innerText = "Rp " + total.toLocaleString('id-ID');
        detailText.innerText = jumlah + " pcs x " + "Rp " + harga.toLocaleString('id-ID') + " (" + nama + ")";

        updateKaosSelectionUI();
    }

    kaosRadios.forEach(radio => {
        radio.addEventListener("change", hitungTotal);
    });

    jumlahInput.addEventListener("input", hitungTotal);
    hitungTotal();
});
</script>
