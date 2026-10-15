<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/Member.php';


class MemberController extends Controller
{
    private Member $memberModel;

    public function __construct()
    {
        $this->memberModel = new Member();
    }

    public function index(): void
    {
        $this->requireAdmin();

        $keyword   = trim($_GET['keyword'] ?? '');
        $dsMembers = $this->memberModel->search($keyword);

        $this->render('members/index', [
            'dsMembers' => $dsMembers,
            'keyword'   => $keyword,
        ]);
    }
    public function store(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=dashboard&a=index');
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $balance  = (int)($_POST['balance'] ?? 0);

        if ($username === '' || $password === '') {
            $this->flash('error', "Vui lòng nhập đầy đủ Tên tài khoản và Mật khẩu!");
        } elseif ($this->memberModel->existsByUsername($username)) {
            $this->flash('error', "Tài khoản <strong>$username</strong> đã tồn tại trong hệ thống!");
        } else {
            $this->memberModel->create($username, $password, $balance);
            $this->flash('success', "Thêm tài khoản hội viên <strong>$username</strong> thành công!");
        }

        $this->redirect('index.php?c=member&a=index');
    }

    public function edit(): void
    {
        $this->requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        $edit_data = $this->memberModel->find($id);

        if (!$edit_data) {
            $this->flash('error', "Không tìm thấy hội viên cần sửa!");
            $this->redirect('index.php?c=member&a=index');
        }

        $this->render('members/edit', ['edit_data' => $edit_data]);
    }

    public function update(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=member&a=index');
        }

        $id       = (int)($_POST['id'] ?? 0);
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $balance  = (int)($_POST['balance'] ?? 0);

        if ($id > 0 && $username !== '') {
            $this->memberModel->update($id, $username, $balance, $password);
            $this->flash('success', "Cập nhật thông tin tài khoản <strong>$username</strong> thành công!");
        } else {
            $this->flash('error', "Dữ liệu cập nhật hội viên không hợp lệ!");
        }

        $this->redirect('index.php?c=member&a=index');
    }
ic function destroy(): void
    {
        $this->requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            if ($this->memberModel->delete($id)) {
                $this->flash('success', "Đã xóa hội viên thành công!");
            } else {
                $this->flash('error', "Xóa hội viên thất bại!");
            }
        }
        $this->redirect('index.php?c=member&a=index');
    }

    public function topup(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=member&a=index');
        }

        $username  = trim($_POST['username_topup'] ?? '');
        $money_add = (int)($_POST['money_add'] ?? 0);

        if ($username === '') {
            $this->flash('error', "Lỗi: Không tìm thấy tên tài khoản cần nạp!");
        } elseif ($money_add <= 0) {
            $this->flash('error', "Lỗi: Số tiền nạp phải lớn hơn 0!");
        } elseif (!$this->memberModel->existsByUsername($username)) {
            $this->flash('error', "Lỗi: Tài khoản <strong>$username</strong> không tồn tại trong hệ thống!");
        } else {
            $this->memberModel->topup($username, $money_add);
            $this->flash('success', "Đã nạp thành công <strong>" . number_format($money_add) . " đ</strong> vào tài khoản <strong>$username</strong>!");
        }

        $this->redirect('index.php?c=member&a=index');
    }
}
