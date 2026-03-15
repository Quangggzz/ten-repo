<!-- Overdue periods -->
<?php if (!empty($quaHan)): ?>
<div class="card shadow-sm mb-3 border-danger">
    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>Kỳ Lãi Quá Hạn Chưa Thu</h6>
        <span class="badge bg-light text-danger"><?= count($quaHan) ?></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <thead class="table-light"><tr>
                    <th>Hợp Đồng</th><th>Khách Hàng</th><th>SĐT</th><th>Kỳ</th><th>Ngày Thu DK</th><th>Tiền Lãi</th><th>Đã Thu</th><th>Còn Lại</th><th>Thao Tác</th>
                </tr></thead>
                <tbody>
                <?php foreach ($quaHan as $ky): ?>
                <tr class="table-danger">
                    <td><a href="/hop-dong/detail/<?= $ky['hop_dong_id'] ?>"><?= htmlspecialchars($ky['ma_hop_dong']) ?></a></td>
                    <td><?= htmlspecialchars($ky['ten_khach']) ?></td>
                    <td><a href="tel:<?= htmlspecialchars($ky['sdt']) ?>"><?= htmlspecialchars($ky['sdt']) ?></a></td>
                    <td><?= $ky['ky_thu'] ?></td>
                    <td class="text-danger fw-bold"><?= formatDate($ky['ngay_thu_du_kien']) ?></td>
                    <td><?= formatMoney($ky['so_tien_lai']) ?></td>
                    <td><?= formatMoney($ky['so_tien_da_thu']) ?></td>
                    <td class="fw-bold"><?= formatMoney(floatval($ky['so_tien_lai']) - floatval($ky['so_tien_da_thu'])) ?></td>
                    <td>
                        <a href="/thu-tien/thu-lai/<?= $ky['id'] ?>" class="btn btn-sm btn-danger py-0">
                            <i class="fas fa-money-bill me-1"></i>Thu
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Upcoming periods -->
<div class="card shadow-sm">
    <div class="card-header bg-warning d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Sắp Đến Hạn Thu (7 ngày tới)</h6>
        <span class="badge bg-dark"><?= count($sapDenHan) ?></span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($sapDenHan)): ?>
        <p class="text-center text-muted py-3">Không có kỳ nào sắp đến hạn</p>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <thead class="table-light"><tr>
                    <th>Hợp Đồng</th><th>Khách Hàng</th><th>SĐT</th><th>Kỳ</th><th>Ngày Thu DK</th><th>Tiền Lãi</th><th>Trạng Thái</th><th>Thao Tác</th>
                </tr></thead>
                <tbody>
                <?php foreach ($sapDenHan as $ky): ?>
                <?php
                $daysLeft = (strtotime($ky['ngay_thu_du_kien']) - time()) / 86400;
                $rowClass = $daysLeft <= 1 ? 'table-warning' : '';
                ?>
                <tr class="<?= $rowClass ?>">
                    <td><a href="/hop-dong/detail/<?= $ky['hop_dong_id'] ?>"><?= htmlspecialchars($ky['ma_hop_dong']) ?></a></td>
                    <td><?= htmlspecialchars($ky['ten_khach']) ?></td>
                    <td><a href="tel:<?= htmlspecialchars($ky['sdt']) ?>"><?= htmlspecialchars($ky['sdt']) ?></a></td>
                    <td><?= $ky['ky_thu'] ?></td>
                    <td><?= formatDate($ky['ngay_thu_du_kien']) ?></td>
                    <td><?= formatMoney($ky['so_tien_lai']) ?></td>
                    <td><span class="badge bg-info"><?= ceil($daysLeft) ?> ngày nữa</span></td>
                    <td>
                        <a href="/thu-tien/thu-lai/<?= $ky['id'] ?>" class="btn btn-sm btn-warning py-0">
                            <i class="fas fa-money-bill me-1"></i>Thu
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
