<!-- app/Views/admin/products/index.php -->
<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-seam"></i> Kelola Produk</h2>
    <a href="<?= base_url('admin/products/add') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Produk Baru
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td>
                                <img src="<?= base_url('uploads/' . ($product['image'] ?? 'placeholder.jpg')) ?>"
                                    alt="<?= esc($product['name']) ?>"
                                    class="img-thumbnail"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td><strong><?= esc($product['name']) ?></strong></td>
                            <td><span class="badge bg-secondary"><?= esc($product['category_name']) ?></span></td>
                            <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($product['stock'] < 10): ?>
                                    <span class="badge bg-danger"><?= $product['stock'] ?> unit</span>
                                <?php else: ?>
                                    <span class="badge bg-success"><?= $product['stock'] ?> unit</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($product['stock'] > 0): ?>
                                    <span class="badge bg-success">Tersedia</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Stok Habis</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('admin/products/edit/' . $product['id']) ?>"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('admin/products/delete/' . $product['id']) ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah anda yakin ingin menghapus produk ini?')" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>