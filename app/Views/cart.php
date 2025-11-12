<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h2 class="mb-4"><i class="bi bi-cart3"></i> Keranjang</h2>

<?php if (empty($cart)): ?>
    <div class="alert text-center py-5">
        <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
        <h4>Your cart is empty</h4>
        <p>Start shopping to add items to your cart</p>
        <a href="<?= base_url('/') ?>" class="btn btn-glow">
            <i class="bi bi-shop"></i> Continue Shopping
        </a>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($cart as $item):
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= base_url('uploads/' . ($item['image'] ?? 'placeholder.jpg')) ?>"
                                                    alt="<?= esc($item['name']) ?>"
                                                    class="img-thumbnail me-3" style="width: 70px; height: 70px; object-fit: contain;">
                                                <div>
                                                    <strong><?= esc($item['name']) ?></strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                        <td>
                                            <form action="<?= base_url('cart/update') ?>" method="post" class="d-flex align-items-center">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>"
                                                    min="1" class="form-control form-control-sm" style="width: 70px;">
                                                <button type="submit" class="btn btn-sm btn-glow ms-2">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td><strong>Rp <?= number_format($subtotal, 0, ',', '.') ?></strong></td>
                                        <td>
                                            <a href="<?= base_url('cart/remove/' . $item['id']) ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Remove this item?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <a href="<?= base_url('cart/clear') ?>"
                            class="btn bg-danger btn-outline-danger"
                            onclick="return confirm('Clear all items from cart?')">
                            <i class="bi bi-trash"></i> Kosongkan Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background: linear-gradient(90deg, var(--accent-color), var(--accent-hover));">
                    <h5 class="mb-0"><i class="bi bi-receipt"></i> Rincian Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkir:</span>
                        <strong>Gratis</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <h5>Total:</h5>
                        <h5 class="text-primary">Rp <?= number_format($total, 0, ',', '.') ?></h5>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('checkout') ?>" class="btn btn-glow btn-lg">
                            <i class="bi bi-credit-card"></i> Bayar Sekarang
                        </a>
                        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>