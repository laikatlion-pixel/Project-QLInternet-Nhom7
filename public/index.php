<?php
/**
 * FRONT CONTROLLER - Điểm vào duy nhất của toàn bộ ứng dụng MVC
 * Mọi yêu cầu đều đi qua file này: index.php?c=<controller>&a=<action>
 */
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Nạp các lớp cốt lõi (core)
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Router.php';

// Nạp hàm tiện ích dùng chung
require_once __DIR__ . '/../helpers/functions.php';

// Khởi động bộ định tuyến và điều phối yêu cầu
$router = new Router();
$router->dispatch();
