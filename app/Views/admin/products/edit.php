<!-- app/Views/admin/products/edit.php -->
<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-pencil"></i> Edit Produk</h2>
    <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <?php if (session()->get('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->get('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/products/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk *</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?= old('name', $product['name']) ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori *</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>"
                                            <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                            <?= esc($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <?php if ($product['image']): ?>
                                    <small class="text-muted">Current: <?= $product['image'] ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if ($product['image']): ?>
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label><br>
                            <img src="<?= base_url('uploads/' . $product['image']) ?>"
                                alt="<?= esc($product['name']) ?>"
                                class="img-thumbnail"
                                style="max-width: 200px;">
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Produk *</label>
                        <textarea class="form-control" id="description" name="description"
                            rows="4" required><?= old('description', $product['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga (Rp) *</label>
                                <input type="number" class="form-control" id="price" name="price"
                                    value="<?= old('price', $product['price']) ?>" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok *</label>
                                <input type="number" class="form-control" id="stock" name="stock"
                                    value="<?= old('stock', $product['stock']) ?>" required min="0">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Perbarui Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>