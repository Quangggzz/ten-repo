<?php
spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    $file = SYSTEM . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }
    // Try direct path under System/
    $parts = explode('/', $className);
    if (count($parts) > 1) {
        $file2 = SYSTEM . implode('/', $parts) . '.php';
        if (file_exists($file2)) {
            require_once $file2;
        }
    }
});

require_once SYSTEM . 'Helper/public.php';
