<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="fas fa-chart-line text-primary me-2"></i> Dashboard Admin Produksi</h3>
        <p class="text-muted mb-0">Visualisasi statistik status antrean produksi, pilihan bahan kaos, dan tren pendapatan secara real-time.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/pesanan'); ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-semibold"><i class="fas fa-tasks me-1"></i> Kelola Pesanan</a>
        <a href="<?= base_url('admin/stok_kaos'); ?>" class="btn btn-outline-dark rounded-pill px-4 fw-semibold"><i class="fas fa-boxes me-1"></i> Stok Kaos</a>
    </div>
</div>

<!-- 4 Executive Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Pesanan</span>
                <h2 class="fw-extrabold text-primary mb-0"><?= $total_pesanan; ?></h2>
            </div>
            <div class="stat-icon-bg bg-primary bg-opacity-10 text-primary">
                <i class="fas fa-shopping-bag"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Produksi Aktif</span>
                <h2 class="fw-extrabold text-warning mb-0"><?= $produksi_aktif; ?></h2>
            </div>
            <div class="stat-icon-bg bg-warning bg-opacity-10 text-warning">
                <i class="fas fa-cogs"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Menunggu Verifikasi</span>
                <h2 class="fw-extrabold text-info mb-0"><?= $menunggu_verifikasi; ?></h2>
            </div>
            <div class="stat-icon-bg bg-info bg-opacity-10 text-info">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Pesanan Selesai</span>
                <h2 class="fw-extrabold text-success mb-0"><?= $pesanan_selesai; ?></h2>
            </div>
            <div class="stat-icon-bg bg-success bg-opacity-10 text-success">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<!-- Interactive Charts Section -->
<div class="row g-4 mb-4">
    <!-- Chart 1: Status Produksi Real-Time (Doughnut) -->
    <div class="col-lg-5">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold mb-3 text-dark"><i class="fas fa-chart-pie text-primary me-2"></i> Distribusi Status Produksi</h5>
            <div style="height: 280px; position: relative;">
                <canvas id="chartStatusProduksi"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart 2: Pilihan Bahan Kaos Terpopuler (Bar) -->
    <div class="col-lg-7">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold mb-3 text-dark"><i class="fas fa-tshirt text-success me-2"></i> Bahan Kaos Terpopuler (Total Pcs Dipesan)</h5>
            <div style="height: 280px; position: relative;">
                <canvas id="chartPopularKaos"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart 3: Tren Omset Pendapatan (Line) -->
<div class="card-custom p-4">
    <h5 class="fw-bold mb-3 text-dark"><i class="fas fa-chart-area text-info me-2"></i> Tren Omset Pendapatan Real-Time</h5>
    <div style="height: 250px; position: relative;">
        <canvas id="chartOmsetPendapatan"></canvas>
    </div>
</div>

<!-- Chart Initialization Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Doughnut Chart: Status Produksi
    const ctxStatus = document.getElementById('chartStatusProduksi').getContext('2d');
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

    // 2. Bar Chart: Bahan Kaos Terpopuler
    const ctxKaos = document.getElementById('chartPopularKaos').getContext('2d');
    new Chart(ctxKaos, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chart_kaos['labels']); ?>,
            datasets: [{
                label: 'Total Pcs Dipesan',
                data: <?= json_encode($chart_kaos['data']); ?>,
                backgroundColor: 'rgba(37, 99, 235, 0.8)',
                borderColor: '#2563eb',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 3. Line Chart: Omset Pendapatan
    const ctxOmset = document.getElementById('chartOmsetPendapatan').getContext('2d');
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
                pointRadius: 5,
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
});
</script>
