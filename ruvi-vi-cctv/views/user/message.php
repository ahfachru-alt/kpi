<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-user.php'; ?>
    <section class="content">
        <h2>Pesan</h2>
        <form method="post" action="<?= base_url('messages/send') ?>" class="grid">
            <?= csrf_field() ?>
            <input type="hidden" name="from_id" value="<?= (int)($_SESSION['user']['id'] ?? 0) ?>">
            <select name="to_id" required>
                <option value="">Kirim ke...</option>
                <?php $users = db()->query('SELECT id,name FROM users ORDER BY name')->fetchAll(); foreach ($users as $u): if ($u['id'] == ($_SESSION['user']['id'] ?? 0)) continue; ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <input name="content" placeholder="Tulis pesan..." required>
            <button class="btn primary">Kirim</button>
        </form>
        <div id="sse-messages" data-url="<?= base_url('sse/messages.php') ?>"></div>
        <table>
            <thead><tr><th>Waktu</th><th>Dari</th><th>Ke</th><th>Pesan</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['created_at']) ?></td>
                    <td><?= htmlspecialchars($m['from_name']) ?></td>
                    <td><?= htmlspecialchars($m['to_name']) ?></td>
                    <td><?= htmlspecialchars($m['content']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

