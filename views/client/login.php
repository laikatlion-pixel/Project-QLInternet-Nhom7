<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Đăng Nhập Máy Trạm - <?= e($current_may['computer_name'] ?? 'MAY-'.$may_id) ?></title>
</head>
<body class="bg-dark text-white d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="card shadow-lg p-4 bg-secondary text-white" style="width: 100%; max-width: 400px;">
        <h3 class="text-center fw-bold mb-1"><?= e($current_may['computer_name'] ?? "Máy #".$may_id) ?></h3>
        <p class="text-center text-warning mb-4">
            Trạng thái: <strong><?= strtoupper($current_may['status'] ?? 'OFFLINE') ?></strong>
        </p>

        <?php if ($loginSuccess): ?>
            <div class="alert alert-success text-center">
                <p class="mb-1 fw-bold">🎉 Đăng nhập thành công!</p>
                <p class="small mb-3">Hội viên: <strong><?= e($loggedInUser) ?></strong></p>
                <a href="index.php?c=client&a=logout&may_id=<?= $may_id ?>&user=<?= urlencode($loggedInUser) ?>"
                   class="btn btn-danger btn-sm fw-bold w-100"
                   onclick="return confirm('Bạn có chắc chắn muốn đăng xuất và tắt máy?')">
                    Tắt máy / Đăng xuất
                </a>
            </div>
        <?php else: ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center py-2 mb-3"><?= e($error) ?></div>
            <?php endif; ?>
            <form action="index.php?c=client&a=login&may_id=<?= $may_id ?>" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold">Tài khoản hội viên:</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Nhập tên tài khoản" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Mật khẩu:</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold">Đăng nhập</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
