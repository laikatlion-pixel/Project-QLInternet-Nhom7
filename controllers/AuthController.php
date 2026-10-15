<?php
require_once __DIR__ . '/../model/AuthModel.php';

class AuthController {
    private $authModel;

    public function __construct($pdo) {
        $this->authModel = new AuthModel($pdo);
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = $this->authModel->login($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                header("Location: index.php?route=home");
                exit();
            } else {
                $error = "Tài khoản hoặc mật khẩu không đúng!";
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user']);
        session_destroy();
        header("Location: index.php?route=login");
        exit();
    }
}
?>
