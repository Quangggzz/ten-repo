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

<!-- Inline styles & lightbox overlay -->
<style>
.upload-dropzone {
    border: 2px dashed #6c9bd1;
    border-radius: 10px;
    padding: 18px 12px;
    text-align: center;
    background: #f0f6ff;
    cursor: pointer;
    transition: background .2s, border-color .2s;
    position: relative;
}
.upload-dropzone.dragover {
    background: #dceeff;
    border-color: #0d6efd;
}
.upload-dropzone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.upload-dropzone .dz-icon { font-size: 2rem; color: #6c9bd1; }
.upload-dropzone .dz-label { font-size: .85rem; color: #555; margin-top: 4px; }
.upload-preview-list { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
.upload-preview-item {
    position: relative;
    width: 72px; height: 72px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #dee2e6;
    background: #f8f9fa;
}
.upload-preview-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
.upload-preview-item .preview-info {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(0,0,0,.55); color: #fff;
    font-size: 9px; padding: 2px 3px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.upload-preview-item .preview-remove {
    position: absolute; top: 2px; right: 2px;
    width: 16px; height: 16px; border-radius: 50%;
    background: rgba(220,53,69,.85); color: #fff;
    border: none; font-size: 11px; line-height: 1;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    padding: 0;
}
.img-thumb-wrap {
    position: relative;
    width: 120px; height: 120px;
    border-radius: 10px;
    overflow: hidden;
    border: 2px solid #dee2e6;
    background: #f8f9fa;
    cursor: zoom-in;
    transition: transform .2s, box-shadow .2s;
}
.img-thumb-wrap:hover { transform: scale(1.04); box-shadow: 0 4px 16px rgba(0,0,0,.18); }
.img-thumb-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
.img-thumb-wrap .thumb-delete {
    position: absolute; top: 4px; right: 4px;
    width: 24px; height: 24px; border-radius: 50%;
    background: rgba(220,53,69,.85); color: #fff;
    border: none; font-size: 13px; line-height: 1;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    padding: 0; text-decoration: none;
    opacity: 0; transition: opacity .2s;
}
.img-thumb-wrap:hover .thumb-delete { opacity: 1; }
.img-gallery-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
/* Lightbox */
#img-lightbox {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,.88);
    z-index: 9999;
    align-items: center; justify-content: center;
    flex-direction: column;
}
#img-lightbox.active { display: flex; }
#img-lightbox img {
    max-width: 92vw; max-height: 85vh;
    border-radius: 8px;
    box-shadow: 0 8px 40px rgba(0,0,0,.6);
}
#img-lightbox .lb-close {
    position: fixed; top: 18px; right: 24px;
    color: #fff; font-size: 2.2rem; cursor: pointer;
    line-height: 1; background: none; border: none; padding: 0;
}
#img-lightbox .lb-nav {
    position: fixed; top: 50%; transform: translateY(-50%);
    color: #fff; font-size: 2.5rem; cursor: pointer;
    background: rgba(255,255,255,.12); border: none; border-radius: 50%;
    width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;
    padding: 0; transition: background .2s;
}
#img-lightbox .lb-nav:hover { background: rgba(255,255,255,.25); }
#img-lightbox .lb-prev { left: 14px; }
#img-lightbox .lb-next { right: 14px; }
#img-lightbox .lb-caption {
    color: rgba(255,255,255,.7); font-size: .85rem; margin-top: 10px;
}
</style>

