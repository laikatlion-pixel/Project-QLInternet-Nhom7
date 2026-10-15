<?php
require_once __DIR__ . '/../models/MemberModel.php';
require_once __DIR__ . '/../includes/auth.php';

class MemberController {
    private $model;

    public function __construct($pdo) {
        requireAdmin();
        $this->model = new MemberModel($pdo);
    }

    public function index() {
        $members = $this->model->getAllMembers();
        require_once __DIR__ . '/../views/members/index.php';
    }

    public function add() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = trim($_POST["username"] ?? "");
            $password = trim($_POST["password"] ?? "");
            $balance = (int)($_POST["balance"] ?? 0);

            if (!empty($username) && !empty($password)) {
                $existing = $this->model->findByUsername($username);
                if ($existing) {
                    $_SESSION['error_msg'] = "Tài khoản đã tồn tại!";
                } else {
                    $this->model->create($username, $password, $balance);
                    $_SESSION['success_msg'] = "Thêm hội viên thành công!";
                }
            } else {
                $_SESSION['error_msg'] = "Vui lòng nhập đầy đủ thông tin!";
            }
            header("Location: index.php?route=members");
            exit();
        }
        require_once __DIR__ . '/../views/members/add.php';
    }

    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        $member = $this->model->getById($id);
        if (!$member) {
            header("Location: index.php?route=members");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = trim($_POST["username"] ?? "");
            $password = trim($_POST["password"] ?? "");
            $balance = (int)($_POST["balance"] ?? 0);

            if (!empty($username)) {
                $this->model->update($id, $username, $password, $balance);
                $_SESSION['success_msg'] = "Cập nhật hội viên thành công!";
            } else {
                $_SESSION['error_msg'] = "Tên tài khoản không được để trống!";
            }
            header("Location: index.php?route=members");
            exit();
        }
        require_once __DIR__ . '/../views/members/edit.php';
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
            $_SESSION['success_msg'] = "Xóa hội viên thành công!";
        }
        header("Location: index.php?route=members");
        exit();
    }
}
?>