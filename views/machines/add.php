<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Máy Tính</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-4">THÊM MÁY TÍNH MỚI</h3>
                <form method="POST" action="index.php?route=machines&action=add">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên máy:</label>
                        <input type="text" name="computer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Khu vực:</label>
                        <select name="zone_id" class="form-select">
                            <?php foreach ($zones as $z): ?>
                                <option value="<?= $z['id'] ?>"><?= htmlspecialchars($z['zone_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cấu hình:</label>
                        <textarea name="specs" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Giá tiền / giờ (VNĐ):</label>
                        <input type="number" name="hourly_price" class="form-control" value="8000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ghi chú:</label>
                        <input type="text" name="note" class="form-control">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php?route=machines" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-success">Lưu máy tính</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
```[cite: 24]

---

### 2. `views/machines/edit.php`
```php
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
```[cite: 25]

---

### 3. `views/machines/index.php`
```php
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
        
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="index.php?route=machines&action=add" class="btn btn-success">+ Thêm máy mới</a>
                <a href="index.php?route=home" class="btn btn-secondary">Về trang chủ</a>
            </div>
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
```[cite: 26]
