<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-edit me-2 text-warning"></i>Sửa Hợp Đồng: <?= htmlspecialchars($hopDong['ma_hop_dong']) ?></h5>
    <a href="/hop-dong/detail/<?= $hopDong['id'] ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
</div>

<form method="POST" action="/hop-dong/update/<?= $hopDong['id'] ?>">
<div class="card shadow-sm">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Khách Hàng <span class="text-danger">*</span></label>
                <select name="khach_hang_id" class="form-select" required>
                    <?php foreach ($khachHang as $kh): ?>
                    <option value="<?= $kh['id'] ?>" <?= $hopDong['khach_hang_id'] == $kh['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kh['ho_ten']) ?> - <?= htmlspecialchars($kh['cmnd']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Ngày Cầm <span class="text-danger">*</span></label>
                <input type="date" id="ngay_cam" name="ngay_cam" class="form-control" value="<?= $hopDong['ngay_cam'] ?>" required onchange="tinhTienLai()">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Ngày Đáo Hạn <span class="text-danger">*</span></label>
                <input type="date" id="ngay_dao_han" name="ngay_dao_han" class="form-control" value="<?= $hopDong['ngay_dao_han'] ?>" required onchange="tinhTienLai()">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Số Tiền Cầm (VNĐ) <span class="text-danger">*</span></label>
                <input type="number" id="so_tien_cam" name="so_tien_cam" class="form-control" value="<?= $hopDong['so_tien_cam'] ?>" step="100000" required onchange="tinhTienLai()">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Lãi Suất (%/tháng)</label>
                <input type="number" id="lai_suat" name="lai_suat" class="form-control" value="<?= $hopDong['lai_suat'] ?>" step="0.1" onchange="tinhTienLai()">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Chu Kỳ Thu Lãi</label>
                <select name="chu_ky_thu_lai" class="form-select">
                    <?php foreach (['hang_thang'=>'Hàng Tháng','hang_tuan'=>'Hàng Tuần','hang_ngay'=>'Hàng Ngày','cuoi_ky'=>'Cuối Kỳ'] as $v => $l): ?>
                    <option value="<?= $v ?>" <?= $hopDong['chu_ky_thu_lai'] === $v ? 'selected' : '' ?>><?= $l ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Ngày Bắt Đầu Thu Lãi</label>
                <input type="date" name="ngay_bat_dau_thu_lai" class="form-control" value="<?= $hopDong['ngay_bat_dau_thu_lai'] ?? '' ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tiền Lãi</label>
                <input type="text" id="tien_lai" class="form-control bg-light" readonly value="<?= number_format($hopDong['tien_lai'], 0, ',', '.') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tổng Chuộc</label>
                <input type="text" id="tong_tien_chuoc" class="form-control bg-warning" readonly value="<?= number_format($hopDong['tong_tien_chuoc'], 0, ',', '.') ?>">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Ghi Chú</label>
                <textarea name="ghi_chu" class="form-control" rows="2"><?= htmlspecialchars($hopDong['ghi_chu'] ?? '') ?></textarea>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Cập Nhật</button>
            <a href="/hop-dong/detail/<?= $hopDong['id'] ?>" class="btn btn-outline-secondary">Hủy</a>
        </div>
    </div>
</div>
</form>
