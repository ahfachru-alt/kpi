<?php
$appTitle = $title ?? 'RU VI CCTV';
$theme = $_SESSION['user']['theme'] ?? 'system';
?>
<!doctype html>
<html lang="id" data-theme="<?= htmlspecialchars($theme) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($appTitle) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script src="<?= base_url('assets/js/app.js') ?>" defer></script>
</head>
<body>
<header class="headbar">
    <div class="brand">
        <img src="<?= base_url('assets/images/logo-pertamina.png') ?>" alt="Pertamina" class="logo">
        <div class="title">
            <strong>Monitoring CCTV</strong>
            <small>PT Kilang Pertamina Internasional RU VI Balongan</small>
        </div>
    </div>
    <div class="actions">
        <?php if (auth_user()): ?>
        <form method="post" action="<?= base_url('toggle-theme') ?>" class="theme-toggle">
            <?= csrf_field() ?>
            <select name="theme" onchange="this.form.submit()">
                <option value="system" <?= ($theme==='system'?'selected':'') ?>>System</option>
                <option value="light" <?= ($theme==='light'?'selected':'') ?>>Light</option>
                <option value="dark" <?= ($theme==='dark'?'selected':'') ?>>Dark</option>
            </select>
        </form>
        <a href="<?= base_url('logout') ?>" class="btn">Logout</a>
        <?php endif; ?>
    </div>
</header>
<main class="main">

