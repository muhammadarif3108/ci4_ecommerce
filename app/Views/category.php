<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
            <li class="breadcrumb-item active"><?= esc($category['name']) ?></li>
        </ol>
    </nav>
    <h2><i class="bi bi-grid-3x3"></i> <?= esc($category['name']) ?></h2>
    <p class="text-muted"><?= esc($category['description']) ?></p>
</div>

<?php if (empty($products)): ?>
    <div class="alert alert-info text-center py-5">
        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
        <h4>Belum ada produk di kategori ini</h4>
        <p>Produk baru akan segera hadir, cek lagi nanti</p>
        <a href="<?= base_url('/') ?>" class="btn btn-primary">lihat Semua Produk</a>
    </div>
<?php else: ?>
<div class="row g-4">
        <?php foreach ($products as $product):
            $sold = $product['sold'] ?? 0;
            $rating = $product['rating'] ?? 0.0;
            $reviewCount = $product['review_count'] ?? 0;
        ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card product-card h-100">
                    <!-- Badge Terlaris -->
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

                    <div class="card-body d-flex flex-column p-3">
                        <span class="badge bg-secondary mb-2 align-self-start"><?= esc($product['category_name']) ?></span>

                        <!-- Product Title - Fixed Height -->
                        <h5 class="card-title product-title"><?= esc($product['name']) ?></h5>

                        <!-- Rating & Sold Count - FIXED POSITION -->
                        <div class="product-stats mb-3">
                            <!-- Rating dengan bintang -->
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-warning me-2" style="font-size: 0.9rem; letter-spacing: 2px;">
                                    <?php
                                    $fullStars = floor($rating);
                                    $hasHalfStar = ($rating - $fullStars) >= 0.5;

                                    for ($i = 0; $i < $fullStars; $i++): ?>
                                        <i class="bi bi-star-fill"></i>
                                    <?php endfor; ?>

                                    <?php if ($hasHalfStar): ?>
                                        <i class="bi bi-star-half"></i>
                                    <?php endif; ?>

                                    <?php for ($i = 0; $i < (5 - ceil($rating)); $i++): ?>
                                        <i class="bi bi-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="fw-bold text-dark" style="font-size: 0.9rem;">
                                    <?= number_format($rating, 1) ?>
                                </span>
                            </div>

                            <!-- Ulasan dan Terjual -->
                            <div class="d-flex align-items-center" style="font-size: 0.85rem;">
                                <span class="text-muted me-3">
                                    <i class="bi bi-chat-dots me-1"></i><?= $reviewCount ?> ulasan
                                </span>
                                <span class="text-muted">
                                    <i class="bi bi-bag-check me-1"></i><?= $sold ?> terjual
                                </span>
                            </div>
                        </div>

                        <!-- Price and Stock - FIXED AT BOTTOM -->
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-primary mb-0 fw-bold">
                                    Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                </h4>
                                <?php if ($product['stock'] > 0): ?>
                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        <i class="bi bi-check-circle"></i> Stok: <?= $product['stock'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger px-3 py-2">Habis</span>
                                <?php endif; ?>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <a href="<?= base_url('product/' . $product['id']) ?>"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Detail Produk
                                </a>

                                <?php if ($product['stock'] > 0): ?>
                                    <form action="<?= base_url('cart/add') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
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
<?php endif; ?>

<!-- Category Info -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body text-center">
                <h5>About <?= esc($category['name']) ?></h5>
                <p class="mb-0"><?= esc($category['description']) ?></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>