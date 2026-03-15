<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-success"></i>Thêm Món Cầm</h5>
    <a href="/mon-cam" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="/mon-cam/store">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hợp Đồng <span class="text-danger">*</span></label>
                    <select name="hop_dong_id" class="form-select" required>
                        <option value="">-- Chọn hợp đồng --</option>
                        <?php foreach ($hopDong as $hd): ?>
                        <option value="<?= $hd['id'] ?>"><?= htmlspecialchars($hd['ma_hop_dong']) ?> - <?= htmlspecialchars($hd['ten_khach'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tên Món <span class="text-danger">*</span></label>
                    <input type="text" name="ten_mon" class="form-control" placeholder="Nhập tên món cầm" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Loại Món</label>
                    <select name="loai_mon" class="form-select">
                        <option value="vang">Vàng</option>
                        <option value="xe">Xe</option>
                        <option value="dien_thoai">Điện Thoại</option>
                        <option value="laptop">Laptop</option>
                        <option value="khac" selected>Khác</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Số Lượng</label>
                    <input type="number" name="so_luong" class="form-control" value="1" min="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tình Trạng</label>
                    <select name="tinh_trang" class="form-select">
                        <option value="tot">Tốt</option>
                        <option value="kha">Khá</option>
                        <option value="trung_binh">Trung Bình</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Giá Trị Định Giá (VNĐ)</label>
                    <input type="number" name="gia_tri_dinh_gia" class="form-control" value="0" step="1000" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mô Tả</label>
                    <input type="text" name="mo_ta" class="form-control" placeholder="Mô tả thêm về món cầm">
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i>Lưu</button>
                <a href="/mon-cam" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
