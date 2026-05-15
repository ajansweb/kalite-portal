<?php
// config/app.php - Uygulama Konfigürasyonu

return [
    'name' => 'Kalite Standartları Portalı',
    'version' => '1.0.0',
    'environment' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => $_ENV['APP_DEBUG'] ?? false,
    'url' => $_ENV['APP_URL'] ?? 'http://localhost:8000',
    'timezone' => $_ENV['TIMEZONE'] ?? 'Europe/Istanbul',
    
    'database' => [
        'driver' => 'mysql',
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => $_ENV['DB_PORT'] ?? 3306,
        'database' => $_ENV['DB_NAME'] ?? 'kalite_portal',
        'username' => $_ENV['DB_USER'] ?? 'root',
        'password' => $_ENV['DB_PASS'] ?? '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci'
    ],
    
    'upload' => [
        'max_size' => $_ENV['MAX_UPLOAD_SIZE'] ?? 52428800,
        'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'pdf'],
        'directory' => __DIR__ . '/../uploads'
    ],
    
    'session' => [
        'lifetime' => $_ENV['SESSION_LIFETIME'] ?? 3600,
        'timeout' => 1800,
        'path' => '/'
    ]
];
