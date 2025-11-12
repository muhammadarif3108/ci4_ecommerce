<!-- app/Views/admin/products/add.php -->
<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-plus-circle"></i> Tambah Produk Baru</h2>
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

                <form action="<?= base_url('admin/products/save') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk *</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?= old('name') ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori *</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
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
                                <small class="text-muted">Max 2MB. Format: JPG, PNG, GIF</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Produk *</label>
                        <textarea class="form-control" id="description" name="description"
                            rows="4" required><?= old('description') ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga (Rp) *</label>
                                <input type="number" class="form-control" id="price" name="price"
                                    value="<?= old('price') ?>" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok *</label>
                                <input type="number" class="form-control" id="stock" name="stock"
                                    value="<?= old('stock') ?>" required min="0">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"> Simpan</i> 
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Tips</h6>
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li class="mb-2">Use clear and descriptive product names</li>
                    <li class="mb-2">Add high-quality images for better conversion</li>
                    <li class="mb-2">Write detailed descriptions including features and specifications</li>
                    <li class="mb-2">Set competitive prices based on market research</li>
                    <li>Keep stock levels updated to avoid overselling</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>