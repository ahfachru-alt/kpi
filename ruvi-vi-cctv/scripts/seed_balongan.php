<?php
// Seed sample buildings and rooms around RU VI Balongan, and distribute CCTV lat/lng
require_once __DIR__ . '/../config/database.php';

// Buildings (approximate coordinates around RU VI Balongan)
$buildings = [
    ['Kilometer 0', -6.3638, 108.4368],
    ['Central Control Room', -6.3645, 108.4379],
    ['Tank Farm A', -6.3652, 108.4387],
    ['Jetty Area', -6.3629, 108.4393],
    ['Maintenance Workshop', -6.3660, 108.4369],
];

// Create buildings
$insB = db()->prepare('INSERT INTO buildings (name, lat, lng) VALUES (?, ?, ?)');
foreach ($buildings as $b) { $insB->execute($b); }

// Fetch created buildings with ids
$bs = db()->query('SELECT * FROM buildings ORDER BY id DESC LIMIT ' . count($buildings))->fetchAll();

// Create 3 rooms per building
$insR = db()->prepare('INSERT INTO rooms (building_id, name) VALUES (?, ?)');
foreach ($bs as $b) {
    for ($i=1; $i<=3; $i++) { $insR->execute([$b['id'], $b['name'] . ' - Room ' . $i]); }
}

// Fetch all rooms
$rooms = db()->query('SELECT * FROM rooms ORDER BY id')->fetchAll();

// Distribute existing CCTV entries without lat/lng across rooms and set coords around building
$cctvs = db()->query('SELECT cctvs.*, rooms.building_id FROM cctvs LEFT JOIN rooms ON rooms.id=cctvs.room_id WHERE cctvs.lat IS NULL OR cctvs.lng IS NULL')->fetchAll();
$updC = db()->prepare('UPDATE cctvs SET room_id=?, lat=?, lng=? WHERE id=?');

foreach ($cctvs as $idx => $c) {
    $room = $rooms[$idx % count($rooms)];
    $bStmt = db()->prepare('SELECT lat,lng FROM buildings WHERE id=?');
    $bStmt->execute([$room['building_id']]);
    $bc = $bStmt->fetch();
    $lat = (float)$bc['lat'] + mt_rand(-30, 30)/10000;
    $lng = (float)$bc['lng'] + mt_rand(-30, 30)/10000;
    $updC->execute([$room['id'], $lat, $lng, $c['id']]);
}

echo "Seeded buildings, rooms, and updated CCTV coordinates." . PHP_EOL;

