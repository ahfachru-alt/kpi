<?php
declare(strict_types=1);
session_start();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

require_once dirname(__DIR__, 2) . '/config/database.php';

$lastTime = $_GET['last_time'] ?? '1970-01-01 00:00:00';
$uid = (int)($_SESSION['user']['id'] ?? 0);
if (!$uid) { echo "event: auth\n"; echo "data: {}\n\n"; flush(); exit; }

while (true) {
    $stmt = db()->prepare('SELECT id, title, body, created_at FROM notifications WHERE user_id=? AND created_at>? ORDER BY created_at ASC LIMIT 10');
    $stmt->execute([$uid,$lastTime]);
    $rows = $stmt->fetchAll();
    foreach ($rows as $row) {
        $lastTime = $row['created_at'];
        echo "data: " . json_encode($row) . "\n\n";
        @ob_flush(); flush();
    }
    sleep(2);
}

