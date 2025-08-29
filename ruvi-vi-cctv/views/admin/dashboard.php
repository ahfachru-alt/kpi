<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-admin.php'; ?>
    <section class="content">
        <h2>Dashboard Admin</h2>
        <div class="cards">
            <div class="card">Users: <strong><?= $stats['users_total'] ?></strong></div>
            <div class="card">Gedung: <strong><?= $stats['buildings_total'] ?></strong></div>
            <div class="card">Ruangan: <strong><?= $stats['rooms_total'] ?></strong></div>
            <div class="card">CCTV: <strong><?= $stats['cctvs_total'] ?></strong></div>
        </div>
        <div class="cards">
            <div class="card green">CCTV Online: <strong><?= $stats['cctv_online'] ?></strong></div>
            <div class="card red">CCTV Offline: <strong><?= $stats['cctv_offline'] ?></strong></div>
            <div class="card yellow">CCTV Maintenance: <strong><?= $stats['cctv_maintenance'] ?></strong></div>
        </div>
        <a class="btn primary" href="<?= base_url('admin/export/cctvs') ?>">Export CCTV (CSV)</a>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

