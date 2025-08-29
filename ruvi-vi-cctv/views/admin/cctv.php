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
        <form method="get" action="<?= base_url('api/seed_room_cctv.php') ?>" target="_blank" class="grid" style="grid-template-columns:1fr auto;gap:6px;margin:10px 0">
            <input name="room_id" placeholder="Seed 700 CCTV untuk Room ID">
            <button class="btn">Seed 700 CCTV (HTTP)</button>
        </form>
        <table>
            <thead><tr><th>ID</th><th>Ruangan</th><th>IP</th><th>Status</th><th>Stream</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['room_name']) ?></td>
                    <td>
                        <form method="post" action="<?= base_url('admin/cctvs/update') ?>" class="grid" style="grid-template-columns:1fr 1fr 1fr 1fr 1fr auto;gap:6px">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <input name="ip_address" value="<?= htmlspecialchars($r['ip_address']) ?>">
                            <select name="status">
                                <option value="online" <?= $r['status']==='online'?'selected':'' ?>>Online</option>
                                <option value="offline" <?= $r['status']==='offline'?'selected':'' ?>>Offline</option>
                                <option value="maintenance" <?= $r['status']==='maintenance'?'selected':'' ?>>Maintenance</option>
                            </select>
                            <input name="stream_url" value="<?= htmlspecialchars($r['stream_url']) ?>">
                            <input name="lat" value="<?= htmlspecialchars($r['lat'] ?? '') ?>" placeholder="Lat">
                            <input name="lng" value="<?= htmlspecialchars($r['lng'] ?? '') ?>" placeholder="Lng">
                            <input type="hidden" name="room_id" value="<?= $r['room_id'] ?>">
                            <button class="btn">Save</button>
                        </form>
                    </td>
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

