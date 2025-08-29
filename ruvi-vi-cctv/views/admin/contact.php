<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-admin.php'; ?>
    <section class="content">
        <h2>Kontak</h2>
        <form method="post" action="<?= base_url('admin/contacts/create') ?>" class="grid">
            <?= csrf_field() ?>
            <input name="name" placeholder="Nama" required>
            <input name="email" type="email" placeholder="Email">
            <input name="phone" placeholder="Telepon">
            <input name="whatsapp" placeholder="WhatsApp">
            <input name="address" placeholder="Alamat">
            <button class="btn">Create</button>
        </form>
        <table>
            <thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Telepon</th><th>Whatsapp</th><th>Alamat</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= htmlspecialchars($r['email']) ?></td>
                    <td><?= htmlspecialchars($r['phone']) ?></td>
                    <td><?= htmlspecialchars($r['whatsapp']) ?></td>
                    <td><?= htmlspecialchars($r['address']) ?></td>
                    <td>
                        <form method="post" action="<?= base_url('admin/contacts/delete') ?>" onsubmit="return confirm('Hapus?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <button class="btn danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn primary" href="<?= base_url('admin/export/contacts') ?>">Export Contact (CSV)</a>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

