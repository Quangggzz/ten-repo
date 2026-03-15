<?php
namespace Models;

class LichThuLaiModel extends \MVC\Model {
    protected $table = 'ps_lich_thu_lai';

    public function getByHopDong($hopDongId) {
        $hopDongId = intval($hopDongId);
        return $this->db->query("SELECT * FROM {$this->table} WHERE hop_dong_id = {$hopDongId} ORDER BY ky_thu ASC");
    }

    public function getById($id) {
        $id = intval($id);
        $result = $this->db->query("SELECT ltl.*, hd.ma_hop_dong, hd.so_tien_cam, hd.lai_suat, kh.ho_ten as ten_khach, kh.sdt
            FROM {$this->table} ltl
            LEFT JOIN ps_hop_dong hd ON ltl.hop_dong_id = hd.id
            LEFT JOIN ps_khach_hang kh ON hd.khach_hang_id = kh.id
            WHERE ltl.id = {$id} LIMIT 1");
        return $result ? $result[0] : null;
    }

    public function taoLichThuLai($hopDongId, $ngayCam, $ngayDaoHan, $soTienCam, $laiSuat, $chuKy, $ngayBatDau) {
        $hopDongId = intval($hopDongId);
        $soTienCam = floatval($soTienCam);
        $laiSuat = floatval($laiSuat);
        $monthlyRate = $laiSuat / 100;
        $now = date('Y-m-d H:i:s');

        // Delete existing schedule
        $this->db->query("DELETE FROM {$this->table} WHERE hop_dong_id = {$hopDongId}");

        $records = [];
        $startDate = new \DateTime($ngayBatDau ?: $ngayCam);
        $endDate = new \DateTime($ngayDaoHan);
        $ky = 1;

        switch ($chuKy) {
            case 'hang_ngay':
                $dailyRate = $soTienCam * $monthlyRate / 30;
                $current = clone $startDate;
                while ($current <= $endDate) {
                    $records[] = [$hopDongId, $ky++, $current->format('Y-m-d'), round($dailyRate, 0)];
                    $current->modify('+1 day');
                    if ($ky > 500) break;
                }
                break;

            case 'hang_tuan':
                $weeklyRate = $soTienCam * $monthlyRate / 4;
                $current = clone $startDate;
                while ($current <= $endDate) {
                    $records[] = [$hopDongId, $ky++, $current->format('Y-m-d'), round($weeklyRate, 0)];
                    $current->modify('+7 days');
                    if ($ky > 200) break;
                }
                break;

            case 'hang_thang':
                $monthlyInterest = $soTienCam * $monthlyRate;
                $current = clone $startDate;
                while ($current <= $endDate) {
                    $records[] = [$hopDongId, $ky++, $current->format('Y-m-d'), round($monthlyInterest, 0)];
                    $current->modify('+1 month');
                    if ($ky > 120) break;
                }
                break;

            case 'cuoi_ky':
                $start = new \DateTime($ngayCam);
                $diff = $start->diff($endDate);
                $months = $diff->m + ($diff->y * 12);
                if ($diff->d > 0) $months++;
                if ($months < 1) $months = 1;
                $totalInterest = $soTienCam * $monthlyRate * $months;
                $records[] = [$hopDongId, 1, $endDate->format('Y-m-d'), round($totalInterest, 0)];
                break;
        }

        foreach ($records as $rec) {
            $this->db->query("INSERT INTO {$this->table} (hop_dong_id, ky_thu, ngay_thu_du_kien, so_tien_lai, created_at) VALUES ({$rec[0]}, {$rec[1]}, '{$rec[2]}', {$rec[3]}, '{$now}')");
        }

        return count($records);
    }

    public function capNhatThu($id, $amount, $date, $collector, $note) {
        $id = intval($id);
        $amount = floatval($amount);
        $date = $this->db->escape($date);
        $collector = $this->db->escape($collector);
        $note = $this->db->escape($note);
        $now = date('Y-m-d H:i:s');

        $ky = $this->getById($id);
        if (!$ky) return false;

        $soTienLai = floatval($ky['so_tien_lai']);
        $daThu = floatval($ky['so_tien_da_thu']) + $amount;
        
        if ($daThu >= $soTienLai) {
            $trangThai = 'da_thu';
        } else {
            $trangThai = 'thu_mot_phan';
        }

        return $this->db->query("UPDATE {$this->table} SET so_tien_da_thu={$daThu}, trang_thai='{$trangThai}', ngay_thu_thuc_te='{$date}', nguoi_thu='{$collector}', ghi_chu='{$note}', updated_at='{$now}' WHERE id={$id}");
    }

    public function capNhatQuaHan() {
        $now = date('Y-m-d H:i:s');
        return $this->db->query("UPDATE {$this->table} SET trang_thai='qua_han', updated_at='{$now}' WHERE ngay_thu_du_kien < CURDATE() AND trang_thai IN ('chua_thu','thu_mot_phan')");
    }

    public function getSapDenHan($days = 7) {
        $days = intval($days);
        return $this->db->query("SELECT ltl.*, hd.ma_hop_dong, kh.ho_ten as ten_khach, kh.sdt
            FROM {$this->table} ltl
            LEFT JOIN ps_hop_dong hd ON ltl.hop_dong_id = hd.id
            LEFT JOIN ps_khach_hang kh ON hd.khach_hang_id = kh.id
            WHERE ltl.ngay_thu_du_kien BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL {$days} DAY)
            AND ltl.trang_thai IN ('chua_thu','thu_mot_phan')
            ORDER BY ltl.ngay_thu_du_kien ASC");
    }

    public function getQuaHanChuaThu() {
        return $this->db->query("SELECT ltl.*, hd.ma_hop_dong, kh.ho_ten as ten_khach, kh.sdt
            FROM {$this->table} ltl
            LEFT JOIN ps_hop_dong hd ON ltl.hop_dong_id = hd.id
            LEFT JOIN ps_khach_hang kh ON hd.khach_hang_id = kh.id
            WHERE ltl.trang_thai IN ('qua_han','chua_thu') AND ltl.ngay_thu_du_kien < CURDATE()
            ORDER BY ltl.ngay_thu_du_kien ASC");
    }

    public function tongHopByHopDong($hopDongId) {
        $hopDongId = intval($hopDongId);
        $result = $this->db->query("SELECT
            COUNT(*) as tong_ky,
            SUM(so_tien_lai) as tong_lai_phai_thu,
            SUM(so_tien_da_thu) as tong_lai_da_thu,
            SUM(CASE WHEN trang_thai = 'da_thu' THEN 1 ELSE 0 END) as so_ky_da_thu,
            SUM(CASE WHEN trang_thai IN ('qua_han','chua_thu') AND ngay_thu_du_kien < CURDATE() THEN 1 ELSE 0 END) as so_ky_qua_han
            FROM {$this->table} WHERE hop_dong_id = {$hopDongId}");
        return $result ? $result[0] : null;
    }

    public function xoaByHopDong($hopDongId) {
        $hopDongId = intval($hopDongId);
        return $this->db->query("DELETE FROM {$this->table} WHERE hop_dong_id = {$hopDongId}");
    }
}
