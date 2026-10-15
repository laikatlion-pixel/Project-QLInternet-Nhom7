<?php
declare(strict_types=1);

/**
 * Bộ định tuyến (Router) đơn giản - ánh xạ query string sang Controller & Action
 *
 * Cú pháp URL: index.php?c=<controller>&a=<action>&...
 * Ví dụ:       index.php?c=machine&a=edit&id=5
 */
class Router
{
    /**
     * Điều phối yêu cầu tới controller/action tương ứng
     */
    public function dispatch(): void
    {
        $controllerName = ucfirst(strtolower($_GET['c'] ?? 'dashboard')) . 'Controller';
        $action         = $_GET['a'] ?? 'index';

        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            http_response_code(404);
            exit("404 - Không tìm thấy trang: $controllerName");
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            http_response_code(404);
            exit("404 - Lớp controller không tồn tại: $controllerName");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            http_response_code(404);
            exit("404 - Không tìm thấy hành động: $action");
        }

        $controller->$action();
    }
}
