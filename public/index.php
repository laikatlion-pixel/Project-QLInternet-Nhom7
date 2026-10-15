<?php

session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');


require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Router.php';


require_once __DIR__ . '/../helpers/functions.php';


$router = new Router();
$router->dispatch();
