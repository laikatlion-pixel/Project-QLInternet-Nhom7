<?php $activePage = 'member'; $pageTitle = 'Quản Lý Khách Hàng / Hội Viên'; ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white fw-bold">➕ Thêm Tài Khoản Hội Viên Mới</div>
    <div class="card-body">
        <form method="POST" action="index.php?c=member&a=store" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Tên tài khoản:</label>
                <input type="text" name="username" class="form-control" placeholder="Nhập username..." required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Mật khẩu:</label>
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu..." required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Số dư tài khoản (VNĐ):</label>
                <input type="number" name="balance" class="form-control" step="1000" min="0" value="0">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary fw-bold px-4">Thêm Hội Viên</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <span class="fw-bold">👤 Danh Sách Khách Hàng / Hội Viên</span>
        <form method="GET" action="index.php" class="d-flex gap-2">
            <input type="hidden" name="c" value="member">
            <input type="hidden" name="a" value="index">
            <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Tìm username..." value="<?= e($keyword) ?>">
            <button type="submit" class="btn btn-outline-light btn-sm">Tìm kiếm</button>
            <?php if ($keyword !== ''): ?>
                <a href="index.php?c=member&a=index" class="btn btn-secondary btn-sm">Hủy</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped align-middle mb-0 text-center">
            <thead class="table-secondary">
                <tr><th>ID</th><th>Tên Tài Khoản</th><th>Số Dư</th><th>Ngày Tạo</th><th>Thao Tác</th></tr>
            </thead>
            <tbody>
                <?php if (empty($dsMembers)): ?>
                    <tr><td colspan="5" class="text-muted py-3">Không tìm thấy hội viên nào phù hợp!</td></tr>
                <?php else: ?>
                    <?php foreach ($dsMembers as $mem): ?>
                        <tr>
                            <td><?= $mem['id'] ?></td>
                            <td class="fw-bold"><?= e($mem['username']) ?></td>
                            <td class="text-success fw-bold"><?= number_format($mem['balance']) ?> đ</td>
                            <td class="small text-muted"><?= $mem['created_at'] ?? 'N/A' ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success fw-bold"
                                        data-bs-toggle="modal" data-bs-target="#topupModal"
                                        data-username="<?= e($mem['username']) ?>">
                                    💵 Nạp tiền
                                </button>
                                <a href="index.php?c=member&a=edit&id=<?= $mem['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <a href="index.php?c=member&a=destroy&id=<?= $mem['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa hội viên này không?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="topupModal" tabindex="-1" aria-labelledby="topupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="index.php?c=member&a=topup">
                <input type="hidden" name="topup_action" value="1">
                <input type="hidden" name="username_topup" id="modal_username_input">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="topupModalLabel">💵 Nạp Tiền Cho: <span id="modal_username_display" class="text-warning"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">⚡ Chọn mức nạp nhanh:</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-outline-success btn-sm quick-amount" data-amount="10000">+10.000đ</button>
                            <button type="button" class="btn btn-outline-success btn-sm quick-amount" data-amount="20000">+20.000đ</button>
                            <button type="button" class="btn btn-outline-success btn-sm quick-amount" data-amount="50000">+50.000đ</button>
                            <button type="button" class="btn btn-outline-success btn-sm quick-amount" data-amount="100000">+100.000đ</button>
                            <button type="button" class="btn btn-outline-success btn-sm quick-amount" data-amount="200000">+200.000đ</button>
                            <button type="button" class="btn btn-outline-success btn-sm quick-amount" data-amount="500000">+500.000đ</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hoặc nhập số tiền tùy chỉnh (VNĐ):</label>
                        <input type="number" name="money_add" id="money_input" class="form-control" min="1000" step="1000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-success fw-bold">Xác Nhận Nạp</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const topupModal = document.getElementById('topupModal');
    if (topupModal) {
        topupModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const username = button.getAttribute('data-username');
            topupModal.querySelector('#modal_username_input').value = username;
            topupModal.querySelector('#modal_username_display').textContent = username;
            topupModal.querySelector('#money_input').value = '';
        });
    }
    document.querySelectorAll('.quick-amount').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('money_input').value = this.getAttribute('data-amount');
        });
    });
</script>
