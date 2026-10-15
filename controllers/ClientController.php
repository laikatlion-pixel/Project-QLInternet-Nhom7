<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/Machine.php';
require_once __DIR__ . '/../models/Member.php';

class ClientController extends Controller
{
    private Machine $machineModel;
    private Member $memberModel;

    public function __construct()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->machineModel = new Machine();
        $this->memberModel  = new Member();
    }

    public function login(): void
    {
        $may_id = (int)($_GET['may_id'] ?? 1);
        $current_may = $this->machineModel->find($may_id);

        if (!$current_may) {
            die("Lỗi: Máy tính không tồn tại trên hệ thống!");
        }

        $error = '';
        $loginSuccess = false;
        $loggedInUser = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $member = $this->memberModel->authenticateClient($username, $password, $error);

            if ($member) {
                $now = date('Y-m-d H:i:s');
                $this->machineModel->markOnline($may_id, $now);

                $_SESSION['client_user']   = $member['username'];
                $_SESSION['client_may_id'] = $may_id;

                $this->redirect(
                    'index.php?c=client&a=login&status=success&may_id=' . $may_id
                    . '&user=' . urlencode($username)
                );
            }
        }

        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            $loginSuccess = true;
            $loggedInUser = $_GET['user'] ?? '';
        }

        $this->render('client/login', [
            'current_may'   => $current_may,
            'may_id'        => $may_id,
            'error'         => $error,
            'loginSuccess'  => $loginSuccess,
            'loggedInUser'  => $loggedInUser,
        ], 'none');
    }

    public function logout(): void
    {
        $may_id   = (int)($_GET['may_id'] ?? 0);
        $username = $_GET['user'] ?? '';

        if ($may_id > 0) {
            $may = $this->machineModel->find($may_id);

            if ($may && !empty($may['last_login'])) {
                $login_time   = strtotime($may['last_login']);
                $diff_seconds = time() - $login_time;
                $added_hours  = round($diff_seconds / 3600, 2);
                $total_cost   = $added_hours * ($may['hourly_price'] ?? 0);

                if ($username !== '') {
                    $this->memberModel->deduct($username, $total_cost);
                }

                $this->machineModel->markOfflineAndAddHours($may_id, $added_hours);
            }
        }

        $this->redirect('index.php?c=client&a=login&may_id=' . $may_id);
    }
}
