<?php
require_once __DIR__ . '/../models/MachineModel.php';
require_once __DIR__ . '/../includes/auth.php';

class MachineController {
    private $model;

    public function __construct($pdo) {
        requireAdmin(); // Chặn nếu không phải admin[cite: 5, 10, 11, 12]
        $this->model = new MachineModel($pdo);
    }

    public function index() {
        $keyword = $_GET['keyword'] ?? '';
        $machines = $this->model->getAllMachines($keyword);
        // require_once __DIR__ . '/../views/machines/index.php'; // Tạo file view hiển thị danh sách
    }

    public function add() {
        $zones = $this->model->getZones();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "computer_name"      => trim($_POST["computer_name"] ?? ""),
                "zone_id"            => (int)($_POST["zone_id"] ?? 0),
                "hourly_price"       => (int)($_POST["hourly_price"] ?? 0),
                "specs"              => trim($_POST["specs"] ?? ""),
                "note"               => trim($_POST["note"] ?? ""),
                "peripheral_details" => trim($_POST["peripheral_details"] ?? "")
            ];
            if (!empty($data['computer_name']) && $data['hourly_price'] >= 0 && $data['zone_id'] > 0) {
                $this->model->create($data);
                $_SESSION['success_msg'] = "Thêm máy thành công!";
            } else {
                $_SESSION['error_msg'] = "Dữ liệu không hợp lệ!";
            }
            header("Location: index.php?route=machines");
            exit();
        }
        // require_once __DIR__ . '/../views/machines/add.php';
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
            $_SESSION['success_msg'] = "Xóa máy thành công!";
        }
        header("Location: index.php?route=machines");
        exit();
    }
}
?>
