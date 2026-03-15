<!-- Dashboard Stats -->
<div class="row g-3 mb-4">
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card stat-card orange p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Tổng Hợp Đồng</div>
                    <div class="fs-3 fw-bold"><?= number_format($thongKe['tong_hop_dong']) ?></div>
                </div>
                <i class="fas fa-file-contract icon"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card stat-card blue p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Đang Cầm</div>
                    <div class="fs-3 fw-bold"><?= number_format($thongKe['dang_cam']) ?></div>
                </div>
                <i class="fas fa-hand-holding-usd icon"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card stat-card green p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Đã Chuộc</div>
                    <div class="fs-3 fw-bold"><?= number_format($thongKe['da_chuoc']) ?></div>
                </div>
                <i class="fas fa-check-circle icon"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card stat-card purple p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Khách Hàng</div>
                    <div class="fs-3 fw-bold"><?= number_format($tongKhachHang) ?></div>
                </div>
                <i class="fas fa-users icon"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card stat-card teal p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Tổng Tiền Cầm</div>
                    <div class="fs-5 fw-bold"><?= formatMoney($thongKe['tong_tien_cam']) ?></div>
                </div>
                <i class="fas fa-piggy-bank icon"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card stat-card red p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Thu Hôm Nay</div>
                    <div class="fs-5 fw-bold"><?= formatMoney($tongThuHomNay) ?></div>
                </div>
                <i class="fas fa-money-bill-wave icon"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Overdue contracts -->
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Hợp Đồng Quá Hạn</h6>
                <span class="badge bg-light text-danger"><?= count($hopDongQuaHan) ?></span>
            </div>
            <div class="card-body p-0">
                <?php if (empty($hopDongQuaHan)): ?>
                <p class="text-center text-muted py-3">Không có hợp đồng quá hạn</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light"><tr>
                            <th>Mã HĐ</th><th>Khách Hàng</th><th>Số Tiền</th><th>Đáo Hạn</th><th></th>
                        </tr></thead>
                        <tbody>
                        <?php foreach ($hopDongQuaHan as $hd): ?>
                        <tr class="table-danger">
                            <td><a href="/hop-dong/detail/<?= $hd['id'] ?>"><?= htmlspecialchars($hd['ma_hop_dong']) ?></a></td>
                            <td><?= htmlspecialchars($hd['ten_khach']) ?></td>
                            <td><?= formatMoney($hd['so_tien_cam']) ?></td>
                            <td class="text-danger fw-bold"><?= formatDate($hd['ngay_dao_han']) ?></td>
                            <td><a href="/hop-dong/detail/<?= $hd['id'] ?>" class="btn btn-xs btn-outline-danger btn-sm py-0">Xem</a></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Overdue payment periods -->
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header bg-warning d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Kỳ Lãi Quá Hạn</h6>
                <span class="badge bg-dark"><?= count($kyQuaHan) ?></span>
            </div>
            <div class="card-body p-0">
                <?php if (empty($kyQuaHan)): ?>
                <p class="text-center text-muted py-3">Không có kỳ quá hạn</p>
                <?php else: ?>
                <div class="table-responsive" style="max-height:300px;overflow-y:auto">
                    <table class="table table-sm mb-0">
                        <thead class="table-light"><tr><th>Khách</th><th>Ngày thu</th><th>Tiền lãi</th><th></th></tr></thead>
                        <tbody>
                        <?php foreach (array_slice($kyQuaHan, 0, 8) as $ky): ?>
                        <tr>
                            <td class="small"><?= htmlspecialchars($ky['ten_khach']) ?></td>
                            <td class="small text-danger"><?= formatDate($ky['ngay_thu_du_kien']) ?></td>
                            <td class="small"><?= formatMoney($ky['so_tien_lai']) ?></td>
                            <td><a href="/thu-tien/thu-lai/<?= $ky['id'] ?>" class="btn btn-sm btn-warning py-0 small">Thu</a></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="card-footer text-end">
                <a href="/thu-tien/lich-thu-lai" class="btn btn-sm btn-warning">Xem tất cả</a>
            </div>
        </div>
    </div>
</div>
