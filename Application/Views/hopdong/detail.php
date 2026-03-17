<?php
$trangThaiLabels = [
    'dang_cam' => '<span class="badge badge-dang_cam fs-6">Đang Cầm</span>',
    'da_chuoc'  => '<span class="badge badge-da_chuoc fs-6">Đã Chuộc</span>',
    'thanh_ly'  => '<span class="badge badge-thanh_ly fs-6">Thanh Lý</span>',
    'qua_han'   => '<span class="badge badge-qua_han fs-6">Quá Hạn</span>',
];
$loaiThuLabels = ['thu_lai'=>'Thu Lãi','thu_goc'=>'Thu Gốc','thu_chuoc'=>'Thu Chuộc','thu_phat'=>'Phạt','thu_khac'=>'Khác'];
$phuongThucLabels = ['tien_mat'=>'Tiền Mặt','chuyen_khoan'=>'Chuyển Khoản','khac'=>'Khác'];
?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h5 class="fw-bold mb-0">
        <i class="fas fa-file-contract me-2"></i>
        <?= htmlspecialchars($hopDong['ma_hop_dong']) ?>
        <?= $trangThaiLabels[$hopDong['trang_thai']] ?? '' ?>
    </h5>
    <div class="d-flex gap-2 flex-wrap no-print">
        <?php if ($hopDong['trang_thai'] === 'dang_cam'): ?>
        <a href="/thu-tien/thu-tien-form/<?= $hopDong['id'] ?>" class="btn btn-success btn-sm">
            <i class="fas fa-money-bill me-1"></i>Thu Tiền
        </a>
        <a href="/hop-dong/chuoc/<?= $hopDong['id'] ?>" class="btn btn-primary btn-sm"
           onclick="return confirm('Xác nhận khách đã chuộc?')">
            <i class="fas fa-undo me-1"></i>Chuộc
        </a>
        <a href="/hop-dong/thanh-ly/<?= $hopDong['id'] ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Xác nhận thanh lý hợp đồng này?')">
            <i class="fas fa-ban me-1"></i>Thanh Lý
        </a>
        <?php endif; ?>
        <a href="/hop-dong/edit/<?= $hopDong['id'] ?>" class="btn btn-warning btn-sm">
            <i class="fas fa-edit me-1"></i>Sửa
        </a>
        <a href="/hop-dong/print/<?= $hopDong['id'] ?>" class="btn btn-outline-secondary btn-sm" target="_blank">
            <i class="fas fa-print me-1"></i>In
        </a>
        <a href="/hop-dong" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Quay lại
        </a>
    </div>
</div>

<!-- Contract & Customer Info -->
<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white"><h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Thông Tin Hợp Đồng</h6></div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted w-40">Mã HĐ:</td><td class="fw-bold"><?= htmlspecialchars($hopDong['ma_hop_dong']) ?></td></tr>
                    <tr><td class="text-muted">Ngày cầm:</td><td><?= formatDate($hopDong['ngay_cam']) ?></td></tr>
                    <tr><td class="text-muted">Đáo hạn:</td><td class="<?= strtotime($hopDong['ngay_dao_han']) < time() && $hopDong['trang_thai']==='dang_cam' ? 'text-danger fw-bold' : '' ?>"><?= formatDate($hopDong['ngay_dao_han']) ?></td></tr>
                    <tr><td class="text-muted">Số tiền cầm:</td><td class="fw-bold text-primary"><?= formatMoney($hopDong['so_tien_cam']) ?></td></tr>
                    <tr><td class="text-muted">Lãi suất:</td><td><?= $hopDong['lai_suat'] ?>%/tháng</td></tr>
                    <tr><td class="text-muted">Tiền lãi:</td><td><?= formatMoney($hopDong['tien_lai']) ?></td></tr>
                    <tr><td class="text-muted">Tổng chuộc:</td><td class="fw-bold text-success"><?= formatMoney($hopDong['tong_tien_chuoc']) ?></td></tr>
                    <tr><td class="text-muted">Chu kỳ thu:</td><td><?= ['hang_thang'=>'Hàng tháng','hang_tuan'=>'Hàng tuần','hang_ngay'=>'Hàng ngày','cuoi_ky'=>'Cuối kỳ'][$hopDong['chu_ky_thu_lai']] ?? '' ?></td></tr>
                    <tr><td class="text-muted">Lãi đã thu:</td><td><?= formatMoney($hopDong['tong_lai_da_thu']) ?></td></tr>
                    <?php if (!empty($hopDong['ghi_chu'])): ?>
                    <tr><td class="text-muted">Ghi chú:</td><td><?= htmlspecialchars($hopDong['ghi_chu']) ?></td></tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white"><h6 class="mb-0"><i class="fas fa-user me-2"></i>Thông Tin Khách Hàng</h6></div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted w-40">Họ tên:</td><td class="fw-bold"><?= htmlspecialchars($hopDong['ten_khach']) ?></td></tr>
                    <tr><td class="text-muted">CMND:</td><td><?= htmlspecialchars($hopDong['cmnd'] ?? '') ?></td></tr>
                    <tr><td class="text-muted">SĐT:</td><td><a href="tel:<?= htmlspecialchars($hopDong['sdt'] ?? '') ?>"><?= htmlspecialchars($hopDong['sdt'] ?? '') ?></a></td></tr>
                    <tr><td class="text-muted">Địa chỉ:</td><td><?= htmlspecialchars($hopDong['dia_chi'] ?? '') ?></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Pawned Items -->
