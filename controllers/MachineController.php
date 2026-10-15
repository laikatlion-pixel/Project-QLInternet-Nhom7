<?php
require_once __DIR__ . '/../model/MachineModel.php';
require_once __DIR__ . '/../includes/auth.php';

class MachineController {
    private $machineModel;

    public function __construct($pdo) {
        $this->machineModel = new MachineModel($pdo);
    }

    public function index() {
        $tu_khoa = $_GET['keyword'] ?? '';
        $machines = $this->machineModel->layTatCa($tu_khoa);
        require_once __DIR__ . '/../views/machines/index.php';
    }

    public function add() {
        $zones = $this->machineModel->layDanhSachKhuVuc();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                "computer_name" => trim($_POST['computer_name']),
                "zone_id"       => $_POST['zone_id'],
                "specs"         => trim($_POST['specs']),
                "hourly_price"  => $_POST['hourly_price'],
                "note"          => trim($_POST['note'])
            ];

            if ($data['computer_name'] != "" && $data['hourly_price'] != "") {
                $this->machineModel->themMoi($data);
                header("Location: index.php?route=machines");
                exit();
            } else {
                $error = "Vui lòng nhập đầy đủ thông tin bắt buộc!";
            }
        }
        require_once __DIR__ . '/../views/machines/add.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $this->machineModel->xoa($id);
        }
        header("Location: index.php?route=machines");
        exit();
    }
}
?>
