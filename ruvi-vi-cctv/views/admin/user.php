<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-admin.php'; ?>
    <section class="content">
        <h2>User</h2>
        <form method="post" action="<?= base_url('admin/users/create') ?>" class="grid">
            <?= csrf_field() ?>
            <input name="name" placeholder="Nama" required>
            <input name="email" placeholder="Email" type="email" required>
            <input name="password" placeholder="Password" type="password" required>
            <select name="role"><option value="user">User</option><option value="admin">Admin</option></select>
            <button class="btn">Create</button>
        </form>
        <table>
            <thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['role']) ?></td>
                    <td class="flex">
                        <form method="post" action="<?= base_url('admin/users/delete') ?>" onsubmit="return confirm('Hapus?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                            <button class="btn danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn primary" href="<?= base_url('admin/export/users') ?>">Export Users (CSV)</a>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

