<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-file-contract me-2 text-orange"></i>Danh Sách Hợp Đồng Cầm</h5>
    <a href="/hop-dong/create" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i>Tạo Hợp Đồng Mới
    </a>
</div>

<?php
$trangThaiLabels = [
    'dang_cam' => '<span class="badge badge-dang_cam">Đang Cầm</span>',
    'da_chuoc'  => '<span class="badge badge-da_chuoc">Đã Chuộc</span>',
    'thanh_ly'  => '<span class="badge badge-thanh_ly">Thanh Lý</span>',
    'qua_han'   => '<span class="badge badge-qua_han">Quá Hạn</span>',
];
?>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Mã HĐ</th>
                        <th>Khách Hàng</th>
                        <th>SĐT</th>
                        <th>Ngày Cầm</th>
                        <th>Đáo Hạn</th>
                        <th>Số Tiền Cầm</th>
                        <th>Lãi Suất</th>
                        <th>Trạng Thái</th>
                        <th>Kỳ QH</th>
                        <th class="text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($hopDong)): ?>
                    <tr><td colspan="10" class="text-center text-muted py-4">Không có hợp đồng nào</td></tr>
                <?php else: ?>
                    <?php foreach ($hopDong as $hd): ?>
                    <?php $isOverdue = $hd['trang_thai'] === 'dang_cam' && strtotime($hd['ngay_dao_han']) < time(); ?>
                    <tr class="<?= $isOverdue ? 'table-danger' : '' ?>">
                        <td><a href="/hop-dong/detail/<?= $hd['id'] ?>" class="fw-semibold"><?= htmlspecialchars($hd['ma_hop_dong']) ?></a></td>
                        <td><?= htmlspecialchars($hd['ten_khach']) ?></td>
                        <td><a href="tel:<?= htmlspecialchars($hd['sdt'] ?? '') ?>"><?= htmlspecialchars($hd['sdt'] ?? '') ?></a></td>
                        <td><?= formatDate($hd['ngay_cam']) ?></td>
                        <td class="<?= $isOverdue ? 'text-danger fw-bold' : '' ?>"><?= formatDate($hd['ngay_dao_han']) ?></td>
                        <td><?= formatMoney($hd['so_tien_cam']) ?></td>
                        <td><?= $hd['lai_suat'] ?>%/tháng</td>
                        <td><?= $trangThaiLabels[$hd['trang_thai']] ?? $hd['trang_thai'] ?></td>
                        <td><?= intval($hd['so_ky_qua_han']) > 0 ? '<span class="badge bg-danger">' . $hd['so_ky_qua_han'] . '</span>' : '-' ?></td>
                        <td class="text-center">
                            <a href="/hop-dong/detail/<?= $hd['id'] ?>" class="btn btn-sm btn-outline-info py-0" title="Chi tiết"><i class="fas fa-eye"></i></a>
                            <a href="/hop-dong/edit/<?= $hd['id'] ?>" class="btn btn-sm btn-outline-warning py-0" title="Sửa"><i class="fas fa-edit"></i></a>
                            <a href="/hop-dong/delete/<?= $hd['id'] ?>" class="btn btn-sm btn-outline-danger py-0"
                               onclick="return confirm('Xóa hợp đồng này?')" title="Xóa"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
