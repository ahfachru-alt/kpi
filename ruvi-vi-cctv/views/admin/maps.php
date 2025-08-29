<?php include BASE_PATH . '/views/layouts/header.php'; ?>
<div class="layout">
    <?php include BASE_PATH . '/views/layouts/sidebar-admin.php'; ?>
    <section class="content">
        <h2>Peta (Admin)</h2>
        <div id="map" style="height: 70vh"></div>
        <script>
            const map = L.map('map').setView([-6.3643, 108.4376], 15);
            const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
            const sat = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', { subdomains:['mt0','mt1','mt2','mt3'] });
            L.control.layers({ 'OSM': osm, 'Satelit': sat }).addTo(map);
            const cctvLayer = L.layerGroup().addTo(map);
            const colorByStatus = s => s==='online'?'green':(s==='offline'?'red':'orange');
            const cctvs = <?= json_encode($cctvs) ?>;
            cctvs.forEach(c => {
                if (c.lat && c.lng) {
                    L.circleMarker([parseFloat(c.lat), parseFloat(c.lng)], { radius: 7, color: colorByStatus(c.status) })
                        .bindPopup(`<strong>${c.room_name||''}</strong><br>${c.ip_address}`)
                        .addTo(cctvLayer);
                }
            });
        </script>
    </section>
</div>
<?php include BASE_PATH . '/views/layouts/footer.php'; ?>

