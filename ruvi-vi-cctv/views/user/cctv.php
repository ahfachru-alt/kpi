<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-user.php'; ?>
    <section class="content">
        <h2>CCTV</h2>
        <table>
            <thead><tr><th>ID</th><th>Ruangan</th><th>IP</th><th>Status</th><th>Live</th></tr></thead>
            <tbody>
            <?php foreach ($cctvs as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['room_name']) ?></td>
                    <td><?= htmlspecialchars($c['ip_address']) ?></td>
                    <td><?= htmlspecialchars($c['status']) ?></td>
                    <td>
                        <?php if (!empty($c['stream_url'])): ?>
                            <a class="btn" href="<?= base_url('player.php?src=' . urlencode($c['stream_url'])) ?>" target="_blank">Play</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

