<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-receipt"></i> Order #<?= $order['id'] ?></h2>
    <a href="<?= base_url('orders') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <!-- Order Items -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Item Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('uploads/' . ($item['image'] ?? 'placeholder.jpg')) ?>"
                                                alt="<?= esc($item['product_name']) ?>"
                                                class="img-thumbnail me-3"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0"><?= esc($item['product_name']) ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                    <td class="align-middle"><?= $item['quantity'] ?></td>
                                    <td class="align-middle">
                                        <strong>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Ongkir:</strong></td>
                                <td><strong>Rp 0</strong></td>
                            </tr>
                            <tr class="table-light">
                                <td colspan="3" class="text-end">
                                    <h5 class="mb-0">Total:</h5>
                                </td>
                                <td>
                                    <h5 class="mb-0 text-primary">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></h5>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Alamat Pengiriman</h5>
            </div>
            <div class="card-body">
                <p class="mb-0"><?= nl2br(esc($order['shipping_address'])) ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Order Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Order ID</small>
                    <p class="mb-0"><strong>#<?= $order['id'] ?></strong></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Order Date</small>
                    <p class="mb-0"><?= date('d F Y, H:i', strtotime($order['created_at'])) ?></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Status</small><br>
                    <?php
                    $statusColors = [
                        'pending' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger'
                    ];
                    $color = $statusColors[$order['status']] ?? 'secondary';
                    ?>
                    <span class="badge bg-<?= $color ?> mt-1"><?= ucfirst($order['status']) ?></span>
                </div>
                <div>
                    <small class="text-muted">Customer Name</small>
                    <p class="mb-0"><?= esc($order['customer_name']) ?></p>
                </div>
            </div>
        </div>

        <!-- Track Order -->
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-truck fs-1 text-primary mb-3"></i>
                <h6>Cek Status Pesanan</h6>
                <p class="text-muted small">Pesanan Anda Sedang Diproses</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>