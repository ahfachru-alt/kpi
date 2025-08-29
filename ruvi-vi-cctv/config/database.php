<?php
class Database {
    private static ?PDO $pdo = null;

    public static function connection(): PDO {
        if (self::$pdo === null) {
            $dbHost = getenv('DB_HOST') ?: '127.0.0.1';
            $dbName = getenv('DB_NAME') ?: 'ruvi_vi_cctv';
            $dbUser = getenv('DB_USER') ?: 'root';
            $dbPass = getenv('DB_PASS') ?: '';
            $dbPort = getenv('DB_PORT') ?: '3306';

            $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            self::$pdo = new PDO($dsn, $dbUser, $dbPass, $options);
        }
        return self::$pdo;
    }
}

function db(): PDO {
    return Database::connection();
}

