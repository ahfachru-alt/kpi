<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-admin.php'; ?>
    <section class="content">
        <h2>CCTV</h2>
        <form method="post" action="<?= base_url('admin/cctvs/create') ?>" class="grid">
            <?= csrf_field() ?>
            <select name="room_id" required>
                <option value="">Pilih Ruangan</option>
                <?php foreach ($rooms as $r): ?>
                    <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <input name="ip_address" placeholder="rtsp://..." required>
            <select name="status">
                <option value="online">Online</option>
                <option value="offline">Offline</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <input name="stream_url" placeholder="/public/live/x.m3u8">
            <input name="lat" placeholder="Lat (-6.36)">
            <input name="lng" placeholder="Lng (108.43)">
            <button class="btn">Create</button>
        </form>
        <table>
            <thead><tr><th>ID</th><th>Ruangan</th><th>IP</th><th>Status</th><th>Stream</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['room_name']) ?></td>
                    <td><?= htmlspecialchars($r['ip_address']) ?></td>
                    <td><?= htmlspecialchars($r['status']) ?></td>
                    <td>
                        <?php if (!empty($r['stream_url'])): ?>
                            <a class="btn" href="<?= base_url('player.php?src=' . urlencode($r['stream_url'])) ?>" target="_blank">Play</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="post" action="<?= base_url('admin/cctvs/start') ?>" style="display:inline-block">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <button class="btn">Start Stream</button>
                        </form>
                        <form method="post" action="<?= base_url('admin/cctvs/delete') ?>" onsubmit="return confirm('Hapus?')" style="display:inline-block">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <button class="btn danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn primary" href="<?= base_url('admin/export/cctvs') ?>">Export CCTV (CSV)</a>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

