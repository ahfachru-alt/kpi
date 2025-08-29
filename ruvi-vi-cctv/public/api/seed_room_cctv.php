<?php
// Seed 700 RTSP CCTV for a room via HTTP (admin-only)
declare(strict_types=1);
session_start();
define('BASE_PATH', dirname(__DIR__, 1));
require_once BASE_PATH . '/../config/database.php';

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') { http_response_code(403); exit('Forbidden'); }

$roomId = (int)($_GET['room_id'] ?? 0);
if (!$roomId) { http_response_code(400); exit('room_id required'); }

$ins = db()->prepare('INSERT INTO cctvs (room_id, ip_address, status, stream_url, lat, lng) VALUES (?, ?, "offline", "", ?, ?)');

for ($i=1; $i<=700; $i++) {
    $octet = str_pad((string)$i, 3, '0', STR_PAD_LEFT);
    $ip = "rtsp://admin:password.123@10.56.236.$octet/streaming/channels/";
    // Position around building center if available
    $b = db()->prepare('SELECT b.lat, b.lng FROM rooms r JOIN buildings b ON b.id=r.building_id WHERE r.id=?');
    $b->execute([$roomId]);
    $bc = $b->fetch();
    $lat = isset($bc['lat']) ? (float)$bc['lat'] + mt_rand(-20,20)/10000 : null;
    $lng = isset($bc['lng']) ? (float)$bc['lng'] + mt_rand(-20,20)/10000 : null;
    $ins->execute([$roomId, $ip, $lat, $lng]);
}

header('Content-Type: application/json');
echo json_encode(['ok' => true, 'room_id' => $roomId, 'count' => 700]);

