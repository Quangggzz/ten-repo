<?php
namespace Http;

class Request {
    public function get($key = null, $default = null) {
        if ($key === null) return $_GET;
        return isset($_GET[$key]) ? $this->clean($_GET[$key]) : $default;
    }

    public function post($key = null, $default = null) {
        if ($key === null) return $_POST;
        return isset($_POST[$key]) ? $this->clean($_POST[$key]) : $default;
    }

    public function input($key = null, $default = null) {
        $data = array_merge($_GET, $_POST);
        if ($key === null) return $data;
        return isset($data[$key]) ? $this->clean($data[$key]) : $default;
    }

    public function server($key = null, $default = null) {
        if ($key === null) return $_SERVER;
        return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
    }

    public function getMethod() {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public function getClientIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    public function getUrl() {
        return HTTP_URL;
    }

    public function clean($data) {
        if (is_array($data)) {
            return array_map([$this, 'clean'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }
}
