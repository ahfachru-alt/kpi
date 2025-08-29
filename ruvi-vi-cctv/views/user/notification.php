<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-user.php'; ?>
    <section class="content">
        <h2>Notifikasi</h2>
        <div id="sse-messages" data-url="<?= base_url('sse/notifications.php') ?>"></div>
        <ul>
            <?php foreach ($rows as $n): ?>
                <li><strong><?= htmlspecialchars($n['title']) ?></strong> — <?= htmlspecialchars($n['body']) ?> (<?= htmlspecialchars($n['created_at']) ?>)</li>
            <?php endforeach; ?>
        </ul>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

