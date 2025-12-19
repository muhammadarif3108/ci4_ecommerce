<!-- app/Views/admin/orders/detail.php -->
<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-receipt"></i> Rincian Pesanan #<?= $order['id'] ?></h2>
    <a href="<?= base_url('admin/orders') ?>" class="btn btn-secondary">
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
        <!-- Customer Information -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person"></i> Informasi Pelanggan</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Nama</small>
                    <p class="mb-0"><strong><?= esc($order['customer_name']) ?></strong></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Email</small>
                    <p class="mb-0"><?= esc($order['customer_email']) ?></p>
                </div>
                <div class="mb-0">
                    <small class="text-muted">No. Handphone</small>
                    <p class="mb-0"><?= esc($order['customer_phone'] ?? 'Not provided') ?></p>
                </div>
            </div>
        </div>

        <!-- Order Status -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Status Pesanan</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/orders/update-status/' . $order['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Order Status</label>
                        <select class="form-select" name="status">
                            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Belum Bayar</option>
                            <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Dikemas</option>
                            <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Dikirim</option>
                            <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>Selesai</option>
                            <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Ubah Status
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Info & Proof -->
        <?php if ($order['payment_method'] === 'transfer'): ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-credit-card"></i> Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Metode Pembayaran</small>
                        <p class="mb-0"><strong>Transfer Bank</strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Virtual Account</small>
                        <p class="mb-0"><strong><?= $order['virtual_account'] ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status Pembayaran</small><br>
                        <?php
                        $paymentBadge = [
                            'unpaid' => 'danger',
                            'pending' => 'warning',
                            'verified' => 'success'
                        ];
                        $paymentText = [
                            'unpaid' => 'Belum Dibayar',
                            'pending' => 'Menunggu Verifikasi',
                            'verified' => 'Terverifikasi'
                        ];
                        $badge = $paymentBadge[$order['payment_status']] ?? 'secondary';
                        $text = $paymentText[$order['payment_status']] ?? 'Unknown';
                        ?>
                        <span class="badge bg-<?= $badge ?>"><?= $text ?></span>
                    </div>

                    <?php if ($order['payment_proof']): ?>
                        <div class="mb-3">
                            <small class="text-muted">Bukti Transfer</small>
                            <div class="mt-2">
                                <a href="<?= base_url('uploads/payments/' . $order['payment_proof']) ?>"
                                    target="_blank">
                                    <img src="<?= base_url('uploads/payments/' . $order['payment_proof']) ?>"
                                        alt="Payment Proof"
                                        class="img-thumbnail"
                                        style="max-width: 300px;">
                                </a>
                            </div>
                        </div>

                        <?php if ($order['payment_status'] === 'pending'): ?>
                            <div class="d-grid gap-2">
                                <a href="<?= base_url('admin/orders/verify-payment/' . $order['id']) ?>"
                                    class="btn btn-success"
                                    onclick="return confirm('Verifikasi pembayaran ini?')">
                                    <i class="bi bi-check-circle"></i> Verifikasi Pembayaran
                                </a>
                                <a href="<?= base_url('admin/orders/reject-payment/' . $order['id']) ?>"
                                    class="btn btn-danger"
                                    onclick="return confirm('Tolak pembayaran ini?')">
                                    <i class="bi bi-x-circle"></i> Tolak Pembayaran
                                </a>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-exclamation-triangle"></i> Bukti transfer belum diupload
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Order Info -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Tanggal Pesanan</small>
                    <p class="mb-0"><?= date('d M Y H:i', strtotime($order['created_at'])) ?></p>
                </div>
                <div class="mb-0">
                    <small class="text-muted">Order ID</small>
                    <p class="mb-0"><strong>#<?= $order['id'] ?></strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>