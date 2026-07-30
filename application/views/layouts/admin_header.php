<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Admin Panel - Gind Screen Printing'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-color: #94a3b8;
            --sidebar-active-bg: #2563eb;
            --sidebar-active-color: #ffffff;
            --main-bg: #f8fafc;
            --card-border: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--main-bg);
            color: #1e293b;
            overflow-x: hidden;
        }

        #wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        #sidebar-wrapper {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.1);
            transition: margin-left 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sidebar-brand img {
            height: 38px;
            object-fit: contain;
        }

        .sidebar-user {
            padding: 1.2rem 1.25rem;
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sidebar-menu {
            padding: 1rem 0;
            flex: 1;
            overflow-y: auto;
        }

        .menu-header {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #64748b;
            font-weight: 700;
            padding: 0.85rem 1.5rem 0.35rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--sidebar-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.88rem;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-link i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 12px;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.04);
        }

        .sidebar-link.active {
            color: var(--sidebar-active-color);
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.2) 0%, rgba(37, 99, 235, 0.02) 100%);
            border-left-color: var(--sidebar-active-bg);
            font-weight: 700;
        }

        /* Page Content Wrapper */
        #page-content-wrapper {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-width: 0;
            flex: 1 1 auto;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        #wrapper.toggled #page-content-wrapper {
            margin-left: 0;
            width: 100%;
        }

        @media (max-width: 991.98px) {
            #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #page-content-wrapper {
                margin-left: 0;
                width: 100%;
            }
            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
            }
        }

        .admin-topbar {
            height: 70px;
            width: 100%;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .admin-main-content {
            padding: 2rem 1.75rem;
            flex: 1 0 auto;
            width: 100%;
        }

        /* Modern Executive Card Styling */
        .card-custom {
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            background: #ffffff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            width: 100%;
        }

        .stat-card {
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            padding: 1.5rem;
            transition: all 0.25 ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .stat-icon-bg {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        /* DataTables Modern Customization */
        .dataTables_wrapper .dataTables_paginate .paginate_button.active .page-link {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: white !important;
            border-radius: 8px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button .page-link {
            border-radius: 8px;
            margin: 0 2px;
            color: #475569;
            font-weight: 600;
        }

        table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            width: 100% !important;
        }

        table.dataTable thead th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 0.9rem 1rem !important;
            border-bottom: 2px solid #e2e8f0 !important;
        }

        table.dataTable tbody td {
            padding: 0.9rem 1rem !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 0.88rem;
        }

        .dataTables_filter input {
            border-radius: 20px !important;
            padding: 0.4rem 1rem !important;
            border: 1px solid #cbd5e1 !important;
            outline: none !important;
        }

        .dataTables_length select {
            border-radius: 10px !important;
            padding: 0.3rem 0.8rem !important;
            border: 1px solid #cbd5e1 !important;
        }

        .badge-stok {
            font-size: 0.72rem;
            padding: 0.3em 0.6em;
            border-radius: 6px;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div id="wrapper">
    <!-- Left Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-brand d-flex align-items-center">
            <img src="<?= base_url('assets/images/gind_logo.png'); ?>" alt="Gind Logo" class="me-2" onerror="this.src='<?= base_url('assets/images/hero_sablon.png'); ?>'">
            <div class="lh-1">
                <span class="fw-bold fs-5 text-white d-block">GIND</span>
                <small class="text-info fs-7 fw-semibold" style="letter-spacing: 1px;">PANEL PRODUKSI</small>
            </div>
        </div>

        <div class="sidebar-user d-flex align-items-center gap-3">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 42px; height: 42px; font-size: 1.1rem;">
                <?= strtoupper(substr($this->session->userdata('nama_lengkap'), 0, 1)); ?>
            </div>
            <div class="lh-sm overflow-hidden">
                <span class="fw-bold text-white d-block text-truncate small"><?= $this->session->userdata('nama_lengkap'); ?></span>
                <?php 
                    $role = $this->session->userdata('role');
                    $role_badge = ($role == 'owner') ? 'bg-danger' : 'bg-warning text-dark';
                ?>
                <span class="badge <?= $role_badge; ?>" style="font-size: 0.68rem; text-transform: uppercase;"><?= $role; ?></span>
            </div>
        </div>

        <div class="sidebar-menu">
            <?php 
                $uri_1 = $this->uri->segment(1);
                $uri_2 = $this->uri->segment(2);
            ?>

            <?php if ($role == 'admin'): ?>
                <div class="menu-header">Menu Utama Admin</div>
                <a href="<?= base_url('admin/dashboard'); ?>" class="sidebar-link <?= ($uri_1 == 'admin' && ($uri_2 == 'dashboard' || $uri_2 == '')) ? 'active' : ''; ?>">
                    <i class="fas fa-chart-line text-info"></i> Dashboard Admin
                </a>
                <a href="<?= base_url('admin/pesanan'); ?>" class="sidebar-link <?= ($uri_1 == 'admin' && ($uri_2 == 'pesanan' || $uri_2 == 'detail_pesanan')) ? 'active' : ''; ?>">
                    <i class="fas fa-tasks text-warning"></i> Kelola Produksi
                </a>
                <a href="<?= base_url('admin/stok_kaos'); ?>" class="sidebar-link <?= ($uri_1 == 'admin' && $uri_2 == 'stok_kaos') ? 'active' : ''; ?>">
                    <i class="fas fa-boxes text-success"></i> Stok Kaos (S-XXL)
                </a>
            <?php elseif ($role == 'owner'): ?>
                <div class="menu-header">Menu Eksekutif Pemilik</div>
                <a href="<?= base_url('owner/dashboard'); ?>" class="sidebar-link <?= ($uri_1 == 'owner' && ($uri_2 == 'dashboard' || $uri_2 == '')) ? 'active' : ''; ?>">
                    <i class="fas fa-user-shield text-danger"></i> Dashboard Pemilik
                </a>
                <a href="<?= base_url('owner/laporan'); ?>" class="sidebar-link <?= ($uri_1 == 'owner' && ($uri_2 == 'laporan' || $uri_2 == 'cetak_laporan')) ? 'active' : ''; ?>">
                    <i class="fas fa-file-invoice-dollar text-success"></i> Laporan & Omset
                </a>
                <a href="<?= base_url('admin/stok_kaos'); ?>" class="sidebar-link <?= ($uri_1 == 'admin' && $uri_2 == 'stok_kaos') ? 'active' : ''; ?>">
                    <i class="fas fa-boxes text-primary"></i> Rekap Stok Kaos
                </a>
            <?php endif; ?>

            <div class="menu-header">Navigasi Publik</div>
            <a href="<?= base_url('lacak'); ?>" target="_blank" class="sidebar-link">
                <i class="fas fa-search-location text-info"></i> Lacak Pesanan
            </a>
            <a href="<?= base_url(); ?>" target="_blank" class="sidebar-link">
                <i class="fas fa-globe text-primary"></i> Landing Page Publik
            </a>

            <div class="menu-header">Akun</div>
            <a href="<?= base_url('logout'); ?>" class="sidebar-link text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout Sistem
            </a>
        </div>

        <div class="p-3 text-center border-top border-secondary border-opacity-25 text-muted small">
            <small>&copy; <?= date('Y'); ?> Gind Screen Printing</small>
        </div>
    </div>

    <!-- Page Content Wrapper -->
    <div id="page-content-wrapper">
        <!-- Topbar Header -->
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light border rounded-circle" id="sidebarToggle" type="button" title="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="fw-bold mb-0 text-dark d-none d-sm-block"><?= isset($title) ? $title : 'Panel Kelola Sablon'; ?></h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="<?= base_url(); ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3 d-none d-md-inline-block">
                    <i class="fas fa-external-link-alt me-1"></i> Lihat Web
                </a>
                
                <div class="dropdown">
                    <button class="btn btn-light border rounded-pill px-3 dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle text-primary fs-5"></i>
                        <span class="fw-semibold small"><?= $this->session->userdata('nama_lengkap'); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><h6 class="dropdown-header">Login sebagai <?= ucfirst($role); ?></h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout'); ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="admin-main-content">
            <!-- Flash messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i><?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
