<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-money-bill me-2 text-success"></i>Thu Tiền Hợp Đồng <?= htmlspecialchars($hopDong['ma_hop_dong']) ?></h5>
    <a href="/hop-dong/detail/<?= $hopDong['id'] ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white"><h6 class="mb-0"><i class="fas fa-file-contract me-2"></i>Thông Tin Hợp Đồng</h6></div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted">Mã HĐ:</td><td class="fw-bold"><?= htmlspecialchars($hopDong['ma_hop_dong']) ?></td></tr>
                    <tr><td class="text-muted">Khách Hàng:</td><td><?= htmlspecialchars($hopDong['ten_khach']) ?></td></tr>
                    <tr><td class="text-muted">SĐT:</td><td><a href="tel:<?= htmlspecialchars($hopDong['sdt'] ?? '') ?>"><?= htmlspecialchars($hopDong['sdt'] ?? '') ?></a></td></tr>
                    <tr><td class="text-muted">Số Tiền Cầm:</td><td class="fw-bold"><?= formatMoney($hopDong['so_tien_cam']) ?></td></tr>
                    <tr><td class="text-muted">Tổng Chuộc:</td><td class="fw-bold text-success"><?= formatMoney($hopDong['tong_tien_chuoc']) ?></td></tr>
                    <tr><td class="text-muted">Lãi Đã Thu:</td><td><?= formatMoney($hopDong['tong_lai_da_thu']) ?></td></tr>
                    <tr><td class="text-muted">Đáo Hạn:</td><td><?= formatDate($hopDong['ngay_dao_han']) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white"><h6 class="mb-0"><i class="fas fa-hand-holding-usd me-2"></i>Form Thu Tiền</h6></div>
            <div class="card-body">
                <form method="POST" action="/thu-tien/xu-ly-thu-tien/<?= $hopDong['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Loại Thu <span class="text-danger">*</span></label>
                        <select name="loai_thu" class="form-select" required>
                            <option value="thu_lai">Thu Lãi</option>
                            <option value="thu_goc">Thu Gốc</option>
                            <option value="thu_chuoc">Thu Chuộc (Toàn Bộ)</option>
                            <option value="thu_phat">Phạt</option>
                            <option value="thu_khac">Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Số Tiền <span class="text-danger">*</span></label>
                        <input type="number" name="so_tien" class="form-control" step="1000" min="1" required placeholder="Nhập số tiền...">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ngày Thu</label>
                            <input type="date" name="ngay_thu" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phương Thức</label>
                            <select name="phuong_thuc" class="form-select">
                                <option value="tien_mat">Tiền Mặt</option>
                                <option value="chuyen_khoan">Chuyển Khoản</option>
                                <option value="khac">Khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label fw-semibold">Ghi Chú</label>
                        <textarea name="ghi_chu" class="form-control" rows="2" placeholder="Ghi chú thêm..."></textarea>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-check me-2"></i>Xác Nhận Thu Tiền
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
