<?php
namespace Models;

class LichSuThuTienModel extends \MVC\Model {
    protected $table = 'ps_lich_su_thu_tien';

    public function getAll($limit = 50) {
        $limit = intval($limit);
        return $this->db->query("SELECT lstt.*, hd.ma_hop_dong, kh.ho_ten as ten_khach
            FROM {$this->table} lstt
            LEFT JOIN ps_hop_dong hd ON lstt.hop_dong_id = hd.id
            LEFT JOIN ps_khach_hang kh ON hd.khach_hang_id = kh.id
            ORDER BY lstt.id DESC LIMIT {$limit}");
    }

    public function getByHopDong($hopDongId) {
        $hopDongId = intval($hopDongId);
        return $this->db->query("SELECT * FROM {$this->table} WHERE hop_dong_id = {$hopDongId} ORDER BY id DESC");
    }

    public function getById($id) {
        $id = intval($id);
        $result = $this->db->query("SELECT lstt.*, hd.ma_hop_dong, kh.ho_ten as ten_khach, kh.sdt, kh.dia_chi
            FROM {$this->table} lstt
            LEFT JOIN ps_hop_dong hd ON lstt.hop_dong_id = hd.id
            LEFT JOIN ps_khach_hang kh ON hd.khach_hang_id = kh.id
            WHERE lstt.id = {$id} LIMIT 1");
        return $result ? $result[0] : null;
    }

    public function create($data) {
        $hopDongId = intval($data['hop_dong_id']);
        $lichThuLaiId = !empty($data['lich_thu_lai_id']) ? intval($data['lich_thu_lai_id']) : 'NULL';
        $loaiThu = $this->db->escape($data['loai_thu'] ?? 'thu_lai');
        $soTien = floatval($data['so_tien']);
        $phuongThuc = $this->db->escape($data['phuong_thuc'] ?? 'tien_mat');
        $ngayThu = $this->db->escape($data['ngay_thu']);
        $nguoiThu = $this->db->escape($data['nguoi_thu'] ?? '');
        $nguoiNop = $this->db->escape($data['nguoi_nop'] ?? '');
        $maPhieuThu = $this->db->escape($this->generateMaPhieuThu());
        $ghiChu = $this->db->escape($data['ghi_chu'] ?? '');
        $now = date('Y-m-d H:i:s');

        $this->db->query("INSERT INTO {$this->table} (hop_dong_id, lich_thu_lai_id, loai_thu, so_tien, phuong_thuc, ngay_thu, nguoi_thu, nguoi_nop, ma_phieu_thu, ghi_chu, created_at) VALUES ({$hopDongId}, {$lichThuLaiId}, '{$loaiThu}', {$soTien}, '{$phuongThuc}', '{$ngayThu}', '{$nguoiThu}', '{$nguoiNop}', '{$maPhieuThu}', '{$ghiChu}', '{$now}')");
        return $this->db->getLastId();
    }

    public function generateMaPhieuThu() {
        $prefix = 'PT' . date('Ymd');
        $result = $this->db->query("SELECT ma_phieu_thu FROM {$this->table} WHERE ma_phieu_thu LIKE '{$prefix}%' ORDER BY ma_phieu_thu DESC LIMIT 1");
        if ($result && count($result) > 0) {
            $last = $result[0]['ma_phieu_thu'];
            $seq = intval(substr($last, -4)) + 1;
        } else {
            $seq = 1;
        }
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    public function thongKeTheoNgay($from, $to) {
        $from = $this->db->escape($from);
        $to = $this->db->escape($to);
        return $this->db->query("SELECT DATE(ngay_thu) as ngay, SUM(so_tien) as tong_thu, COUNT(*) as so_phieu
            FROM {$this->table}
            WHERE ngay_thu BETWEEN '{$from}' AND '{$to}'
            GROUP BY DATE(ngay_thu)
            ORDER BY ngay DESC");
    }

    public function tongThuByHopDong($hopDongId) {
        $hopDongId = intval($hopDongId);
        $result = $this->db->query("SELECT SUM(so_tien) as tong FROM {$this->table} WHERE hop_dong_id = {$hopDongId}");
        return $result ? floatval($result[0]['tong'] ?? 0) : 0;
    }

    public function tongThuHomNay() {
        $result = $this->db->query("SELECT SUM(so_tien) as tong FROM {$this->table} WHERE DATE(ngay_thu) = CURDATE()");
        return $result ? floatval($result[0]['tong'] ?? 0) : 0;
    }

    public function tongThuThangNay() {
        $result = $this->db->query("SELECT SUM(so_tien) as tong FROM {$this->table} WHERE MONTH(ngay_thu) = MONTH(CURDATE()) AND YEAR(ngay_thu) = YEAR(CURDATE())");
        return $result ? floatval($result[0]['tong'] ?? 0) : 0;
    }

    public function filter($filters) {
        $where = '1=1';
        if (!empty($filters['loai_thu'])) {
            $loai = $this->db->escape($filters['loai_thu']);
            $where .= " AND lstt.loai_thu = '{$loai}'";
        }
        if (!empty($filters['tu_ngay'])) {
            $tuNgay = $this->db->escape($filters['tu_ngay']);
            $where .= " AND lstt.ngay_thu >= '{$tuNgay}'";
        }
        if (!empty($filters['den_ngay'])) {
            $denNgay = $this->db->escape($filters['den_ngay']);
            $where .= " AND lstt.ngay_thu <= '{$denNgay}'";
        }
        if (!empty($filters['phuong_thuc'])) {
            $phuongThuc = $this->db->escape($filters['phuong_thuc']);
            $where .= " AND lstt.phuong_thuc = '{$phuongThuc}'";
        }
        return $this->db->query("SELECT lstt.*, hd.ma_hop_dong, kh.ho_ten as ten_khach
            FROM {$this->table} lstt
            LEFT JOIN ps_hop_dong hd ON lstt.hop_dong_id = hd.id
            LEFT JOIN ps_khach_hang kh ON hd.khach_hang_id = kh.id
            WHERE {$where}
            ORDER BY lstt.id DESC");
    }
}
