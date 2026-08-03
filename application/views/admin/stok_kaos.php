<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="fas fa-boxes text-primary me-2"></i> Katalog & Stok Kaos</h3>
        <p class="text-muted mb-0">Kelola informasi bahan baku kaos, harga dasar, serta stok terperinci per ukuran (S - XXL).</p>
    </div>
    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahKaos">
        <i class="fas fa-plus me-1"></i> Tambah Produk
    </button>
</div>

<!-- 1 Single Ultra-Clean DataTables Table -->
<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle w-100" id="tabelStokKaos">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 10%;">Gambar</th>
                    <th style="width: 25%;">Nama Kaos & Bahan</th>
                    <th style="width: 10%;">Kategori</th>
                    <th style="width: 12%;">Harga / Pcs</th>
                    <th class="text-center" style="width: 5%;">S</th>
                    <th class="text-center" style="width: 5%;">M</th>
                    <th class="text-center" style="width: 5%;">L</th>
                    <th class="text-center" style="width: 5%;">XL</th>
                    <th class="text-center" style="width: 5%;">XXL</th>
                    <th class="text-center" style="width: 8%;">Total</th>
                    <th class="text-center" style="width: 5%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($kaos_list as $k): ?>
                    <?php 
                        $s_map = [];
                        foreach ($k['stok'] as $s) $s_map[$s['ukuran']] = $s['stok'];
                    ?>
                    <tr>
                        <td class="text-center fw-bold text-muted"><?= $no++; ?></td>
                        <td>
                            <img src="<?= base_url('assets/images/' . $k['gambar']); ?>" alt="<?= $k['nama_kaos']; ?>" class="rounded-3 shadow-sm border" style="width: 55px; height: 55px; object-fit: cover;" onerror="this.src='<?= base_url('assets/images/hero_sablon.png'); ?>'">
                        </td>
                        <td>
                            <strong class="text-dark d-block mb-0 fs-6"><?= $k['nama_kaos']; ?></strong>
                            <small class="text-muted"><i class="fas fa-layer-group me-1"></i> <?= $k['jenis_bahan']; ?></small>
                        </td>
                        <td>
                            <?php 
                                $kat = $k['kategori'];
                                $badge_kat = ($kat == 'murah') ? 'bg-success' : (($kat == 'sedang') ? 'bg-primary' : 'bg-purple text-white');
                            ?>
                            <span class="badge <?= $badge_kat; ?> rounded-pill px-3 py-1 fw-semibold" style="<?= ($kat == 'mahal') ? 'background-color: #8b5cf6;' : ''; ?>">
                                <?= ucfirst($kat); ?>
                            </span>
                        </td>
                        <td><strong class="text-primary fs-6"><?= format_rupiah($k['harga_dasar']); ?></strong></td>
                        <td class="text-center">
                            <span class="badge <?= (isset($s_map['S']) && $s_map['S'] > 15) ? 'bg-light text-dark border' : 'bg-danger text-white'; ?> fs-7">
                                <?= isset($s_map['S']) ? $s_map['S'] : 0; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge <?= (isset($s_map['M']) && $s_map['M'] > 15) ? 'bg-light text-dark border' : 'bg-danger text-white'; ?> fs-7">
                                <?= isset($s_map['M']) ? $s_map['M'] : 0; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge <?= (isset($s_map['L']) && $s_map['L'] > 15) ? 'bg-light text-dark border' : 'bg-danger text-white'; ?> fs-7">
                                <?= isset($s_map['L']) ? $s_map['L'] : 0; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge <?= (isset($s_map['XL']) && $s_map['XL'] > 15) ? 'bg-light text-dark border' : 'bg-danger text-white'; ?> fs-7">
                                <?= isset($s_map['XL']) ? $s_map['XL'] : 0; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge <?= (isset($s_map['XXL']) && $s_map['XXL'] > 15) ? 'bg-light text-dark border' : 'bg-danger text-white'; ?> fs-7">
                                <?= isset($s_map['XXL']) ? $s_map['XXL'] : 0; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1 fs-6 fw-bold">
                                <?= $k['total_stok']; ?> Pcs
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#modalEditStok<?= $k['id']; ?>" title="Edit Stok & Harga">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="<?= base_url('admin/hapus_kaos/' . $k['id']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus kaos ini?');" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Edit Stok -->
                    <div class="modal fade" id="modalEditStok<?= $k['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <form action="<?= base_url('admin/update_stok'); ?>" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="kaos_id" value="<?= $k['id']; ?>">
                                    <div class="modal-header bg-light py-3">
                                        <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit text-warning me-2"></i> Edit Stok & Harga — <?= $k['nama_kaos']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold small text-secondary">Nama Kaos</label>
                                                <input type="text" name="nama_kaos" class="form-control rounded-3" value="<?= $k['nama_kaos']; ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold small text-secondary">Jenis Bahan</label>
                                                <input type="text" name="jenis_bahan" class="form-control rounded-3" value="<?= $k['jenis_bahan']; ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold small text-secondary">Harga Dasar / Pcs (Rp)</label>
                                                <input type="number" name="harga_dasar" class="form-control rounded-3" value="<?= intval($k['harga_dasar']); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold small text-secondary">Kategori Harga</label>
                                                <select name="kategori" class="form-select rounded-3">
                                                    <option value="murah" <?= ($k['kategori'] == 'murah') ? 'selected' : ''; ?>>Murah (Ekonomis)</option>
                                                    <option value="sedang" <?= ($k['kategori'] == 'sedang') ? 'selected' : ''; ?>>Sedang (Standar)</option>
                                                    <option value="mahal" <?= ($k['kategori'] == 'mahal') ? 'selected' : ''; ?>>Mahal (Premium)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <label class="form-label fw-bold text-dark d-block mb-2"><i class="fas fa-ruler-combined me-1"></i> Update Stok per Ukuran (S - XXL):</label>
                                        <div class="row g-2 mb-3 bg-light p-3 rounded-3 border">
                                            <?php foreach (['S','M','L','XL','XXL'] as $uk): ?>
                                                <div class="col">
                                                    <label class="form-label small text-muted text-center d-block fw-bold mb-1">Ukuran <?= $uk; ?></label>
                                                    <input type="number" name="stok_<?= $uk; ?>" class="form-control text-center fw-bold rounded-3" value="<?= isset($s_map[$uk]) ? $s_map[$uk] : 0; ?>" min="0" required>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-secondary">Ganti Gambar Produk (Opsional)</label>
                                            <input type="file" name="gambar" class="form-control rounded-3" accept="image/*">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-secondary">Deskripsi Singkat</label>
                                            <textarea name="deskripsi" class="form-control rounded-3" rows="2"><?= $k['deskripsi']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Kaos Baru -->
