<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Thu - <?= htmlspecialchars($phieu['ma_phieu_thu']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .receipt { max-width: 640px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.1); }
        .receipt-header { background: linear-gradient(135deg, #2c3e50, #e67e22); color: #fff; padding: 1.5rem; text-align: center; }
        .receipt-body { padding: 1.5rem; }
        .receipt-row { display: flex; justify-content: space-between; padding: .5rem 0; border-bottom: 1px dashed #eee; }
        .receipt-row:last-child { border-bottom: none; }
        .receipt-total { background: #f8f9fa; border-radius: 8px; padding: 1rem; text-align: center; margin: 1rem 0; }
        .signatures { display: flex; justify-content: space-between; margin-top: 2rem; }
        .signatures div { text-align: center; width: 40%; }
        .signatures .sig-line { border-top: 1px solid #333; margin-top: 60px; padding-top: 5px; font-size: .9rem; }
        @media print {
            body { background: white; }
            .receipt { box-shadow: none; max-width: 100%; margin: 0; border-radius: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
<div class="receipt">
    <div class="receipt-header">
        <h4 class="mb-1"><i class="fas fa-store me-2"></i><?= APP_NAME ?></h4>
        <p class="mb-0 opacity-75 small">PHIẾU THU TIỀN</p>
    </div>
    <div class="receipt-body">
        <div class="text-center mb-3">
            <div class="display-6 fw-bold text-success"><?= htmlspecialchars($phieu['ma_phieu_thu']) ?></div>
        </div>

        <div class="receipt-row"><span class="text-muted">Hợp đồng:</span><strong><?= htmlspecialchars($phieu['ma_hop_dong']) ?></strong></div>
        <div class="receipt-row"><span class="text-muted">Khách hàng:</span><strong><?= htmlspecialchars($phieu['ten_khach']) ?></strong></div>
        <div class="receipt-row"><span class="text-muted">SĐT:</span><span><?= htmlspecialchars($phieu['sdt'] ?? '') ?></span></div>
        <div class="receipt-row"><span class="text-muted">Loại thu:</span><span><?= ['thu_lai'=>'Thu Lãi','thu_goc'=>'Thu Gốc','thu_chuoc'=>'Thu Chuộc','thu_phat'=>'Phạt','thu_khac'=>'Khác'][$phieu['loai_thu']] ?? $phieu['loai_thu'] ?></span></div>
        <div class="receipt-row"><span class="text-muted">Phương thức:</span><span><?= ['tien_mat'=>'Tiền Mặt','chuyen_khoan'=>'Chuyển Khoản','khac'=>'Khác'][$phieu['phuong_thuc']] ?? $phieu['phuong_thuc'] ?></span></div>
        <div class="receipt-row"><span class="text-muted">Ngày thu:</span><span><?= formatDate($phieu['ngay_thu']) ?></span></div>
        <div class="receipt-row"><span class="text-muted">Người thu:</span><span><?= htmlspecialchars($phieu['nguoi_thu']) ?></span></div>
        <?php if (!empty($phieu['ghi_chu'])): ?>
        <div class="receipt-row"><span class="text-muted">Ghi chú:</span><span><?= htmlspecialchars($phieu['ghi_chu']) ?></span></div>
        <?php endif; ?>

        <div class="receipt-total">
            <div class="text-muted small">SỐ TIỀN</div>
            <div class="fs-2 fw-bold text-success"><?= formatMoney($phieu['so_tien']) ?></div>
        </div>

        <div class="signatures">
            <div>
                <p class="small mb-0">Người nộp tiền</p>
                <div class="sig-line"><?= htmlspecialchars($phieu['nguoi_nop'] ?? '') ?></div>
            </div>
            <div>
                <p class="small mb-0">Người thu tiền</p>
                <div class="sig-line"><?= htmlspecialchars($phieu['nguoi_thu']) ?></div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4 no-print">
            <button onclick="window.print()" class="btn btn-outline-secondary w-100">
                <i class="fas fa-print me-2"></i>In Phiếu
            </button>
            <a href="/hop-dong/detail/<?= $phieu['hop_dong_id'] ?>" class="btn btn-primary w-100">
                <i class="fas fa-file-contract me-2"></i>Xem HĐ
            </a>
            <a href="/thu-tien" class="btn btn-outline-dark w-100">
                <i class="fas fa-list me-2"></i>Lịch Sử
            </a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
