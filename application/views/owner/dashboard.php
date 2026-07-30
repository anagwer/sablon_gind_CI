<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="fas fa-user-shield text-danger me-2"></i> Dashboard Pemilik (Owner)</h3>
        <p class="text-muted mb-0">Selamat datang, Bpk. Gind. Visualisasi performa omset, status produksi, dan popularitas produk kaos.</p>
    </div>
    <a href="<?= base_url('owner/laporan'); ?>" class="btn btn-danger rounded-pill px-4 shadow-sm fw-semibold"><i class="fas fa-file-invoice-dollar me-1"></i> Lihat & Cetak Laporan</a>
</div>

<!-- 4 Executive Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card d-flex align-items-center justify-content-between border-start border-success border-4">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Omset Pendapatan</span>
                <h3 class="fw-extrabold text-success mb-0"><?= format_rupiah($total_omset); ?></h3>
            </div>
            <div class="stat-icon-bg bg-success bg-opacity-10 text-success">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card d-flex align-items-center justify-content-between border-start border-primary border-4">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Pesanan Masuk</span>
                <h2 class="fw-extrabold text-primary mb-0"><?= $total_pesanan; ?></h2>
            </div>
            <div class="stat-icon-bg bg-primary bg-opacity-10 text-primary">
                <i class="fas fa-shopping-bag"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card d-flex align-items-center justify-content-between border-start border-warning border-4">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Produksi Berjalan</span>
                <h2 class="fw-extrabold text-warning mb-0"><?= $produksi_aktif; ?></h2>
            </div>
            <div class="stat-icon-bg bg-warning bg-opacity-10 text-warning">
                <i class="fas fa-cogs"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card d-flex align-items-center justify-content-between border-start border-info border-4">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Pesanan Selesai</span>
                <h2 class="fw-extrabold text-info mb-0"><?= $pesanan_selesai; ?></h2>
            </div>
            <div class="stat-icon-bg bg-info bg-opacity-10 text-info">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<!-- Interactive Charts Section -->
<div class="row g-4 mb-4">
    <!-- Chart 1: Tren Omset (Line Chart) -->
    <div class="col-lg-7">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold mb-3 text-dark"><i class="fas fa-chart-line text-success me-2"></i> Tren Pendapatan Omset (Lunas)</h5>
            <div style="height: 280px; position: relative;">
                <canvas id="chartOmsetOwner"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart 2: Status Produksi (Doughnut Chart) -->
    <div class="col-lg-5">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold mb-3 text-dark"><i class="fas fa-chart-pie text-primary me-2"></i> Distribusi Status Produksi</h5>
            <div style="height: 280px; position: relative;">
                <canvas id="chartStatusOwner"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart Initialization Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Line Chart: Omset Pendapatan
    const ctxOmset = document.getElementById('chartOmsetOwner').getContext('2d');
    new Chart(ctxOmset, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_omset['labels']); ?>,
            datasets: [{
                label: 'Total Omset (Rp)',
                data: <?= json_encode($chart_omset['data']); ?>,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.15)',
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#10b981'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Doughnut Chart: Status Produksi
    const ctxStatus = document.getElementById('chartStatusOwner').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($chart_status['labels']); ?>,
            datasets: [{
                data: <?= json_encode($chart_status['data']); ?>,
                backgroundColor: [
                    '#94a3b8', '#38bdf8', '#3b82f6', '#6366f1',
                    '#eab308', '#f97316', '#10b981', '#22c55e'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { family: 'Plus Jakarta Sans', size: 11 } }
                }
            }
        }
    });
});
</script>
