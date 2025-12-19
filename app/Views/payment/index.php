<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header text-white text-center py-4" style="background: linear-gradient(90deg, var(--accent-color), var(--accent-hover));">
                    <h3 class="mb-0">
                        <i class="bi bi-credit-card me-2"></i>Pembayaran Order #<?= $order['id'] ?>
                    </h3>
                </div>

                <div class="card-body p-4">
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

                    <!-- Total Pembayaran -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">
                                    <i class="bi bi-wallet2 me-2"></i>Total Pembayaran
                                </h5>
                            </div>
                            <div>
                                <h3 class="mb-0 text-primary">
                                    Rp <?= number_format($order['total_amount'], 0, ',', '.') ?>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Virtual Account -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-bank me-2"></i>Transfer ke Bank BCA
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg"
                                        alt="BCA"
                                        style="max-width: 120px;">
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="text-muted mb-1">Nomor Virtual Account</label>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control form-control-lg fw-bold text-primary"
                                                value="<?= $order['virtual_account'] ?>"
                                                id="vaNumber"
                                                readonly>
                                            <button class="btn btn-outline-primary"
                                                type="button"
                                                onclick="copyVA()">
                                                <i class="bi bi-clipboard"></i> Copy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="text-muted mb-1">Nama Penerima</label>
                                        <p class="mb-0 fw-bold">iTechStore Indonesia</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instruksi Pembayaran -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>Cara Pembayaran
                            </h6>
                        </div>
                        <div class="card-body">
                            <ol class="mb-0">
                                <li class="mb-2">Buka aplikasi mobile banking atau internet banking BCA Anda</li>
                                <li class="mb-2">Pilih menu <strong>Transfer</strong></li>
                                <li class="mb-2">Masukkan nomor Virtual Account: <strong><?= $order['virtual_account'] ?></strong></li>
                                <li class="mb-2">Pastikan nama penerima adalah <strong>iTechStore Indonesia</strong></li>
                                <li class="mb-2">Masukkan jumlah transfer: <strong>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></strong></li>
                                <li class="mb-2">Konfirmasi dan selesaikan transaksi</li>
                                <li>Upload bukti transfer di bawah ini</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Form Upload Bukti Transfer -->
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="bi bi-cloud-upload me-2"></i>Upload Bukti Transfer
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('payment/upload/' . $order['id']) ?>"
                                method="post"
                                enctype="multipart/form-data">
                                <?= csrf_field() ?>

                                <div class="mb-4">
                                    <label for="payment_proof" class="form-label fw-bold">
                                        Pilih File Bukti Transfer *
                                    </label>
                                    <input type="file"
                                        class="form-control form-control-lg"
                                        id="payment_proof"
                                        name="payment_proof"
                                        accept="image/*"
                                        required
                                        onchange="previewImage(event)">
                                    <small class="text-muted">
                                        Format: JPG, PNG, atau GIF. Maksimal 2MB
                                    </small>
                                </div>

                                <!-- Preview Image -->
                                <div id="imagePreview" class="mb-4 text-center" style="display: none;">
                                    <img id="preview"
                                        src=""
                                        alt="Preview"
                                        class="img-fluid rounded border"
                                        style="max-height: 300px;">
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-upload me-2"></i>Upload Bukti Transfer
                                    </button>
                                    <a href="<?= base_url('orders') ?>"
                                        class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Pesanan
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Warning -->
                    <div class="alert alert-warning mt-4 mb-0">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Penting!</strong> Pesanan akan diproses setelah pembayaran Anda diverifikasi oleh admin (maksimal 1x24 jam).
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Copy Virtual Account
    function copyVA() {
        var vaNumber = document.getElementById('vaNumber');
        vaNumber.select();
        vaNumber.setSelectionRange(0, 99999); // For mobile

        navigator.clipboard.writeText(vaNumber.value).then(function() {
            alert('Nomor Virtual Account berhasil disalin!');
        }, function(err) {
            console.error('Gagal menyalin: ', err);
        });
    }

    // Preview Image
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?= $this->endSection() ?>