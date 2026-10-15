<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Thông Tin Máy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-4">CẬP NHẬT MÁY TÍNH</h3>
                <form method="POST" action="index.php?route=machines&action=edit&id=<?= $machine['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên máy:</label>
                        <input type="text" name="computer_name" class="form-control" value="<?= htmlspecialchars($machine['computer_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Khu vực:</label>
                        <select name="zone_id" class="form-select">
                            <?php foreach ($zones as $z): ?>
                                <option value="<?= $z['id'] ?>" <?= $machine['zone_id'] == $z['id'] ? 'selected' : '' ?>><?= htmlspecialchars($z['zone_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cấu hình:</label>
                        <textarea name="specs" class="form-control" rows="2"><?= htmlspecialchars($machine['specs']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Giá tiền / giờ (VNĐ):</label>
                        <input type="number" name="hourly_price" class="form-control" value="<?= $machine['hourly_price'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Trạng thái:</label>
                        <select name="status" class="form-select">
                            <option value="offline" <?= $machine['status'] == 'offline' ? 'selected' : '' ?>>Offline</option>
                            <option value="online" <?= $machine['status'] == 'online' ? 'selected' : '' ?>>Online</option>
                            <option value="maintenance" <?= $machine['status'] == 'maintenance' ? 'selected' : '' ?>>Bảo trì</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php?route=machines" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
