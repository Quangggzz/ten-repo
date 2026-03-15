<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>In Hợp Đồng - <?= htmlspecialchars($hopDong['ma_hop_dong']) ?></title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 13pt; margin: 20mm; }
        h1 { text-align: center; font-size: 16pt; text-transform: uppercase; }
        h2 { text-align: center; font-size: 14pt; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        table th, table td { border: 1px solid #333; padding: 6px 8px; }
        table th { background: #f0f0f0; }
        .info-row { display: flex; margin: 6px 0; }
        .info-label { width: 180px; font-weight: bold; }
        .signature { display: flex; justify-content: space-between; margin-top: 40px; }
        .signature div { text-align: center; width: 40%; }
        .signature p { margin-bottom: 60px; }
        @media print { body { margin: 10mm; } }
    </style>
</head>
<body>
<h1><?= APP_NAME ?></h1>
<h2>HỢP ĐỒNG CẦM ĐỒ</h2>
<p style="text-align:center">Mã: <?= htmlspecialchars($hopDong['ma_hop_dong']) ?></p>
<hr>

<h3>I. THÔNG TIN KHÁCH HÀNG</h3>
<div class="info-row"><div class="info-label">Họ tên:</div><div><?= htmlspecialchars($hopDong['ten_khach']) ?></div></div>
<div class="info-row"><div class="info-label">CMND/CCCD:</div><div><?= htmlspecialchars($hopDong['cmnd'] ?? '') ?></div></div>
<div class="info-row"><div class="info-label">Số điện thoại:</div><div><?= htmlspecialchars($hopDong['sdt'] ?? '') ?></div></div>
<div class="info-row"><div class="info-label">Địa chỉ:</div><div><?= htmlspecialchars($hopDong['dia_chi'] ?? '') ?></div></div>

<h3>II. THÔNG TIN CẦM ĐỒ</h3>
<div class="info-row"><div class="info-label">Ngày cầm:</div><div><?= formatDate($hopDong['ngay_cam']) ?></div></div>
<div class="info-row"><div class="info-label">Ngày đáo hạn:</div><div><?= formatDate($hopDong['ngay_dao_han']) ?></div></div>
<div class="info-row"><div class="info-label">Số tiền cầm:</div><div><strong><?= formatMoney($hopDong['so_tien_cam']) ?></strong></div></div>
<div class="info-row"><div class="info-label">Lãi suất:</div><div><?= $hopDong['lai_suat'] ?>%/tháng</div></div>
<div class="info-row"><div class="info-label">Tiền lãi:</div><div><?= formatMoney($hopDong['tien_lai']) ?></div></div>
<div class="info-row"><div class="info-label">Tổng tiền chuộc:</div><div><strong><?= formatMoney($hopDong['tong_tien_chuoc']) ?></strong></div></div>

<h3>III. DANH SÁCH MÓN CẦM</h3>
<table>
    <tr><th>#</th><th>Tên Món</th><th>Loại</th><th>Số Lượng</th><th>Tình Trạng</th><th>Định Giá</th></tr>
    <?php foreach ($monCam as $i => $mc): ?>
    <tr>
        <td><?= $i+1 ?></td>
        <td><?= htmlspecialchars($mc['ten_mon']) ?></td>
        <td><?= ['vang'=>'Vàng','xe'=>'Xe','dien_thoai'=>'Điện Thoại','laptop'=>'Laptop','khac'=>'Khác'][$mc['loai_mon']] ?? $mc['loai_mon'] ?></td>
        <td><?= $mc['so_luong'] ?></td>
        <td><?= ['tot'=>'Tốt','kha'=>'Khá','trung_binh'=>'Trung Bình'][$mc['tinh_trang']] ?? $mc['tinh_trang'] ?></td>
        <td><?= formatMoney($mc['gia_tri_dinh_gia']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (!empty($hopDong['ghi_chu'])): ?>
<p><strong>Ghi chú:</strong> <?= htmlspecialchars($hopDong['ghi_chu']) ?></p>
<?php endif; ?>

<h3>IV. CAM KẾT</h3>
<p>Hai bên đã đọc và đồng ý với các điều khoản trên. Người cầm đồ cam kết sẽ chuộc lại tài sản trước ngày đáo hạn.</p>

<div class="signature">
    <div>
        <p>Người cầm đồ</p>
        <p>(Ký và ghi rõ họ tên)</p>
        <p><?= htmlspecialchars($hopDong['ten_khach']) ?></p>
    </div>
    <div>
        <p>Nhân viên tiếp nhận</p>
        <p>(Ký và ghi rõ họ tên)</p>
        <p><?= htmlspecialchars($_SESSION['ho_ten'] ?? '') ?></p>
    </div>
</div>
<script>
    window.onload = function() { window.print(); }
    function manualPrint() { window.print(); }
</script>
<div style="text-align:center;margin-top:20px;" class="no-print">
    <button onclick="manualPrint()" style="padding:8px 24px;font-size:14pt;cursor:pointer;">🖨️ In Hợp Đồng</button>
</div>
</body>
</html>
