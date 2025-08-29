<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="auth-container">
    <h2>Daftar</h2>
    <?php if (!empty($_SESSION['flash'])): $f = $_SESSION['flash']; unset($_SESSION['flash']); ?>
        <div class="alert <?= htmlspecialchars($f['type']) ?>"><?= htmlspecialchars($f['msg']) ?></div>
    <?php endif; ?>
    <form method="post" action="<?= base_url('register') ?>">
        <?= csrf_field() ?>
        <label>Nama Lengkap</label>
        <input type="text" name="name" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <label>Role</label>
        <select name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button class="btn primary" type="submit">Daftar</button>
    </form>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

