<?php
// config/database.php - Veritabanı Bağlantı Konfigürasyonu

if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env');
} else {
    $env = [
        'DB_HOST' => $_ENV['DB_HOST'] ?? 'localhost',
        'DB_USER' => $_ENV['DB_USER'] ?? 'root',
        'DB_PASS' => $_ENV['DB_PASS'] ?? '',
        'DB_NAME' => $_ENV['DB_NAME'] ?? 'kalite_portal'
    ];
}

define('DB_HOST', $env['DB_HOST'] ?? 'localhost');
define('DB_USER', $env['DB_USER'] ?? 'root');
define('DB_PASS', $env['DB_PASS'] ?? '');
define('DB_NAME', $env['DB_NAME'] ?? 'kalite_portal');
define('DB_PORT', $env['DB_PORT'] ?? 3306);

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ':' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );
} catch (PDOException $e) {
    die(json_encode([
        'success' => false,
        'error' => 'Veritabanı Bağlantı Hatası: ' . $e->getMessage()
    ]));
}

return $pdo;
