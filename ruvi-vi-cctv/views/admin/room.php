<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-admin.php'; ?>
    <section class="content">
        <h2>Ruangan</h2>
        <form method="post" action="<?= base_url('admin/rooms/create') ?>" class="grid">
            <?= csrf_field() ?>
            <select name="building_id" required>
                <option value="">Pilih Gedung</option>
                <?php foreach ($buildings as $b): ?>
                    <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <input name="name" placeholder="Nama Ruangan" required>
            <button class="btn">Create</button>
        </form>
        <table>
            <thead><tr><th>ID</th><th>Gedung</th><th>Ruangan</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td>
                        <form method="post" action="<?= base_url('admin/rooms/update') ?>" class="grid" style="grid-template-columns:1fr 1fr auto;gap:6px">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <select name="building_id">
                                <?php foreach ($buildings as $b): ?>
                                    <option value="<?= $b['id'] ?>" <?= $b['name']===$r['building_name']?'selected':'' ?>><?= htmlspecialchars($b['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input name="name" value="<?= htmlspecialchars($r['name']) ?>">
                            <button class="btn">Save</button>
                        </form>
                    </td>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td>
                        <form method="post" action="<?= base_url('admin/rooms/delete') ?>" onsubmit="return confirm('Hapus?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <button class="btn danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn primary" href="<?= base_url('admin/export/rooms') ?>">Export Ruangan (CSV)</a>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

