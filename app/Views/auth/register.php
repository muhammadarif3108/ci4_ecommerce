<!-- app/Views/auth/register.php -->
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-person-plus-fill fs-1 text-primary"></i>
                    <h3 class="mt-2">Daftar</h3>
                    <p class="text-muted">Gabung sekarang dan mulai belanja!</p>
                </div>

                <form action="<?= base_url('register/process') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Masukkan password" required minlength="6">
                        </div>
                        <small class="text-muted">Minimum 6 characters</small>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="confirm_password"
                                name="confirm_password" placeholder="Konfirmasi password" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">No. Handphone *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-phone"></i></span>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                placeholder="Masukkan No. Handphone">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <textarea class="form-control" id="address" name="address"
                                rows="2" placeholder="Masukkan alamat"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Dengan mendaftar, kamu setuju dengan <a href="#" class="text-decoration-none">Syarat, Ketentuan, dan Privasi</a> kami
                        </label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle"></i> Daftar
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="mb-0">Sudah punya akun?
                            <a href="<?= base_url('login') ?>" class="text-decoration-none">Masuk</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>