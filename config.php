<?php
session_start();

$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('HTTP_URL', '/'. substr_replace(trim($_SERVER['REQUEST_URI'], '/'), '', 0, strlen($scriptName)));

define('SCRIPT', str_replace('\\', '/', rtrim(__DIR__, '/')) . '/');
define('SYSTEM', SCRIPT . 'System/');
define('CONTROLLERS', SCRIPT . 'Application/Controllers/');
define('MODELS', SCRIPT . 'Application/Models/');
define('VIEWS', SCRIPT . 'Application/Views/');
define('UPLOAD', SCRIPT . 'Upload/');

define('DATABASE', [
    'Port'   => '3306',
    'Host'   => 'localhost',
    'Driver' => 'PDO',
    'Name'   => 'pawnshop_db',
    'User'   => 'root',
    'Pass'   => '',
    'Prefix' => 'ps_'
]);

define('DB_PREFIX', 'ps_');
define('APP_NAME', 'Hệ Thống Quản Lý Cầm Đồ');
define('APP_VERSION', '1.0.0');
define('INTEREST_RATE', 3);
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('MAX_DAILY_PAYMENT_PERIODS', 500);
define('MAX_WEEKLY_PAYMENT_PERIODS', 200);
define('MAX_MONTHLY_PAYMENT_PERIODS', 120);
