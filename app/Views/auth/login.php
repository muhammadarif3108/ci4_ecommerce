<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-person-circle fs-1 text-primary"></i>
                    <h3 class="mt-2">Masuk</h3>
                    <p class="text-muted">Masuk dengan email yang sudah terdaftar</p>
                </div>

                <form action="<?= base_url('login/process') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Masukkan password" required>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="mb-0">Belum punya akun?
                            <a href="<?= base_url('register') ?>" class="text-decoration-none">Daftar</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>