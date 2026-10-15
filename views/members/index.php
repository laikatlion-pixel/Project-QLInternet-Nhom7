<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Hội Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light container my-4">
    <h2 class="text-center mb-4">QUẢN LÝ HỘI VIÊN</h2>
    <div class="mb-3">
        <a href="index.php?route=members&action=add" class="btn btn-success">+ Thêm hội viên</a>
        <a href="index.php?route=home" class="btn btn-secondary">Về trang chủ</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr><th>ID</th><th>Tài khoản</th><th>Số dư</th><th>Thao tác</th></tr>
        </thead>
        <tbody>
            <?php foreach ($members as $mem): ?>
            <tr>
                <td><?= $mem['id'] ?></td>
                <td><?= $mem['username'] ?></td>
                <td><?= number_format($mem['balance']) ?>đ</td>
                <td>
                    <a href="index.php?route=members&action=edit&id=<?= $mem['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="index.php?route=members&action=delete&id=<?= $mem['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa hội viên này?');">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
