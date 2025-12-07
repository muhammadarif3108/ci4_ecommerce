<!-- app/Views/review/create.php -->
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<style>
    .star-rating {
        direction: rtl;
        display: inline-flex;
        font-size: 2.5rem;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        color: #ddd;
        cursor: pointer;
        padding: 0 5px;
        transition: color 0.2s;
    }

    .star-rating label:hover,
    .star-rating label:hover~label,
    .star-rating input[type="radio"]:checked~label {
        color: #ffc107;
    }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-star-fill me-2"></i>Beri Review Produk
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Info Produk -->
                    <div class="mb-4 p-3 bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <?php
                                $imagePath = $product['product_image'] ?? 'placeholder.jpg';
                                $imageUrl = base_url('uploads/' . $imagePath);
                                if (empty($product['product_image']) || !file_exists(FCPATH . 'uploads/' . $imagePath)) {
                                    $imageUrl = 'https://via.placeholder.com/100x100/00B4DB/FFFFFF?text=Product';
                                }
                                ?>
                                <img src="<?= $imageUrl ?>"
                                    alt="<?= esc($product['product_name']) ?>"
                                    class="rounded"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="col">
                                <h5 class="mb-1"><?= esc($product['product_name']) ?></h5>
                                <p class="text-muted mb-0">
                                    Order #<?= $order['id'] ?> •
                                    Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Review -->
                    <form action="<?= base_url('review/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

                        <!-- Rating Bintang -->
                        <div class="mb-4 text-center">
                            <label class="form-label fw-bold d-block mb-3">
                                Berikan Rating Anda
                            </label>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="rating" value="5" required>
                                <label for="star5" title="5 bintang">★</label>

                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4" title="4 bintang">★</label>

                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3" title="3 bintang">★</label>

                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2" title="2 bintang">★</label>

                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1" title="1 bintang">★</label>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Klik bintang untuk memberikan rating
                            </small>
                        </div>

                        <!-- Komentar -->
                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">
                                <i class="bi bi-chat-left-text me-1"></i>Tulis Review Anda (Opsional)
                            </label>
                            <textarea class="form-control"
                                id="comment"
                                name="comment"
                                rows="5"
                                maxlength="1000"
                                placeholder="Bagikan pengalaman Anda dengan produk ini..."><?= old('comment') ?></textarea>
                            <small class="text-muted">Maksimal 1000 karakter</small>
                        </div>

                        <!-- Tombol -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('order/detail/' . $order['id']) ?>"
                                class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>Kirim Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>