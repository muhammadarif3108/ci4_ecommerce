<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'iTechStore' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* GLOBAL VARIABLES */
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


        /* BASE STYLES */
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            padding-top: 60px;
        }

        main {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
        }


        /* NAVBAR */
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.5px;
            color: var(--accent-color) !important;
        }

        .nav-link {
            color: var(--text-color) !important;
            font-weight: 500;
            transition: 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--accent-color) !important;
        }

        .dropdown-menu {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: #fff;
        }

        .dropdown-item {
            color: var(--text-color);
        }

        .dropdown-item:hover {
            background-color: var(--accent-color);
            color: #fff;
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -8px;
            font-size: 0.7rem;
            background: var(--accent-color);
            color: #fff;
        }


        /* SEARCH BOX */
        .form-control {
            background: #fff;
            border: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .form-control::placeholder {
            color: var(--muted-text);
        }


        /* BUTTONS */
        .btn,
        .btn-primary {
            background: var(--primary-gradient);
            color: #fff;
            border: none;
            border-radius: 2rem;
            transition: 0.3s ease;
        }

        .btn:hover {
            background: var(--primary-hover);
            box-shadow: 0 0 10px rgba(0, 180, 219, 0.4);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            border: 1px solid var(--accent-color);
            color: var(--accent-color);
            background: transparent;
            border-radius: 2rem;
        }

        .btn-outline-primary:hover {
            background: var(--accent-color);
            color: #fff;
        }

        .btn-light {
            background: linear-gradient(90deg, var(--accent-color), var(--accent-hover));
            color: #fff;
            border: none;
            transition: 0.3s ease;
        }

        .btn-light:hover {
            opacity: 0.9;
            box-shadow: 0 0 10px rgba(0, 169, 201, 0.3);
        }

        /* Button glow for CTAs */
        .btn-glow {
            background: var(--primary-gradient);
            color: #fff;
            border: none;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .btn-glow:hover {
            box-shadow: 0 0 12px rgba(0, 169, 201, 0.4);
            transform: translateY(-1px);
        }


        /* ALERTS */
        .alert {
            border-radius: 10px;
            background: rgba(0, 169, 201, 0.1);
            border: 1px solid rgba(0, 169, 201, 0.3);
            color: var(--accent-color);
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


        /* HERO SECTION */
        .hero-section {
            background: linear-gradient(135deg, #E6F9FC, #D6F2FF);
            text-align: center;
            border-radius: 1rem;
            padding: 5rem 1rem;
            margin-bottom: 4rem;
            box-shadow: 0 6px 20px rgba(0, 132, 176, 0.1);
        }

        .hero-section h1 {
            font-weight: 700;
            color: #022C43;
        }

        .hero-section p {
            font-size: 1.1rem;
            color: var(--muted-text);
            max-width: 600px;
            margin: 1rem auto 2rem;
        }

        .hero-section .btn-light {
            background: var(--primary-gradient);
            color: #fff;
            border: none;
            font-weight: 600;
            padding: 0.8rem 2rem;
            border-radius: 2rem;
            transition: 0.3s ease;
            box-shadow: 0 0 10px rgba(0, 180, 219, 0.3);
        }

        .hero-section .btn-light:hover {
            background: var(--primary-hover);
            transform: translateY(-3px);
            box-shadow: 0 0 18px rgba(0, 180, 219, 0.4);
        }


        /* CATEGORY CARDS */
        .category-card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            background-color: var(--card-bg);
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 6px 20px rgba(0, 180, 219, 0.2);
        }

        .category-card i {
            color: var(--accent-color);
        }


        /* PRODUCT CARDS */
        .product-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            transition: 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 180, 219, 0.25);
        }

        .product-image {
            height: 180px;
            object-fit: cover;
        }

        .product-card .badge.bg-secondary {
            background-color: var(--accent-color) !important;
            font-weight: 600;
        }


        /* WHY CHOOSE US */
        .why-us {
            background-color: var(--secondary-color);
            border-radius: 1rem;
            padding: 4rem 1rem;
            margin-top: 5rem;
        }

        .why-us i {
            color: var(--accent-color);
        }

        .why-us h5 {
            color: var(--text-color);
            font-weight: 600;
        }

        .why-us p {
            color: var(--muted-text);
            font-size: 0.95rem;
        }


        /* FOOTER */
        footer {
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            color: var(--muted-text);
            padding-top: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        footer h5 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }

        footer a {
            text-decoration: none;
            color: var(--muted-text);
            transition: 0.3s ease;
        }

        footer a:hover {
            color: var(--accent-color);
        }

        footer hr {
            border-color: rgba(0, 0, 0, 0.08);
        }

        /* PRODUCTS DETAIL PAGE */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-item a {
            color: var(--accent-color);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--accent-hover);
        }

        .breadcrumb-item.active {
            color: var(--muted-text);
        }

        .product-image {
            background-color: #f8f9fa;
            border-radius: 0.75rem;
            border: 1px solid #e0e0e0;
            object-fit: cover;
            width: 100%;
            height: fit-content;
            max-height: 600px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .product-info h2 {
            font-weight: 700;
            color: var(--text-color);
        }

        .product-info h3 {
            font-weight: 600;
            color: var(--accent-color);
        }

        .product-info p {
            color: #555;
            line-height: 1.6;
        }

        .badge.fs-6 {
            padding: 0.6em 1em;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .badge.bg-success {
            background-color: #4caf50 !important;
        }

        .badge.bg-danger {
            background-color: #f44336 !important;
        }

        .related-products {
            background: #f9f9f9;
            border-radius: 1rem;
            padding: 2rem;
            border: 1px solid #eee;
            margin-top: 4rem;
        }

        .related-products h4 {
            font-weight: 700;
            color: var(--text-color);
        }

        .related-item {
            transition: all 0.3s ease;
            border: 1px solid #e6e6e6;
            border-radius: 0.75rem;
            background-color: #fff;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.04);
        }

        .related-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 188, 212, 0.15);
        }

        .related-item img {
            height: 160px;
            object-fit: contain;
            padding: 10px;
        }


        /* TITLES */
        section h2 {
            color: var(--accent-color);
            font-weight: 700;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
                <i class="bi bi-shop me-2 fs-4"></i> iTechStore
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown">
                            Kategori
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                            $categoryModel = new \App\Models\CategoryModel();
                            $categories = $categoryModel->getCategories();
                            foreach ($categories as $cat):
                            ?>
                                <li><a class="dropdown-item" href="<?= base_url('category/' . $cat['id']) ?>"><?= esc($cat['name']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>

                <form class="d-flex me-3" action="<?= base_url('search') ?>" method="get">
                    <input class="form-control me-2" type="search" name="q" placeholder="Search products" required>
                    <button class="btn btn-light" type="submit"><i class="bi bi-search"></i></button>
                </form>

                <ul class="navbar-nav">
                    <li class="nav-item position-relative">
                        <a class="nav-link" href="<?= base_url('cart') ?>">
                            <i class="bi bi-cart3 fs-5"></i>
                            <?php
                            $cart = session()->get('cart') ?? [];
                            $cartCount = array_sum(array_column($cart, 'quantity'));
                            if ($cartCount > 0):
                            ?>
                                <span class="badge bg-danger cart-badge"><?= $cartCount ?></span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <?php if (session()->has('user_id')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?= esc(session()->get('user_name')) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="bi bi-person"></i> Profil</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('orders') ?>"><i class="bi bi-bag"></i> Pesanan Saya</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>"><i class="bi bi-box-arrow-in-right"></i> Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('register') ?>"><i class="bi bi-person-plus"></i> Daftar</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i><?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Main -->
    <main class="container mb-5">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="py-4">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <h5><i class="bi bi-shop"></i> iTechStore</h5>
                    <p>Your trusted online tech destination — where innovation meets convenience.</p>
                </div>
                <div class="col-md-4">
                    <h5>Tautan Utama</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                        <li><a href="<?= base_url('about') ?>">Tentang Kami</a></li>
                        <li><a href="<?= base_url('contact') ?>">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Hubungi Kami</h5>
                    <p><i class="bi bi-envelope"></i> info@itechstore.com</p>
                    <p><i class="bi bi-phone"></i> +62 813 3358 3159</p>
                </div>
            </div>
            <hr>
            <div class="text-center small">
                &copy; <?= date('Y') ?> iTechStore. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>