<!-- Lightbox overlay (shared for all items) -->
<div id="img-lightbox" onclick="if(event.target===this)closeLightbox()">
    <button class="lb-close" onclick="closeLightbox()" aria-label="Đóng">&#x2715;</button>
    <button class="lb-nav lb-prev" onclick="lbNav(-1)" aria-label="Ảnh trước">&#8249;</button>
    <img id="lb-img" src="" alt="Ảnh phóng to">
    <div id="lb-caption" class="lb-caption"></div>
    <button class="lb-nav lb-next" onclick="lbNav(1)" aria-label="Ảnh tiếp theo">&#8250;</button>
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
            <div class="row align-items-start g-3">
                <div class="col-md-7">
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
                <div class="col-md-5 no-print">
                    <form method="POST" action="/hinh-anh/upload" enctype="multipart/form-data"
                          class="upload-form" data-item-id="<?= $mc['id'] ?>">
                        <input type="hidden" name="mon_cam_id" value="<?= $mc['id'] ?>">
                        <input type="hidden" name="hop_dong_id" value="<?= $hopDong['id'] ?>">
                        <div class="upload-dropzone" id="dz-<?= $mc['id'] ?>"
                             ondragover="dzDragOver(event,this)" ondragleave="dzDragLeave(this)"
                             ondrop="dzDrop(event,this)">
                            <input type="file" name="hinh_anh[]" multiple accept="image/*"
                                   aria-label="Chọn ảnh để tải lên"
                                   onchange="dzPreview(this, <?= $mc['id'] ?>)">
                            <div class="dz-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <div class="dz-label">Kéo thả ảnh vào đây<br><small class="text-primary">hoặc click để chọn file</small></div>
                        </div>
                        <div class="upload-preview-list" id="preview-<?= $mc['id'] ?>"></div>
                        <div id="dz-info-<?= $mc['id'] ?>" class="small text-muted mt-1" style="display:none;"></div>
                        <button type="submit" class="btn btn-primary btn-sm mt-2 w-100" style="display:none;"
                                id="btn-upload-<?= $mc['id'] ?>">
                            <i class="fas fa-upload me-1"></i>Tải Lên Ảnh
                        </button>
                    </form>
                </div>
            </div>
            <!-- Images for this item -->
            <?php
            $anhCuaMon = array_filter($hinhAnh, fn($a) => (int)$a['mon_cam_id'] === (int)$mc['id']);
            if (!empty($anhCuaMon)):
                $anhList = array_values($anhCuaMon);
            ?>
            <div class="img-gallery-grid" id="gallery-<?= $mc['id'] ?>">
                <?php foreach ($anhList as $idx => $anh): ?>
                <div class="img-thumb-wrap"
                     data-gallery="<?= $mc['id'] ?>"
                     data-src="/Upload/<?= htmlspecialchars($anh['file_path']) ?>"
                     data-idx="<?= $idx ?>"
                     onclick="openLightbox(<?= $mc['id'] ?>, <?= $idx ?>)">
                    <img src="/Upload/<?= htmlspecialchars($anh['file_path']) ?>"
                         alt="Ảnh món cầm <?= htmlspecialchars($mc['ten_mon']) ?>"
                         onerror="this.src='/Application/Views/assets/img-placeholder.png';this.onerror=null;">
                    <a href="/hinh-anh/delete/<?= $anh['id'] ?>"
                       class="thumb-delete no-print"
                       title="Xóa ảnh"
                       aria-label="Xóa ảnh"
                       onclick="event.stopPropagation();return confirm('Xóa hình này?')">&#x2715;</a>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
