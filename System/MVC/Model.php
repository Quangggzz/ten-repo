<?php
namespace MVC;

use Database\DatabaseAdapter;

class Model {
    protected $db;

    public function __construct() {
        $this->db = new DatabaseAdapter(DATABASE);
    }

    public function findAll($table, $orderBy = 'id DESC') {
        return $this->db->query("SELECT * FROM {$table} ORDER BY {$orderBy}");
    }

    public function findById($table, $id) {
        $id = intval($id);
        $result = $this->db->query("SELECT * FROM {$table} WHERE id = {$id} LIMIT 1");
        return $result ? $result[0] : null;
    }

    public function deleteById($table, $id) {
        $id = intval($id);
        return $this->db->query("DELETE FROM {$table} WHERE id = {$id}");
    }

    public function count($table, $where = '1=1') {
        $result = $this->db->query("SELECT COUNT(*) as total FROM {$table} WHERE {$where}");
        return $result ? intval($result[0]['total']) : 0;
    }
}
