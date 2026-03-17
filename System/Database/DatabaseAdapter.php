<?php
namespace Database;

class DatabaseAdapter {
    private $driver;

    public function __construct($config) {
        $driverName = $config['Driver'] ?? 'PDO';
        $driverClass = 'Database\\DB\\' . $driverName;
        
        $driverFile = SYSTEM . 'Database/DB/' . $driverName . '.php';
        if (file_exists($driverFile)) {
            require_once $driverFile;
        }
        
        if (class_exists($driverClass)) {
            $this->driver = new $driverClass($config);
        } else {
            throw new \Exception("Database driver not found: $driverClass");
        }
    }

    public function query($sql, $params = []) {
        return $this->driver->query($sql, $params);
    }

    public function escape($value) {
        return $this->driver->escape($value);
    }

    public function getLastId() {
        return $this->driver->getLastId();
    }
}
