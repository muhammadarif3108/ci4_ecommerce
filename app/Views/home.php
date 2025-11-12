<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="hero-section">
    <h1 class="display-5 fw-bold">Selamat Datang di iTechStore</h1>
    <p>Find the best gadgets at the best prices — shop now and enjoy free shipping!</p>
    <a href="#products" class="btn btn-light btn-lg shadow-sm">
        <i class="bi bi-cart4 me-1"></i> Belanja Sekarang
    </a>
</div>

<!-- Featured Categories -->
<section class="container mb-5">
    <h2 class="mb-4">Belanja Berdasarkan Kategori</h2>
    <div class="row g-3">
        <?php foreach ($categories as $category): ?>
            <div class="col-md-3">
                <a href="<?= base_url('category/' . $category['id']) ?>" class="text-decoration-none">
                    <div class="card text-center h-100 category-card p-3">
                        <div class="card-body">
                            <i class="bi bi-grid-3x3-gap fs-1 mb-2"></i>
                            <h5 class="card-title mt-2"><?= esc($category['name']) ?></h5>
                            <p class="card-text text-muted"><?= esc($category['description']) ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Featured Products -->
<section id="products" class="container mb-5">
    <h2 class="mb-4">Produk Unggulan</h2>
    <div class="row g-4">
        <?php foreach ($products as $product):
            // Tidak perlu random lagi, ambil dari database
            $sold = $product['sold'] ?? 0;
            $rating = $product['rating'] ?? 0.0;
            $reviewCount = $product['review_count'] ?? 0;
        ?>
            <div class="col-md-3">
                <div class="card product-card h-100">
                    <!-- Badge Terlaris (jika terjual > 100) -->
                    <?php if ($sold > 100): ?>
                        <div class="position-absolute top-0 end-0 m-2" style="z-index: 1;">
                            <span class="badge bg-danger">
                                <i class="bi bi-fire"></i> Terlaris
                            </span>
                        </div>
                    <?php endif; ?>

                    <img src="<?= base_url('uploads/' . ($product['image'] ?? 'placeholder.jpg')) ?>"
                        class="card-img-top product-image"
                        alt="<?= esc($product['name']) ?>">
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-secondary mb-2 align-self-start"><?= esc($product['category_name']) ?></span>
                        <h5 class="card-title"><?= esc($product['name']) ?></h5>
                        <p class="card-text text-muted small"><?= substr(esc($product['description']), 0, 60) ?>...</p>

                        <!-- Rating & Sold Count -->
                        <div class="mb-2">
                            <div class="d-flex align-items-center mb-1">
                                <div class="text-warning me-1" style="font-size: 0.85rem;">
                                    <?php
                                    $fullStars = floor($rating);
                                    $hasHalfStar = ($rating - $fullStars) >= 0.5;

                                    // Bintang penuh
                                    for ($i = 0; $i < $fullStars; $i++): ?>
                                        <i class="bi bi-star-fill"></i>
                                    <?php endfor; ?>

                                    <!-- Bintang setengah -->
                                    <?php if ($hasHalfStar): ?>
                                        <i class="bi bi-star-half"></i>
                                    <?php endif; ?>

                                    <!-- Bintang kosong -->
                                    <?php for ($i = 0; $i < (5 - ceil($rating)); $i++): ?>
                                        <i class="bi bi-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="small text-muted"><?= number_format($rating, 1) ?></span>
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-chat-dots"></i> <?= $reviewCount ?> ulasan |
                                <i class="bi bi-bag-check"></i> <?= $sold ?> terjual
                            </small>
                        </div>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="mb-0">Rp <?= number_format($product['price'], 0, ',', '.') ?></h4>
                                <?php if ($product['stock'] > 0): ?>
                                    <span class="badge bg-success">Stock: <?= $product['stock'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Habis</span>
                                <?php endif; ?>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="<?= base_url('product/' . $product['id']) ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Detail Produk
                                </a>

                                <?php if ($product['stock'] > 0): ?>
                                    <form action="<?= base_url('cart/add') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <button type="submit" class="btn btn-sm w-100">
                                            <i class="bi bi-cart-plus"></i> Masukkan Keranjang
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        <i class="bi bi-x-circle"></i> Stok Habis
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Why Choose Us -->
<section class="why-us container text-center">
    <h2 class="mb-5">Why Choose Us?</h2>
    <div class="row">
        <div class="col-md-3 mb-4">
            <i class="bi bi-truck fs-1 mb-3"></i>
            <h5>Gratis Ongkir</h5>
            <p>Untuk setiap pesanan</p>
        </div>
        <div class="col-md-3 mb-4">
            <i class="bi bi-shield-check fs-1 mb-3"></i>
            <h5>Pembayaran Aman</h5>
            <p>100% safe transactions</p>
        </div>
        <div class="col-md-3 mb-4">
            <i class="bi bi-arrow-repeat fs-1 mb-3"></i>
            <h5>Pengembalian Mudah</h5>
            <p>Bisa Dikembalikan dalam 30 Hari</p>
        </div>
        <div class="col-md-3 mb-4">
            <i class="bi bi-headset fs-1 mb-3"></i>
            <h5>24/7 Support</h5>
            <p>Layanan Pelanggan</p>
        </div>
    </div>
</section>

<?= $this->endSection() ?>