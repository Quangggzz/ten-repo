<?php
namespace Database\DB;

class PDO {
    private $connection;

    public function __construct($config) {
        $host = $config['Host'] ?? 'localhost';
        $port = $config['Port'] ?? '3306';
        $name = $config['Name'] ?? '';
        $user = $config['User'] ?? 'root';
        $pass = $config['Pass'] ?? '';

        try {
            $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
            $this->connection = new \PDO($dsn, $user, $pass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]);
        } catch (\PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            
            $sqlUpper = strtoupper(trim($sql));
            if (strpos($sqlUpper, 'SELECT') === 0 || strpos($sqlUpper, 'SHOW') === 0) {
                return $stmt->fetchAll();
            }
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            error_log('Query error: ' . $e->getMessage() . ' SQL: ' . $sql);
            return false;
        }
    }

    public function escape($value) {
        $quoted = $this->connection->quote($value);
        return substr($quoted, 1, -1);
    }

    public function getLastId() {
        return $this->connection->lastInsertId();
    }
}