(function () {
    /* ---- Drag & drop helpers ---- */
    window.dzDragOver = function (e, el) {
        e.preventDefault();
        el.classList.add('dragover');
    };
    window.dzDragLeave = function (el) {
        el.classList.remove('dragover');
    };
    window.dzDrop = function (e, el) {
        e.preventDefault();
        el.classList.remove('dragover');
        var input = el.querySelector('input[type="file"]');
        var itemId = el.id.replace('dz-', '');
        // Transfer dropped files to the hidden input via DataTransfer
        var dt = e.dataTransfer;
        if (dt && dt.files && dt.files.length) {
            try {
                var newDt = new DataTransfer();
                // Merge existing + dropped
                if (input.files) {
                    for (var i = 0; i < input.files.length; i++) newDt.items.add(input.files[i]);
                }
                for (var i = 0; i < dt.files.length; i++) newDt.items.add(dt.files[i]);
                input.files = newDt.files;
            } catch(ex) {
                // Fallback: just set dropped files
                input.files = dt.files;
            }
            dzPreview(input, itemId);
        }
    };

    /* ---- Preview helper ---- */
    window.dzPreview = function (input, itemId) {
        var previewEl = document.getElementById('preview-' + itemId);
        var infoEl    = document.getElementById('dz-info-' + itemId);
        var btnEl     = document.getElementById('btn-upload-' + itemId);
        previewEl.innerHTML = '';
        var files = input.files;
        if (!files || !files.length) {
            infoEl.style.display = 'none';
            btnEl.style.display  = 'none';
            return;
        }
        var totalSize = 0;
        for (var i = 0; i < files.length; i++) {
            totalSize += files[i].size;
            (function(file, idx) {
                var wrap = document.createElement('div');
                wrap.className = 'upload-preview-item';

                var img = document.createElement('img');
                var reader = new FileReader();
                reader.onload = function(ev) { img.src = ev.target.result; };
                reader.readAsDataURL(file);
                wrap.appendChild(img);

                var info = document.createElement('div');
                info.className = 'preview-info';
                info.title = file.name;
                info.textContent = file.name;
                wrap.appendChild(info);

                var rmBtn = document.createElement('button');
                rmBtn.className = 'preview-remove';
                rmBtn.type = 'button';
                rmBtn.title = 'Bỏ chọn';
                rmBtn.innerHTML = '&times;';
                rmBtn.onclick = function () {
                    var newDt = new DataTransfer();
                    var allFiles = input.files;
                    for (var j = 0; j < allFiles.length; j++) {
                        if (j !== idx) newDt.items.add(allFiles[j]);
                    }
                    input.files = newDt.files;
                    dzPreview(input, itemId);
                };
                wrap.appendChild(rmBtn);
                previewEl.appendChild(wrap);
            })(files[i], i);
        }
        var sizeKB = (totalSize / 1024).toFixed(1);
        infoEl.textContent = files.length + ' file • ' + sizeKB + ' KB';
        infoEl.style.display = 'block';
        btnEl.style.display  = 'block';
    };

    /* ---- Lightbox ---- */
    var lbGalleries = {};

    // Build gallery index from DOM on load
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.img-thumb-wrap').forEach(function (el) {
            var gid = el.dataset.gallery;
            if (!lbGalleries[gid]) lbGalleries[gid] = [];
            lbGalleries[gid].push({
                src:   el.dataset.src,
                title: el.querySelector('img') ? el.querySelector('img').alt : ''
            });
        });
    });

    var _lbGid = null, _lbIdx = 0;

    window.openLightbox = function (gid, idx) {
        _lbGid = String(gid);
        _lbIdx = idx;
        showLbImage();
        document.getElementById('img-lightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    window.closeLightbox = function () {
        document.getElementById('img-lightbox').classList.remove('active');
        document.body.style.overflow = '';
        _lbGid = null;
    };
    window.lbNav = function (dir) {
        if (!_lbGid) return;
        var arr = lbGalleries[_lbGid] || [];
        _lbIdx = (_lbIdx + dir + arr.length) % arr.length;
        showLbImage();
    };
    function showLbImage() {
        var arr = lbGalleries[_lbGid] || [];
        if (!arr.length) return;
        var item = arr[_lbIdx];
        document.getElementById('lb-img').src = item.src;
        document.getElementById('lb-caption').textContent = (_lbIdx + 1) + ' / ' + arr.length;
    }
    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        var lb = document.getElementById('img-lightbox');
        if (!lb.classList.contains('active')) return;
        if (e.key === 'Escape')      closeLightbox();
        else if (e.key === 'ArrowLeft')  lbNav(-1);
        else if (e.key === 'ArrowRight') lbNav(1);
    });
})();
</script>

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
