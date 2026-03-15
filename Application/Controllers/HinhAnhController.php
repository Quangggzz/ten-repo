<?php
namespace Controllers;

class HinhAnhController extends \MVC\Controller {
    public function __construct() {
        parent::__construct();
        if (!isLoggedIn()) redirect('/login');
    }

    public function upload() {
        if (empty($_POST['mon_cam_id']) || empty($_POST['hop_dong_id'])) {
            $this->json(['success' => false, 'message' => 'Missing parameters'], 400);
            return;
        }

        if (empty($_FILES['hinh_anh']['name'][0])) {
            $this->json(['success' => false, 'message' => 'No files uploaded'], 400);
            return;
        }

        require_once MODELS . 'HinhAnh.php';
        $model = new \Models\HinhAnhModel();

        $result = $model->uploadMultiple(
            intval($_POST['mon_cam_id']),
            intval($_POST['hop_dong_id']),
            $_FILES['hinh_anh']
        );

        $this->json([
            'success' => count($result['success']) > 0,
            'uploaded' => $result['success'],
            'errors' => $result['errors'],
        ]);
    }

    public function delete($id) {
        require_once MODELS . 'HinhAnh.php';
        $model = new \Models\HinhAnhModel();
        $img = $model->getById($id);

        if (!$img) {
            $this->json(['success' => false, 'message' => 'Image not found'], 404);
            return;
        }

        $hopDongId = $img['hop_dong_id'];
        $model->delete($id);

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $this->json(['success' => true]);
        } else {
            setFlash('success', 'Xóa hình ảnh thành công');
            redirect('/hop-dong/detail/' . $hopDongId);
        }
    }

    public function gallery($hopDongId) {
        require_once MODELS . 'HinhAnh.php';
        $model = new \Models\HinhAnhModel();
        $images = $model->getByHopDong($hopDongId) ?: [];
        $this->json(['images' => $images]);
    }
}
