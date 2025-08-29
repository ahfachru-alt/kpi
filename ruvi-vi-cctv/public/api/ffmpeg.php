<?php
// Simple starter to spawn ffmpeg for a given RTSP and generate HLS into public/live
declare(strict_types=1);
$ip = $_GET['rtsp'] ?? '';
if (!$ip) { http_response_code(400); exit('Missing rtsp'); }
$safe = preg_replace('/[^0-9\.]/','_', parse_url($ip, PHP_URL_HOST) ?? 'stream');
$output = __DIR__ . '/../live/' . $safe . '.m3u8';
$cmd = sprintf('ffmpeg -nostdin -rtsp_transport tcp -i %s -c:v libx264 -preset veryfast -tune zerolatency -f hls -hls_time 1 -hls_list_size 3 -hls_flags delete_segments %s > /dev/null 2>&1 &', escapeshellarg($ip), escapeshellarg($output));
exec($cmd);
header('Content-Type: application/json');
echo json_encode(['ok' => true, 'output' => basename($output)]);

