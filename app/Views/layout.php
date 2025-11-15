<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'iTechStore' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ========================================
        CSS VARIABLES
        ======================================== */
        :root {
            /* Primary Colors */
            --primary-blue: #00B4DB;
            --primary-dark: #0083B0;
            --accent-color: #00A9C9;
            --accent-hover: #0083B0;

            /* Background Colors */
            --bg-color: #F8FBFC;
            --secondary-bg: #F0FAFB;
            --card-bg: #FFFFFF;

            /* Text Colors */
            --text-color: #1B1F24;
            --muted-text: #5F6B7A;

            /* Border & Shadow */
            --border-color: #E5E9EC;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 6px 20px rgba(0, 180, 219, 0.15);
            --shadow-lg: 0 8px 30px rgba(0, 180, 219, 0.25);

            /* Gradients */
            --gradient-primary: linear-gradient(90deg, #00B4DB, #0083B0);
            --gradient-primary-hover: linear-gradient(90deg, #0083B0, #00B4DB);
            --gradient-hero: linear-gradient(135deg, #E6F9FC, #D6F2FF);

            /* Status Colors */
            --success-color: #4caf50;
            --success-bg: rgba(76, 175, 80, 0.1);
            --danger-color: #f44336;
            --danger-bg: rgba(244, 67, 54, 0.1);
        }

        /* ========================================
        BASE & RESET
        ======================================== */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            padding-top: 60px;
            line-height: 1.6;
        }

        main {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* ========================================
        NAVBAR
        ======================================== */
        .navbar {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
            color: var(--accent-color) !important;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--accent-hover) !important;
        }

        .nav-link {
            color: var(--text-color) !important;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 0.5rem 1rem;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--accent-color) !important;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--card-bg);
            box-shadow: var(--shadow-md);
            margin-top: 0.5rem;
        }

        .dropdown-item {
            color: var(--text-color);
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: var(--accent-color);
            color: #fff;
        }

        /* Cart Badge */
        .cart-badge {
            position: absolute;
            top: -6px;
            right: -8px;
            font-size: 0.7rem;
            background: var(--accent-color);
            color: #fff;
            padding: 0.2rem 0.4rem;
            border-radius: 50%;
            font-weight: 600;
        }

        /* ========================================
        FORM CONTROLS
        ======================================== */
        .form-control {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 169, 201, 0.15);
            outline: 0;
        }

        .form-control::placeholder {
            color: var(--muted-text);
        }

        .form-select {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-color);
        }

        /* ========================================
        BUTTONS
        ======================================== */
        .btn {
            font-weight: 500;
            padding: 0.6rem 1.5rem;
            border-radius: 2rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--gradient-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 180, 219, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--accent-color);
            color: #fff;
            border-color: var(--accent-color);
        }

        .btn-light {
            background: var(--gradient-primary);
            color: #fff;
        }

        .btn-light:hover {
            background: var(--gradient-primary-hover);
            box-shadow: 0 4px 12px rgba(0, 169, 201, 0.3);
        }

        .btn-secondary {
            background: var(--muted-text);
            color: #fff;
        }

        .btn-success {
            background: var(--success-color);
            color: #fff;
        }

        .btn-danger {
            background: var(--danger-color);
            color: #fff;
        }

        .btn-glow {
            background: var(--gradient-primary);
            color: #fff;
            border-radius: 8px;
        }

        .btn-glow:hover {
            box-shadow: 0 0 12px rgba(0, 169, 201, 0.4);
            transform: translateY(-1px);
        }

        /* Button Sizes */
        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
        }

        .btn-lg {
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
        }

        /* ========================================
        ALERTS
        ======================================== */
        .alert {
            border-radius: 10px;
            padding: 1rem 1.25rem;
            border: 1px solid;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: var(--success-bg);
            border-color: rgba(76, 175, 80, 0.3);
            color: #2E7D32;
        }

        .alert-danger {
            background: var(--danger-bg);
            border-color: rgba(244, 67, 54, 0.3);
            color: #C62828;
        }

        .alert-info {
            background: rgba(0, 169, 201, 0.1);
            border-color: rgba(0, 169, 201, 0.3);
            color: var(--accent-color);
        }

        .alert-dismissible .btn-close {
            padding: 0.75rem 1rem;
        }

        /* ========================================
        HERO SECTION
        ======================================== */
        .hero-section {
            background: var(--gradient-hero);
            text-align: center;
            border-radius: 1rem;
            padding: 5rem 2rem;
            margin-bottom: 4rem;
            box-shadow: var(--shadow-md);
        }

        .hero-section h1 {
            font-weight: 700;
            color: #022C43;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }

        .hero-section p {
            font-size: 1.1rem;
            color: var(--muted-text);
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        .hero-section .btn {
            padding: 0.8rem 2rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 180, 219, 0.3);
        }

        .hero-section .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 180, 219, 0.4);
        }

        /* ========================================
        CATEGORY CARDS
        ======================================== */
        .category-card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            background-color: var(--card-bg);
            color: var(--text-color);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
            border-color: var(--accent-color);
        }

        .category-card i {
            color: var(--accent-color);
            transition: transform 0.3s ease;
        }

        .category-card:hover i {
            transform: scale(1.1);
        }

        /* ========================================
        PRODUCT CARDS
        ======================================== */
        .product-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent-color);
        }

        /* Product Image */
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        /* Product Title - Fixed Height */
        .product-title {
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.4;
            height: 44px;
            overflow: hidden;
            display: -webkit-box;
            --webkit-line-clamp: 2;
            --webkit-box-orient: vertical;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }

        /* Product Description - Fixed Height */
        .product-desc {
            height: 40px;
            line-height: 1.4;
            overflow: hidden;
            display: -webkit-box;
            --webkit-line-clamp: 2;
            --webkit-box-orient: vertical;
            color: var(--muted-text);
            font-size: 0.9rem;
        }

        /* Product Stats - Fixed Height */
        .product-stats {
            height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Rating Stars */
        .product-stats .bi-star-fill,
        .product-stats .bi-star-half,
        .product-stats .bi-star {
            color: #ffc107;
        }

        .product-stats .bi-star {
            color: #ddd;
        }

        /* ========================================
        BADGES
        ======================================== */
        .badge {
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
        }

        .badge.bg-secondary {
            background-color: var(--accent-color) !important;
        }

        .badge.bg-success {
            background-color: var(--success-color) !important;
        }

        .badge.bg-danger {
            background-color: var(--danger-color) !important;
        }

        .bg-success-subtle {
            background-color: var(--success-bg) !important;
            color: #2E7D32 !important;
        }

        .badge.fs-6 {
            padding: 0.6em 1em;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        /* ========================================
        WHY CHOOSE US SECTION
        ======================================== */
        .why-us {
            background-color: var(--secondary-bg);
            border-radius: 1rem;
            padding: 4rem 2rem;
            margin-top: 5rem;
            margin-bottom: 3rem;
        }

        .why-us h2 {
            color: var(--accent-color);
            font-weight: 700;
            margin-bottom: 3rem;
        }

        .why-us i {
            color: var(--accent-color);
            transition: transform 0.3s ease;
        }

        .why-us .col-md-3:hover i {
            transform: translateY(-5px);
        }

        .why-us h5 {
            color: var(--text-color);
            font-weight: 600;
            margin-top: 1rem;
        }

        .why-us p {
            color: var(--muted-text);
            font-size: 0.95rem;
        }

        /* ========================================
        FOOTER
        ======================================== */
        footer {
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            color: var(--muted-text);
            padding: 2rem 0 1rem;
            box-shadow: var(--shadow-sm);
        }

        footer h5 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }

        footer a {
            text-decoration: none;
            color: var(--muted-text);
            transition: color 0.3s ease;
            display: inline-block;
        }

        footer a:hover {
            color: var(--accent-color);
        }

        footer hr {
            border-color: rgba(0, 0, 0, 0.08);
            margin: 1.5rem 0;
        }

        footer .text-center {
            color: var(--muted-text);
            font-size: 0.9rem;
        }

        /* ========================================
        BREADCRUMB
        ======================================== */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-item {
            color: var(--muted-text);
        }

        .breadcrumb-item a {
            color: var(--accent-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--accent-hover);
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: var(--muted-text);
        }

        /* ========================================
        PRODUCT DETAIL PAGE
        ======================================== */
        .product-detail-image {
            background-color: #f8f9fa;
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
            object-fit: cover;
            width: 100%;
            max-height: 600px;
            box-shadow: var(--shadow-md);
        }

        .product-info h2 {
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 1rem;
        }

        .product-info h3 {
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 1.5rem;
        }

        .product-info p {
            color: var(--muted-text);
            line-height: 1.8;
        }

        /* Related Products */
        .related-products {
            background: var(--secondary-bg);
            border-radius: 1rem;
            padding: 2rem;
            border: 1px solid var(--border-color);
            margin-top: 4rem;
        }

        .related-products h4 {
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 2rem;
        }

        .related-item {
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            background-color: var(--card-bg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .related-item:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--accent-color);
        }

        .related-item img {
            height: 160px;
            object-fit: contain;
            padding: 10px;
        }

        /* ========================================
        UTILITY CLASSES
        ======================================== */
        .text-primary {
            color: var(--accent-color) !important;
        }

        .text-muted {
            color: var(--muted-text) !important;
        }

        .bg-primary {
            background-color: var(--accent-color) !important;
        }

        .border-primary {
            border-color: var(--accent-color) !important;
        }

        section h2 {
            color: var(--accent-color);
            font-weight: 700;
            margin-bottom: 2rem;
        }

        /* ========================================
        RESPONSIVE DESIGN
        ======================================== */
        @media (max-width: 992px) {
            .navbar-brand {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-top: 56px;
            }

            .hero-section {
                padding: 3rem 1.5rem;
            }

            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .product-image {
                height: 180px;
            }

            .product-title {
                font-size: 0.9rem;
                height: 40px;
            }

            .product-desc {
                height: 36px;
                font-size: 0.85rem;
            }

            .product-stats {
                height: 55px;
            }

            .why-us {
                padding: 2rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                padding: 2rem 1rem;
            }

            .hero-section h1 {
                font-size: 1.5rem;
            }

            .product-image {
                height: 160px;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }
        }

        /* ========================================
        ANIMATIONS
        ======================================== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .product-card,
        .category-card {
            animation: fadeIn 0.5s ease;
        }

        /* ========================================
        PRINT STYLES
        ======================================== */
        @media print {

            .navbar,
            footer,
            .btn,
            .alert {
                display: none;
            }

            body {
                padding-top: 0;
            }
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