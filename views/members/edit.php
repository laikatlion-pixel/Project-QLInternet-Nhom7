<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Thông Tin Hội Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5" style="max-width: 500px;">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-4">CẬP NHẬT HỘI VIÊN</h3>
                <form method="POST" action="index.php?route=members&action=edit&id=<?= $member['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên tài khoản:</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($member['username']) ?>" required>
                    </div>
                    <div class="mb-3">
<label class="form-label fw-bold">Mật khẩu mới: <span class="text-muted fw-normal small">(Bỏ trống nếu giữ nguyên)</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Số dư (VNĐ):</label>
                        <input type="number" name="balance" class="form-control" value="<?= $member['balance'] ?>" min="0" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php?route=members" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
