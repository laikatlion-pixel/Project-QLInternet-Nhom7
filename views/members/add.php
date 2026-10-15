<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Hội Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5" style="max-width: 500px;">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-4">THÊM HỘI VIÊN MỚI</h3>
                <form method="POST" action="index.php?route=members&action=add">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên tài khoản:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mật khẩu:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Số dư ban đầu (VNĐ):</label>
                        <input type="number" name="balance" class="form-control" value="0" min="0" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php?route=members" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-success">Thêm hội viên</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
