<?php
namespace Models;

class HopDongModel extends \MVC\Model {
    protected $table = 'ps_hop_dong';

    public function getAll() {
        return $this->db->query("SELECT hd.*, kh.ho_ten as ten_khach, kh.sdt,
            (SELECT COUNT(*) FROM ps_lich_thu_lai ltl WHERE ltl.hop_dong_id = hd.id AND ltl.trang_thai IN ('qua_han','chua_thu') AND ltl.ngay_thu_du_kien < CURDATE()) as so_ky_qua_han
            FROM {$this->table} hd
            LEFT JOIN ps_khach_hang kh ON hd.khach_hang_id = kh.id
            ORDER BY hd.id DESC");
    }

    public function getById($id) {
        $id = intval($id);
        $result = $this->db->query("SELECT hd.*, kh.ho_ten as ten_khach, kh.sdt, kh.cmnd, kh.dia_chi
            FROM {$this->table} hd
            LEFT JOIN ps_khach_hang kh ON hd.khach_hang_id = kh.id
            WHERE hd.id = {$id} LIMIT 1");
        return $result ? $result[0] : null;
    }

    public function create($data) {
        $maHopDong = $this->db->escape($data['ma_hop_dong']);
        $khachHangId = intval($data['khach_hang_id']);
        $ngayCam = $this->db->escape($data['ngay_cam']);
        $ngayDaoHan = $this->db->escape($data['ngay_dao_han']);
        $soTienCam = floatval($data['so_tien_cam']);
        $laiSuat = floatval($data['lai_suat'] ?? 3);
        $tienLai = floatval($data['tien_lai'] ?? 0);
        $tongTienChuoc = floatval($data['tong_tien_chuoc'] ?? 0);
        $chuKy = $this->db->escape($data['chu_ky_thu_lai'] ?? 'hang_thang');
        $ngayBatDau = !empty($data['ngay_bat_dau_thu_lai']) ? "'" . $this->db->escape($data['ngay_bat_dau_thu_lai']) . "'" : 'NULL';
        $ghiChu = $this->db->escape($data['ghi_chu'] ?? '');
        $now = date('Y-m-d H:i:s');

        $this->db->query("INSERT INTO {$this->table} (ma_hop_dong, khach_hang_id, ngay_cam, ngay_dao_han, so_tien_cam, lai_suat, tien_lai, tong_tien_chuoc, chu_ky_thu_lai, ngay_bat_dau_thu_lai, ghi_chu, created_at) VALUES ('{$maHopDong}', {$khachHangId}, '{$ngayCam}', '{$ngayDaoHan}', {$soTienCam}, {$laiSuat}, {$tienLai}, {$tongTienChuoc}, '{$chuKy}', {$ngayBatDau}, '{$ghiChu}', '{$now}')");
        return $this->db->getLastId();
    }

    public function update($id, $data) {
        $id = intval($id);
        $khachHangId = intval($data['khach_hang_id']);
        $ngayCam = $this->db->escape($data['ngay_cam']);
        $ngayDaoHan = $this->db->escape($data['ngay_dao_han']);
        $soTienCam = floatval($data['so_tien_cam']);
        $laiSuat = floatval($data['lai_suat'] ?? 3);
        $tienLai = floatval($data['tien_lai'] ?? 0);
        $tongTienChuoc = floatval($data['tong_tien_chuoc'] ?? 0);
        $chuKy = $this->db->escape($data['chu_ky_thu_lai'] ?? 'hang_thang');
        $ngayBatDau = !empty($data['ngay_bat_dau_thu_lai']) ? "'" . $this->db->escape($data['ngay_bat_dau_thu_lai']) . "'" : 'NULL';
        $ghiChu = $this->db->escape($data['ghi_chu'] ?? '');
        $now = date('Y-m-d H:i:s');

        return $this->db->query("UPDATE {$this->table} SET khach_hang_id={$khachHangId}, ngay_cam='{$ngayCam}', ngay_dao_han='{$ngayDaoHan}', so_tien_cam={$soTienCam}, lai_suat={$laiSuat}, tien_lai={$tienLai}, tong_tien_chuoc={$tongTienChuoc}, chu_ky_thu_lai='{$chuKy}', ngay_bat_dau_thu_lai={$ngayBatDau}, ghi_chu='{$ghiChu}', updated_at='{$now}' WHERE id={$id}");
    }

    public function updateTrangThai($id, $status) {
        $id = intval($id);
        $status = $this->db->escape($status);
        $now = date('Y-m-d H:i:s');
        return $this->db->query("UPDATE {$this->table} SET trang_thai='{$status}', updated_at='{$now}' WHERE id={$id}");
    }

    public function updateTongDaThu($hopDongId) {
        $hopDongId = intval($hopDongId);
        $result = $this->db->query("SELECT
            SUM(CASE WHEN loai_thu = 'thu_lai' THEN so_tien ELSE 0 END) as tong_lai,
            SUM(CASE WHEN loai_thu IN ('thu_goc','thu_chuoc') THEN so_tien ELSE 0 END) as tong_goc
            FROM ps_lich_su_thu_tien WHERE hop_dong_id = {$hopDongId}");
        if ($result) {
            $tongLai = floatval($result[0]['tong_lai'] ?? 0);
            $tongGoc = floatval($result[0]['tong_goc'] ?? 0);
            $now = date('Y-m-d H:i:s');
            return $this->db->query("UPDATE {$this->table} SET tong_lai_da_thu={$tongLai}, tong_goc_da_thu={$tongGoc}, updated_at='{$now}' WHERE id={$hopDongId}");
        }
        return false;
    }

    public function delete($id) {
        $id = intval($id);
        return $this->db->query("DELETE FROM {$this->table} WHERE id = {$id}");
    }

    public function generateMaHopDong() {
        $prefix = 'HD' . date('Ymd');
        $result = $this->db->query("SELECT ma_hop_dong FROM {$this->table} WHERE ma_hop_dong LIKE '{$prefix}%' ORDER BY ma_hop_dong DESC LIMIT 1");
        if ($result && count($result) > 0) {
            $last = $result[0]['ma_hop_dong'];
            $seq = intval(substr($last, -4)) + 1;
        } else {
            $seq = 1;
        }
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    public function getThongKe() {
        $tongHD = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $dangCam = $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE trang_thai = 'dang_cam'");
        $daChuoc = $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE trang_thai = 'da_chuoc'");
        $tongTienCam = $this->db->query("SELECT SUM(so_tien_cam) as total FROM {$this->table} WHERE trang_thai = 'dang_cam'");
        $tongLai = $this->db->query("SELECT SUM(tong_lai_da_thu) as total FROM {$this->table}");

        return [
            'tong_hop_dong' => $tongHD ? intval($tongHD[0]['total']) : 0,
            'dang_cam' => $dangCam ? intval($dangCam[0]['total']) : 0,
            'da_chuoc' => $daChuoc ? intval($daChuoc[0]['total']) : 0,
            'tong_tien_cam' => $tongTienCam ? floatval($tongTienCam[0]['total'] ?? 0) : 0,
            'tong_lai_da_thu' => $tongLai ? floatval($tongLai[0]['total'] ?? 0) : 0,
        ];
    }

    public function getHopDongQuaHan() {
        return $this->db->query("SELECT hd.*, kh.ho_ten as ten_khach, kh.sdt
            FROM {$this->table} hd
            LEFT JOIN ps_khach_hang kh ON hd.khach_hang_id = kh.id
            WHERE hd.ngay_dao_han < CURDATE() AND hd.trang_thai = 'dang_cam'
            ORDER BY hd.ngay_dao_han ASC");
    }
}
