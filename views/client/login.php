<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Đăng Nhập Hệ Thống Quản Lý Net</title>
</head>
<body class="bg-dark text-white d-flex align-items-center justify-content-center vh-100">
    <div class="card card-body bg-secondary text-white shadow" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">Đăng Nhập Hệ Thống</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger p-2 text-center"><?= $error ?></div>
        <?php endif; ?>

        <form action="index.php?route=login" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label fw-bold">Tài khoản:</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Nhập tên tài khoản" required autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Mật khẩu:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold mt-2">Đăng nhập</button>
        </form>
    </div>
</body>
</html>