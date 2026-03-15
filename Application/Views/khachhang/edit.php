<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-user-edit me-2 text-warning"></i>Sửa Thông Tin Khách Hàng</h5>
    <a href="/khach-hang" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="/khach-hang/update/<?= $khachHang['id'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Họ Tên <span class="text-danger">*</span></label>
                    <input type="text" name="ho_ten" class="form-control" value="<?= htmlspecialchars($khachHang['ho_ten']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">CMND / CCCD <span class="text-danger">*</span></label>
                    <input type="text" name="cmnd" class="form-control" value="<?= htmlspecialchars($khachHang['cmnd']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Số Điện Thoại <span class="text-danger">*</span></label>
                    <input type="text" name="sdt" class="form-control" value="<?= htmlspecialchars($khachHang['sdt']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Ngày Sinh</label>
                    <input type="date" name="ngay_sinh" class="form-control" value="<?= htmlspecialchars($khachHang['ngay_sinh'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Giới Tính</label>
                    <select name="gioi_tinh" class="form-select">
                        <option value="nam" <?= ($khachHang['gioi_tinh'] ?? '') === 'nam' ? 'selected' : '' ?>>Nam</option>
                        <option value="nu" <?= ($khachHang['gioi_tinh'] ?? '') === 'nu' ? 'selected' : '' ?>>Nữ</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Địa Chỉ</label>
                    <input type="text" name="dia_chi" class="form-control" value="<?= htmlspecialchars($khachHang['dia_chi'] ?? '') ?>">
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Cập Nhật</button>
                <a href="/khach-hang" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
