<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/database.php';

$route = $_GET['route'] ?? 'home';

switch ($route) {
    case 'login':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->login();
        break;

    case 'logout':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->logout();
        break;

    case 'home':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    case 'machines':
        require_once 'controllers/MachineController.php';
        $controller = new MachineController($pdo);
        $action = $_GET['action'] ?? 'index';
        if ($action === 'add') $controller->add();
        elseif ($action === 'edit') $controller->edit();
        elseif ($action === 'delete') $controller->delete();
        else $controller->index();
        break;

    case 'members':
        require_once 'controllers/MemberController.php';
        $controller = new MemberController($pdo);
        $action = $_GET['action'] ?? 'index';
        if ($action === 'add') $controller->add();
        elseif ($action === 'edit') $controller->edit();
        elseif ($action === 'delete') $controller->delete();
        else $controller->index();
        break;

    case 'client_login':
        require_once 'controllers/ClientController.php';
        $controller = new ClientController($pdo);
        $controller->login();
        break;

    case 'client_logout':
        require_once 'controllers/ClientController.php';
        $controller = new ClientController($pdo);
        $controller->logout();
        break;

    default:
        echo "404 Không tìm thấy trang!";
        break;
}
?>