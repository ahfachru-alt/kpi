<aside class="sidebar">
    <div class="logo">
        <img src="<?= base_url('assets/images/logo-pertamina.png') ?>" alt="logo">
        <small>Platform</small>
    </div>
    <nav>
        <h6>Signal Analytic</h6>
        <a href="<?= base_url('admin') ?>">Dashboard</a>
        <h6>User</h6>
        <a href="<?= base_url('admin/users') ?>">User List</a>
        <h6>Maps</h6>
        <a href="<?= base_url('admin/maps') ?>">Maps List</a>
        <h6>Location</h6>
        <a href="<?= base_url('admin/buildings') ?>">Gedung</a>
        <a href="<?= base_url('admin/rooms') ?>">Ruangan</a>
        <a href="<?= base_url('admin/cctvs') ?>">CCTV</a>
        <h6>Contact</h6>
        <a href="#">Contact List</a>
        <h6>Notification</h6>
        <a href="<?= base_url('admin/notifications') ?>">Notification</a>
        <h6>Message</h6>
        <a href="<?= base_url('admin/messages') ?>">Message</a>
        <h6>Theme</h6>
        <span>Appearance: via headbar</span>
    </nav>
    <div class="profile">
        <div><?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?></div>
        <small><?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?></small>
    </div>
</aside>

