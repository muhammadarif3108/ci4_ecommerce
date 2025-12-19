<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container my-5">
    <h2 class="mb-4">
        <i class="bi bi-receipt me-2"></i>Detail Pesanan #<?= $order['id'] ?>
    </h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Informasi Order -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Status:</strong>
                            <?php
                            $statusClass = [
                                'pending' => 'warning',
                                'processing' => 'primary',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                'cancelled' => 'danger'
                            ];
                            $statusText = [
                                'pending' => 'Belum Bayar',
                                'processing' => 'Dikemas',
                                'shipped' => 'Dikirim',
                                'delivered' => 'Selesai',
                                'cancelled' => 'Dibatalkan'
                            ];
                            ?>
                            <span class="badge bg-<?= $statusClass[$order['status']] ?> ms-2">
                                <?= $statusText[$order['status']] ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <strong>Tanggal Pesan:</strong>
                            <?= date('d M Y H:i', strtotime($order['created_at'])) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <strong>Alamat Pengiriman:</strong>
                            <p class="mb-0"><?= nl2br(esc($order['shipping_address'])) ?></p>
                        </div>
                    </div>

                    <!-- Tombol Konfirmasi Diterima - Hanya muncul jika status "shipped" -->
                    <?php if ($order['status'] === 'shipped'): ?>
                        <div class="alert alert-info mt-3 mb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-truck me-2"></i>
                                    <strong>Pesanan sedang dalam perjalanan</strong>
                                    <p class="mb-0 mt-2 small">Sudah menerima pesanan? Klik tombol <b>Pesanan Diterima</b></p>
                                </div>
                                <form action="<?= base_url('order/confirm-delivery/' . $order['id']) ?>"
                                    method="post"
                                    onsubmit="return confirm('Apakah Anda yakin sudah menerima pesanan ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle me-1"></i>Pesanan Diterima
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Item Produk -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Produk yang Dipesan</h5>
                </div>
                <div class="card-body">
                    <?php
                    // Load review model untuk cek review
                    $reviewModel = new \App\Models\ReviewModel();
                    ?>
                    <?php foreach ($orderItems as $item): ?>
                        <div class="row align-items-center mb-3 pb-3 border-bottom">
                            <div class="col-md-2">
                                <?php
                                $imagePath = $item['image'] ?? 'placeholder.jpg';
                                $imageUrl = base_url('uploads/' . $imagePath);
                                if (empty($item['image']) || !file_exists(FCPATH . 'uploads/' . $imagePath)) {
                                    $imageUrl = 'https://via.placeholder.com/100x100/00B4DB/FFFFFF?text=Product';
                                }
                                ?>
                                <img src="<?= $imageUrl ?>"
                                    class="img-fluid rounded"
                                    alt="<?= esc($item['product_name']) ?>">
                            </div>
                            <div class="col-md-4">
                                <h6><?= esc($item['product_name']) ?></h6>
                                <small class="text-muted">
                                    Rp <?= number_format($item['price'], 0, ',', '.') ?> x <?= $item['quantity'] ?>
                                </small>
                            </div>
                            <div class="col-md-3 text-end">
                                <strong>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></strong>
                            </div>
                            <div class="col-md-3 text-end">
                                <?php if ($order['status'] == 'delivered'): ?>
                                    <?php
                                    $hasReviewed = $reviewModel->hasReviewed(
                                        $item['product_id'],
                                        session()->get('user_id'),
                                        $order['id']
                                    );
                                    ?>
                                    <?php if ($hasReviewed): ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Sudah direview
                                        </span>
                                    <?php else: ?>
                                        <a href="<?= base_url('review/create/' . $order['id'] . '/' . $item['product_id']) ?>"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-star me-1"></i>Beri Review
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Ringkasan Pembayaran -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ringkasan Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <strong>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong class="text-primary fs-5">
                            Rp <?= number_format($order['total_amount'], 0, ',', '.') ?>
                        </strong>
                    </div>

                    <a href="<?= base_url('orders') ?>" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Pesanan
                    </a>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>Status Pesanan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item <?= $order['status'] == 'pending' || $order['status'] == 'processing' || $order['status'] == 'shipped' || $order['status'] == 'delivered' ? 'active' : '' ?>">
                            <i class="bi bi-circle-fill"></i>
                            <span>Pesanan Dibuat</span>
                        </div>
                        <div class="timeline-item <?= $order['status'] == 'processing' || $order['status'] == 'shipped' || $order['status'] == 'delivered' ? 'active' : '' ?>">
                            <i class="bi bi-circle-fill"></i>
                            <span>Sedang Dikemas</span>
                        </div>
                        <div class="timeline-item <?= $order['status'] == 'shipped' || $order['status'] == 'delivered' ? 'active' : '' ?>">
                            <i class="bi bi-circle-fill"></i>
                            <span>Sedang Dikirim</span>
                        </div>
                        <div class="timeline-item <?= $order['status'] == 'delivered' ? 'active' : '' ?>">
                            <i class="bi bi-circle-fill"></i>
                            <span>Pesanan Diterima</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 20px;
        color: #999;
    }

    .timeline-item:before {
        content: '';
        position: absolute;
        left: -22px;
        top: 8px;
        bottom: -12px;
        width: 2px;
        background: #ddd;
    }

    .timeline-item:last-child:before {
        display: none;
    }

    .timeline-item i {
        position: absolute;
        left: -28px;
        top: 0;
        font-size: 12px;
        color: #ddd;
    }

    .timeline-item.active {
        color: #333;
        font-weight: 500;
    }

    .timeline-item.active:before {
        background: var(--accent-color);
    }

    .timeline-item.active i {
        color: var(--accent-color);
    }
</style>

<?= $this->endSection() ?>