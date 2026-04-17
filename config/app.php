<?php

declare(strict_types=1);

require_once ROOT_PATH . '/core/helpers.php';

loadEnv(ROOT_PATH . '/.env');

define('APP_NAME', (string) env('APP_NAME', 'Wincon Pilling Construction'));
define('APP_ENV', (string) env('APP_ENV', 'production'));
define('APP_URL', (string) env('APP_URL', 'http://localhost'));
define('APP_DEBUG', filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN));
define('APP_TIMEZONE', (string) env('APP_TIMEZONE', 'Africa/Lagos'));

$dbPath = (string) env('DB_PATH', 'database/wincon.db');
define('DB_PATH', $dbPath);

define('ADMIN_SETUP_TOKEN', (string) env('ADMIN_SETUP_TOKEN', ''));

define('SESSION_NAME', (string) env('SESSION_NAME', 'wincon_session'));
define('SESSION_LIFETIME', (int) env('SESSION_LIFETIME', 7200));

define('UPLOAD_MAX_SIZE', (int) env('UPLOAD_MAX_SIZE', 5242880));
define('ALLOWED_IMAGE_TYPES', (string) env('ALLOWED_IMAGE_TYPES', 'image/jpeg,image/png,image/webp'));

define('LOG_CHANNEL', (string) env('LOG_CHANNEL', 'file'));

date_default_timezone_set(APP_TIMEZONE);

if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
    ini_set('display_errors', '0');
}
