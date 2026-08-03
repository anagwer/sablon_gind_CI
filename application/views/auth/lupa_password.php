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

        .login-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 440px;
            padding: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo-img {
            height: 55px;
            object-fit: contain;
        }

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

<div class="login-card">
    <div class="text-center mb-4">
        <a href="<?= base_url(); ?>">
            <img src="<?= base_url('assets/images/gind_logo.png'); ?>" alt="Gind Logo" class="logo-img mb-2" onerror="this.src='<?= base_url('assets/images/hero_sablon.png'); ?>'">
        </a>
        <h4 class="fw-extrabold text-dark mb-1">RESET PASSWORD</h4>
        <p class="text-muted small">Masukkan Username/Email terdaftar dan buat password baru</p>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger rounded-3 py-2 px-3 small mb-3">
            <i class="fas fa-exclamation-triangle me-1"></i><?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('auth/lupa_password'); ?>" method="POST">
        <div class="mb-3">
            <label class="form-label fw-bold small text-secondary">Username atau Email</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                <input type="text" name="identifier" class="form-control bg-light border-start-0" placeholder="Masukkan username atau email" value="<?= set_value('identifier'); ?>" required autofocus>
            </div>
            <?= form_error('identifier', '<small class="text-danger">', '</small>'); ?>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold small text-secondary">Password Baru</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" name="password" id="input_password" class="form-control bg-light border-start-0 border-end-0" placeholder="Min 6 karakter" required>
                <button type="button" class="btn btn-light border border-start-0 text-muted toggle-password" data-target="input_password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold small text-secondary">Konfirmasi Password Baru</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" name="confirm_password" id="input_confirm_password" class="form-control bg-light border-start-0 border-end-0" placeholder="Ulangi password baru" required>
                <button type="button" class="btn btn-light border border-start-0 text-muted toggle-password" data-target="input_confirm_password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <?= form_error('confirm_password', '<small class="text-danger">', '</small>'); ?>
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 mb-3"><i class="fas fa-key me-1"></i> Simpan Password Baru</button>
    </form>

    <div class="text-center mt-3">
        <a href="<?= base_url('auth/login'); ?>" class="text-primary fw-bold small text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Kembali ke Halaman Login</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});
</script>
</body>
</html>
