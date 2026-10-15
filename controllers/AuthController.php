<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/User.php';


class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login(): void
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('index.php?c=dashboard&a=index');
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($username === '' || $password === '') {
                $error = "Vui lòng nhập đầy đủ thông tin!";
            } else {
                $user = $this->userModel->authenticate($username, $password);
                if ($user) {
                    $_SESSION['user'] = [
                        'id'       => $user['id'],
                        'username' => $user['username'],
                        'fullname' => $user['fullname'],
                        'role'     => $user['role'],
                    ];
                    $this->redirect('index.php?c=dashboard&a=index');
                }
                $error = "Tài khoản hoặc mật khẩu không chính xác!";
            }
        }

        $this->render('auth/login', ['error' => $error], 'none');
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->redirect('index.php?c=auth&a=login');
    }
}
