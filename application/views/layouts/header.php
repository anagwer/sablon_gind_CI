<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Gind Screen Printing'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --gind-primary: #1e293b;
            --gind-secondary: #0f172a;
            --gind-accent: #2563eb;
            --gind-accent-hover: #1d4ed8;
            --gind-bg: #f8fafc;
            --gind-card-bg: #ffffff;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--gind-bg);
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand img {
            height: 42px;
            object-fit: contain;
        }

        .nav-link {
            color: #cbd5e1 !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        .main-content {
            flex: 1;
            padding-top: 2rem;
            padding-bottom: 3rem;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
            background: #ffffff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-custom:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .btn-gind {
            background-color: var(--gind-accent);
            color: white;
            border-radius: 10px;
            font-weight: 600;
            padding: 0.6rem 1.4rem;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-gind:hover {
            background-color: var(--gind-accent-hover);
            color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.35);
        }

        .badge-role {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.35em 0.8em;
            border-radius: 20px;
        }

        /* Timeline tracking styling */
        .timeline-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .timeline-steps::before {
            content: '';
            position: absolute;
            top: 24px;
            left: 5%;
            width: 90%;
            height: 4px;
            background: #e2e8f0;
            z-index: 1;
        }

        .timeline-step {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
        }

        .timeline-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #ffffff;
            border: 3px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            color: #64748b;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .timeline-step.active .timeline-icon {
            background: var(--gind-accent);
            border-color: var(--gind-accent);
            color: white;
            box-shadow: 0 0 0 6px rgba(37, 99, 235, 0.2);
        }

        .timeline-step.completed .timeline-icon {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }

        .timeline-label {
            font-size: 0.825rem;
            font-weight: 600;
            color: #475569;
        }

        .timeline-step.active .timeline-label {
            color: var(--gind-accent);
            font-weight: 700;
        }
    </style>
</head>
<body>

<!-- Navbar Top -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top py-2">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url(); ?>">
            <img src="<?= base_url('assets/images/gind_logo.png'); ?>" alt="Gind Logo" class="me-2" onerror="this.src='<?= base_url('assets/images/hero_sablon.png'); ?>'">
            <div class="lh-1">
                <span class="fw-bold fs-5 text-white d-block">GIND</span>
                <small class="text-info fs-7 fw-semibold" style="letter-spacing: 1px;">SCREEN PRINTING</small>
            </div>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto ms-lg-4 mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>"><i class="fas fa-home me-1">="</i> Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('lacak'); ?>"><i class="fas fa-search-location me-1"></i> Lacak Pesanan</a>
                </li>

                <?php if ($this->session->userdata('user_id')): ?>
                    <?php $role = $this->session->userdata('role'); ?>
                    <?php if ($role == 'pelanggan'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('pelanggan/dashboard'); ?>"><i class="fas fa-tachometer-alt me-1"></i> Dashboard Saya</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('pelanggan/buat_pesanan'); ?>"><i class="fas fa-plus-circle me-1"></i> Buat Pesanan</a>
                        </li>
                    <?php elseif ($role == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>"><i class="fas fa-chart-line me-1"></i> Dashboard Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/pesanan'); ?>"><i class="fas fa-tasks me-1"></i> Kelola Produksi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/stok_kaos'); ?>"><i class="fas fa-boxes me-1"></i> Stok Kaos</a>
                        </li>
                    <?php elseif ($role == 'owner'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('owner/dashboard'); ?>"><i class="fas fa-user-shield me-1"></i> Dashboard Pemilik</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('owner/laporan'); ?>"><i class="fas fa-file-invoice-dollar me-1"></i> Laporan Produksi</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <?php if ($this->session->userdata('user_id')): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center gap-2 rounded-pill px-3 py-1" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fs-5"></i>
                            <span class="fw-semibold me-1"><?= $this->session->userdata('nama_lengkap'); ?></span>
                            <?php 
                                $r = $this->session->userdata('role');
                                $badge_cls = ($r == 'owner') ? 'bg-danger' : (($r == 'admin') ? 'bg-warning text-dark' : 'bg-success');
                            ?>
                            <span class="badge <?= $badge_cls; ?> badge-role"><?= strtoupper($r); ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><h6 class="dropdown-header">Login sebagai <?= ucfirst($r); ?></h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('logout'); ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('login'); ?>" class="btn btn-outline-light rounded-pill px-3"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                    <a href="<?= base_url('register'); ?>" class="btn btn-primary rounded-pill px-3 fw-semibold"><i class="fas fa-user-plus me-1"></i> Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="main-content">
    <div class="container">
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
