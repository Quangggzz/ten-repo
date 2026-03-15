<?php
namespace Controllers;

class HopDongController extends \MVC\Controller {
    private $model;

    public function __construct() {
        parent::__construct();
        if (!isLoggedIn()) redirect('/login');
        require_once MODELS . 'HopDong.php';
        $this->model = new \Models\HopDongModel();
    }

    public function index() {
        $hopDong = $this->model->getAll();
        $this->render('hopdong/index', [
            'hopDong' => $hopDong ?: [],
            'pageTitle' => 'Quản Lý Hợp Đồng',
        ]);
    }

    public function create() {
        require_once MODELS . 'KhachHang.php';
        $khachHangModel = new \Models\KhachHangModel();
        $khachHang = $khachHangModel->getAll();
        $maHopDong = $this->model->generateMaHopDong();
        $this->render('hopdong/create', [
            'khachHang' => $khachHang ?: [],
            'maHopDong' => $maHopDong,
            'pageTitle' => 'Tạo Hợp Đồng Mới',
        ]);
    }

    public function store() {
        $errors = [];
        $khachHangId = intval($_POST['khach_hang_id'] ?? 0);
        $ngayCam = $_POST['ngay_cam'] ?? '';
        $ngayDaoHan = $_POST['ngay_dao_han'] ?? '';
        $soTienCam = floatval($_POST['so_tien_cam'] ?? 0);

        if (empty($khachHangId)) $errors[] = 'Vui lòng chọn khách hàng';
        if (empty($ngayCam)) $errors[] = 'Ngày cầm không được để trống';
        if (empty($ngayDaoHan)) $errors[] = 'Ngày đáo hạn không được để trống';
        if ($soTienCam <= 0) $errors[] = 'Số tiền cầm phải lớn hơn 0';

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirect('/hop-dong/create');
            return;
        }

        $laiSuat = floatval($_POST['lai_suat'] ?? 3);
        $chuKy = $_POST['chu_ky_thu_lai'] ?? 'hang_thang';
        $ngayBatDau = $_POST['ngay_bat_dau_thu_lai'] ?? $ngayCam;

        // Calculate interest
        $start = new \DateTime($ngayCam);
        $end = new \DateTime($ngayDaoHan);
        $diff = $start->diff($end);
        $soThang = $diff->m + ($diff->y * 12);
        if ($diff->d > 0) $soThang++;
        if ($soThang < 1) $soThang = 1;
        $tienLai = $soTienCam * ($laiSuat / 100) * $soThang;
        $tongTienChuoc = $soTienCam + $tienLai;

        $data = [
            'ma_hop_dong' => $this->model->generateMaHopDong(),
            'khach_hang_id' => $khachHangId,
            'ngay_cam' => $ngayCam,
            'ngay_dao_han' => $ngayDaoHan,
            'so_tien_cam' => $soTienCam,
            'lai_suat' => $laiSuat,
            'tien_lai' => $tienLai,
            'tong_tien_chuoc' => $tongTienChuoc,
            'chu_ky_thu_lai' => $chuKy,
            'ngay_bat_dau_thu_lai' => $ngayBatDau,
            'ghi_chu' => trim($_POST['ghi_chu'] ?? ''),
        ];

        $hopDongId = $this->model->create($data);

        // Save pawned items
        if (!empty($_POST['ten_mon']) && is_array($_POST['ten_mon'])) {
            require_once MODELS . 'MonCam.php';
            $monCamModel = new \Models\MonCamModel();
            foreach ($_POST['ten_mon'] as $idx => $tenMon) {
                if (empty(trim($tenMon))) continue;
                $monCamModel->create([
                    'hop_dong_id' => $hopDongId,
                    'ten_mon' => $tenMon,
                    'loai_mon' => $_POST['loai_mon'][$idx] ?? 'khac',
                    'so_luong' => intval($_POST['so_luong'][$idx] ?? 1),
                    'gia_tri_dinh_gia' => floatval($_POST['gia_tri_dinh_gia'][$idx] ?? 0),
                    'tinh_trang' => $_POST['tinh_trang'][$idx] ?? 'tot',
                    'mo_ta' => $_POST['mo_ta_mon'][$idx] ?? '',
                ]);
            }
        }

        // Auto-create payment schedule
        require_once MODELS . 'LichThuLai.php';
        $lichModel = new \Models\LichThuLaiModel();
        $lichModel->taoLichThuLai($hopDongId, $ngayCam, $ngayDaoHan, $soTienCam, $laiSuat, $chuKy, $ngayBatDau);

