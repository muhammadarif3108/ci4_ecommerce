<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-cart-check"></i> Kelola Pesanan</h2>
    <div>
        <select class="form-select" id="filterStatus">
            <option value="">Status</option>
            <option value="pending">Menunggu Konfirmasi</option>
            <option value="processing">Dikemas</option>
            <option value="shipped">Dikirim</option>
            <option value="delivered">Terkirim</option>
            <option value="cancelled">Dibatalkan</option>
        </select>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Total Pembayaran</th>
                        <th>Status</th>
                        <th>Tanggal Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                <p>Tidak ada pesanan</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><strong>#<?= $order['id'] ?></strong></td>
                                <td><?= esc($order['customer_name']) ?></td>
                                <td><?= esc($order['customer_email']) ?></td>
                                <td><strong>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></strong></td>
                                <td>
                                    <?php
                                    // Array warna status
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger'
                                    ];
                                    
                                    // Array teks status dalam bahasa Indonesia
                                    $statusText = [
                                        'pending' => 'Menunggu Konfirmasi',
                                        'processing' => 'Dikemas',
                                        'shipped' => 'Dikirim',
                                        'delivered' => 'Terkirim',
                                        'cancelled' => 'Dibatalkan'
                                    ];
                                    
                                    $color = $statusColors[$order['status']] ?? 'secondary';
                                    $text = $statusText[$order['status']] ?? ucfirst($order['status']);
                                    ?>
                                    <span class="badge badge-status bg-<?= $color ?>"><?= $text ?></span>
                                </td>
                                <td><?= date('d M Y H:i', strtotime($order['created_at'])) ?></td>
                                <td>
                                    <a href="<?= base_url('admin/orders/detail/' . $order['id']) ?>"
                                        class="btn btn-sm btn-primary" title="Lihat Detail">
                                        <i class="bi bi-eye"></i> Rincian
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>