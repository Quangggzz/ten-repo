<?php
namespace Models;

class KhachHangModel extends \MVC\Model {
    protected $table = 'ps_khach_hang';

    public function getAll() {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
    }

    public function getById($id) {
        $id = intval($id);
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE id = {$id} LIMIT 1");
        return $result ? $result[0] : null;
    }

    public function search($keyword) {
        $param = '%' . $keyword . '%';
        return $this->db->query("SELECT * FROM {$this->table} WHERE ho_ten LIKE ? OR cmnd LIKE ? OR sdt LIKE ? ORDER BY id DESC", [$param, $param, $param]);
    }

    public function create($data) {
        $hoTen = $this->db->escape($data['ho_ten']);
        $cmnd = $this->db->escape($data['cmnd']);
        $sdt = $this->db->escape($data['sdt']);
        $diaChi = $this->db->escape($data['dia_chi'] ?? '');
        $ngaySinh = !empty($data['ngay_sinh']) ? "'" . $this->db->escape($data['ngay_sinh']) . "'" : 'NULL';
        $gioiTinh = $this->db->escape($data['gioi_tinh'] ?? 'nam');
        $now = date('Y-m-d H:i:s');

        return $this->db->query("INSERT INTO {$this->table} (ho_ten, cmnd, sdt, dia_chi, ngay_sinh, gioi_tinh, created_at) VALUES ('{$hoTen}', '{$cmnd}', '{$sdt}', '{$diaChi}', {$ngaySinh}, '{$gioiTinh}', '{$now}')");
    }

    public function update($id, $data) {
        $id = intval($id);
        $hoTen = $this->db->escape($data['ho_ten']);
        $cmnd = $this->db->escape($data['cmnd']);
        $sdt = $this->db->escape($data['sdt']);
        $diaChi = $this->db->escape($data['dia_chi'] ?? '');
        $ngaySinh = !empty($data['ngay_sinh']) ? "'" . $this->db->escape($data['ngay_sinh']) . "'" : 'NULL';
        $gioiTinh = $this->db->escape($data['gioi_tinh'] ?? 'nam');
        $now = date('Y-m-d H:i:s');

        return $this->db->query("UPDATE {$this->table} SET ho_ten='{$hoTen}', cmnd='{$cmnd}', sdt='{$sdt}', dia_chi='{$diaChi}', ngay_sinh={$ngaySinh}, gioi_tinh='{$gioiTinh}', updated_at='{$now}' WHERE id={$id}");
    }

    public function delete($id) {
        $id = intval($id);
        return $this->db->query("DELETE FROM {$this->table} WHERE id = {$id}");
    }

    public function countAll() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $result ? intval($result[0]['total']) : 0;
    }
}
