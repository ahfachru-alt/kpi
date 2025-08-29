<?php
$src = $_GET['src'] ?? '';
if (!$src) { http_response_code(400); exit('Missing src'); }
?><!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>HLS Player</title>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<style>body{margin:0;background:#000;display:flex;align-items:center;justify-content:center;height:100vh}video{width:100%;height:100%;}</style>
</head><body>
<video id="video" controls autoplay muted playsinline></video>
<script>
const src = <?= json_encode($src) ?>;
const video = document.getElementById('video');
if (Hls.isSupported()){
  const hls = new Hls({ maxBufferLength: 3 });
  hls.loadSource(src);
  hls.attachMedia(video);
} else if (video.canPlayType('application/vnd.apple.mpegurl')){
  video.src = src;
}
</script>
</body></html>

