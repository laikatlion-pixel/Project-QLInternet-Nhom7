<?php
require_once __DIR__ . '/../../includes/auth.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ Thống Quản Lý Phòng Net</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white d-flex align-items-center justify-content-center vh-100">
    <div class="container text-center" style="max-width: 700px;">
        <h2 class="fw-bold mb-2">HỆ THỐNG QUẢN LÝ PHÒNG MÁY</h2>
        <p class="text-secondary mb-5">
            Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['fullname'] ?? $_SESSION['user']['username'] ?? 'Admin') ?></strong>! Vui lòng chọn chức năng quản lý:
        </p>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card bg-secondary text-white border-0 shadow h-100 p-3">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h1 class="display-4">🖥️</h1>
                            <h4 class="card-title fw-bold">Quản Lý Máy Tính</h4>
                            <p class="card-text text-light small">Thêm máy mới, xem sơ đồ phòng máy, chỉnh sửa thông tin & giá tiền giờ chơi.</p>
                        </div>
                        <a href="index.php?route=machines" class="btn btn-primary btn-lg fw-bold mt-3">Vào Quản Lý Máy</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-secondary text-white border-0 shadow h-100 p-3">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h1 class="display-4">👤</h1>
                            <h4 class="card-title fw-bold">Quản Lý Khách Hàng</h4>
                            <p class="card-text text-light small">Tra cứu tài khoản hội viên, kiểm tra số dư tiền, ước tính giờ chơi còn lại.</p>
                        </div>
                        <a href="index.php?route=members" class="btn btn-info text-white btn-lg fw-bold mt-3">Vào Quản Lý Khách</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <a href="index.php?route=logout" class="btn btn-outline-danger">Đăng xuất</a>
        </div>
    </div>
</body>
</html>
