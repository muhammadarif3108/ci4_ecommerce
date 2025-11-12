<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
        <li class="breadcrumb-item">
            <a href="<?= base_url('category/' . $product['category_id']) ?>">
                <?= esc($product['category_name']) ?>
            </a>
        </li>
        <li class="breadcrumb-item active"><?= esc($product['name']) ?></li>
    </ol>
</nav>

<!-- Product Details -->
<div class="row">
    <div class="col-md-5">
        <img src="<?= base_url('uploads/' . ($product['image'] ?? 'placeholder.jpg')) ?>"
            class="img-fluid product-image"
            alt="<?= esc($product['name']) ?>">
    </div>

    <div class="col-md-7 product-info">
        <span class="badge bg-secondary mb-3"><?= esc($product['category_name']) ?></span>
        <h2 class="mb-3"><?= esc($product['name']) ?></h2>
        <h3 class="mb-3">Rp <?= number_format($product['price'], 0, ',', '.') ?></h3>

        <?php if ($product['stock'] > 0): ?>
            <span class="badge bg-success fs-6 mb-4">
                <i class="bi bi-check-circle"></i> In Stock (<?= $product['stock'] ?> units)
            </span>
        <?php else: ?>
            <span class="badge bg-danger fs-6 mb-4">
                <i class="bi bi-x-circle"></i> Out of Stock
            </span>
        <?php endif; ?>

        <div class="mb-4">
            <h5>Deskripsi</h5>
            <p><?= nl2br(esc($product['description'])) ?></p>
        </div>

        <?php if ($product['stock'] > 0): ?>
            <form action="<?= base_url('cart/add') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jumlah</label>
                        <input type="number" class="form-control" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-plus"></i> Masukkan Keranjang
                    </button>
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left"></i> Lanjut Belanja
                    </a>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-warning mt-3">
                <i class="bi bi-exclamation-triangle"></i> This product is currently out of stock
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Related Products -->
<?php if (!empty($related_products)): ?>
    <div class="related-products mt-5">
        <h4 class="mb-4">Related Products</h4>
        <div class="row g-4">
            <?php foreach ($related_products as $item): ?>
                <div class="col-md-3">
                    <div class="card related-item text-center h-100">
                        <img src="<?= base_url('uploads/' . ($item['image'] ?? 'placeholder.jpg')) ?>"
                            alt="<?= esc($item['name']) ?>"
                            class="card-img-top">
                        <div class="card-body">
                            <h6 class="fw-semibold"><?= esc($item['name']) ?></h6>
                            <p class="fw-bold mb-2">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                            <a href="<?= base_url('product/' . $item['id']) ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="mt-5 text-center text-muted fst-italic">
        <p>No related products available.</p>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>