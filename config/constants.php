<?php
// config/constants.php - Uygulama Sabitleri

// Uygulama
define('APP_NAME', 'Kalite Standartları Portalı');
define('APP_VERSION', '1.0.0');
define('APP_ENV', $_ENV['APP_ENV'] ?? 'production');
define('APP_DEBUG', $_ENV['APP_DEBUG'] ?? false);
define('APP_SECRET', $_ENV['APP_SECRET'] ?? 'change-this-secret-key');
define('APP_TIMEZONE', $_ENV['TIMEZONE'] ?? 'Europe/Istanbul');
date_default_timezone_set(APP_TIMEZONE);

// Upload
define('MAX_UPLOAD_SIZE', $_ENV['MAX_UPLOAD_SIZE'] ?? 52428800); // 50MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'pdf']);
define('UPLOAD_DIR', __DIR__ . '/../uploads');
define('PHOTOS_DIR', UPLOAD_DIR . '/photos');
define('REPORTS_DIR', UPLOAD_DIR . '/reports');
define('LABELS_DIR', UPLOAD_DIR . '/labels');

// Session
define('SESSION_LIFETIME', $_ENV['SESSION_LIFETIME'] ?? 3600);
define('SESSION_TIMEOUT', 1800); // 30 dakika inaktivite

// Markalar
define('BRANDS', [
    'ABB' => 'ABB Group',
    'Siemens' => 'Siemens AG',
    'Schneider' => 'Schneider Electric',
    'Legrand' => 'Legrand Group',
    'EATON' => 'Eaton Corporation',
    'Phoenix' => 'Phoenix Contact'
]);

// Renkler
define('LABEL_COLORS', [
    'red' => '#ef4444',
    'yellow' => '#facc15',
    'green' => '#22c55e',
    'blue' => '#3b82f6',
    'white' => '#ffffff',
    'orange' => '#f97316',
    'purple' => '#a855f7'
]);

// Durum Kodları
define('STATUS_DRAFT', 'draft');
define('STATUS_ACTIVE', 'active');
define('STATUS_COMPLETED', 'completed');
define('STATUS_ARCHIVED', 'archived');
define('STATUS_PUBLISHED', 'published');

// Roller
define('ROLE_ADMIN', 'admin');
define('ROLE_SUPERVISOR', 'supervisor');
define('ROLE_USER', 'user');

// Kontrol Öğeleri
define('CHECKS', [
    'safety' => ['label' => 'Güvenlik Kontrolleri Yapıldı', 'desc' => 'Topraklama, yalıtım, koruma sistemleri kontrol edildi'],
    'connections' => ['label' => 'Tüm Bağlantılar Sıkı', 'desc' => 'Terminal bağlantıları, kablolar kontrol edildi'],
    'wiring' => ['label' => 'Kablolama Standartlara Uygun', 'desc' => 'DIN 43380 standartlara göre kontrol'],
    'labeling' => ['label' => 'Etiketleme Tamamlandı', 'desc' => 'Tüm devreler ve bileşenler etiketlendi'],
    'documentation' => ['label' => 'Dokümantasyon Eksiksiz', 'desc' => 'Teknik resimler ve şemalar eksik değil'],
    'testing' => ['label' => 'Ön Test Tamamlandı', 'desc' => 'Voltaj ve akım testleri yapıldı']
]);

// Paging
define('DEFAULT_PAGE_SIZE', 15);
define('MAX_PAGE_SIZE', 100);

// API
define('API_RATE_LIMIT', 100); // İstek/saat
