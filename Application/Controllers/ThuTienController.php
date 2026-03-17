<?php
namespace Controllers;

class ThuTienController extends \MVC\Controller {
    public function __construct() {
        parent::__construct();
        if (!isLoggedIn()) redirect('/login');
    }

    public function index() {
        require_once MODELS . 'LichSuThuTien.php';

        $lichSuModel = new \Models\LichSuThuTienModel();
        $filters = [];
        if (!empty($_GET['loai_thu'])) $filters['loai_thu'] = $_GET['loai_thu'];
        if (!empty($_GET['tu_ngay'])) $filters['tu_ngay'] = $_GET['tu_ngay'];
        if (!empty($_GET['den_ngay'])) $filters['den_ngay'] = $_GET['den_ngay'];
        if (!empty($_GET['phuong_thuc'])) $filters['phuong_thuc'] = $_GET['phuong_thuc'];

        $lichSu = empty($filters) ? $lichSuModel->getAll(100) : $lichSuModel->filter($filters);
        $tongHomNay = $lichSuModel->tongThuHomNay();
        $tongThangNay = $lichSuModel->tongThuThangNay();

        $this->render('thutien/index', [
            'lichSu' => $lichSu ?: [],
            'tongHomNay' => $tongHomNay,
            'tongThangNay' => $tongThangNay,
            'filters' => $filters,
            'pageTitle' => 'Lịch Sử Thu Tiền',
        ]);
    }

    public function lichThuLai() {
        require_once MODELS . 'LichThuLai.php';
        $lichThuLaiModel = new \Models\LichThuLaiModel();
        $lichThuLaiModel->capNhatQuaHan();

        $sapDenHan = $lichThuLaiModel->getSapDenHan(7) ?: [];
        $quaHan = $lichThuLaiModel->getQuaHanChuaThu() ?: [];

        $this->render('thutien/lich_thu_lai', [
            'sapDenHan' => $sapDenHan,
            'quaHan' => $quaHan,
            'pageTitle' => 'Lịch Thu Lãi',
        ]);
    }

    public function thuLai($lichThuLaiId) {
        require_once MODELS . 'LichThuLai.php';
        $lichThuLaiModel = new \Models\LichThuLaiModel();
        $ky = $lichThuLaiModel->getById($lichThuLaiId);

        if (!$ky) {
            setFlash('error', 'Không tìm thấy kỳ thu');
            redirect('/thu-tien/lich-thu-lai');
            return;
        }

        $this->render('thutien/thu_lai', [
            'ky' => $ky,
            'pageTitle' => 'Thu Lãi',
        ]);
    }

    public function xuLyThuLai($lichThuLaiId) {
        require_once MODELS . 'LichThuLai.php';
        require_once MODELS . 'LichSuThuTien.php';
        require_once MODELS . 'HopDong.php';

        $lichThuLaiModel = new \Models\LichThuLaiModel();
        $lichSuModel = new \Models\LichSuThuTienModel();
        $hopDongModel = new \Models\HopDongModel();

        $ky = $lichThuLaiModel->getById($lichThuLaiId);
        if (!$ky) {
            setFlash('error', 'Không tìm thấy kỳ thu');
            redirect('/thu-tien/lich-thu-lai');
            return;
        }

        $soTien = floatval($_POST['so_tien'] ?? 0);
        $ngayThu = $_POST['ngay_thu'] ?? date('Y-m-d');
        $phuongThuc = $_POST['phuong_thuc'] ?? 'tien_mat';
        $ghiChu = trim($_POST['ghi_chu'] ?? '');

        if ($soTien <= 0) {
            setFlash('error', 'Số tiền phải lớn hơn 0');
            redirect('/thu-tien/thu-lai/' . $lichThuLaiId);
            return;
        }

        // Create receipt
        $receiptId = $lichSuModel->create([
            'hop_dong_id' => $ky['hop_dong_id'],
            'lich_thu_lai_id' => $lichThuLaiId,
            'loai_thu' => 'thu_lai',
            'so_tien' => $soTien,
            'phuong_thuc' => $phuongThuc,
            'ngay_thu' => $ngayThu,
            'nguoi_thu' => $_SESSION['ho_ten'] ?? '',
            'nguoi_nop' => $ky['ten_khach'] ?? '',
            'ghi_chu' => $ghiChu,
        ]);

        // Update period
        $lichThuLaiModel->capNhatThu($lichThuLaiId, $soTien, $ngayThu, $_SESSION['ho_ten'] ?? '', $ghiChu);

        // Update contract totals
        $hopDongModel->updateTongDaThu($ky['hop_dong_id']);

        setFlash('success', 'Thu lãi thành công');
        redirect('/thu-tien/chi-tiet/' . $receiptId);
    }

    public function thuTienForm($hopDongId) {
        require_once MODELS . 'HopDong.php';
        $hopDongModel = new \Models\HopDongModel();
        $hopDong = $hopDongModel->getById($hopDongId);

        if (!$hopDong) {
            setFlash('error', 'Không tìm thấy hợp đồng');
            redirect('/hop-dong');
            return;
        }

        $this->render('thutien/thu_tien_form', [
            'hopDong' => $hopDong,
            'pageTitle' => 'Thu Tiền',
        ]);
    }

    public function xuLyThuTien($hopDongId) {
        require_once MODELS . 'LichSuThuTien.php';
        require_once MODELS . 'HopDong.php';

        $lichSuModel = new \Models\LichSuThuTienModel();
        $hopDongModel = new \Models\HopDongModel();

        $hopDong = $hopDongModel->getById($hopDongId);
        if (!$hopDong) {
            setFlash('error', 'Không tìm thấy hợp đồng');
            redirect('/hop-dong');
            return;
        }

        $soTien = floatval($_POST['so_tien'] ?? 0);
        $loaiThu = $_POST['loai_thu'] ?? 'thu_lai';
        $ngayThu = $_POST['ngay_thu'] ?? date('Y-m-d');
        $phuongThuc = $_POST['phuong_thuc'] ?? 'tien_mat';
        $ghiChu = trim($_POST['ghi_chu'] ?? '');

        if ($soTien <= 0) {
            setFlash('error', 'Số tiền phải lớn hơn 0');
            redirect('/thu-tien/thu-tien-form/' . $hopDongId);
            return;
        }

        $receiptId = $lichSuModel->create([
            'hop_dong_id' => $hopDongId,
            'loai_thu' => $loaiThu,
            'so_tien' => $soTien,
            'phuong_thuc' => $phuongThuc,
            'ngay_thu' => $ngayThu,
            'nguoi_thu' => $_SESSION['ho_ten'] ?? '',
            'nguoi_nop' => $hopDong['ten_khach'] ?? '',
            'ghi_chu' => $ghiChu,
        ]);

        $hopDongModel->updateTongDaThu($hopDongId);

        if ($loaiThu === 'thu_chuoc') {
            $hopDongModel->updateTrangThai($hopDongId, 'da_chuoc');
        }

        setFlash('success', 'Thu tiền thành công');
        redirect('/thu-tien/chi-tiet/' . $receiptId);
    }

    public function chiTietPhieu($id) {
        require_once MODELS . 'LichSuThuTien.php';
        $lichSuModel = new \Models\LichSuThuTienModel();
        $phieu = $lichSuModel->getById($id);

        if (!$phieu) {
            setFlash('error', 'Không tìm thấy phiếu thu');
            redirect('/thu-tien');
            return;
        }

        $this->view('thutien/chi_tiet_phieu', [
            'phieu' => $phieu,
            'pageTitle' => 'Chi Tiết Phiếu Thu',
        ]);
    }
}
