<?php
// Generate 700 RTSP endpoints as examples
for ($i = 1; $i <= 700; $i++) {
    $octet = str_pad((string)$i, 3, '0', STR_PAD_LEFT);
    $ip = "rtsp://admin:password.123@10.56.236.$octet/streaming/channels/";
    echo $ip, PHP_EOL;
}

