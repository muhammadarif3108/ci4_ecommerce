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
        <?php foreach ($products as $product): ?>
            <div class="col-md-3">
                <div class="card product-card">
                    <img src="<?= base_url('uploads/' . ($product['image'] ?? 'placeholder.jpg')) ?>"
                        class="card-img-top product-image"
                        alt="<?= esc($product['name']) ?>">
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-secondary mb-2 align-self-start"><?= esc($product['category_name']) ?></span>
                        <h5 class="card-title"><?= esc($product['name']) ?></h5>
                        <p class="card-text text-muted small"><?= substr(esc($product['description']), 0, 60) ?>...</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="text-primary mb-0">Rp <?= number_format($product['price'], 0, ',', '.') ?></h4>
                                <span class="badge bg-success">Stock: <?= $product['stock'] ?></span>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="<?= base_url('product/' . $product['id']) ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Detail Produk
                                </a>
                                <form action="<?= base_url('cart/add') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn btn-sm w-100">
                                        <i class="bi bi-cart-plus"></i> Masukkan Keranjang
                                    </button>
                                </form>
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