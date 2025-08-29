<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-user.php'; ?>
    <section class="content">
        <h2>Lokasi</h2>
        <input id="search" placeholder="Cari gedung..." oninput="filterBuildings(this.value)" />
        <div class="cards" id="building-list">
            <?php foreach ($buildings as $b): ?>
                <div class="card">
                    <strong><?= htmlspecialchars($b['name']) ?></strong>
                    <?php $rooms = db()->prepare('SELECT * FROM rooms WHERE building_id=?'); $rooms->execute([$b['id']]); $rs=$rooms->fetchAll(); ?>
                    <ul>
                        <?php foreach ($rs as $r): ?>
                            <li>
                                <?= htmlspecialchars($r['name']) ?>
                                <?php $cams = db()->prepare('SELECT * FROM cctvs WHERE room_id=?'); $cams->execute([$r['id']]); $cs=$cams->fetchAll(); ?>
                                <ul>
                                    <?php foreach ($cs as $c): ?>
                                        <li><?= htmlspecialchars($c['ip_address']) ?> <?php if (!empty($c['stream_url'])): ?><a class="btn" href="<?= base_url(ltrim($c['stream_url'],'/')) ?>" target="_blank">Live</a><?php endif; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
        <script>
            function filterBuildings(q){
                q=(q||'').toLowerCase();
                document.querySelectorAll('#building-list .card').forEach(c=>{
                    const name=c.querySelector('strong').textContent.toLowerCase();
                    c.style.display = name.includes(q) ? '' : 'none';
                })
            }
        </script>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

