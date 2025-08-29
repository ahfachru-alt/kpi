<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-user.php'; ?>
    <section class="content">
        <h2>Profil</h2>
        <form method="post" action="<?= base_url('profile/update') ?>" class="grid">
            <?= csrf_field() ?>
            <input name="name" value="<?= htmlspecialchars($user['name']) ?>" placeholder="Nama" required>
            <input name="email" type="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Email" required>
            <button class="btn primary">Simpan</button>
        </form>
        <h3>Ganti Password</h3>
        <form method="post" action="<?= base_url('profile/password') ?>" class="grid">
            <?= csrf_field() ?>
            <input name="current_password" type="password" placeholder="Current Password" required>
            <input name="new_password" type="password" placeholder="New Password" required>
            <input name="confirm_password" type="password" placeholder="Confirm Password" required>
            <button class="btn">Update Password</button>
        </form>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

