<?php
namespace Controllers;

class MonCamController extends \MVC\Controller {
    private $model;

    public function __construct() {
        parent::__construct();
        if (!isLoggedIn()) redirect('/login');
        require_once MODELS . 'MonCam.php';
        $this->model = new \Models\MonCamModel();
    }

    public function index() {
        $monCam = $this->model->getAll();
        $this->render('moncam/index', [
            'monCam' => $monCam ?: [],
            'pageTitle' => 'Quản Lý Món Cầm',
        ]);
    }

    public function create() {
        require_once MODELS . 'HopDong.php';
        $hopDongModel = new \Models\HopDongModel();
        $hopDong = $hopDongModel->getAll();
        $this->render('moncam/create', [
            'hopDong' => $hopDong ?: [],
            'pageTitle' => 'Thêm Món Cầm',
        ]);
    }

    public function store() {
        $errors = [];
        $tenMon = trim($_POST['ten_mon'] ?? '');
        $hopDongId = intval($_POST['hop_dong_id'] ?? 0);

        if (empty($tenMon)) $errors[] = 'Tên món không được để trống';
        if (empty($hopDongId)) $errors[] = 'Vui lòng chọn hợp đồng';

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirect('/mon-cam/create');
            return;
        }

        $data = [
            'hop_dong_id' => $hopDongId,
            'ten_mon' => $tenMon,
            'loai_mon' => $_POST['loai_mon'] ?? 'khac',
            'mo_ta' => trim($_POST['mo_ta'] ?? ''),
            'so_luong' => intval($_POST['so_luong'] ?? 1),
            'tinh_trang' => $_POST['tinh_trang'] ?? 'tot',
            'gia_tri_dinh_gia' => floatval($_POST['gia_tri_dinh_gia'] ?? 0),
        ];

        $this->model->create($data);
        setFlash('success', 'Thêm món cầm thành công');
        redirect('/mon-cam');
    }

    public function edit($id) {
        $monCam = $this->model->getById($id);
        if (!$monCam) {
            setFlash('error', 'Không tìm thấy món cầm');
            redirect('/mon-cam');
            return;
        }
        require_once MODELS . 'HopDong.php';
        $hopDongModel = new \Models\HopDongModel();
        $hopDong = $hopDongModel->getAll();
        $this->render('moncam/edit', [
            'monCam' => $monCam,
            'hopDong' => $hopDong ?: [],
            'pageTitle' => 'Sửa Món Cầm',
        ]);
    }

    public function update($id) {
        $errors = [];
        $tenMon = trim($_POST['ten_mon'] ?? '');
        if (empty($tenMon)) $errors[] = 'Tên món không được để trống';

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirect('/mon-cam/edit/' . $id);
            return;
        }

        $data = [
            'ten_mon' => $tenMon,
            'loai_mon' => $_POST['loai_mon'] ?? 'khac',
            'mo_ta' => trim($_POST['mo_ta'] ?? ''),
            'so_luong' => intval($_POST['so_luong'] ?? 1),
            'tinh_trang' => $_POST['tinh_trang'] ?? 'tot',
            'gia_tri_dinh_gia' => floatval($_POST['gia_tri_dinh_gia'] ?? 0),
        ];

        $this->model->update($id, $data);
        setFlash('success', 'Cập nhật món cầm thành công');
        redirect('/mon-cam');
    }

    public function delete($id) {
        $this->model->delete($id);
        setFlash('success', 'Xóa món cầm thành công');
        redirect('/mon-cam');
    }
}
