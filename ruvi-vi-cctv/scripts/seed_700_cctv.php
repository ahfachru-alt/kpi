<?php
// CLI: php scripts/seed_700_cctv.php <room_id>
require_once __DIR__ . '/../config/database.php';
$roomId = (int)($argv[1] ?? 0);
if (!$roomId) { fwrite(STDERR, "Usage: php scripts/seed_700_cctv.php <room_id>\n"); exit(1); }
$ins = db()->prepare('INSERT INTO cctvs (room_id, ip_address, status, stream_url, lat, lng) VALUES (?, ?, "offline", "", ?, ?)');
for ($i=1; $i<=700; $i++) {
    $octet = str_pad((string)$i, 3, '0', STR_PAD_LEFT);
    $ip = "rtsp://admin:password.123@10.56.236.$octet/streaming/channels/";
    $lat = -6.3640 + mt_rand(-50, 50)/10000; // small spread
    $lng = 108.4370 + mt_rand(-50, 50)/10000;
    $ins->execute([$roomId, $ip, $lat, $lng]);
}
echo "Seeded 700 CCTV for room {$roomId}\n";

