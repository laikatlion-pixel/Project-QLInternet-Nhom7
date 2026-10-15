<?php $activePage = 'machine'; $pageTitle = 'Quản Lý Máy Tính'; ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white fw-bold">➕ Thêm Máy Tính Mới</div>
    <div class="card-body">
        <form method="POST" action="index.php?c=machine&a=store" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Tên máy tính:</label>
                <input type="text" name="computer_name" class="form-control" placeholder="Ví dụ: MAY-01" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Khu vực (Zone):</label>
                <select name="zone_id" class="form-select" required>
                    <option value="">-- Chọn Khu Vực --</option>
                    <?php foreach ($dsZone as $z): ?>
                        <option value="<?= $z['id'] ?>"><?= e($z['zone_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Giá tiền / Giờ (VNĐ):</label>
                <input type="number" name="hourly_price" class="form-control" min="0" step="500" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Cấu hình:</label>
                <textarea name="specs" class="form-control" rows="2" placeholder="Nhập cấu hình máy..."></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Chi tiết ngoại vi:</label>
                <textarea name="peripheral_details" class="form-control" rows="2" placeholder="Chuột, phím, tai nghe..."></textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Ghi chú:</label>
                <input type="text" name="note" class="form-control" placeholder="Ghi chú thêm...">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success fw-bold px-4">Thêm Máy Tính</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <span class="fw-bold">🖥️ Danh Sách Máy Trạm</span>
        <form method="GET" action="index.php" class="d-flex gap-2">
            <input type="hidden" name="c" value="machine">
            <input type="hidden" name="a" value="index">
            <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Tìm tên máy, khu vực..." value="<?= e($keyword) ?>">
            <button type="submit" class="btn btn-outline-light btn-sm">Tìm kiếm</button>
            <?php if ($keyword !== ''): ?>
                <a href="index.php?c=machine&a=index" class="btn btn-secondary btn-sm">Hủy</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped align-middle mb-0 text-center">
            <thead class="table-secondary">
                <tr>
                    <th>ID</th><th>Tên Máy</th><th>Khu Vực</th><th>Giá / Giờ</th>
                    <th>Trạng Thái</th><th>Tổng Giờ</th><th>Ghi Chú</th><th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($dsMay)): ?>
                    <tr><td colspan="8" class="text-muted py-3">Không tìm thấy máy tính nào phù hợp!</td></tr>
                <?php else: ?>
                    <?php foreach ($dsMay as $m): ?>
                        <tr>
                            <td><?= $m['id'] ?></td>
                            <td class="fw-bold"><?= e($m['computer_name']) ?></td>
                            <td>
                                <?php
                                    $zoneName = e($m['zone_name'] ?? 'Mặc định');
                                    if (strpos($zoneName, 'Thường') !== false) { echo '🎮 ' . $zoneName; }
                                    elseif (strpos($zoneName, 'Stream') !== false) { echo '🎙️ ' . $zoneName; }
                                    elseif (strpos($zoneName, 'VIP') !== false) { echo '👑 ' . $zoneName; }
                                    else { echo $zoneName; }
                                ?>
                            </td>
                            <td><?= number_format($m['hourly_price']) ?> đ</td>
                            <td>
                                <span class="badge bg-<?= strtolower($m['status']) === 'online' ? 'success' : 'danger' ?>">
                                    <?= strtoupper($m['status']) ?>
                                </span>
                            </td>
                            <td><?= number_format($m['total_play_hours'], 2) ?> h</td>
                            <td class="small text-muted"><?= e($m['note'] ?? '') ?></td>
                            <td>
                                <a href="index.php?c=machine&a=edit&id=<?= $m['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <a href="index.php?c=machine&a=destroy&id=<?= $m['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa máy này không?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
