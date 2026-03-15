<?php
namespace Models;

class UserModel extends \MVC\Model {
    protected $table = 'ps_users';

    public function authenticate($username, $password) {
        $username = $this->db->escape($username);
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE username = '{$username}' LIMIT 1");
        if ($result && count($result) > 0) {
            $user = $result[0];
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    public function getById($id) {
        $id = intval($id);
        $result = $this->db->query("SELECT id, username, ho_ten, email, role, created_at FROM {$this->table} WHERE id = {$id} LIMIT 1");
        return $result ? $result[0] : null;
    }
}
