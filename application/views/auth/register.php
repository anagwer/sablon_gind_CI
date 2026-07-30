<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 500px;
            padding: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo-img { height: 50px; object-fit: contain; }

        .btn-primary-custom {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 0.8rem;
            color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5);
            color: white;
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="text-center mb-4">
        <a href="<?= base_url(); ?>">
            <img src="<?= base_url('assets/images/gind_logo.png'); ?>" alt="Gind Logo" class="logo-img mb-2" onerror="this.src='<?= base_url('assets/images/hero_sablon.png'); ?>'">
        </a>
        <h4 class="fw-extrabold text-dark mb-1">Daftar Akun Pelanggan</h4>
        <p class="text-muted small">Buat akun untuk memesan sablon kaos custom & pantau status produksi</p>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger rounded-3 py-2 px-3 small mb-3">
            <i class="fas fa-exclamation-triangle me-1"></i><?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('auth/register'); ?>" method="POST">
        <div class="mb-3">
            <label class="form-label fw-bold small text-secondary">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control bg-light" placeholder="e.g. Rizky Pratama" value="<?= set_value('nama_lengkap'); ?>" required>
            <?= form_error('nama_lengkap', '<small class="text-danger">', '</small>'); ?>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Username</label>
                <input type="text" name="username" class="form-control bg-light" placeholder="username" value="<?= set_value('username'); ?>" required>
                <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">No. WhatsApp</label>
                <input type="text" name="no_hp" class="form-control bg-light" placeholder="08xxxxxxxxxx" value="<?= set_value('no_hp'); ?>" required>
                <?= form_error('no_hp', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold small text-secondary">Email</label>
            <input type="email" name="email" class="form-control bg-light" placeholder="email@domain.com" value="<?= set_value('email'); ?>" required>
            <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold small text-secondary">Alamat Lengkap Pengiriman</label>
            <textarea name="alamat" class="form-control bg-light" rows="2" placeholder="Jl. Merdeka No..., Kota..."><?= set_value('alamat'); ?></textarea>
        </div>

        <div class="row g-2 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Password</label>
                <input type="password" name="password" class="form-control bg-light" placeholder="Min 6 karakter" required>
                <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Ulangi Password</label>
                <input type="password" name="confirm_password" class="form-control bg-light" placeholder="Konfirmasi" required>
                <?= form_error('confirm_password', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 mb-3"><i class="fas fa-user-plus me-1"></i> Register Akun Baru</button>
    </form>

    <div class="text-center">
        <span class="text-muted small">Sudah punya akun?</span>
        <a href="<?= base_url('login'); ?>" class="fw-bold text-primary text-decoration-none small"> Login Sekarang</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
