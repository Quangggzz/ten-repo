<?php
namespace MVC;

class Controller {
    protected $request;
    protected $response;

    public function __construct() {
        $this->request = $GLOBALS['request'] ?? null;
        $this->response = $GLOBALS['response'] ?? null;
    }

    protected function model($model) {
        $modelFile = MODELS . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
        }
        $className = 'Models\\' . $model;
        if (class_exists($className)) {
            return new $className();
        }
        return null;
    }

    protected function view($view, $data = []) {
        extract($data);
        $viewFile = VIEWS . $view . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "View not found: $view";
        }
    }

    protected function render($view, $data = []) {
        extract($data);
        $viewFile = VIEWS . $view . '.php';
        $content = '';
        if (file_exists($viewFile)) {
            ob_start();
            require $viewFile;
            $content = ob_get_clean();
        } else {
            $content = "View not found: $view";
        }
        require VIEWS . 'layouts/header.php';
        require VIEWS . 'layouts/sidebar.php';
        echo $content;
        require VIEWS . 'layouts/footer.php';
    }

    protected function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function send($status, $msg) {
        http_response_code($status);
        echo $msg;
        exit;
    }
}
