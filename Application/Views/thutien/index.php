<!-- Stats -->
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card stat-card green p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Thu Hôm Nay</div>
                    <div class="fs-5 fw-bold"><?= formatMoney($tongHomNay) ?></div>
                </div>
                <i class="fas fa-calendar-day icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card blue p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Thu Tháng Này</div>
                    <div class="fs-5 fw-bold"><?= formatMoney($tongThangNay) ?></div>
                </div>
                <i class="fas fa-calendar-alt icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card orange p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Số Phiếu Thu</div>
                    <div class="fs-4 fw-bold"><?= count($lichSu) ?></div>
                </div>
                <i class="fas fa-receipt icon"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" action="/thu-tien" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small mb-1">Loại Thu</label>
                <select name="loai_thu" class="form-select form-select-sm">
                    <option value="">-- Tất cả --</option>
                    <?php foreach (['thu_lai'=>'Thu Lãi','thu_goc'=>'Thu Gốc','thu_chuoc'=>'Thu Chuộc','thu_phat'=>'Phạt','thu_khac'=>'Khác'] as $v => $l): ?>
                    <option value="<?= $v ?>" <?= ($filters['loai_thu'] ?? '') === $v ? 'selected' : '' ?>><?= $l ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Từ Ngày</label>
                <input type="date" name="tu_ngay" class="form-control form-control-sm" value="<?= $filters['tu_ngay'] ?? '' ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Đến Ngày</label>
                <input type="date" name="den_ngay" class="form-control form-control-sm" value="<?= $filters['den_ngay'] ?? '' ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Phương Thức</label>
                <select name="phuong_thuc" class="form-select form-select-sm">
                    <option value="">-- Tất cả --</option>
                    <?php foreach (['tien_mat'=>'Tiền Mặt','chuyen_khoan'=>'Chuyển Khoản','khac'=>'Khác'] as $v => $l): ?>
                    <option value="<?= $v ?>" <?= ($filters['phuong_thuc'] ?? '') === $v ? 'selected' : '' ?>><?= $l ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
                <a href="/thu-tien" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h6 class="mb-0"><i class="fas fa-history me-2"></i>Lịch Sử Thu Tiền</h6>
        <span class="fw-bold text-success">Tổng: <?= formatMoney(array_sum(array_column($lichSu, 'so_tien'))) ?></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Mã Phiếu</th>
                        <th>Hợp Đồng</th>
                        <th>Khách Hàng</th>
                        <th>Loại Thu</th>
                        <th>Số Tiền</th>
                        <th>Phương Thức</th>
                        <th>Ngày Thu</th>
                        <th>Người Thu</th>
                        <th class="text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $loaiThuLabels = ['thu_lai'=>'Thu Lãi','thu_goc'=>'Thu Gốc','thu_chuoc'=>'Thu Chuộc','thu_phat'=>'Phạt','thu_khac'=>'Khác'];
                $phuongThucLabels = ['tien_mat'=>'Tiền Mặt','chuyen_khoan'=>'Chuyển Khoản','khac'=>'Khác'];
                ?>
                <?php if (empty($lichSu)): ?>
                    <tr><td colspan="9" class="text-center text-muted py-4">Không có dữ liệu</td></tr>
                <?php else: ?>
                    <?php foreach ($lichSu as $ls): ?>
                    <tr>
                        <td><small><?= htmlspecialchars($ls['ma_phieu_thu']) ?></small></td>
                        <td><a href="/hop-dong/detail/<?= $ls['hop_dong_id'] ?>"><?= htmlspecialchars($ls['ma_hop_dong'] ?? '') ?></a></td>
                        <td><?= htmlspecialchars($ls['ten_khach'] ?? '') ?></td>
                        <td><span class="badge bg-secondary"><?= $loaiThuLabels[$ls['loai_thu']] ?? $ls['loai_thu'] ?></span></td>
                        <td class="fw-bold text-success"><?= formatMoney($ls['so_tien']) ?></td>
                        <td><?= $phuongThucLabels[$ls['phuong_thuc']] ?? $ls['phuong_thuc'] ?></td>
                        <td><?= formatDate($ls['ngay_thu']) ?></td>
                        <td><?= htmlspecialchars($ls['nguoi_thu']) ?></td>
                        <td class="text-center">
                            <a href="/thu-tien/chi-tiet/<?= $ls['id'] ?>" class="btn btn-sm btn-outline-info py-0">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
