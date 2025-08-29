<?php
declare(strict_types=1);
session_start();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

require_once dirname(__DIR__, 2) . '/config/database.php';

$lastId = (int)($_GET['last_id'] ?? 0);
$uid = (int)($_SESSION['user']['id'] ?? 0);
if (!$uid) { echo "event: auth\n"; echo "data: {}\n\n"; flush(); exit; }

while (true) {
    $stmt = db()->prepare('SELECT m.id, m.content, m.created_at, ufrom.name AS from_name FROM messages m JOIN users ufrom ON ufrom.id=m.from_id WHERE (m.to_id=? OR m.from_id=?) AND m.id>? ORDER BY m.id ASC LIMIT 10');
    $stmt->execute([$uid,$uid,$lastId]);
    $rows = $stmt->fetchAll();
    foreach ($rows as $row) {
        $lastId = (int)$row['id'];
        echo "id: {$lastId}\n";
        echo "data: " . json_encode($row) . "\n\n";
        @ob_flush(); flush();
    }
    sleep(2);
}

