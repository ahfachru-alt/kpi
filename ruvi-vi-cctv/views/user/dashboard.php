<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-user.php'; ?>
    <section class="content">
        <h2>Dashboard</h2>
        <div class="cards">
            <div class="card">Gedung: <strong><?= $stats['buildings_total'] ?></strong></div>
            <div class="card">Ruangan: <strong><?= $stats['rooms_total'] ?></strong></div>
            <div class="card green">Online: <strong><?= $stats['cctv_online'] ?></strong></div>
            <div class="card red">Offline: <strong><?= $stats['cctv_offline'] ?></strong></div>
            <div class="card yellow">Maintenance: <strong><?= $stats['cctv_maintenance'] ?></strong></div>
        </div>
        <h3>Notifikasi Terbaru</h3>
        <ul>
            <?php foreach ($notifications as $n): ?>
                <li><strong><?= htmlspecialchars($n['title']) ?></strong> — <?= htmlspecialchars($n['body']) ?> (<?= htmlspecialchars($n['created_at']) ?>)</li>
            <?php endforeach; ?>
        </ul>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

