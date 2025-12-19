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

        <!-- Rating Section -->
        <?php
        $reviewModel = new \App\Models\ReviewModel();
        $avgRating = $reviewModel->getAverageRating($product['id']);
        $totalReviews = $reviewModel->getTotalReviews($product['id']);
        ?>
        <?php if ($totalReviews > 0): ?>
            <div class="mb-3">
                <span class="text-warning fs-5">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= floor($avgRating)): ?>
                            <i class="bi bi-star-fill"></i>
                        <?php elseif ($i - $avgRating < 1 && $i - $avgRating > 0): ?>
                            <i class="bi bi-star-half"></i>
                        <?php else: ?>
                            <i class="bi bi-star"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                </span>
                <span class="ms-2 text-muted">
                    <?= $avgRating ?> (<?= $totalReviews ?> review<?= $totalReviews > 1 ? 's' : '' ?>)
                </span>
            </div>
        <?php endif; ?>

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

<!-- Reviews Section -->
<?php if ($totalReviews > 0): ?>
    <div class="mt-5">
        <h4 class="mb-4">
            <i class="bi bi-star-fill me-2"></i>Review Pelanggan
        </h4>

        <!-- Rating Summary -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center border-end">
                        <h1 class="display-4 mb-0"><?= $avgRating ?></h1>
                        <div class="text-warning mb-2">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= floor($avgRating)): ?>
                                    <i class="bi bi-star-fill"></i>
                                <?php elseif ($i - $avgRating < 1 && $i - $avgRating > 0): ?>
                                    <i class="bi bi-star-half"></i>
                                <?php else: ?>
                                    <i class="bi bi-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <small class="text-muted"><?= $totalReviews ?> review<?= $totalReviews > 1 ? 's' : '' ?></small>
                    </div>
                    <div class="col-md-9">
                        <?php
                        $ratingStats = $reviewModel->getRatingStats($product['id']);
                        for ($i = 5; $i >= 1; $i--):
                            $count = $ratingStats[$i];
                            $percentage = $totalReviews > 0 ? ($count / $totalReviews * 100) : 0;
                        ?>
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2" style="min-width: 70px;">
                                    <?= $i ?> <i class="bi bi-star-fill text-warning"></i>
                                </span>
                                <div class="progress flex-grow-1" style="height: 20px;">
                                    <div class="progress-bar bg-warning"
                                        style="width: <?= $percentage ?>%">
                                    </div>
                                </div>
                                <span class="ms-2 text-muted" style="min-width: 40px;">
                                    <?= $count ?>
                                </span>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review List -->
        <?php
        $reviews = $reviewModel->getProductReviews($product['id']);
        foreach ($reviews as $review):
        ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-1">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= esc($review['user_name']) ?>
                            </h6>
                            <div class="text-warning">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $review['rating']): ?>
                                        <i class="bi bi-star-fill"></i>
                                    <?php else: ?>
                                        <i class="bi bi-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <small class="text-muted">
                            <?= date('d M Y', strtotime($review['created_at'])) ?>
                        </small>
                    </div>
                    
                    <?php if (!empty($review['comment'])): ?>
                        <p class="mb-3 text-muted"><?= nl2br(esc($review['comment'])) ?></p>
                    <?php endif; ?>

                    <!-- Review Images -->
                    <?php if (!empty($review['review_images'])): ?>
                        <?php
                        $reviewImages = json_decode($review['review_images'], true);
                        if (is_array($reviewImages) && count($reviewImages) > 0):
                        ?>
                            <div class="review-images-grid mb-2">
                                <?php foreach ($reviewImages as $index => $image): ?>
                                    <?php
                                    $imagePath = FCPATH . 'uploads/reviews/' . $image;
                                    if (file_exists($imagePath)):
                                    ?>
                                        <div class="review-image-item">
                                            <img src="<?= base_url('uploads/reviews/' . $image) ?>" 
                                                alt="Review Image <?= $index + 1 ?>"
                                                class="review-image-thumb"
                                                onclick="openImageModal('<?= base_url('uploads/reviews/' . $image) ?>')">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

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

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalImage" src="" class="img-fluid" alt="Review Image">
            </div>
        </div>
    </div>
</div>

<style>
.review-images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 10px;
}

.review-image-item {
    aspect-ratio: 1;
    overflow: hidden;
    border-radius: 8px;
    border: 1px solid #ddd;
    cursor: pointer;
    transition: all 0.3s;
}

.review-image-item:hover {
    border-color: var(--accent-color);
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 180, 219, 0.3);
}

.review-image-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#imageModal .modal-body img {
    max-height: 80vh;
    object-fit: contain;
}
</style>

<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}
</script>

<?= $this->endSection() ?>