<div class="card shadow-sm mb-3">
    <div class="card-header"><h6 class="mb-0"><i class="fas fa-boxes me-2"></i>Danh Sách Món Cầm</h6></div>
    <div class="card-body p-0">
        <?php if (empty($monCam)): ?>
        <p class="text-muted text-center py-3">Không có món cầm</p>
        <?php else: ?>
        <?php foreach ($monCam as $mc): ?>
        <div class="border-bottom p-3">
            <div class="row align-items-start">
                <div class="col-md-8">
                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($mc['ten_mon']) ?></h6>
                    <div class="small text-muted">
                        Loại: <?= ['vang'=>'Vàng','xe'=>'Xe','dien_thoai'=>'Điện Thoại','laptop'=>'Laptop','khac'=>'Khác'][$mc['loai_mon']] ?? $mc['loai_mon'] ?> |
                        SL: <?= $mc['so_luong'] ?> |
                        Tình trạng: <?= ['tot'=>'Tốt','kha'=>'Khá','trung_binh'=>'Trung bình'][$mc['tinh_trang']] ?? $mc['tinh_trang'] ?> |
                        Định giá: <strong><?= formatMoney($mc['gia_tri_dinh_gia']) ?></strong>
                    </div>
                    <?php if (!empty($mc['mo_ta'])): ?>
                    <div class="small text-muted mt-1"><?= htmlspecialchars($mc['mo_ta']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 no-print">
                    <form method="POST" action="/hinh-anh/upload" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                        <input type="hidden" name="mon_cam_id" value="<?= $mc['id'] ?>">
                        <input type="hidden" name="hop_dong_id" value="<?= $hopDong['id'] ?>">
                        <input type="file" name="hinh_anh[]" class="form-control form-control-sm" multiple accept="image/*">
                        <button type="submit" class="btn btn-sm btn-outline-primary text-nowrap">
                            <i class="fas fa-upload"></i>
                        </button>
                    </form>
                </div>
            </div>
            <!-- Images for this item -->
            <?php
            $anhCuaMon = array_filter($hinhAnh, fn($a) => (int)$a['mon_cam_id'] === (int)$mc['id']);
            if (!empty($anhCuaMon)): ?>
            <div class="d-flex flex-wrap gap-2 mt-2">
                <?php foreach ($anhCuaMon as $anh): ?>
                <div class="position-relative">
                    <img src="/Upload/<?= htmlspecialchars($anh['file_path']) ?>"
                         class="rounded" style="width:80px;height:80px;object-fit:cover;"
                         onerror="this.src='/Application/Views/assets/img-placeholder.png';this.onerror=null;">
                    <a href="/hinh-anh/delete/<?= $anh['id'] ?>"
                       class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 lh-1 no-print"
                       style="width:18px;height:18px;font-size:10px;"
                       onclick="return confirm('Xóa hình này?')">×</a>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Payment Schedule -->
<div class="card shadow-sm mb-3">
    <div class="card-header d-flex justify-content-between">
        <h6 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Lịch Thu Lãi</h6>
        <?php if ($tongHop): ?>
        <small class="text-muted">
            Đã thu: <?= $tongHop['so_ky_da_thu'] ?>/<?= $tongHop['tong_ky'] ?> kỳ |
            Tổng đã thu: <?= formatMoney($tongHop['tong_lai_da_thu'] ?? 0) ?>
        </small>
        <?php endif; ?>
    </div>
    <div class="card-body p-0">
        <?php if (empty($lichThuLai)): ?>
        <p class="text-muted text-center py-3">Chưa có lịch thu</p>
        <?php else: ?>
        <div class="table-responsive" style="max-height:300px;overflow-y:auto">
            <table class="table table-sm mb-0">
                <thead class="table-light sticky-top">
                    <tr><th>Kỳ</th><th>Ngày Thu DK</th><th>Tiền Lãi</th><th>Đã Thu</th><th>Còn Lại</th><th>Trạng Thái</th><th class="no-print">Thao Tác</th></tr>
                </thead>
                <tbody>
                <?php foreach ($lichThuLai as $ky): ?>
                <?php
                $rowClass = '';
                if ($ky['trang_thai'] === 'da_thu') $rowClass = 'table-success';
                elseif ($ky['trang_thai'] === 'thu_mot_phan') $rowClass = 'table-warning';
                elseif ($ky['trang_thai'] === 'qua_han') $rowClass = 'table-danger';
                $conLai = floatval($ky['so_tien_lai']) - floatval($ky['so_tien_da_thu']);
                $trangThaiMap = ['chua_thu'=>'Chưa Thu','da_thu'=>'Đã Thu','thu_mot_phan'=>'Thu Một Phần','qua_han'=>'Quá Hạn'];
                ?>
                <tr class="<?= $rowClass ?>">
                    <td><?= $ky['ky_thu'] ?></td>
                    <td><?= formatDate($ky['ngay_thu_du_kien']) ?></td>
                    <td><?= formatMoney($ky['so_tien_lai']) ?></td>
                    <td><?= formatMoney($ky['so_tien_da_thu']) ?></td>
                    <td><?= $conLai > 0 ? formatMoney($conLai) : '-' ?></td>
                    <td><small><?= $trangThaiMap[$ky['trang_thai']] ?? $ky['trang_thai'] ?></small></td>
                    <td class="no-print">
                        <?php if ($ky['trang_thai'] !== 'da_thu'): ?>
                        <a href="/thu-tien/thu-lai/<?= $ky['id'] ?>" class="btn btn-sm btn-success py-0">
                            <i class="fas fa-money-bill-wave"></i> Thu
                        </a>
                        <?php else: ?>
                        <span class="text-success"><i class="fas fa-check"></i></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Payment History -->
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h6 class="mb-0"><i class="fas fa-history me-2"></i>Lịch Sử Thu Tiền</h6>
        <span class="fw-bold text-success">Tổng: <?= formatMoney($tongThu) ?></span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($lichSu)): ?>
        <p class="text-muted text-center py-3">Chưa có lịch sử thu tiền</p>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <thead class="table-light"><tr><th>Mã Phiếu</th><th>Loại Thu</th><th>Số Tiền</th><th>Phương Thức</th><th>Ngày Thu</th><th>Người Thu</th><th class="no-print"></th></tr></thead>
                <tbody>
                <?php foreach ($lichSu as $ls): ?>
                <tr>
                    <td><?= htmlspecialchars($ls['ma_phieu_thu']) ?></td>
                    <td><?= $loaiThuLabels[$ls['loai_thu']] ?? $ls['loai_thu'] ?></td>
                    <td class="fw-bold text-success"><?= formatMoney($ls['so_tien']) ?></td>
                    <td><?= $phuongThucLabels[$ls['phuong_thuc']] ?? $ls['phuong_thuc'] ?></td>
                    <td><?= formatDate($ls['ngay_thu']) ?></td>
                    <td><?= htmlspecialchars($ls['nguoi_thu']) ?></td>
                    <td class="no-print"><a href="/thu-tien/chi-tiet/<?= $ls['id'] ?>" class="btn btn-sm btn-outline-info py-0"><i class="fas fa-eye"></i></a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
