<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-user.php'; ?>
    <section class="content">
        <h2>Peta</h2>
        <div class="legend">
            <button class="badge green" onclick="filterStatus('online')">Online</button>
            <button class="badge red" onclick="filterStatus('offline')">Offline</button>
            <button class="badge yellow" onclick="filterStatus('maintenance')">Maintenance</button>
            <button class="badge" onclick="filterStatus('all')">Semua</button>
        </div>
        <input id="search" placeholder="Cari gedung..." oninput="searchBuilding(this.value)" />
        <div id="map" style="height: 70vh"></div>
        <script>
            const map = L.map('map').setView([-6.3643, 108.4376], 15);
            const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
            const sat = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', { subdomains:['mt0','mt1','mt2','mt3'] });
            L.control.layers({ 'OSM': osm, 'Satelit': sat }).addTo(map);

            const cctvLayer = L.layerGroup().addTo(map);
            const buildings = <?= json_encode($buildings) ?>;
            const rooms = <?= json_encode($rooms) ?>;
            const cctvs = <?= json_encode($cctvs) ?>;

            const colorByStatus = s => s==='online'?'green':(s==='offline'?'red':'orange');
            let currentFilter = 'all';

            function renderMarkers() {
                cctvLayer.clearLayers();
                cctvs.forEach(c => {
                    if (currentFilter !== 'all' && c.status !== currentFilter) return;
                    if (c.lat && c.lng) {
                        L.circleMarker([parseFloat(c.lat), parseFloat(c.lng)], { radius: 7, color: colorByStatus(c.status) })
                            .bindPopup(`<strong>${c.room_name||''}</strong><br>${c.ip_address}<br>${c.stream_url?`<a href='player.php?src=${encodeURIComponent(c.stream_url)}' target='_blank'>Live</a>`:''}`)
                            .addTo(cctvLayer);
                    }
                });
            }
            renderMarkers();

            window.filterStatus = (s) => { currentFilter = s; renderMarkers(); };
            window.searchBuilding = (q) => {
                q = (q||'').toLowerCase();
                const found = buildings.find(b => (b.name||'').toLowerCase().includes(q));
                if (found && found.lat && found.lng) {
                    map.setView([parseFloat(found.lat), parseFloat(found.lng)], 17);
                }
            }
        </script>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

