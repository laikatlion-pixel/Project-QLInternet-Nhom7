<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

class ClientController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login() {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = "";
        $may_id = (int)($_GET["may_id"] ?? 1);

        $stmMay = $this->pdo->prepare("SELECT * FROM may WHERE id = :id");
        $stmMay->execute(["id" => $may_id]);
        $current_may = $stmMay->fetch();

        if (!$current_may) {
            die("Lỗi: Máy tính không tồn tại!");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = trim($_POST["username"] ?? "");
            $password = trim($_POST["password"] ?? "");

            $stmMem = $this->pdo->prepare("SELECT * FROM members WHERE username = :username AND password = :password");
            $stmMem->execute(["username" => $username, "password" => $password]);
            $member = $stmMem->fetch();

            if (!$member) {
                $error = "Tài khoản hoặc mật khẩu không hợp lệ!";
            } elseif (($member["balance"] ?? 0) <= 0) {
                $error = "Tài khoản đã hết tiền!";
            } else {
                $now = date('Y-m-d H:i:s');
                $sql = "UPDATE may SET status = 'online', last_login = :now_time WHERE id = :id";
                $stm = $this->pdo->prepare($sql);
                $stm->execute(["now_time" => $now, "id" => $may_id]);

                $_SESSION['client_user'] = $member['username'];
                $_SESSION['client_may_id'] = $may_id;

                header("Location: index.php?route=client_login&status=success&may_id=" . $may_id . "&user=" . urlencode($username));
                exit();
            }
        }
        require_once __DIR__ . '/../views/client/login.php';
    }

    public function logout() {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $may_id = $_GET["may_id"] ?? 0;
        $username = $_GET["user"] ?? "";

        if ($may_id > 0) {
            $stmSelect = $this->pdo->prepare("SELECT last_login, hourly_price FROM may WHERE id = :id");
            $stmSelect->execute(["id" => $may_id]);
            $may = $stmSelect->fetch();

            if ($may && !empty($may['last_login'])) {
                $login_time = strtotime($may['last_login']);
                $now_time = time();
                $diff_seconds = $now_time - $login_time;
                
                $added_hours = round($diff_seconds / 3600, 2); 
                $total_cost = $added_hours * ($may['hourly_price'] ?? 0);

                if (!empty($username)) {
                    $stmUser = $this->pdo->prepare("UPDATE members SET balance = balance - :cost WHERE username = :username");
                    $stmUser->execute(["cost" => $total_cost, "username" => $username]);
                }

                $sql = "UPDATE may SET status = 'offline', total_play_hours = total_play_hours + :added_hours WHERE id = :id";
                $stmUpdate = $this->pdo->prepare($sql);
                $stmUpdate->execute(["added_hours" => $added_hours, "id" => $may_id]);
            }
        }
        header("Location: index.php?route=client_login&may_id=" . $may_id);
        exit();
    }
}
?>
                  