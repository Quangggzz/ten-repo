<?php
namespace Router;

class Router {
    private $url;
    private $method;
    private $routes = [];

    public function __construct($url, $method) {
        $this->url = '/' . trim($url, '/');
        if ($this->url === '//') $this->url = '/';
        $this->method = strtoupper($method);
    }

    public function get($path, $callback) {
        $this->addRoute('GET', $path, $callback);
    }

    public function post($path, $callback) {
        $this->addRoute('POST', $path, $callback);
    }

    public function put($path, $callback) {
        $this->addRoute('PUT', $path, $callback);
    }

    public function delete($path, $callback) {
        $this->addRoute('DELETE', $path, $callback);
    }

    public function addRoute($method, $path, $callback) {
        $this->routes[] = new Route($method, $path, $callback);
    }

    public function run() {
        foreach ($this->routes as $route) {
            $params = $route->match($this->url, $this->method);
            if ($params !== false) {
                $this->dispatch($route->getCallback(), $params);
                return;
            }
        }
        http_response_code(404);
        echo '<h1>404 - Page Not Found</h1>';
    }

    private function dispatch($callback, $params = []) {
        if (is_callable($callback)) {
            call_user_func_array($callback, $params);
        } elseif (is_string($callback)) {
            $parts = explode('@', $callback);
            $controllerName = $parts[0];
            $methodName = isset($parts[1]) ? $parts[1] : 'index';

            $controllerFile = CONTROLLERS . $controllerName . 'Controller.php';
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
            }
            $fullClass = 'Controllers\\' . $controllerName . 'Controller';
            if (class_exists($fullClass)) {
                $controller = new $fullClass();
                call_user_func_array([$controller, $methodName], $params);
            } else {
                echo "Controller not found: $fullClass";
            }
        }
    }
}
