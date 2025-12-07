<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Success Message -->
        <div class="card border-0 shadow-sm mb-4 bg-success text-white">
            <div class="card-body text-center py-5">
                <i class="bi bi-check-circle-fill fs-1 mb-3 d-block"></i>
                <h2>Pesanan Berhasil!</h2>
                <p class="mb-0">Terima kasih atas pesanan anda. Kami sedang memproses pesanan Anda</p>
            </div>
        </div>

        <!-- Order Details -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Detail Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted">Order ID</small>
                        <p class="mb-0"><strong>#<?= $order['id'] ?></strong></p>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Tanggal Pesanan</small>
                        <p class="mb-0"><?= date('d F Y, H:i', strtotime($order['created_at'])) ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted">Customer Name</small>
                        <p class="mb-0"><?= esc($order['customer_name']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Email</small>
                        <p class="mb-0"><?= esc($order['customer_email']) ?></p>
                    </div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Alamat Pengiriman</small>
                    <p class="mb-0"><?= nl2br(esc($order['shipping_address'])) ?></p>
                </div>
                <div>
                    <small class="text-muted">Status</small><br>
                    <span class="badge bg-warning">Menunggu Konfirmasi</span>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
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
                                <td><strong>Free Ongkir</strong></td>
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

        <!-- Action Buttons -->
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <p class="mb-3">
                    <i class="bi bi-info-circle text-primary"></i>
                    Konfirmasi dan informasi pelacakan akan segera dikirimkan ke email Anda.
                </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="<?= base_url('orders') ?>" class="btn btn-primary">
                        <i class="bi bi-list-ul"></i> Lihat Semua Pesanan
                    </a>
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-primary">
                        <i class="bi bi-shop"></i> Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>