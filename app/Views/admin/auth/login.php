<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - iTechStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(90deg, #00B4DB, #0083B0);
            --primary-hover: linear-gradient(90deg, #0083B0, #00B4DB);
            --accent-color: #00A9C9;
            --accent-hover: #0083B0;
            --secondary-color: #F0FAFB;
            --bg-color: #F8FBFC;
            --card-bg: #FFFFFF;
            --text-color: #1B1F24;
            --muted-text: #5F6B7A;
            --border-color: #E5E9EC;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-card {
            max-width: 450px;
            width: 90%;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            background-color: var(--card-bg);
            overflow: hidden;
        }

        .login-header {
            background: var(--primary-gradient);
            color: #fff;
            padding: 2.5rem 1.5rem;
            text-align: center;
        }

        .login-header i {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .login-header h3 {
            margin-bottom: 0.25rem;
            font-weight: 700;
        }

        .login-header p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .login-body {
            padding: 2rem 1.5rem;
        }

        .form-control {
            border-radius: 2rem;
            border: 1px solid var(--border-color);
            padding: 0.8rem 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 8px rgba(0, 169, 201, 0.3);
            border-color: var(--accent-color);
        }

        .btn-login {
            background: var(--primary-gradient);
            color: #fff;
            border-radius: 2rem;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            box-shadow: 0 0 12px rgba(0, 180, 219, 0.4);
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 1rem;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.1);
            border-color: rgba(76, 175, 80, 0.3);
            color: #2E7D32;
        }

        .alert-danger {
            background: rgba(244, 67, 54, 0.1);
            border-color: rgba(244, 67, 54, 0.3);
            color: #C62828;
        }

        a.text-decoration-none {
            color: var(--accent-color);
        }

        a.text-decoration-none:hover {
            text-decoration: underline;
            color: var(--accent-hover);
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <i class="bi bi-shield-lock"></i>
            <h3>Dashboard Admin</h3>
            <p>iTechStore Management System</p>
        </div>
        <div class="login-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/login/process') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-4">
                    <label for="email" class="form-label"><i class="bi bi-envelope"></i> Email Address</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Enter your email" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label"><i class="bi bi-lock"></i> Password</label>
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-login btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Login to Dashboard
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="<?= base_url('/') ?>" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Back to Store
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>