<?php
namespace Controllers;

class KhachHangController extends \MVC\Controller {
    private $model;

    public function __construct() {
        parent::__construct();
        if (!isLoggedIn()) redirect('/login');
        require_once MODELS . 'KhachHang.php';
        $this->model = new \Models\KhachHangModel();
    }

    public function index() {
        $khachHang = $this->model->getAll();
        $this->render('khachhang/index', [
            'khachHang' => $khachHang ?: [],
            'pageTitle' => 'Quản Lý Khách Hàng',
        ]);
    }

    public function create() {
        $this->render('khachhang/create', ['pageTitle' => 'Thêm Khách Hàng']);
    }

    public function store() {
        $errors = [];
        $hoTen = trim($_POST['ho_ten'] ?? '');
        $cmnd = trim($_POST['cmnd'] ?? '');
        $sdt = trim($_POST['sdt'] ?? '');

        if (empty($hoTen)) $errors[] = 'Họ tên không được để trống';
        if (empty($cmnd)) $errors[] = 'CMND/CCCD không được để trống';
        if (empty($sdt)) $errors[] = 'Số điện thoại không được để trống';

        if (!empty($errors)) {
            $_SESSION['old_input'] = $_POST;
            setFlash('error', implode('<br>', $errors));
            redirect('/khach-hang/create');
            return;
        }

        $data = [
            'ho_ten' => $hoTen,
            'cmnd' => $cmnd,
            'sdt' => $sdt,
            'dia_chi' => trim($_POST['dia_chi'] ?? ''),
            'ngay_sinh' => $_POST['ngay_sinh'] ?? '',
            'gioi_tinh' => $_POST['gioi_tinh'] ?? 'nam',
        ];

        $this->model->create($data);
        setFlash('success', 'Thêm khách hàng thành công');
        redirect('/khach-hang');
    }

    public function edit($id) {
        $khachHang = $this->model->getById($id);
        if (!$khachHang) {
            setFlash('error', 'Không tìm thấy khách hàng');
            redirect('/khach-hang');
            return;
        }
        $this->render('khachhang/edit', [
            'khachHang' => $khachHang,
            'pageTitle' => 'Sửa Khách Hàng',
        ]);
    }

    public function update($id) {
        $errors = [];
        $hoTen = trim($_POST['ho_ten'] ?? '');
        $cmnd = trim($_POST['cmnd'] ?? '');
        $sdt = trim($_POST['sdt'] ?? '');

        if (empty($hoTen)) $errors[] = 'Họ tên không được để trống';
        if (empty($cmnd)) $errors[] = 'CMND/CCCD không được để trống';
        if (empty($sdt)) $errors[] = 'Số điện thoại không được để trống';

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirect('/khach-hang/edit/' . $id);
            return;
        }

        $data = [
            'ho_ten' => $hoTen,
            'cmnd' => $cmnd,
            'sdt' => $sdt,
            'dia_chi' => trim($_POST['dia_chi'] ?? ''),
            'ngay_sinh' => $_POST['ngay_sinh'] ?? '',
            'gioi_tinh' => $_POST['gioi_tinh'] ?? 'nam',
        ];

        $this->model->update($id, $data);
        setFlash('success', 'Cập nhật khách hàng thành công');
        redirect('/khach-hang');
    }

    public function delete($id) {
        $this->model->delete($id);
        setFlash('success', 'Xóa khách hàng thành công');
        redirect('/khach-hang');
    }

    public function search() {
        $keyword = trim($_GET['q'] ?? '');
        if (empty($keyword)) {
            redirect('/khach-hang');
            return;
        }
        $khachHang = $this->model->search($keyword);
        $this->render('khachhang/index', [
            'khachHang' => $khachHang ?: [],
            'keyword' => $keyword,
            'pageTitle' => 'Tìm kiếm: ' . htmlspecialchars($keyword),
        ]);
    }
}
