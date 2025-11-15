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
    <div class="col-md-5 mb-4">
        <div class="product-image-wrapper">
            <?php
            $imagePath = $product['image'] ?? 'placeholder.jpg';
            $imageUrl = base_url('uploads/' . $imagePath);

            // Cek apakah file ada
            if (empty($product['image']) || !file_exists(FCPATH . 'uploads/' . $imagePath)) {
                $imageUrl = 'https://via.placeholder.com/500x500/00B4DB/FFFFFF?text=' . urlencode(substr($product['name'], 0, 20));
            }
            ?>
            <img src="<?= $imageUrl ?>"
                class="product-detail-image"
                alt="<?= esc($product['name']) ?>"
                onerror="this.src='https://via.placeholder.com/500x500/00B4DB/FFFFFF?text=No+Image'">
        </div>
    </div>

    <div class="col-md-7 product-info">
        <span class="badge bg-secondary mb-3">
            <i class="bi bi-tag-fill me-1"></i><?= esc($product['category_name']) ?>
        </span>

        <h2 class="mb-3"><?= esc($product['name']) ?></h2>
        <h3 class="mb-3">Rp <?= number_format($product['price'], 0, ',', '.') ?></h3>

        <?php if ($product['stock'] > 0): ?>
            <span class="badge bg-success fs-6 mb-4">
                <i class="bi bi-check-circle me-1"></i> In Stock (<?= $product['stock'] ?> units)
            </span>
        <?php else: ?>
            <span class="badge bg-danger fs-6 mb-4">
                <i class="bi bi-x-circle me-1"></i> Out of Stock
            </span>
        <?php endif; ?>

        <div class="mb-4">
            <h5 class="text-primary">
                <i class="bi bi-info-circle me-2"></i>Deskripsi
            </h5>
            <p class="text-muted"><?= nl2br(esc($product['description'])) ?></p>
        </div>

        <?php if ($product['stock'] > 0): ?>
            <form action="<?= base_url('cart/add') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            <i class="bi me-1"></i>Jumlah
                        </label>
                        <input type="number"
                            class="form-control"
                            name="quantity"
                            value="1"
                            min="1"
                            max="<?= $product['stock'] ?>">
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-plus me-2"></i>Masukkan Keranjang
                    </button>
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                    </a>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Produk ini sedang tidak tersedia
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Related Products -->
<?php if (!empty($related_products)): ?>
    <div class="related-products mt-5">
        <h4 class="mb-4">
            <i class="bi bi-grid-3x3-gap me-2"></i>Produk Terkait
        </h4>
        <div class="row g-4">
            <?php foreach ($related_products as $item): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card related-item text-center h-100">
                        <?php
                        $relatedImagePath = $item['image'] ?? 'placeholder.jpg';
                        $relatedImageUrl = base_url('uploads/' . $relatedImagePath);

                        if (empty($item['image']) || !file_exists(FCPATH . 'uploads/' . $relatedImagePath)) {
                            $relatedImageUrl = 'https://via.placeholder.com/300x300/00B4DB/FFFFFF?text=' . urlencode(substr($item['name'], 0, 15));
                        }
                        ?>
                        <img src="<?= $relatedImageUrl ?>"
                            alt="<?= esc($item['name']) ?>"
                            class="card-img-top"
                            onerror="this.src='https://via.placeholder.com/300x300/00B4DB/FFFFFF?text=No+Image'">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-2"><?= esc($item['name']) ?></h6>
                            <p class="text-primary fw-bold mb-3">
                                Rp <?= number_format($item['price'], 0, ',', '.') ?>
                            </p>
                            <a href="<?= base_url('product/' . $item['id']) ?>"
                                class="btn btn-outline-primary btn-sm w-100">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="mt-5 text-center text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
        <p class="fst-italic">Tidak ada produk terkait tersedia.</p>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>