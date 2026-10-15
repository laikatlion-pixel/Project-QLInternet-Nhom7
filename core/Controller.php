<?php
declare(strict_types=1);

/**
 * Lớp Controller cha - cung cấp các phương thức tiện ích: render view, redirect, flash message
 */
abstract class Controller
{
    /**
     * Render view (giao diện) và truyền dữ liệu sang view
     *
     * @param string $view  Đường dẫn view tương đối trong thư mục views/, ví dụ: 'machines/index'
     * @param array  $data  Dữ liệu truyền sang view (sẽ được extract thành biến)
     * @param string $layout Tên layout, 'admin' hoặc 'none'
     */
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

    /**
     * Chuyển hướng (redirect)
     */
    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }

    /**
     * Lưu thông báo flash vào session (hiển thị 1 lần duy nhất)
     */
    protected function flash(string $type, string $message): void
    {
        $_SESSION[$type === 'success' ? 'success_msg' : 'error_msg'] = $message;
    }

    /**
     * Kiểm tra đăng nhập admin - nếu chưa đăng nhập thì đá về trang login
     */
    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('index.php?c=auth&a=login');
        }
    }

    /**
     * Kiểm tra quyền admin - nếu không phải admin thì chặn
     */
    protected function requireAdmin(): void
    {
        $this->requireAuth();
        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            echo "<script>alert('Bạn không có quyền thực hiện chức năng quản trị này!'); window.location.href='index.php?c=dashboard&a=index';</script>";
            exit();
        }
    }
}
