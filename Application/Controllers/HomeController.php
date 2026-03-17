<?php
namespace Controllers;

class HomeController extends \MVC\Controller {
    public function index() {
        if (isLoggedIn()) {
            redirect('/dashboard');
        } else {
            redirect('/login');
        }
    }

    public function dashboard() {
        if (!isLoggedIn()) redirect('/login');

        require_once MODELS . 'HopDong.php';
        require_once MODELS . 'KhachHang.php';
        require_once MODELS . 'LichThuLai.php';
        require_once MODELS . 'LichSuThuTien.php';

        $hopDongModel = new \Models\HopDongModel();
        $khachHangModel = new \Models\KhachHangModel();
        $lichThuLaiModel = new \Models\LichThuLaiModel();
        $lichSuModel = new \Models\LichSuThuTienModel();

        $lichThuLaiModel->capNhatQuaHan();

        $thongKe = $hopDongModel->getThongKe();
        $hopDongQuaHan = $hopDongModel->getHopDongQuaHan();
        $tongKhachHang = $khachHangModel->countAll();
        $tongThuHomNay = $lichSuModel->tongThuHomNay();
        $kyQuaHan = $lichThuLaiModel->getQuaHanChuaThu();

        $this->render('home/index', [
            'thongKe' => $thongKe,
            'hopDongQuaHan' => $hopDongQuaHan ?: [],
            'tongKhachHang' => $tongKhachHang,
            'tongThuHomNay' => $tongThuHomNay,
            'kyQuaHan' => $kyQuaHan ?: [],
            'pageTitle' => 'Tổng Quan',
        ]);
    }
}
