<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<style>
    .star-rating {
        direction: rtl;
        display: inline-flex;
        font-size: 2.5rem;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        color: #ddd;
        cursor: pointer;
        padding: 0 5px;
        transition: color 0.2s;
    }

    .star-rating label:hover,
    .star-rating label:hover~label,
    .star-rating input[type="radio"]:checked~label {
        color: #ffc107;
    }

    .existing-images-container,
    .image-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .image-preview-item,
    .existing-image-item {
        position: relative;
        border: 2px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1;
    }

    .image-preview-item img,
    .existing-image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-image-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(244, 67, 54, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        line-height: 1;
        transition: all 0.3s;
        z-index: 10;
    }

    .remove-image-btn:hover {
        background: #d32f2f;
        transform: scale(1.1);
    }

    .upload-area {
        border: 2px dashed #ddd;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        background: #f9f9f9;
        cursor: pointer;
        transition: all 0.3s;
    }

    .upload-area:hover {
        border-color: var(--accent-color);
        background: #f0f9ff;
    }

    .upload-area.dragover {
        border-color: var(--accent-color);
        background: #e3f2fd;
    }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>Edit Review
                    </h4>
                </div>
                <div class="card-body">
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

                    <!-- Info Produk -->
                    <div class="mb-4 p-3 bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <?php
                                $imagePath = $product['product_image'] ?? 'placeholder.jpg';
                                $imageUrl = base_url('uploads/' . $imagePath);
                                if (empty($product['product_image']) || !file_exists(FCPATH . 'uploads/' . $imagePath)) {
                                    $imageUrl = 'https://via.placeholder.com/100x100/00B4DB/FFFFFF?text=Product';
                                }
                                ?>
                                <img src="<?= $imageUrl ?>"
                                    alt="<?= esc($product['product_name']) ?>"
                                    class="rounded"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="col">
                                <h5 class="mb-1"><?= esc($product['product_name']) ?></h5>
                                <p class="text-muted mb-0">
                                    Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Review -->
                    <form action="<?= base_url('review/update/' . $review['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- Rating Bintang -->
                        <div class="mb-4 text-center">
                            <label class="form-label fw-bold d-block mb-3">
                                Rating <span class="text-danger">*</span>
                            </label>
                            <div class="star-rating">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>"
                                        <?= $review['rating'] == $i ? 'checked' : '' ?> required>
                                    <label for="star<?= $i ?>" title="<?= $i ?> bintang">★</label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <!-- Komentar -->
                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">
                                <i class="bi bi-chat-left-text me-1"></i>Review Anda
                            </label>
                            <textarea class="form-control"
                                id="comment"
                                name="comment"
                                rows="5"
                                maxlength="1000"
                                placeholder="Bagikan pengalaman Anda..."><?= esc($review['comment']) ?></textarea>
                            <small class="text-muted">Maksimal 1000 karakter</small>
                        </div>

                        <!-- Existing Images -->
                        <?php
                        $existingImages = !empty($review['review_images']) ? json_decode($review['review_images'], true) : [];
                        if (!empty($existingImages)):
                        ?>
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-images me-1"></i>Foto Saat Ini
                                </label>
                                <div class="existing-images-container" id="existingImagesContainer">
                                    <?php foreach ($existingImages as $index => $image): ?>
                                        <?php
                                        $imagePath = FCPATH . 'uploads/reviews/' . $image;
                                        if (file_exists($imagePath)):
                                        ?>
                                            <div class="existing-image-item" data-index="<?= $index ?>">
                                                <img src="<?= base_url('uploads/reviews/' . $image) ?>"
                                                    alt="Review Image <?= $index + 1 ?>">
                                                <button type="button"
                                                    class="remove-image-btn remove-existing-btn"
                                                    data-review-id="<?= $review['id'] ?>"
                                                    data-image-index="<?= $index ?>"
                                                    title="Hapus gambar">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Upload New Images -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-plus-circle me-1"></i>Tambah Foto Baru (Opsional)
                            </label>

                            <div class="upload-area" id="uploadArea">
                                <input type="file"
                                    id="review_images"
                                    name="review_images[]"
                                    multiple
                                    accept="image/*"
                                    style="display: none;">
                                <i class="bi bi-cloud-upload fs-1 text-muted d-block mb-2"></i>
                                <p class="mb-1">Klik atau drag & drop untuk upload foto</p>
                                <small class="text-muted">Maksimal <?= 5 - count($existingImages) ?> foto lagi (masing-masing max 2MB)</small>
                            </div>

                            <!-- Preview New Images -->
                            <div id="imagePreviewContainer" class="image-preview-container"></div>
                        </div>

                        <!-- Tombol -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('order/detail/' . $review['order_id']) ?>"
                                class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('review_images');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const existingImagesContainer = document.getElementById('existingImagesContainer');
        let selectedFiles = [];
        let existingImagesCount = <?= count($existingImages) ?>;
        const maxImages = 5;

        // Click to upload
        uploadArea.addEventListener('click', () => fileInput.click());

        // Drag & Drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = Array.from(e.dataTransfer.files);
            handleFiles(files);
        });

        // File input change
        fileInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            handleFiles(files);
        });

        function handleFiles(files) {
            const imageFiles = files.filter(file => file.type.startsWith('image/'));

            const availableSlots = maxImages - existingImagesCount - selectedFiles.length;

            if (imageFiles.length > availableSlots) {
                alert(`Maksimal ${availableSlots} foto lagi`);
                return;
            }

            const validFiles = imageFiles.filter(file => {
                if (file.size > 2 * 1024 * 1024) {
                    alert(`File ${file.name} terlalu besar (max 2MB)`);
                    return false;
                }
                return true;
            });

            selectedFiles = [...selectedFiles, ...validFiles];
            updateFileInput();
            displayPreviews();
        }

        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;
        }

        function displayPreviews() {
            previewContainer.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'image-preview-item';
                    div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}">
                    <button type="button" class="remove-image-btn" data-index="${index}">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                    previewContainer.appendChild(div);
                };

                reader.readAsDataURL(file);
            });
        }

        // Remove new uploaded image
        previewContainer.addEventListener('click', (e) => {
            const btn = e.target.closest('.remove-image-btn');
            if (btn) {
                const index = parseInt(btn.dataset.index);
                selectedFiles.splice(index, 1);
                updateFileInput();
                displayPreviews();
            }
        });

        // Remove existing image
        if (existingImagesContainer) {
            existingImagesContainer.addEventListener('click', async (e) => {
                const btn = e.target.closest('.remove-existing-btn');
                if (btn) {
                    if (!confirm('Hapus gambar ini?')) return;

                    const reviewId = btn.dataset.reviewId;
                    const imageIndex = btn.dataset.imageIndex;

                    try {
                        const response = await fetch(
                            `<?= base_url('review/delete-image/') ?>${reviewId}/${imageIndex}`, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            }
                        );

                        const result = await response.json();

                        if (result.success) {
                            btn.closest('.existing-image-item').remove();
                            existingImagesCount--;
                            // Update upload hint
                            uploadArea.querySelector('small').textContent =
                                `Maksimal ${maxImages - existingImagesCount} foto lagi (masing-masing max 2MB)`;
                        } else {
                            alert(result.message || 'Gagal menghapus gambar');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus gambar');
                    }
                }
            });
        }
    });
</script>

<?= $this->endSection() ?>