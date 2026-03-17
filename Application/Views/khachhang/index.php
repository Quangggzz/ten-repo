<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-users me-2 text-primary"></i>Danh Sách Khách Hàng</h5>
    <a href="/khach-hang/create" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i>Thêm Khách Hàng
    </a>
</div>

<!-- Search form -->
<div class="card shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" action="/khach-hang/search" class="d-flex gap-2">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Tìm theo tên, CMND, SĐT..." value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-search"></i></button>
            <?php if (!empty($keyword)): ?>
            <a href="/khach-hang" class="btn btn-outline-secondary btn-sm">Xóa</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Họ Tên</th>
                        <th>CMND/CCCD</th>
                        <th>Số Điện Thoại</th>
                        <th>Địa Chỉ</th>
                        <th>Ngày Sinh</th>
                        <th>Giới Tính</th>
                        <th class="text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($khachHang)): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">Không có dữ liệu</td></tr>
                <?php else: ?>
                    <?php foreach ($khachHang as $i => $kh): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($kh['ho_ten']) ?></td>
                        <td><?= htmlspecialchars($kh['cmnd']) ?></td>
                        <td><a href="tel:<?= htmlspecialchars($kh['sdt']) ?>"><?= htmlspecialchars($kh['sdt']) ?></a></td>
                        <td><?= htmlspecialchars($kh['dia_chi'] ?? '') ?></td>
                        <td><?= formatDate($kh['ngay_sinh'] ?? '') ?></td>
                        <td><?= $kh['gioi_tinh'] === 'nam' ? '<i class="fas fa-mars text-primary"></i> Nam' : '<i class="fas fa-venus text-danger"></i> Nữ' ?></td>
                        <td class="text-center">
                            <a href="/khach-hang/edit/<?= $kh['id'] ?>" class="btn btn-sm btn-outline-warning py-0">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/khach-hang/delete/<?= $kh['id'] ?>" class="btn btn-sm btn-outline-danger py-0"
                               onclick="return confirm('Xóa khách hàng này?')">
                                <i class="fas fa-trash"></i>
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
