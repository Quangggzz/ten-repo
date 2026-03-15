# Hệ Thống Quản Lý Cầm Đồ (Pawnshop Management System)

> Phần mềm quản lý tiệm cầm đồ sử dụng mô hình PHP MVC

## Tính Năng

- ✅ Quản lý khách hàng (CRUD + tìm kiếm)
- ✅ Quản lý hợp đồng cầm đồ (tạo, sửa, xóa, chi tiết)
- ✅ Quản lý món cầm kèm hình ảnh (upload đa tệp, thumbnail GD)
- ✅ Tự động tạo lịch thu lãi (hàng ngày / tuần / tháng / cuối kỳ)
- ✅ Thu tiền & lịch sử thu tiền với phiếu thu in được
- ✅ Cập nhật trạng thái hợp đồng (đang cầm → chuộc / thanh lý)
- ✅ Dashboard thống kê tổng quan (HĐ, khách hàng, tiền cầm, thu hôm nay)
- ✅ Cảnh báo hợp đồng quá hạn và kỳ lãi quá hạn
- ✅ In hợp đồng và phiếu thu (print CSS)
- ✅ Xác thực người dùng với phân quyền (admin / staff)

## Yêu Cầu

- PHP 7.4+ (với PDO, GD extension)
- MySQL 5.7+ / MariaDB 10.3+
- Apache với mod_rewrite
- Composer không cần thiết (không dùng vendor)

## Cài Đặt

1. **Clone / copy** toàn bộ thư mục vào DocumentRoot hoặc virtualhost của Apache.

2. **Tạo database** từ file `database.sql`:
   ```bash
   mysql -u root -p < database.sql
   ```

3. **Cấu hình database** trong `config.php`:
   ```php
   define('DATABASE', [
       'Host' => 'localhost',
       'Name' => 'pawnshop_db',
       'User' => 'root',
       'Pass' => '',
       ...
   ]);
   ```

4. **Phân quyền thư mục Upload**:
   ```bash
   chmod 755 Upload/
   ```

5. Truy cập: `http://localhost/`

## Tài Khoản Mặc Định

| Tài Khoản | Mật Khẩu | Quyền |
|-----------|----------|-------|
| admin | password | Quản trị viên |
| nhanvien1 | password | Nhân viên |

## Công Nghệ Sử Dụng

- **Backend:** PHP 7.4+ (MVC thuần, không framework)
- **Database:** MySQL / MariaDB (PDO)
- **Frontend:** Bootstrap 5.3, Font Awesome 6.4
- **Upload:** GD Library (tạo thumbnail tự động)

## Cấu Trúc Thư Mục

```
pawnshop/
├── .htaccess               ← URL rewrite
├── config.php              ← Cấu hình ứng dụng
├── index.php               ← Entry point
├── database.sql            ← Schema + dữ liệu mẫu
├── System/                 ← Core framework
│   ├── Startup.php
│   ├── Helper/public.php
│   ├── MVC/{Controller,Model}.php
│   ├── Http/{Request,Response}.php
│   ├── Router/{Router,Route}.php
│   └── Database/{DatabaseAdapter,DB/PDO}.php
├── Application/
│   ├── Controllers/        ← Auth, Home, KhachHang, MonCam, HopDong, ThuTien, HinhAnh
│   ├── Models/             ← User, KhachHang, MonCam, HopDong, HinhAnh, LichThuLai, LichSuThuTien
│   └── Views/              ← layouts/, auth/, home/, khachhang/, moncam/, hopdong/, thutien/
├── Router/Router.php       ← Định nghĩa routes
└── Upload/                 ← Thư mục lưu hình ảnh tải lên
```

## Phiên Bản

**v1.0.0** — Phiên bản đầu tiên