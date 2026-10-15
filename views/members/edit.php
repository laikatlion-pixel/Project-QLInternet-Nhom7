<?php $activePage = 'member'; $pageTitle = 'Chỉnh Sửa Hội Viên'; ?>

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark fw-bold">✏️ Chỉnh Sửa Hội Viên #<?= $edit_data['id'] ?></div>
    <div class="card-body">
        <form method="POST" action="index.php?c=member&a=update" class="row g-3">
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
            <div class="col-md-4">
                <label class="form-label fw-bold">Tên tài khoản:</label>
                <input type="text" name="username" class="form-control" value="<?= e($edit_data['username'] ?? '') ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Mật khẩu mới: <span class="text-muted small fw-normal">(Bỏ trống nếu giữ nguyên)</span></label>
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu mới...">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Số dư (VNĐ):</label>
                <input type="number" name="balance" class="form-control" step="1000" min="0" value="<?= $edit_data['balance'] ?? 0 ?>" required>
            </div>
            <div class="col-12 d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning fw-bold px-4">Lưu Thay Đổi</button>
                <a href="index.php?c=member&a=index" class="btn btn-outline-secondary">Hủy Bỏ</a>
            </div>
        </form>
    </div>
</div>
