<?php
namespace Models;

class MonCamModel extends \MVC\Model {
    protected $table = 'ps_mon_cam';

    public function getAll() {
        return $this->db->query("SELECT mc.*, hd.ma_hop_dong, kh.ho_ten as ten_khach FROM {$this->table} mc LEFT JOIN ps_hop_dong hd ON mc.hop_dong_id = hd.id LEFT JOIN ps_khach_hang kh ON hd.khach_hang_id = kh.id ORDER BY mc.id DESC");
    }

    public function getById($id) {
        $id = intval($id);
        $result = $this->db->query("SELECT mc.*, hd.ma_hop_dong FROM {$this->table} mc LEFT JOIN ps_hop_dong hd ON mc.hop_dong_id = hd.id WHERE mc.id = {$id} LIMIT 1");
        return $result ? $result[0] : null;
    }

    public function getByHopDong($hopDongId) {
        $hopDongId = intval($hopDongId);
        return $this->db->query("SELECT * FROM {$this->table} WHERE hop_dong_id = {$hopDongId} ORDER BY id ASC");
    }

    public function create($data) {
        $hopDongId = intval($data['hop_dong_id']);
        $tenMon = $this->db->escape($data['ten_mon']);
        $loaiMon = $this->db->escape($data['loai_mon'] ?? 'khac');
        $moTa = $this->db->escape($data['mo_ta'] ?? '');
        $soLuong = intval($data['so_luong'] ?? 1);
        $tinhTrang = $this->db->escape($data['tinh_trang'] ?? 'tot');
        $giaTriDinhGia = floatval($data['gia_tri_dinh_gia'] ?? 0);
        $now = date('Y-m-d H:i:s');

        $this->db->query("INSERT INTO {$this->table} (hop_dong_id, ten_mon, loai_mon, mo_ta, so_luong, tinh_trang, gia_tri_dinh_gia, created_at) VALUES ({$hopDongId}, '{$tenMon}', '{$loaiMon}', '{$moTa}', {$soLuong}, '{$tinhTrang}', {$giaTriDinhGia}, '{$now}')");
        return $this->db->getLastId();
    }

    public function update($id, $data) {
        $id = intval($id);
        $tenMon = $this->db->escape($data['ten_mon']);
        $loaiMon = $this->db->escape($data['loai_mon'] ?? 'khac');
        $moTa = $this->db->escape($data['mo_ta'] ?? '');
        $soLuong = intval($data['so_luong'] ?? 1);
        $tinhTrang = $this->db->escape($data['tinh_trang'] ?? 'tot');
        $giaTriDinhGia = floatval($data['gia_tri_dinh_gia'] ?? 0);
        $now = date('Y-m-d H:i:s');

        return $this->db->query("UPDATE {$this->table} SET ten_mon='{$tenMon}', loai_mon='{$loaiMon}', mo_ta='{$moTa}', so_luong={$soLuong}, tinh_trang='{$tinhTrang}', gia_tri_dinh_gia={$giaTriDinhGia}, updated_at='{$now}' WHERE id={$id}");
    }

    public function delete($id) {
        $id = intval($id);
        return $this->db->query("DELETE FROM {$this->table} WHERE id = {$id}");
    }
}
