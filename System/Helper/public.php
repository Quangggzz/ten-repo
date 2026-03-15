<?php
function clean($data) {
    if (is_array($data)) {
        return array_map('clean', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function cleanUrl($url) {
    return filter_var(trim($url), FILTER_SANITIZE_URL);
}

function formatMoney($amount) {
    return number_format($amount, 0, ',', '.') . ' VNĐ';
}

function formatDate($date) {
    if (empty($date)) return '';
    $d = DateTime::createFromFormat('Y-m-d', $date);
    if ($d) return $d->format('d/m/Y');
    $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    if ($d) return $d->format('d/m/Y');
    return $date;
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function oldInput($key, $default = '') {
    return isset($_SESSION['old_input'][$key]) ? htmlspecialchars($_SESSION['old_input'][$key], ENT_QUOTES, 'UTF-8') : $default;
}

function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
