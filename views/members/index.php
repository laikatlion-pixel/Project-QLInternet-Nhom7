<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Hội Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-4">
        <h2 class="text-center mb-4">QUẢN LÝ TÀI KHOẢN HỘI VIÊN</h2>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a href="index.php?route=members&action=add" class="btn btn-success">+ Thêm hội viên</a>
                <a href="index.php?route=home" class="btn btn-secondary">Về trang chủ</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tài khoản</th>
                            <th>Số dư (VNĐ)</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($members)): ?>
                            <?php foreach ($members as $mem): ?>
                            <tr>
                                <td><?= $mem['id'] ?></td>
                                <td><strong><?= htmlspecialchars($mem['username']) ?></strong></td>
                                <td><?= number_format($mem['balance']) ?> đ</td>
                                <td><?= $mem['created_at'] ?? '' ?></td>
                                <td>
                                    <a href="index.php?route=members&action=edit&id=<?= $mem['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
<a href="index.php?route=members&action=delete&id=<?= $mem['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa hội viên này?');">Xóa</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center text-muted">Chưa có hội viên nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
