<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$route = $_GET['route'] ?? '';

// Nếu không phải trang login mà chưa đăng nhập thì mới đá về trang login
if ($route !== 'login' && !isset($_SESSION['user'])) {
    header("Location: index.php?route=login");
    exit();
}

function isAdmin() {
    return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';
}

function requireAdmin() {
    if (!isAdmin()) {
        echo "<script>alert('Bạn không có quyền thực hiện chức năng này!'); window.location.href='index.php?route=home';</script>";
        exit();
    }
}
?>
