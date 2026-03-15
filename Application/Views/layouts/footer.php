    </div><!-- /.content-wrapper -->
</div><!-- /#main -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto-calculate interest
function tinhTienLai() {
    var soTien = parseFloat(document.getElementById('so_tien_cam')?.value || 0);
    var laiSuat = parseFloat(document.getElementById('lai_suat')?.value || 3);
    var ngayCam = document.getElementById('ngay_cam')?.value;
    var ngayDaoHan = document.getElementById('ngay_dao_han')?.value;

    if (soTien > 0 && ngayCam && ngayDaoHan) {
        var d1 = new Date(ngayCam), d2 = new Date(ngayDaoHan);
        var months = (d2.getFullYear() - d1.getFullYear()) * 12 + (d2.getMonth() - d1.getMonth());
        if (d2.getDate() > d1.getDate()) months++;
        if (months < 1) months = 1;
        var tienLai = soTien * (laiSuat / 100) * months;
        var tongChuoc = soTien + tienLai;
        var elLai = document.getElementById('tien_lai');
        var elTong = document.getElementById('tong_tien_chuoc');
        if (elLai) elLai.value = Math.round(tienLai).toLocaleString('vi-VN');
        if (elTong) elTong.value = Math.round(tongChuoc).toLocaleString('vi-VN');
    }
}

// Add item row for contract creation
var pawItemIndex = 1;
function themMonCam() {
    pawItemIndex++;
    var html = '<div class="row g-2 mt-1 item-row" id="paw-item-' + pawItemIndex + '">' +
        '<div class="col-md-3"><input type="text" name="ten_mon[]" class="form-control form-control-sm" placeholder="Tên món *" required></div>' +
        '<div class="col-md-2"><select name="loai_mon[]" class="form-select form-select-sm">' +
        '<option value="vang">Vàng</option><option value="xe">Xe</option><option value="dien_thoai">Điện thoại</option>' +
        '<option value="laptop">Laptop</option><option value="khac" selected>Khác</option></select></div>' +
        '<div class="col-md-1"><input type="number" name="so_luong[]" class="form-control form-control-sm" value="1" min="1"></div>' +
        '<div class="col-md-2"><input type="number" name="gia_tri_dinh_gia[]" class="form-control form-control-sm" placeholder="Giá trị" step="1000"></div>' +
        '<div class="col-md-2"><select name="tinh_trang[]" class="form-select form-select-sm">' +
        '<option value="tot">Tốt</option><option value="kha">Khá</option><option value="trung_binh">Trung bình</option></select></div>' +
        '<div class="col-md-1"><input type="text" name="mo_ta_mon[]" class="form-control form-control-sm" placeholder="Ghi chú"></div>' +
        '<div class="col-md-1"><button type="button" class="btn btn-sm btn-danger" onclick="xoaMonCam(\'paw-item-' + pawItemIndex + '\')"><i class="fas fa-times"></i></button></div>' +
        '</div>';
    document.getElementById('mon-cam-list').insertAdjacentHTML('beforeend', html);
}

function xoaMonCam(id) {
    var el = document.getElementById(id);
    if (el) el.remove();
}
</script>
</body>
</html>
