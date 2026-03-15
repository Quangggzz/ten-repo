<?php
namespace MVC;

use Database\DatabaseAdapter;

class Model {
    protected $db;

    public function __construct() {
        $this->db = new DatabaseAdapter(DATABASE);
    }

    public function findAll($table, $orderBy = 'id DESC') {
        // $orderBy is used internally with trusted values only
        return $this->db->query("SELECT * FROM {$table} ORDER BY {$orderBy}");
    }

    public function findById($table, $id) {
        $result = $this->db->query("SELECT * FROM {$table} WHERE id = ? LIMIT 1", [intval($id)]);
        return $result ? $result[0] : null;
    }

    public function deleteById($table, $id) {
        return $this->db->query("DELETE FROM {$table} WHERE id = ?", [intval($id)]);
    }

    public function count($table, $where = '1=1') {
        // $where must be a trusted, internally-constructed clause; never pass raw user input
        $result = $this->db->query("SELECT COUNT(*) as total FROM {$table} WHERE {$where}");
        return $result ? intval($result[0]['total']) : 0;
    }
}
