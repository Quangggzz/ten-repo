<?php
// AUTH
$router->get('/login', 'Auth@loginForm');
$router->post('/login', 'Auth@login');
$router->get('/logout', 'Auth@logout');

// DASHBOARD
$router->get('/', 'Home@index');
$router->get('/home', 'Home@index');
$router->get('/dashboard', 'Home@dashboard');

// KHÁCH HÀNG
$router->get('/khach-hang', 'KhachHang@index');
$router->get('/khach-hang/create', 'KhachHang@create');
$router->post('/khach-hang/store', 'KhachHang@store');
$router->get('/khach-hang/edit/:id', 'KhachHang@edit');
$router->post('/khach-hang/update/:id', 'KhachHang@update');
$router->get('/khach-hang/delete/:id', 'KhachHang@delete');
$router->get('/khach-hang/search', 'KhachHang@search');

// MÓN CẦM
$router->get('/mon-cam', 'MonCam@index');
$router->get('/mon-cam/create', 'MonCam@create');
$router->post('/mon-cam/store', 'MonCam@store');
$router->get('/mon-cam/edit/:id', 'MonCam@edit');
$router->post('/mon-cam/update/:id', 'MonCam@update');
$router->get('/mon-cam/delete/:id', 'MonCam@delete');

// HỢP ĐỒNG
$router->get('/hop-dong', 'HopDong@index');
$router->get('/hop-dong/create', 'HopDong@create');
$router->post('/hop-dong/store', 'HopDong@store');
$router->get('/hop-dong/detail/:id', 'HopDong@detail');
$router->get('/hop-dong/edit/:id', 'HopDong@edit');
$router->post('/hop-dong/update/:id', 'HopDong@update');
$router->get('/hop-dong/delete/:id', 'HopDong@delete');
$router->get('/hop-dong/chuoc/:id', 'HopDong@chuoc');
$router->get('/hop-dong/thanh-ly/:id', 'HopDong@thanhLy');
$router->get('/hop-dong/print/:id', 'HopDong@printContract');

// HÌNH ẢNH
$router->post('/hinh-anh/upload', 'HinhAnh@upload');
$router->get('/hinh-anh/delete/:id', 'HinhAnh@delete');
$router->get('/hinh-anh/gallery/:hopDongId', 'HinhAnh@gallery');

// THU TIỀN
$router->get('/thu-tien', 'ThuTien@index');
$router->get('/thu-tien/lich-thu-lai', 'ThuTien@lichThuLai');
$router->get('/thu-tien/thu-lai/:lichThuLaiId', 'ThuTien@thuLai');
$router->post('/thu-tien/xu-ly-thu-lai/:lichThuLaiId', 'ThuTien@xuLyThuLai');
$router->get('/thu-tien/thu-tien-form/:hopDongId', 'ThuTien@thuTienForm');
$router->post('/thu-tien/xu-ly-thu-tien/:hopDongId', 'ThuTien@xuLyThuTien');
$router->get('/thu-tien/chi-tiet/:id', 'ThuTien@chiTietPhieu');
