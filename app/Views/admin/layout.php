<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - iTechStore</title>
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
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            min-height: 100vh;
            background-color: var(--card-bg);
            border-right: 1px solid var(--border-color);
            box-shadow: 2px 0 6px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .sidebar .brand {
            text-align: center;
            padding: 1.5rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar .brand h5 {
            margin: 0;
            font-weight: 600;
            color: var(--accent-color);
        }

        .sidebar .brand small {
            color: var(--muted-text);
        }

        .sidebar .nav-link {
            color: var(--text-color);
            padding: 0.65rem 1.5rem;
            border-radius: 0.75rem;
            margin: 0.25rem 0.5rem;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.25s;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            margin-right: 0.75rem;
            opacity: 0.7;
        }

        .sidebar .nav-link:hover {
            background-color: var(--secondary-color);
            color: var(--accent-color);
        }

        .sidebar .nav-link.active {
            background: var(--primary-gradient);
            color: #fff;
            font-weight: 600;
        }

        /* Navbar */
        .navbar {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .navbar .nav-link {
            color: var(--text-color);
            font-weight: 500;
        }

        .navbar .dropdown-menu {
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        /* Main Content */
        .main-content {
            background-color: var(--bg-color);
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        /* Cards */
        .stat-card {
            background-color: var(--card-bg);
            border-radius: 1rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 180, 219, 0.15);
        }

        /* Alerts */
        .alert {
            border-radius: 1rem;
            font-weight: 500;
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

        /* Tables */
        .table-responsive {
            border-radius: 1rem;
            background-color: var(--card-bg);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            padding: 0.5rem;
        }

        .badge-status {
            padding: 0.4rem 0.9rem;
            border-radius: 2rem;
            font-size: 0.85rem;
        }

        /* Footer */
        footer {
            font-size: 0.9rem;
            color: var(--muted-text);
            text-align: center;
            padding: 1rem 0;
            border-top: 1px solid var(--border-color);
            background-color: var(--card-bg);
        }

        /* Scrollbar for sidebar */
        .sidebar {
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav class="col-md-2 col-lg-2 d-md-block sidebar p-0">
                <div class="brand">
                    <i class="bi bi-cpu fs-2" style="color: var(--accent-color)"></i>
                    <h5 class="mt-2">iTechStore</h5>
                    <small class="text-muted">Admin Panel</small>
                </div>
                <ul class="nav flex-column mt-3">
                    <li class="nav-item">
                        <a class="nav-link <?= (uri_string() == 'admin' || uri_string() == 'admin/') ? 'active' : '' ?>"
                            href="<?= base_url('admin') ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'admin/products') !== false ? 'active' : '' ?>"
                            href="<?= base_url('admin/products') ?>">
                            <i class="bi bi-box-seam"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'admin/categories') !== false ? 'active' : '' ?>"
                            href="<?= base_url('admin/categories') ?>">
                            <i class="bi bi-grid-3x3"></i> Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'admin/orders') !== false ? 'active' : '' ?>"
                            href="<?= base_url('admin/orders') ?>">
                            <i class="bi bi-cart-check"></i> Pesanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'admin/users') !== false ? 'active' : '' ?>"
                            href="<?= base_url('admin/users') ?>">
                            <i class="bi bi-people"></i> Pengguna
                        </a>
                    </li>
                    <li class="nav-item mt-4 pt-3 border-top border-light">
                        <a class="nav-link" href="<?= base_url('/') ?>" target="_blank">
                            <i class="bi bi-globe"></i> Kunjungi Toko
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/logout') ?>">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4 main-content">

                <!-- Alerts -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Content -->
                <div class="py-3">
                    <?= $this->renderSection('content') ?>
                </div>

            </main>
        </div>
    </div>

    <footer>
        &copy; <?= date('Y') ?> iTechStore. All Rights Reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>