<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-admin.php'; ?>
    <section class="content">
        <h2>Gedung</h2>
        <form method="post" action="<?= base_url('admin/buildings/create') ?>" class="grid">
            <?= csrf_field() ?>
            <input name="name" placeholder="Nama Gedung" required>
            <input name="lat" placeholder="Latitude" required>
            <input name="lng" placeholder="Longitude" required>
            <button class="btn">Create</button>
        </form>
        <table>
            <thead><tr><th>ID</th><th>Nama</th><th>Lat</th><th>Lng</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= htmlspecialchars($r['lat']) ?></td>
                    <td><?= htmlspecialchars($r['lng']) ?></td>
                    <td>
                        <form method="post" action="<?= base_url('admin/buildings/delete') ?>" onsubmit="return confirm('Hapus?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <button class="btn danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn primary" href="<?= base_url('admin/export/buildings') ?>">Export Gedung (CSV)</a>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