        setFlash('success', 'Tạo hợp đồng thành công');
        redirect('/hop-dong/detail/' . $hopDongId);
    }

    public function detail($id) {
        $hopDong = $this->model->getById($id);
        if (!$hopDong) {
            setFlash('error', 'Không tìm thấy hợp đồng');
            redirect('/hop-dong');
            return;
        }

        require_once MODELS . 'MonCam.php';
        require_once MODELS . 'HinhAnh.php';
        require_once MODELS . 'LichThuLai.php';
        require_once MODELS . 'LichSuThuTien.php';

        $monCamModel = new \Models\MonCamModel();
        $hinhAnhModel = new \Models\HinhAnhModel();
        $lichThuLaiModel = new \Models\LichThuLaiModel();
        $lichSuModel = new \Models\LichSuThuTienModel();

        $monCam = $monCamModel->getByHopDong($id) ?: [];
        $hinhAnh = $hinhAnhModel->getByHopDong($id) ?: [];
        $lichThuLai = $lichThuLaiModel->getByHopDong($id) ?: [];
        $lichSu = $lichSuModel->getByHopDong($id) ?: [];
        $tongHop = $lichThuLaiModel->tongHopByHopDong($id);
        $tongThu = $lichSuModel->tongThuByHopDong($id);

        $this->render('hopdong/detail', [
            'hopDong' => $hopDong,
            'monCam' => $monCam,
            'hinhAnh' => $hinhAnh,
            'lichThuLai' => $lichThuLai,
            'lichSu' => $lichSu,
            'tongHop' => $tongHop,
            'tongThu' => $tongThu,
            'pageTitle' => 'Chi Tiết Hợp Đồng',
        ]);
    }

    public function edit($id) {
        $hopDong = $this->model->getById($id);
        if (!$hopDong) {
            setFlash('error', 'Không tìm thấy hợp đồng');
            redirect('/hop-dong');
            return;
        }
        require_once MODELS . 'KhachHang.php';
        $khachHangModel = new \Models\KhachHangModel();
        $khachHang = $khachHangModel->getAll();
        $this->render('hopdong/edit', [
            'hopDong' => $hopDong,
            'khachHang' => $khachHang ?: [],
            'pageTitle' => 'Sửa Hợp Đồng',
        ]);
    }

    public function update($id) {
        $errors = [];
        $khachHangId = intval($_POST['khach_hang_id'] ?? 0);
        $ngayCam = $_POST['ngay_cam'] ?? '';
        $ngayDaoHan = $_POST['ngay_dao_han'] ?? '';
        $soTienCam = floatval($_POST['so_tien_cam'] ?? 0);

        if (empty($khachHangId)) $errors[] = 'Vui lòng chọn khách hàng';
        if (empty($ngayCam)) $errors[] = 'Ngày cầm không được để trống';
        if (empty($ngayDaoHan)) $errors[] = 'Ngày đáo hạn không được để trống';
        if ($soTienCam <= 0) $errors[] = 'Số tiền cầm phải lớn hơn 0';

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirect('/hop-dong/edit/' . $id);
            return;
        }

        $laiSuat = floatval($_POST['lai_suat'] ?? 3);
        $chuKy = $_POST['chu_ky_thu_lai'] ?? 'hang_thang';
        $ngayBatDau = $_POST['ngay_bat_dau_thu_lai'] ?? $ngayCam;
        $start = new \DateTime($ngayCam);
        $end = new \DateTime($ngayDaoHan);
        $diff = $start->diff($end);
        $soThang = $diff->m + ($diff->y * 12);
        if ($diff->d > 0) $soThang++;
        if ($soThang < 1) $soThang = 1;
        $tienLai = $soTienCam * ($laiSuat / 100) * $soThang;
        $tongTienChuoc = $soTienCam + $tienLai;

        $data = [
            'khach_hang_id' => $khachHangId,
            'ngay_cam' => $ngayCam,
            'ngay_dao_han' => $ngayDaoHan,
            'so_tien_cam' => $soTienCam,
            'lai_suat' => $laiSuat,
            'tien_lai' => $tienLai,
            'tong_tien_chuoc' => $tongTienChuoc,
            'chu_ky_thu_lai' => $chuKy,
            'ngay_bat_dau_thu_lai' => $ngayBatDau,
            'ghi_chu' => trim($_POST['ghi_chu'] ?? ''),
        ];

        $this->model->update($id, $data);
        setFlash('success', 'Cập nhật hợp đồng thành công');
        redirect('/hop-dong/detail/' . $id);
    }

    public function delete($id) {
        $this->model->delete($id);
        setFlash('success', 'Xóa hợp đồng thành công');
        redirect('/hop-dong');
    }

    public function chuoc($id) {
        $this->model->updateTrangThai($id, 'da_chuoc');
        setFlash('success', 'Đã cập nhật trạng thái: Đã chuộc');
        redirect('/hop-dong/detail/' . $id);
    }

    public function thanhLy($id) {
        $this->model->updateTrangThai($id, 'thanh_ly');
        setFlash('success', 'Đã cập nhật trạng thái: Thanh lý');
        redirect('/hop-dong/detail/' . $id);
    }

    public function printContract($id) {
        $hopDong = $this->model->getById($id);
        if (!$hopDong) {
            setFlash('error', 'Không tìm thấy hợp đồng');
            redirect('/hop-dong');
            return;
        }
        require_once MODELS . 'MonCam.php';
        $monCamModel = new \Models\MonCamModel();
        $monCam = $monCamModel->getByHopDong($id) ?: [];
        $this->view('hopdong/print', [
            'hopDong' => $hopDong,
            'monCam' => $monCam,
            'pageTitle' => 'In Hợp Đồng',
        ]);
    }
}
