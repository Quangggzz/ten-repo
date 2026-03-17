<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-edit me-2 text-warning"></i>Sửa Món Cầm</h5>
    <a href="/mon-cam" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="/mon-cam/update/<?= $monCam['id'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tên Món <span class="text-danger">*</span></label>
                    <input type="text" name="ten_mon" class="form-control" value="<?= htmlspecialchars($monCam['ten_mon']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Loại Món</label>
                    <select name="loai_mon" class="form-select">
                        <?php foreach (['vang'=>'Vàng','xe'=>'Xe','dien_thoai'=>'Điện Thoại','laptop'=>'Laptop','khac'=>'Khác'] as $val => $label): ?>
                        <option value="<?= $val ?>" <?= $monCam['loai_mon'] === $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Số Lượng</label>
                    <input type="number" name="so_luong" class="form-control" value="<?= $monCam['so_luong'] ?>" min="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tình Trạng</label>
                    <select name="tinh_trang" class="form-select">
                        <?php foreach (['tot'=>'Tốt','kha'=>'Khá','trung_binh'=>'Trung Bình'] as $val => $label): ?>
                        <option value="<?= $val ?>" <?= $monCam['tinh_trang'] === $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Giá Trị Định Giá (VNĐ)</label>
                    <input type="number" name="gia_tri_dinh_gia" class="form-control" value="<?= $monCam['gia_tri_dinh_gia'] ?>" step="1000" min="0">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Mô Tả</label>
                    <textarea name="mo_ta" class="form-control" rows="2"><?= htmlspecialchars($monCam['mo_ta'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Cập Nhật</button>
                <a href="/mon-cam" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
