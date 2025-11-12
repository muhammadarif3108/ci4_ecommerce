<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h2 class="mb-4"><i class="bi bi-list-ul"></i> Pesanan saya</h2>

<?php if (empty($orders)): ?>
    <div class="alert alert-info text-center py-5">
        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
        <h4>Belum ada pesanan</h4>
        <p>Belanja Sekarang dan Cek Pesanan</p>
        <a href="<?= base_url('/') ?>" class="btn btn-primary">Belanja Sekarang</a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($orders as $order): ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <small class="text-muted">Order ID</small>
                                <h5 class="mb-0">#<?= $order['id'] ?></h5>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Tanggal</small>
                                <p class="mb-0"><?= date('d M Y', strtotime($order['created_at'])) ?></p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Total Pembayaran</small>
                                <h5 class="mb-0 text-primary">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></h5>
                            </div>
                            <div class="col-md-2">
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
                                <span class="badge bg-<?= $color ?>"><?= ucfirst($order['status']) ?></span>
                            </div>
                            <div class="col-md-3 text-end">
                                <a href="<?= base_url('order/detail/' . $order['id']) ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>