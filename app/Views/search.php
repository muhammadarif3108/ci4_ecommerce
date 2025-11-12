<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h2><i class="bi bi-search"></i> Search Results for "<?= esc($keyword) ?>"</h2>
    <p class="text-muted"><?= count($products) ?> product(s) found</p>
</div>

<?php if (empty($products)): ?>
    <div class="alert alert-info text-center py-5">
        <i class="bi bi-search fs-1 d-block mb-3"></i>
        <h4>No products found</h4>
        <p>Try different keywords or browse our categories</p>
        <a href="<?= base_url('/') ?>" class="btn btn-primary">Browse All Products</a>
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
                                    <i class="bi bi-eye"></i> View Details
                                </a>
                                <form action="<?= base_url('cart/add') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
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

<?= $this->endSection() ?>