<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="fas fa-box me-2 text-warning"></i>Danh Sách Món Cầm</h5>
    <a href="/mon-cam/create" class="btn btn-warning btn-sm text-dark">
        <i class="fas fa-plus me-1"></i>Thêm Món Cầm
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tên Món</th>
                        <th>Loại</th>
                        <th>Hợp Đồng</th>
                        <th>Khách Hàng</th>
                        <th>Số Lượng</th>
                        <th>Tình Trạng</th>
                        <th>Giá Trị</th>
                        <th class="text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $loaiLabels = ['vang'=>'Vàng','xe'=>'Xe','dien_thoai'=>'Điện Thoại','laptop'=>'Laptop','khac'=>'Khác'];
                $tinhTrangLabels = ['tot'=>'<span class="badge bg-success">Tốt</span>','kha'=>'<span class="badge bg-primary">Khá</span>','trung_binh'=>'<span class="badge bg-warning text-dark">T.Bình</span>'];
                ?>
                <?php if (empty($monCam)): ?>
                    <tr><td colspan="9" class="text-center text-muted py-4">Không có dữ liệu</td></tr>
                <?php else: ?>
                    <?php foreach ($monCam as $i => $mc): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($mc['ten_mon']) ?></td>
                        <td><?= $loaiLabels[$mc['loai_mon']] ?? $mc['loai_mon'] ?></td>
                        <td><a href="/hop-dong/detail/<?= $mc['hop_dong_id'] ?>"><?= htmlspecialchars($mc['ma_hop_dong'] ?? '') ?></a></td>
                        <td><?= htmlspecialchars($mc['ten_khach'] ?? '') ?></td>
                        <td><?= $mc['so_luong'] ?></td>
                        <td><?= $tinhTrangLabels[$mc['tinh_trang']] ?? $mc['tinh_trang'] ?></td>
                        <td><?= formatMoney($mc['gia_tri_dinh_gia']) ?></td>
                        <td class="text-center">
                            <a href="/mon-cam/edit/<?= $mc['id'] ?>" class="btn btn-sm btn-outline-warning py-0"><i class="fas fa-edit"></i></a>
                            <a href="/mon-cam/delete/<?= $mc['id'] ?>" class="btn btn-sm btn-outline-danger py-0"
                               onclick="return confirm('Xóa món cầm này?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
