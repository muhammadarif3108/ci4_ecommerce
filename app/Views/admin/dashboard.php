<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-semibold mb-0 text-dark"><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard</h2>
        <p class="text-muted small mb-0">Selamat datang kembali, <?= esc(session()->get('admin_name')) ?>!</p>
    </div>
    <div class="text-muted small">
        <i class="bi bi-calendar3 me-1"></i><?= date('l, d F Y') ?>
    </div>
</div>

<!-- Statistic Cards -->
<div class="row g-4 mb-4">
    <?php
    $stats = [
        ['title' => 'Total Produk', 'value' => $totalProducts, 'icon' => 'bi-box-seam', 'color' => '#4e73df'],
        ['title' => 'Total Pesanan', 'value' => $totalOrders, 'icon' => 'bi-cart-check', 'color' => '#1cc88a'],
        ['title' => 'Total Pendapatan', 'value' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'), 'icon' => 'bi-currency-dollar', 'color' => '#36b9cc'],
        ['title' => 'Total Pengguna', 'value' => $totalUsers, 'icon' => 'bi-people', 'color' => '#f6c23e'],
    ];
    foreach ($stats as $s):
    ?>
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card border-0 shadow-sm" style="border-top: 4px solid <?= $s['color'] ?>;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1"><?= $s['title'] ?></div>
                            <h4 class="fw-semibold mb-0"><?= $s['value'] ?></h4>
                        </div>
                        <div class="fs-2" style="color: <?= $s['color'] ?>">
                            <i class="bi <?= $s['icon'] ?>"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Order Statistics by Status -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-pie-chart text-primary me-2"></i>Statistik Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row text-center g-3">
                    <div class="col">
                        <h3 class="text-warning mb-1"><?= $orderStats['pending'] ?></h3>
                        <small class="text-muted">Belum Bayar</small>
                    </div>
                    <div class="col">
                        <h3 class="text-info mb-1"><?= $orderStats['processing'] ?></h3>
                        <small class="text-muted">Dikemas</small>
                    </div>
                    <div class="col">
                        <h3 class="text-primary mb-1"><?= $orderStats['shipped'] ?></h3>
                        <small class="text-muted">Dikirim</small>
                    </div>
                    <div class="col">
                        <h3 class="text-success mb-1"><?= $orderStats['delivered'] ?></h3>
                        <small class="text-muted">Selesai</small>
                    </div>
                    <div class="col">
                        <h3 class="text-danger mb-1"><?= $orderStats['cancelled'] ?></h3>
                        <small class="text-muted">Dibatalkan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-clock-history text-primary me-2"></i>Pesanan Terbaru</h5>
                <a href="<?= base_url('admin/orders') ?>" class="text-decoration-none small">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentOrders)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Belum ada pesanan terbaru
                                    </td>
                                </tr>
                            <?php else: ?>
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
                                    'pending' => 'Belum Bayar',
                                    'processing' => 'Dikemas',
                                    'shipped' => 'Dikirim',
                                    'delivered' => 'Selesai',
                                    'cancelled' => 'Dibatalkan'
                                ];

                                foreach ($recentOrders as $order):
                                    $color = $statusColors[$order['status']] ?? 'secondary';
                                    $text = $statusText[$order['status']] ?? ucfirst($order['status']);
                                ?>
                                    <tr>
                                        <td><strong>#<?= $order['id'] ?></strong></td>
                                        <td><?= esc($order['customer_name']) ?></td>
                                        <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                                        <td><span class="badge bg-<?= $color ?>"><?= $text ?></span></td>
                                        <td><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/orders/detail/' . $order['id']) ?>"
                                                class="btn btn-sm btn-outline-primary rounded-pill"
                                                title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
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

        <!-- Best Sellers -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-trophy text-warning me-2"></i>Produk Terlaris</h5>
            </div>
            <div class="card-body">
                <?php if (empty($bestSellers)): ?>
                    <p class="text-muted text-center py-3 mb-0">Belum ada data</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($bestSellers as $product): ?>
                            <div class="list-group-item border-0 px-0 py-2 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><?= esc($product['name']) ?></h6>
                                    <small class="text-muted">
                                        <i class="bi bi-star-fill text-warning"></i> <?= number_format($product['rating'], 1) ?> |
                                        <i class="bi bi-bag-check"></i> <?= $product['sold'] ?> terjual
                                    </small>
                                </div>
                                <span class="badge bg-warning text-dark">#<?= $product['id'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar Widgets -->
    <div class="col-lg-4">
        <!-- Low Stock -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-exclamation-triangle text-warning me-2"></i>Stok Menipis!</h5>
            </div>
            <div class="card-body" style="max-height: 320px; overflow-y: auto;">
                <?php if (empty($lowStockProducts)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>
                        <p class="mb-0">Semua produk memiliki stok cukup</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($lowStockProducts as $product): ?>
                            <div class="list-group-item border-0 px-0 py-2 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><?= esc($product['name']) ?></h6>
                                    <small class="text-danger fw-bold">Stok: <?= $product['stock'] ?> unit</small>
                                </div>
                                <a href="<?= base_url('admin/products/edit/' . $product['id']) ?>"
                                    class="btn btn-sm btn-outline-warning rounded-pill"
                                    title="Edit Produk">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Top Rated Products -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-star-fill text-success me-2"></i>Rating Tertinggi</h5>
            </div>
            <div class="card-body" style="max-height: 320px; overflow-y: auto;">
                <?php if (empty($topRated)): ?>
                    <p class="text-muted text-center py-3 mb-0">Belum ada data</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($topRated as $product): ?>
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1"><?= esc($product['name']) ?></h6>
                                        <div class="text-warning small">
                                            <?php for ($i = 0; $i < floor($product['rating']); $i++): ?>
                                                <i class="bi bi-star-fill"></i>
                                            <?php endfor; ?>
                                            <span class="text-muted ms-1"><?= number_format($product['rating'], 1) ?> (<?= $product['review_count'] ?>)</span>
                                        </div>
                                    </div>
                                    <span class="badge bg-success"><?= $product['sold'] ?> terjual</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-lightning me-2 text-primary"></i>Akses Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= base_url('admin/products/add') ?>" class="btn btn-primary rounded-pill">
                        <i class="bi bi-plus-circle"></i> Tambah Produk
                    </a>
                    <a href="<?= base_url('admin/orders') ?>" class="btn btn-outline-primary rounded-pill">
                        <i class="bi bi-eye"></i> Lihat Pesanan
                    </a>
                    <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-primary rounded-pill">
                        <i class="bi bi-grid-3x3"></i> Kelola Kategori
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Chart -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-graph-up text-success me-2"></i>Grafik Penjualan</h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Penjualan (Rp)',
                data: [12000000, 19000000, 15000000, 25000000, 22000000, 30000000, 28000000, 35000000, 32000000, 40000000, 38000000, 45000000],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(54, 162, 235, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return 'Penjualan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        },
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>