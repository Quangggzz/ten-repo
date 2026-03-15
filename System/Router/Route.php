<?php
namespace Router;

class Route {
    private $method;
    private $path;
    private $callback;

    public function __construct($method, $path, $callback) {
        $this->method = strtoupper($method);
        $this->path = $path;
        $this->callback = $callback;
    }

    public function match($url, $method) {
        if ($this->method !== strtoupper($method)) return false;

        $pattern = preg_replace('/\/:([^\/]+)/', '/([^/]+)', $this->path);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $url, $matches)) {
            array_shift($matches);
            return $matches;
        }
        return false;
    }

    public function getCallback() {
        return $this->callback;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getPath() {
        return $this->path;
    }
}
