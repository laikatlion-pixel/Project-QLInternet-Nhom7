<?php $activePage = 'machine'; $pageTitle = 'Chỉnh Sửa Máy Tính'; ?>

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark fw-bold">✏️ Chỉnh Sửa Máy Tính #<?= $edit_data['id'] ?></div>
    <div class="card-body">
        <form method="POST" action="index.php?c=machine&a=update" class="row g-3">
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
            <div class="col-md-4">
                <label class="form-label fw-bold">Tên máy tính:</label>
                <input type="text" name="computer_name" class="form-control" value="<?= e($edit_data['computer_name'] ?? '') ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Khu vực (Zone):</label>
                <select name="zone_id" class="form-select" required>
                    <option value="">-- Chọn Khu Vực --</option>
                    <?php foreach ($dsZone as $z): ?>
                        <option value="<?= $z['id'] ?>" <?= ($edit_data['zone_id'] == $z['id']) ? 'selected' : '' ?>>
                            <?= e($z['zone_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Giá tiền / Giờ (VNĐ):</label>
                <input type="number" name="hourly_price" class="form-control" min="0" step="500" value="<?= $edit_data['hourly_price'] ?? '' ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Trạng thái:</label>
                <select name="status" class="form-select">
                    <option value="offline" <?= strtolower($edit_data['status']) == 'offline' ? 'selected' : '' ?>>OFFLINE</option>
                    <option value="online" <?= strtolower($edit_data['status']) == 'online' ? 'selected' : '' ?>>ONLINE</option>
                    <option value="maintenance" <?= strtolower($edit_data['status']) == 'maintenance' ? 'selected' : '' ?>>MAINTENANCE</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Tổng giờ chạy tích lũy:</label>
                <input type="number" step="0.01" name="total_play_hours" class="form-control" value="<?= $edit_data['total_play_hours'] ?? 0 ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Cấu hình:</label>
                <textarea name="specs" class="form-control" rows="2"><?= e($edit_data['specs'] ?? '') ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Chi tiết ngoại vi:</label>
                <textarea name="peripheral_details" class="form-control" rows="2"><?= e($edit_data['peripheral_details'] ?? '') ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Ghi chú:</label>
                <input type="text" name="note" class="form-control" value="<?= e($edit_data['note'] ?? '') ?>">
            </div>
            <div class="col-12 d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning fw-bold px-4">Lưu Thay Đổi</button>
                <a href="index.php?c=machine&a=index" class="btn btn-outline-secondary">Hủy Bỏ</a>
            </div>
        </form>
    </div>
</div>
