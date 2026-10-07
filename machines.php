<?php
require_once 'db.php';

// Xử lý tìm kiếm
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

if ($keyword !== '') {
    $stmt = $pdo->prepare("SELECT may.*, zone.zone_name FROM may JOIN zone ON may.zone_id = zone.id WHERE may.computer_name LIKE :kw OR zone.zone_name LIKE :kw");
    $stmt->execute(['kw' => "%$keyword%"]);
} else {
    $stmt = $pdo->query("SELECT may.*, zone.zone_name FROM may JOIN zone ON may.zone_id = zone.id");
}
$machines = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Máy tính - Phòng Net</title>
    <!-- Sử dụng Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h2 class="mb-4 text-center">QUẢN LÝ DANH SÁCH MÁY TÍNH</h2>
        
        <!-- Thanh công cụ: Tìm kiếm và Thêm mới -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="" method="GET" class="d-flex">
                    <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm theo tên máy hoặc khu vực..." value="<?= htmlspecialchars($keyword) ?>">
                    <button type="submit" class="btn btn-outline-primary">Tìm kiếm</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="add_machine.php" class="btn btn-success">+ Thêm máy tính mới</a>
            </div>
        </div>

        <!-- Bảng hiển thị danh sách -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên Máy</th>
                            <th>Khu Vực</th>
                            <th>Cấu Hình</th>
                            <th>Giá/Giờ (VNĐ)</th>
                            <th>Trạng Thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($machines) > 0): ?>
                            <?php foreach ($machines as $row): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><strong><?= htmlspecialchars($row['computer_name']) ?></strong></td>
                                <td><?= htmlspecialchars($row['zone_name']) ?></td>
                                <td><?= htmlspecialchars($row['specs']) ?></td>
                                <td><?= number_format($row['hourly_price']) ?>đ</td>
                                <td>
                                    <?php if($row['status'] == 'online'): ?>
                                        <span class="badge bg-success">Online</span>
                                    <?php elseif($row['status'] == 'offline'): ?>
                                        <span class="badge bg-secondary">Offline</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Bảo trì</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_machine.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="delete_machine.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa máy này không?');">Xóa</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Không tìm thấy máy tính nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>