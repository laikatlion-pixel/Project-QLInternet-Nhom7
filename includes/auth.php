<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Kiểm tra đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    header("Location: index.php?route=login");
    exit();
}

// 2. Hàm kiểm tra có phải Admin hay không
function isAdmin() {
    return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';
}

// 3. Hàm kiểm tra có phải Nhân viên (user) không
function isStaff() {
    return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'user';
}

// 4. Hàm chặn truy cập nếu không phải Admin (Dùng cho các chức năng nhạy cảm như xóa, sửa hệ thống)
function requireAdmin() {
    if (!isAdmin()) {
        echo "<script>alert('Bạn không có quyền thực hiện chức năng quản trị này!'); window.location.href='index.php?route=home';</script>";
        exit();
    }
}
?>