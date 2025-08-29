<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="auth-container">
    <h2>Lupa Password</h2>
    <form method="post" action="<?= base_url('forgot-password') ?>">
        <?= csrf_field() ?>
        <label>Email</label>
        <input type="email" name="email" required>
        <button class="btn primary" type="submit">Kirim Link Reset</button>
    </form>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>