<div class="modal fade" id="modalTambahKaos" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="<?= base_url('admin/tambah_kaos'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-light py-3">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-plus-circle text-primary me-2"></i> Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-secondary">Nama Kaos</label>
                            <input type="text" name="nama_kaos" class="form-control rounded-3" placeholder="e.g. Kaos Cotton Bamboo 30s" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-secondary">Jenis Bahan</label>
                            <input type="text" name="jenis_bahan" class="form-control rounded-3" placeholder="e.g. Cotton Bamboo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-secondary">Harga Dasar / Pcs (Rp)</label>
                            <input type="number" name="harga_dasar" class="form-control rounded-3" placeholder="60000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-secondary">Kategori Harga</label>
                            <select name="kategori" class="form-select rounded-3">
                                <option value="murah">Murah (Ekonomis)</option>
                                <option value="sedang" selected>Sedang (Standar)</option>
                                <option value="mahal">Mahal (Premium)</option>
                            </select>
                        </div>
                    </div>

                    <label class="form-label fw-bold text-dark d-block mb-2"><i class="fas fa-ruler-combined me-1"></i> Stok Awal per Ukuran (S - XXL):</label>
                    <div class="row g-2 mb-3 bg-light p-3 rounded-3 border">
                        <?php foreach (['S','M','L','XL','XXL'] as $uk): ?>
                            <div class="col">
                                <label class="form-label small text-muted text-center d-block fw-bold mb-1">Ukuran <?= $uk; ?></label>
                                <input type="number" name="stok_<?= $uk; ?>" class="form-control text-center fw-bold rounded-3" value="50" min="0" required>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Foto Produk Kaos</label>
                        <input type="file" name="gambar" class="form-control rounded-3" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Deskripsi Singkat</label>
                        <textarea name="deskripsi" class="form-control rounded-3" rows="2" placeholder="Deskripsi produk kaos..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4"><i class="fas fa-plus me-1"></i> Tambah Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
