<?php

if (!isset($activePage)) { $activePage = ''; }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'Hệ Thống Quản Lý Phòng Net' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?c=dashboard&a=index">🏠 MENU CHÍNH</a>
            <div class="navbar-nav me-auto">
                <a class="nav-link <?= $activePage === 'machine' ? 'active fw-bold' : '' ?>" href="index.php?c=machine&a=index">🖥️ Quản Lý Máy Tính</a>
                <a class="nav-link <?= $activePage === 'member' ? 'active fw-bold' : '' ?>" href="index.php?c=member&a=index">👤 Quản Lý Khách Hàng</a>
            </div>
            <a href="index.php?c=auth&a=logout" class="btn btn-danger btn-sm">Đăng xuất</a>
        </div>
    </nav>
    <div class="container pb-5">
        <?php if (!empty($flashSuccess)): ?>
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <?= $flashSuccess ?>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>
        <?php elseif (!empty($flashError)): ?>
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <?= $flashError ?>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>
        <?php endif; ?>
