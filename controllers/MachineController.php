<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Machine.php';

class MachineController {
    private $db;
    private $machineModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->machineModel = new Machine($this->db);
    }

    // Hiển thị danh sách
    public function index() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $machines = $this->machineModel->getAll($keyword);
        include __DIR__ . '/../views/machines/index.php';
    }

    // Xử lý thêm mới
    public function add() {
        $zones = $this->machineModel->getZones();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['computer_name']) || empty($_POST['hourly_price'])) {
                $error = 'Vui lòng điền đủ thông tin!';
            } else {
                $this->machineModel->create($_POST);
                header('Location: index.php?action=index');
                exit;
            }
        }
        include __DIR__ . '/../views/machines/add.php';
    }

    // Xử lý xóa
    public function delete() {
        if (isset($_GET['id'])) {
            $this->machineModel->delete($_GET['id']);
        }
        header('Location: index.php?action=index');
        exit;
    }
}
?>
