<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h2 class="mb-4"><i class="bi bi-credit-card"></i> Checkout</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pengiriman</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('checkout/process') ?>" method="post">
                    <?= csrf_field() ?>

                    <?php
                    // Ambil data user dari database
                    $userModel = new \App\Models\UserModel();
                    $user = $userModel->find(session()->get('user_id'));
                    ?>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="<?= esc($user['name'] ?? session()->get('user_name')) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= esc($user['email'] ?? session()->get('user_email')) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon *</label>
                        <input type="tel" class="form-control" name="phone"
                            value="<?= esc($user['phone'] ?? '') ?>"
                            placeholder="+62 812 3456 7890" required>
                        <small class="text-muted">Nomor ini akan digunakan untuk pengiriman</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Pengiriman *</label>
                        <textarea class="form-control" name="shipping_address" rows="3" required
                            placeholder="Masukkan alamat lengkap pengiriman"><?= esc($user['address'] ?? '') ?></textarea>
                        <small class="text-muted">Pastikan alamat lengkap dengan kode pos</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-select" name="payment_method">
                            <option value="transfer">Transfer Bank</option>
                            <option value="cod">COD (Bayar di Tempat)</option>
                            <option value="ewallet">E-Wallet (GoPay/OVO/Dana)</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle"></i> Buat Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header text-white" style="background: linear-gradient(90deg, var(--accent-color), var(--accent-hover));">
                <h5 class="mb-0">Rincian Pesanan</h5>
            </div>
            <div class="card-body">
                <?php
                $total = 0;
                foreach ($cart as $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <small><?= esc($item['name']) ?></small><br>
                            <small class="text-muted">Qty: <?= $item['quantity'] ?></small>
                        </div>
                        <small>Rp <?= number_format($subtotal, 0, ',', '.') ?></small>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping:</span>
                    <strong>Gratis</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <h5>Total:</h5>
                    <h5 class="text-primary">Rp <?= number_format($total, 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>