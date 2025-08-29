<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-user.php'; ?>
    <section class="content">
        <h2>Kontak</h2>
        <ul>
            <?php foreach ($rows as $r): ?>
                <li>
                    <strong><?= htmlspecialchars($r['name']) ?></strong>
                    <?php if ($r['email']): ?> — <a href="mailto:<?= htmlspecialchars($r['email']) ?>">Email</a><?php endif; ?>
                    <?php if ($r['phone']): ?> — <a href="tel:<?= htmlspecialchars($r['phone']) ?>">Telepon</a><?php endif; ?>
                    <?php if ($r['whatsapp']): ?> — <a target="_blank" href="https://wa.me/<?= preg_replace('/\D/','', $r['whatsapp']) ?>">WhatsApp</a><?php endif; ?>
                    <?php if ($r['address']): ?> — <span><?= htmlspecialchars($r['address']) ?></span><?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

