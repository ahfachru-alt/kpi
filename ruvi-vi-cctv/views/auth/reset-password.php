<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="auth-container">
    <h2>Reset Password</h2>
    <form method="post" action="<?= base_url('reset-password') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
        <label>Password Baru</label>
        <input type="password" name="password" required>
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required>
        <button class="btn primary" type="submit">Reset</button>
    </form>
    
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

