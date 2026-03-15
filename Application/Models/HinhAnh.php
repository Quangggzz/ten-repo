<?php
namespace Models;

class HinhAnhModel extends \MVC\Model {
    protected $table = 'ps_hinh_anh';

    public function getByMonCam($monCamId) {
        $monCamId = intval($monCamId);
        return $this->db->query("SELECT * FROM {$this->table} WHERE mon_cam_id = {$monCamId} ORDER BY thu_tu ASC, id ASC");
    }

    public function getByHopDong($hopDongId) {
        $hopDongId = intval($hopDongId);
        return $this->db->query("SELECT ha.*, mc.ten_mon FROM {$this->table} ha LEFT JOIN ps_mon_cam mc ON ha.mon_cam_id = mc.id WHERE ha.hop_dong_id = {$hopDongId} ORDER BY mc.id ASC, ha.thu_tu ASC");
    }

    public function getById($id) {
        $id = intval($id);
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE id = {$id} LIMIT 1");
        return $result ? $result[0] : null;
    }

    public function uploadMultiple($monCamId, $hopDongId, $files) {
        $monCamId = intval($monCamId);
        $hopDongId = intval($hopDongId);
        $result = ['success' => [], 'errors' => []];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        $uploadDir = UPLOAD . 'hop_dong_' . $hopDongId . '/';
        $thumbDir = $uploadDir . 'thumbs/';

        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        if (!is_dir($thumbDir)) mkdir($thumbDir, 0755, true);

        $fileCount = count($files['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                $result['errors'][] = "File " . ($i+1) . ": Upload error";
                continue;
            }

            $fileType = mime_content_type($files['tmp_name'][$i]);
            if (!in_array($fileType, $allowedTypes)) {
                $result['errors'][] = $files['name'][$i] . ": Invalid file type";
                continue;
            }

            if ($files['size'][$i] > $maxSize) {
                $result['errors'][] = $files['name'][$i] . ": File too large (max 5MB)";
                continue;
            }

            $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
            $fileName = 'mc' . $monCamId . '_' . time() . '_' . $i . '.' . $ext;
            $filePath = $uploadDir . $fileName;
            $thumbPath = $thumbDir . $fileName;

            if (move_uploaded_file($files['tmp_name'][$i], $filePath)) {
                $this->createThumbnail($filePath, $thumbPath, 300, 300);

                $fileNameEsc = $this->db->escape($fileName);
                $filePathEsc = $this->db->escape('hop_dong_' . $hopDongId . '/' . $fileName);
                $fileTypeEsc = $this->db->escape($fileType);
                $fileSize = intval($files['size'][$i]);
                $now = date('Y-m-d H:i:s');

                $this->db->query("INSERT INTO {$this->table} (mon_cam_id, hop_dong_id, file_name, file_path, file_size, file_type, created_at) VALUES ({$monCamId}, {$hopDongId}, '{$fileNameEsc}', '{$filePathEsc}', {$fileSize}, '{$fileTypeEsc}', '{$now}')");
                $result['success'][] = $fileName;
            } else {
                $result['errors'][] = $files['name'][$i] . ": Move failed";
            }
        }

        return $result;
    }

    public function createThumbnail($src, $dest, $maxW, $maxH) {
        if (!function_exists('imagecreatefromjpeg')) return false;

        $info = getimagesize($src);
        if (!$info) return false;

        $mime = $info['mime'];
        $srcImg = null;

        switch ($mime) {
            case 'image/jpeg': $srcImg = imagecreatefromjpeg($src); break;
            case 'image/png':  $srcImg = imagecreatefrompng($src); break;
            case 'image/gif':  $srcImg = imagecreatefromgif($src); break;
            case 'image/webp': $srcImg = imagecreatefromwebp($src); break;
            default: return false;
        }

        if (!$srcImg) return false;

        $srcW = imagesx($srcImg);
        $srcH = imagesy($srcImg);
        $ratio = min($maxW / $srcW, $maxH / $srcH);
        $newW = intval($srcW * $ratio);
        $newH = intval($srcH * $ratio);

        $thumb = imagecreatetruecolor($newW, $newH);
        imagecopyresampled($thumb, $srcImg, 0, 0, 0, 0, $newW, $newH, $srcW, $srcH);

        switch ($mime) {
            case 'image/jpeg': imagejpeg($thumb, $dest, 85); break;
            case 'image/png':  imagepng($thumb, $dest); break;
            case 'image/gif':  imagegif($thumb, $dest); break;
            case 'image/webp': imagewebp($thumb, $dest, 85); break;
        }

        imagedestroy($srcImg);
        imagedestroy($thumb);
        return true;
    }

    public function delete($id) {
        $id = intval($id);
        $img = $this->getById($id);
        if ($img) {
            $filePath = UPLOAD . $img['file_path'];
            $thumbPath = UPLOAD . dirname($img['file_path']) . '/thumbs/' . $img['file_name'];
            if (file_exists($filePath)) unlink($filePath);
            if (file_exists($thumbPath)) unlink($thumbPath);
            return $this->db->query("DELETE FROM {$this->table} WHERE id = {$id}");
        }
        return false;
    }

    public function updateMoTa($id, $moTa) {
        $id = intval($id);
        $moTa = $this->db->escape($moTa);
        return $this->db->query("UPDATE {$this->table} SET mo_ta='{$moTa}' WHERE id={$id}");
    }

    public function countByMonCam($monCamId) {
        $monCamId = intval($monCamId);
        $result = $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE mon_cam_id = {$monCamId}");
        return $result ? intval($result[0]['total']) : 0;
    }
}
