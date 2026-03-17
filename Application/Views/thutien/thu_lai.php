<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-money-bill-wave me-2 text-success"></i>Thu Lãi Kỳ <?= $ky['ky_thu'] ?></h5>
    <a href="/thu-tien/lich-thu-lai" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white"><h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông Tin Kỳ Thu</h6></div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted">Hợp Đồng:</td><td class="fw-bold"><a href="/hop-dong/detail/<?= $ky['hop_dong_id'] ?>"><?= htmlspecialchars($ky['ma_hop_dong']) ?></a></td></tr>
                    <tr><td class="text-muted">Khách Hàng:</td><td class="fw-bold"><?= htmlspecialchars($ky['ten_khach']) ?></td></tr>
                    <tr><td class="text-muted">SĐT:</td><td><a href="tel:<?= htmlspecialchars($ky['sdt']) ?>"><?= htmlspecialchars($ky['sdt']) ?></a></td></tr>
                    <tr><td class="text-muted">Kỳ Thu:</td><td><?= $ky['ky_thu'] ?></td></tr>
                    <tr><td class="text-muted">Ngày Thu DK:</td><td><?= formatDate($ky['ngay_thu_du_kien']) ?></td></tr>
                    <tr><td class="text-muted">Tiền Lãi:</td><td class="fw-bold text-primary"><?= formatMoney($ky['so_tien_lai']) ?></td></tr>
                    <tr><td class="text-muted">Đã Thu:</td><td><?= formatMoney($ky['so_tien_da_thu']) ?></td></tr>
                    <tr><td class="text-muted">Còn Lại:</td><td class="fw-bold text-danger"><?= formatMoney(floatval($ky['so_tien_lai']) - floatval($ky['so_tien_da_thu'])) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white"><h6 class="mb-0"><i class="fas fa-hand-holding-usd me-2"></i>Biểu Mẫu Thu Lãi</h6></div>
            <div class="card-body">
                <form method="POST" action="/thu-tien/xu-ly-thu-lai/<?= $ky['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Số Tiền Thu <span class="text-danger">*</span></label>
                        <input type="number" name="so_tien" class="form-control" 
                               value="<?= floatval($ky['so_tien_lai']) - floatval($ky['so_tien_da_thu']) ?>"
                               step="1000" min="1" required>
                        <div class="form-text">Số tiền còn lại: <?= formatMoney(floatval($ky['so_tien_lai']) - floatval($ky['so_tien_da_thu'])) ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ngày Thu</label>
                        <input type="date" name="ngay_thu" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phương Thức</label>
                        <select name="phuong_thuc" class="form-select">
                            <option value="tien_mat">Tiền Mặt</option>
                            <option value="chuyen_khoan">Chuyển Khoản</option>
                            <option value="khac">Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ghi Chú</label>
                        <textarea name="ghi_chu" class="form-control" rows="2" placeholder="Ghi chú..."></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-check me-2"></i>Xác Nhận Thu Lãi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
