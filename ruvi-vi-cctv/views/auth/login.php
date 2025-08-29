<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="auth-container">
    <h2>Masuk</h2>
    <?php if (!empty($_SESSION['flash'])): $f = $_SESSION['flash']; unset($_SESSION['flash']); ?>
        <div class="alert <?= htmlspecialchars($f['type']) ?>"><?= htmlspecialchars($f['msg']) ?></div>
    <?php endif; ?>
    <form method="post" action="<?= base_url('login') ?>">
        <?= csrf_field() ?>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button class="btn primary" type="submit">Masuk</button>
    </form>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

