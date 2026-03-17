<div id="sidebar">
    <div class="brand">
        <i class="fas fa-store me-2"></i><span><?= APP_NAME ?></span>
    </div>
    <nav class="mt-2">
        <?php
        $uri = $_SERVER['REQUEST_URI'];
        $isActive = function($path) use ($uri) {
            return (strpos($uri, $path) !== false) ? 'active' : '';
        };
        ?>
        <div class="nav-section">Tổng Quan</div>
        <a href="/dashboard" class="nav-link <?= (strpos($uri,'/dashboard') !== false || $uri == '/') ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </a>

        <div class="nav-section">Quản Lý</div>
        <a href="/hop-dong" class="nav-link <?= $isActive('/hop-dong') ?>">
            <i class="fas fa-file-contract me-2"></i>Hợp Đồng Cầm
        </a>
        <a href="/khach-hang" class="nav-link <?= $isActive('/khach-hang') ?>">
            <i class="fas fa-users me-2"></i>Khách Hàng
        </a>
        <a href="/mon-cam" class="nav-link <?= $isActive('/mon-cam') ?>">
            <i class="fas fa-box me-2"></i>Món Cầm
        </a>

        <div class="nav-section">Tài Chính</div>
        <a href="/thu-tien/lich-thu-lai" class="nav-link <?= $isActive('/thu-tien/lich') ?>">
            <i class="fas fa-calendar-check me-2"></i>Lịch Thu Lãi
        </a>
        <a href="/thu-tien" class="nav-link <?= ($isActive('/thu-tien') && !$isActive('/thu-tien/lich') && !$isActive('/thu-tien/thu') && !$isActive('/thu-tien/chi')) ? 'active' : '' ?>">
            <i class="fas fa-money-bill-wave me-2"></i>Lịch Sử Thu Tiền
        </a>

        <div class="nav-section mt-3">Tài Khoản</div>
        <a href="/logout" class="nav-link text-danger">
            <i class="fas fa-sign-out-alt me-2"></i>Đăng Xuất
        </a>
    </nav>
</div>

<div id="main">
    <div id="topbar">
        <h6 class="mb-0 fw-bold"><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : APP_NAME ?></h6>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small"><i class="fas fa-user me-1"></i><?= htmlspecialchars($_SESSION['ho_ten'] ?? 'Người dùng') ?></span>
            <a href="/logout" class="btn btn-sm btn-outline-danger"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>

    <?php
    $flash = getFlash();
    if ($flash): ?>
    <div class="mx-4 mt-3">
        <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show">
            <?= $flash['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php endif; ?>

    <div class="content-wrapper">
