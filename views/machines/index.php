<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Máy Tính</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-4">
        <h2 class="text-center mb-4">QUẢN LÝ DANH SÁCH MÁY TÍNH</h2>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a href="index.php?route=machines&action=add" class="btn btn-success">+ Thêm máy mới</a>
                <a href="index.php?route=home" class="btn btn-secondary">Về trang chủ</a>
            </div>

            <!-- Form tìm kiếm nhanh -->
            <form method="GET" action="index.php" class="d-flex gap-2">
                <input type="hidden" name="route" value="machines">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm tên máy, khu vực..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">Tìm</button>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên máy</th>
                            <th>Khu vực</th>
                            <th>Cấu hình</th>
                            <th>Giá/giờ</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($machines)): ?>
                            <?php foreach ($machines as $row): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><strong><?= htmlspecialchars($row['computer_name']) ?></strong></td>
                                <td><?= htmlspecialchars($row['zone_name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['specs'] ?? '') ?></td>
                                <td><?= number_format($row['hourly_price']) ?> đ</td>
                                <td>
                                    <span class="badge bg-<?= $row['status'] == 'online' ? 'success' : 'secondary' ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?route=machines&action=edit&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="index.php?route=machines&action=delete&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa máy này?');">Xóa</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center text-muted">Không có dữ liệu máy tính.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
