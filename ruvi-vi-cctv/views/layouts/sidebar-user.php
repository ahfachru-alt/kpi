<aside class="sidebar">
    <div class="logo">
        <img src="<?= base_url('assets/images/logo-pertamina.png') ?>" alt="logo">
        <small>Platform</small>
    </div>
    <nav>
        <a href="<?= base_url('user') ?>">Dashboard</a>
        <a href="<?= base_url('user/maps') ?>">Maps</a>
        <a href="<?= base_url('user/location') ?>">Location</a>
        <a href="#">Contact</a>
        <a href="<?= base_url('user/notifications') ?>">Notification</a>
        <a href="<?= base_url('user/messages') ?>">Message</a>
        <a href="<?= base_url('user/profile') ?>">Profile</a>
    </nav>
    <div class="profile">
        <div><?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?></div>
        <small><?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?></small>
    </div>
</aside>

