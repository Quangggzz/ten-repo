<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #2c3e50 0%, #e67e22 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
        }
        .login-logo {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #e67e22, #d35400);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem; color: #fff;
        }
        .btn-login {
            background: linear-gradient(135deg, #e67e22, #d35400);
            border: none; color: #fff;
        }
        .btn-login:hover { background: linear-gradient(135deg, #d35400, #c0392b); color: #fff; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-logo"><i class="fas fa-store"></i></div>
    <h4 class="text-center fw-bold mb-1"><?= APP_NAME ?></h4>
    <p class="text-center text-muted small mb-4">Phần mềm quản lý tiệm cầm đồ</p>

    <?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-sm py-2"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="/login">
        <div class="mb-3">
            <label class="form-label fw-semibold">Tên đăng nhập</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập" required autofocus>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Mật khẩu</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
            </div>
        </div>
        <button type="submit" class="btn btn-login w-100 fw-semibold py-2">
            <i class="fas fa-sign-in-alt me-2"></i>Đăng Nhập
        </button>
    </form>
    <p class="text-center text-muted small mt-3 mb-0">
        Tài khoản mặc định: <strong>admin</strong> / <strong>password</strong>
    </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
