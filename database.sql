CREATE DATABASE IF NOT EXISTS pawnshop_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pawnshop_db;

CREATE TABLE ps_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    ho_ten VARCHAR(200) NOT NULL,
    email VARCHAR(200),
    role ENUM('admin','staff') DEFAULT 'staff',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO ps_users (username, password, ho_ten, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Quản Trị Viên', 'admin'),
('nhanvien1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn A', 'staff');

CREATE TABLE ps_khach_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ho_ten VARCHAR(200) NOT NULL,
    cmnd VARCHAR(20) NOT NULL,
    sdt VARCHAR(20) NOT NULL,
    dia_chi VARCHAR(500),
    ngay_sinh DATE,
    gioi_tinh ENUM('nam','nu') DEFAULT 'nam',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    KEY idx_cmnd (cmnd),
    KEY idx_sdt (sdt)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO ps_khach_hang (ho_ten, cmnd, sdt, dia_chi, ngay_sinh, gioi_tinh) VALUES
('Nguyễn Văn Bình', '012345678901', '0901234567', '123 Lê Lợi, Q.1, TP.HCM', '1985-03-15', 'nam'),
('Trần Thị Lan', '098765432109', '0912345678', '456 Nguyễn Huệ, Q.1, TP.HCM', '1990-07-22', 'nu'),
('Lê Văn Cường', '111222333444', '0923456789', '789 Trần Hưng Đạo, Q.5, TP.HCM', '1978-11-10', 'nam');

CREATE TABLE ps_hop_dong (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_hop_dong VARCHAR(50) NOT NULL UNIQUE,
    khach_hang_id INT NOT NULL,
    ngay_cam DATE NOT NULL,
    ngay_dao_han DATE NOT NULL,
    so_tien_cam DECIMAL(15,2) NOT NULL DEFAULT 0,
    lai_suat DECIMAL(5,2) NOT NULL DEFAULT 3.00,
    tien_lai DECIMAL(15,2) NOT NULL DEFAULT 0,
    tong_tien_chuoc DECIMAL(15,2) NOT NULL DEFAULT 0,
    trang_thai ENUM('dang_cam','da_chuoc','thanh_ly','qua_han') DEFAULT 'dang_cam',
    chu_ky_thu_lai ENUM('hang_ngay','hang_tuan','hang_thang','cuoi_ky') DEFAULT 'hang_thang',
    ngay_bat_dau_thu_lai DATE,
    tong_lai_da_thu DECIMAL(15,2) DEFAULT 0,
    tong_goc_da_thu DECIMAL(15,2) DEFAULT 0,
    ghi_chu TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    FOREIGN KEY (khach_hang_id) REFERENCES ps_khach_hang(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO ps_hop_dong (ma_hop_dong, khach_hang_id, ngay_cam, ngay_dao_han, so_tien_cam, lai_suat, tien_lai, tong_tien_chuoc, trang_thai, chu_ky_thu_lai, ngay_bat_dau_thu_lai) VALUES
('HD20240101001', 1, '2024-01-01', '2024-04-01', 5000000.00, 3.00, 450000.00, 5450000.00, 'dang_cam', 'hang_thang', '2024-02-01'),
('HD20240115002', 2, '2024-01-15', '2024-04-15', 10000000.00, 3.00, 900000.00, 10900000.00, 'dang_cam', 'hang_thang', '2024-02-15'),
('HD20240201003', 3, '2024-02-01', '2024-05-01', 3000000.00, 3.00, 270000.00, 3270000.00, 'da_chuoc', 'cuoi_ky', '2024-05-01');

CREATE TABLE ps_mon_cam (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hop_dong_id INT NOT NULL,
    ten_mon VARCHAR(300) NOT NULL,
    loai_mon ENUM('vang','xe','dien_thoai','laptop','khac') DEFAULT 'khac',
    mo_ta TEXT,
    so_luong INT DEFAULT 1,
    tinh_trang ENUM('tot','kha','trung_binh') DEFAULT 'tot',
    gia_tri_dinh_gia DECIMAL(15,2) DEFAULT 0,
    hinh_anh VARCHAR(500),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    FOREIGN KEY (hop_dong_id) REFERENCES ps_hop_dong(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO ps_mon_cam (hop_dong_id, ten_mon, loai_mon, mo_ta, so_luong, tinh_trang, gia_tri_dinh_gia) VALUES
(1, 'Nhẫn vàng 18K', 'vang', 'Nhẫn vàng 18K, nặng 2 chỉ', 1, 'tot', 6000000.00),
(2, 'iPhone 14 Pro Max', 'dien_thoai', 'iPhone 14 Pro Max 256GB màu đen, còn bảo hành', 1, 'tot', 12000000.00),
(3, 'Xe máy Honda Wave', 'xe', 'Honda Wave Alpha 2020, biển số 51B-12345', 1, 'kha', 4000000.00);

CREATE TABLE ps_hinh_anh (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mon_cam_id INT NOT NULL,
    hop_dong_id INT NOT NULL,
    file_name VARCHAR(500) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT DEFAULT 0,
    file_type VARCHAR(50),
    mo_ta VARCHAR(300),
    thu_tu INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mon_cam_id) REFERENCES ps_mon_cam(id) ON DELETE CASCADE,
    FOREIGN KEY (hop_dong_id) REFERENCES ps_hop_dong(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE ps_lich_thu_lai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hop_dong_id INT NOT NULL,
    ky_thu INT NOT NULL,
    ngay_thu_du_kien DATE NOT NULL,
    so_tien_lai DECIMAL(15,2) NOT NULL DEFAULT 0,
    so_tien_da_thu DECIMAL(15,2) NOT NULL DEFAULT 0,
    trang_thai ENUM('chua_thu','da_thu','thu_mot_phan','qua_han') DEFAULT 'chua_thu',
    ngay_thu_thuc_te DATE,
    nguoi_thu VARCHAR(200),
    ghi_chu TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    FOREIGN KEY (hop_dong_id) REFERENCES ps_hop_dong(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO ps_lich_thu_lai (hop_dong_id, ky_thu, ngay_thu_du_kien, so_tien_lai, so_tien_da_thu, trang_thai, ngay_thu_thuc_te, nguoi_thu) VALUES
(1, 1, '2024-02-01', 150000.00, 150000.00, 'da_thu', '2024-02-01', 'admin'),
(1, 2, '2024-03-01', 150000.00, 0.00, 'qua_han', NULL, NULL),
(1, 3, '2024-04-01', 150000.00, 0.00, 'chua_thu', NULL, NULL),
(2, 1, '2024-02-15', 300000.00, 300000.00, 'da_thu', '2024-02-15', 'admin'),
(2, 2, '2024-03-15', 300000.00, 0.00, 'qua_han', NULL, NULL),
(2, 3, '2024-04-15', 300000.00, 0.00, 'chua_thu', NULL, NULL),
(3, 1, '2024-05-01', 270000.00, 270000.00, 'da_thu', '2024-05-01', 'admin');

CREATE TABLE ps_lich_su_thu_tien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hop_dong_id INT NOT NULL,
    lich_thu_lai_id INT,
    loai_thu ENUM('thu_lai','thu_goc','thu_chuoc','thu_phat','thu_khac') NOT NULL DEFAULT 'thu_lai',
    so_tien DECIMAL(15,2) NOT NULL DEFAULT 0,
    phuong_thuc ENUM('tien_mat','chuyen_khoan','khac') DEFAULT 'tien_mat',
    ngay_thu DATE NOT NULL,
    nguoi_thu VARCHAR(200),
    nguoi_nop VARCHAR(200),
    ma_phieu_thu VARCHAR(50),
    ghi_chu TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hop_dong_id) REFERENCES ps_hop_dong(id) ON DELETE CASCADE,
    FOREIGN KEY (lich_thu_lai_id) REFERENCES ps_lich_thu_lai(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO ps_lich_su_thu_tien (hop_dong_id, lich_thu_lai_id, loai_thu, so_tien, phuong_thuc, ngay_thu, nguoi_thu, nguoi_nop, ma_phieu_thu) VALUES
(1, 1, 'thu_lai', 150000.00, 'tien_mat', '2024-02-01', 'admin', 'Nguyễn Văn Bình', 'PT20240201001'),
(2, 4, 'thu_lai', 300000.00, 'tien_mat', '2024-02-15', 'admin', 'Trần Thị Lan', 'PT20240215002'),
(3, 7, 'thu_chuoc', 3270000.00, 'tien_mat', '2024-05-01', 'admin', 'Lê Văn Cường', 'PT20240501003');
