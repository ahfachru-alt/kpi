<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-admin.php'; ?>
    <section class="content">
        <h2>Notifikasi</h2>
        <table>
            <thead><tr><th>Waktu</th><th>User</th><th>Judul</th><th>Pesan</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $n): ?>
                <tr>
                    <td><?= htmlspecialchars($n['created_at']) ?></td>
                    <td><?= htmlspecialchars($n['user_name']) ?></td>
                    <td><?= htmlspecialchars($n['title']) ?></td>
                    <td><?= htmlspecialchars($n['body']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

