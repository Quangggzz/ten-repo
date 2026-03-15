<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-success"></i>Tạo Hợp Đồng Cầm Mới</h5>
    <a href="/hop-dong" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
</div>

<form method="POST" action="/hop-dong/store">
<div class="row g-3">
    <!-- Contract info -->
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-primary text-white"><h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông Tin Hợp Đồng</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mã Hợp Đồng</label>
                        <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($maHopDong) ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Khách Hàng <span class="text-danger">*</span></label>
                        <select name="khach_hang_id" class="form-select" required>
                            <option value="">-- Chọn khách hàng --</option>
                            <?php foreach ($khachHang as $kh): ?>
                            <option value="<?= $kh['id'] ?>"><?= htmlspecialchars($kh['ho_ten']) ?> - <?= htmlspecialchars($kh['cmnd']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Ngày Cầm <span class="text-danger">*</span></label>
                        <input type="date" id="ngay_cam" name="ngay_cam" class="form-control" value="<?= date('Y-m-d') ?>" required onchange="tinhTienLai()">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Ngày Đáo Hạn <span class="text-danger">*</span></label>
                        <input type="date" id="ngay_dao_han" name="ngay_dao_han" class="form-control" required onchange="tinhTienLai()">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Lãi Suất (%/tháng)</label>
                        <input type="number" id="lai_suat" name="lai_suat" class="form-control" value="3" step="0.1" min="0" onchange="tinhTienLai()">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Số Tiền Cầm (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" id="so_tien_cam" name="so_tien_cam" class="form-control" placeholder="0" step="100000" min="0" required onchange="tinhTienLai()">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Chu Kỳ Thu Lãi</label>
                        <select name="chu_ky_thu_lai" class="form-select">
                            <option value="hang_thang">Hàng Tháng</option>
                            <option value="hang_tuan">Hàng Tuần</option>
                            <option value="hang_ngay">Hàng Ngày</option>
                            <option value="cuoi_ky">Cuối Kỳ</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Ngày Bắt Đầu Thu Lãi</label>
                        <input type="date" name="ngay_bat_dau_thu_lai" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tiền Lãi (VNĐ)</label>
                        <input type="text" id="tien_lai" class="form-control bg-light" readonly placeholder="Tự động tính">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tổng Tiền Chuộc</label>
                        <input type="text" id="tong_tien_chuoc" class="form-control bg-warning" readonly placeholder="Tự động tính">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Ghi Chú</label>
                        <textarea name="ghi_chu" class="form-control" rows="2" placeholder="Ghi chú thêm về hợp đồng..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="col-lg-4">
        <div class="card shadow-sm bg-light">
            <div class="card-header"><h6 class="mb-0"><i class="fas fa-calculator me-2"></i>Tóm Tắt</h6></div>
            <div class="card-body">
                <p class="small text-muted">Điền thông tin hợp đồng để xem tóm tắt tự động</p>
                <div class="alert alert-info small">
                    <i class="fas fa-info-circle me-1"></i> Lịch thu lãi sẽ được tạo tự động khi lưu hợp đồng
                </div>
            </div>
        </div>
    </div>

    <!-- Pawned items -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-boxes me-2"></i>Danh Sách Món Cầm</h6>
                <button type="button" class="btn btn-sm btn-success" onclick="themMonCam()">
                    <i class="fas fa-plus me-1"></i>Thêm Món
                </button>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-1">
                    <div class="col-md-3 small fw-semibold text-muted">Tên Món *</div>
                    <div class="col-md-2 small fw-semibold text-muted">Loại</div>
                    <div class="col-md-1 small fw-semibold text-muted">SL</div>
                    <div class="col-md-2 small fw-semibold text-muted">Giá Trị ĐG</div>
                    <div class="col-md-2 small fw-semibold text-muted">Tình Trạng</div>
                    <div class="col-md-1 small fw-semibold text-muted">Ghi Chú</div>
                    <div class="col-md-1"></div>
                </div>
                <div id="mon-cam-list">
                    <!-- First row -->
                    <div class="row g-2 item-row" id="item-1">
                        <div class="col-md-3"><input type="text" name="ten_mon[]" class="form-control form-control-sm" placeholder="Tên món *"></div>
                        <div class="col-md-2">
                            <select name="loai_mon[]" class="form-select form-select-sm">
                                <option value="vang">Vàng</option><option value="xe">Xe</option>
                                <option value="dien_thoai">Điện thoại</option><option value="laptop">Laptop</option>
                                <option value="khac" selected>Khác</option>
                            </select>
                        </div>
                        <div class="col-md-1"><input type="number" name="so_luong[]" class="form-control form-control-sm" value="1" min="1"></div>
                        <div class="col-md-2"><input type="number" name="gia_tri_dinh_gia[]" class="form-control form-control-sm" placeholder="Giá trị" step="1000" min="0"></div>
                        <div class="col-md-2">
                            <select name="tinh_trang[]" class="form-select form-select-sm">
                                <option value="tot">Tốt</option><option value="kha">Khá</option><option value="trung_binh">Trung bình</option>
                            </select>
                        </div>
                        <div class="col-md-1"><input type="text" name="mo_ta_mon[]" class="form-control form-control-sm" placeholder="Ghi chú"></div>
                        <div class="col-md-1"><span class="text-muted small">—</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-save me-2"></i>Tạo Hợp Đồng
        </button>
        <a href="/hop-dong" class="btn btn-outline-secondary btn-lg ms-2">Hủy</a>
    </div>
</div>
</form>
