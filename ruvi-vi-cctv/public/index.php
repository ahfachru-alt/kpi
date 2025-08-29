<?php
declare(strict_types=1);

session_start();

// Paths
define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);

// Helpers
function base_url(string $path = ''): string {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptName = rtrim(str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']), '/');
    $base = $scheme . '://' . $host . $scriptName;
    return rtrim($base . '/' . ltrim($path, '/'), '/');
}

// Autoload basic controllers and models
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/controllers/' . $class . '.php',
        BASE_PATH . '/models/' . $class . '.php',
    ];
    foreach ($paths as $file) {
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});

// Config
require_once BASE_PATH . '/config/database.php';

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function csrf_field(): string {
    $token = htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="_token" value="' . $token . '">';
}

function verify_csrf(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $posted = $_POST['_token'] ?? '';
        if (!$posted || !hash_equals($_SESSION['csrf_token'] ?? '', $posted)) {
            http_response_code(419);
            exit('CSRF token mismatch.');
        }
    }
}

// Simple auth helpers
function auth_user(): ?array { return $_SESSION['user'] ?? null; }
function is_admin(): bool { return (($_SESSION['user']['role'] ?? '') === 'admin'); }
function require_auth(): void {
    if (!auth_user()) { header('Location: ' . base_url('login')); exit; }
}
function require_admin(): void {
    require_auth();
    if (!is_admin()) { http_response_code(403); exit('Forbidden'); }
}

// Update last_seen (~1/min)
if (auth_user()) {
    $now = time();
    $lastTick = $_SESSION['last_seen_tick'] ?? 0;
    if ($now - (int)$lastTick >= 60) {
        $_SESSION['last_seen_tick'] = $now;
        $stmt = db()->prepare('UPDATE users SET last_seen=NOW() WHERE id=?');
        $stmt->execute([(int)$_SESSION['user']['id']]);
    }
}

// Routing
$routes = require BASE_PATH . '/routes/routes.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Normalize base path if app served from subdir
$scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
if ($scriptDir && str_starts_with($uri, $scriptDir)) {
    $uri = substr($uri, strlen($scriptDir));
    if ($uri === false) { $uri = '/'; }
}

$uri = '/' . ltrim($uri, '/');

verify_csrf();

$routeKey = $method . ' ' . $uri;
if (isset($routes[$routeKey])) {
    $handler = $routes[$routeKey];
} elseif (isset($routes['ANY ' . $uri])) {
    $handler = $routes['ANY ' . $uri];
} else {
    // Try simple POST/GET pair (e.g. POST /login might map to GET /login)
    $fallback = 'GET ' . $uri;
    if (isset($routes[$fallback])) {
        $handler = $routes[$fallback];
    } else {
        http_response_code(404);
        echo '<h1>404 Not Found</h1>';
        exit;
    }
}

// Resolve controller@method
if (is_string($handler) && str_contains($handler, '@')) {
    [$controller, $action] = explode('@', $handler, 2);
    if (!class_exists($controller)) { http_response_code(500); exit('Controller not found'); }
    $instance = new $controller();
    if (!method_exists($instance, $action)) { http_response_code(500); exit('Action not found'); }
    echo $instance->$action();
    exit;
}

// If closure
if (is_callable($handler)) {
    echo $handler();
    exit;
}

http_response_code(500);
echo 'Invalid route handler';

