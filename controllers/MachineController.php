<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/Machine.php';
require_once __DIR__ . '/../models/Zone.php';


class MachineController extends Controller
{
    private Machine $machineModel;
    private Zone $zoneModel;

    public function __construct()
    {
        $this->machineModel = new Machine();
        $this->zoneModel    = new Zone();
    }

    public function index(): void
    {
        $this->requireAdmin();

        $keyword = trim($_GET['keyword'] ?? '');
        $dsMay   = $this->machineModel->getAllWithZone($keyword);
        $dsZone  = $this->zoneModel->getAll();

        $this->render('machines/index', [
            'dsMay'   => $dsMay,
            'dsZone'  => $dsZone,
            'keyword' => $keyword,
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=dashboard&a=index');
        }

        $computer_name      = trim($_POST['computer_name'] ?? '');
        $zone_id            = (int)($_POST['zone_id'] ?? 0);
        $hourly_price       = (int)($_POST['hourly_price'] ?? 0);
        $specs              = trim($_POST['specs'] ?? '');
        $peripheral_details = trim($_POST['peripheral_details'] ?? '');
        $note               = trim($_POST['note'] ?? '');

        if ($computer_name !== '' && $hourly_price >= 0 && $zone_id > 0) {
            $this->machineModel->create(compact('computer_name', 'zone_id', 'specs', 'hourly_price', 'note', 'peripheral_details'));
            $this->flash('success', "Thêm mới máy tính <strong>$computer_name</strong> thành công!");
        } else {
            $this->flash('error', "Vui lòng nhập đầy đủ tên máy, giá tiền và chọn khu vực!");
        }

        $this->redirect('index.php?c=machine&a=index');
    }
function edit(): void
    {
        $this->requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        $edit_data = $this->machineModel->find($id);

        if (!$edit_data) {
            $this->flash('error', "Không tìm thấy máy tính cần sửa!");
            $this->redirect('index.php?c=machine&a=index');
        }

        $dsZone = $this->zoneModel->getAll();
        $this->render('machines/edit', [
            'edit_data' => $edit_data,
            'dsZone'    => $dsZone,
        ]);
    }

    public function update(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=machine&a=index');
        }

        $id                 = (int)($_POST['id'] ?? 0);
        $computer_name      = trim($_POST['computer_name'] ?? '');
        $zone_id            = (int)($_POST['zone_id'] ?? 0);
        $hourly_price       = (int)($_POST['hourly_price'] ?? 0);
        $status             = $_POST['status'] ?? 'offline';
        $specs              = trim($_POST['specs'] ?? '');
        $peripheral_details = trim($_POST['peripheral_details'] ?? '');
        $note               = trim($_POST['note'] ?? '');
        $total_play_hours   = (float)($_POST['total_play_hours'] ?? 0);

        if ($id > 0 && $computer_name !== '' && $hourly_price >= 0 && $zone_id > 0) {
            $this->machineModel->update($id, compact(
                'computer_name', 'zone_id', 'specs', 'hourly_price',
                'status', 'note', 'peripheral_details', 'total_play_hours'
            ));
            $this->flash('success', "Cập nhật thông tin máy <strong>$computer_name</strong> thành công!");
        } else {
            $this->flash('error', "Dữ liệu cập nhật máy tính không hợp lệ!");
        }

        $this->redirect('index.php?c=machine&a=index');
    }

    public function destroy(): void
    {
        $this->requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            if ($this->machineModel->delete($id)) {
                $this->flash('success', "Xóa máy tính thành công!");
            } else {
                $this->flash('error', "Không thể xóa máy tính!");
            }
        }
        $this->redirect('index.php?c=machine&a=index');
    }
}
