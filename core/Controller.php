<?php
declare(strict_types=1);


abstract class Controller
{
    
    protected function render(string $view, array $data = [], string $layout = 'admin'): void
    {
        extract($data);

        // Lấy flash message từ session để hiển thị (nếu có)
        $flashSuccess = $_SESSION['success_msg'] ?? null;
        $flashError   = $_SESSION['error_msg'] ?? null;
        unset($_SESSION['success_msg'], $_SESSION['error_msg']);

        if ($layout === 'admin') {
            require __DIR__ . '/../views/layouts/admin_header.php';
        }

        require __DIR__ . '/../views/' . $view . '.php';

        if ($layout === 'admin') {
            require __DIR__ . '/../views/layouts/admin_footer.php';
        }
    }

   
    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }

   
    protected function flash(string $type, string $message): void
    {
        $_SESSION[$type === 'success' ? 'success_msg' : 'error_msg'] = $message;
    }

    
    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('index.php?c=auth&a=login');
        }
    }

   
    protected function requireAdmin(): void
    {
        $this->requireAuth();
        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            echo "<script>alert('Bạn không có quyền thực hiện chức năng quản trị này!'); window.location.href='index.php?c=dashboard&a=index';</script>";
            exit();
        }
    }
}
