<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; background: #fff; padding: 20px; }
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 15px; margin-bottom: 25px; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

<div class="container-fluid">
    <div class="no-print mb-4">
        <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Cetak Dokumen</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>

    <!-- Kop Surat Header -->
    <div class="kop-surat text-center">
        <h2 class="fw-bold mb-1" style="letter-spacing: 2px;">GIND SCREEN PRINTING</h2>
        <p class="mb-0 fs-6">Jasa Sablon Kaos Custom Berkualitas & Presisi</p>
        <p class="mb-0 small">Jl. Screen Printing No. 88, Kota Magelang, Jawa Tengah 56115 | Telp/WA: 0812-3456-7890</p>
    </div>

    <div class="text-center mb-4">
        <h4 class="fw-bold text-uppercase mb-1">LAPORAN PENJUALAN & PRODUKSI SABLON</h4>
        <?php if (!empty($tgl_mulai) && !empty($tgl_selesai)): ?>
            <p class="small mb-0">Periode Tanggal: <strong><?= date('d/m/Y', strtotime($tgl_mulai)); ?></strong> s/d <strong><?= date('d/m/Y', strtotime($tgl_selesai)); ?></strong></p>
        <?php else: ?>
            <p class="small mb-0">Periode: Semua Data Transaksi</p>
        <?php endif; ?>
    </div>

    <!-- Table Data -->
    <table class="table table-bordered align-middle fs-7 mb-4">
        <thead class="table-light text-center">
            <tr>
                <th style="width: 5%;">No</th>
                <th>Kode Pesanan</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Jenis Kaos</th>
                <th>Ukuran</th>
                <th>Qty</th>
                <th>Total Biaya</th>
                <th>Status Bayar</th>
                <th>Status Produksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($laporan_list)): ?>
                <tr>
                    <td colspan="10" class="text-center py-3">Tidak ada data pesanan.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($laporan_list as $row): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><strong><?= $row['kode_pesanan']; ?></strong></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($row['created_at'])); ?></td>
                        <td><?= $row['nama_pelanggan']; ?></td>
                        <td><?= $row['nama_kaos']; ?></td>
                        <td class="text-center"><?= $row['ukuran']; ?></td>
                        <td class="text-center"><?= $row['jumlah']; ?> Pcs</td>
                        <td class="text-end">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td class="text-center"><?= strtoupper(str_replace('_', ' ', $row['status_pembayaran'])); ?></td>
                        <td class="text-center"><?= strtoupper($row['status_produksi']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" class="text-end fw-bold">TOTAL OMSET PENDAPATAN (LUNAS):</th>
                <th class="text-end fw-bold text-success">Rp <?= number_format($total_omset, 0, ',', '.'); ?></th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>

    <!-- Tanda Tangan -->
    <div class="row mt-5">
        <div class="col-6"></div>
        <div class="col-6 text-center ms-auto">
            <p class="mb-1">Magelang, <?= date('d F Y'); ?></p>
            <p class="mb-5">Pemilik Gind Screen Printing,</p>
            <br><br>
            <p class="fw-bold text-decoration-underline mb-0">Bpk. Gind</p>
            <small>Owner / Owner Representative</small>
        </div>
    </div>
</div>

</body>
</html>
