<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once __DIR__ . "/../../config/database.php";

$may_id = $_GET["may_id"] ?? 0;
$username = $_GET["user"] ?? "";

if ($may_id > 0) {
    // 1. Lấy thông tin thời gian đăng nhập và giá tiền 1 giờ chơi của máy[cite: 5]
    $stmSelect = $pdo->prepare("SELECT last_login, hourly_price FROM may WHERE id = :id");
    $stmSelect->execute(["id" => $may_id]);
    $may = $stmSelect->fetch();

    if ($may && !empty($may['last_login'])) {
        // Tính khoảng thời gian từ lúc đăng nhập đến bây giờ (tính theo giờ)[cite: 5]
        $login_time = strtotime($may['last_login']);
        $now_time = time();
        $diff_seconds = $now_time - $login_time;
        
        $added_hours = round($diff_seconds / 3600, 2); 
        $total_cost = $added_hours * ($may['hourly_price'] ?? 0);

        // 2. Trừ tiền tài khoản hội viên nếu có thông tin username[cite: 5]
        if (!empty($username)) {
            $stmUser = $pdo->prepare("UPDATE members SET balance = balance - :cost WHERE username = :username");
            $stmUser->execute([
                "cost"     => $total_cost,
                "username" => $username
            ]);
        }

        // 3. Cập nhật trạng thái về 'offline' và cộng dồn số giờ chơi vào total_play_hours[cite: 5]
        $sql = "UPDATE may 
                SET status = 'offline', 
                    total_play_hours = total_play_hours + :added_hours 
                WHERE id = :id";
        
        $stmUpdate = $pdo->prepare($sql);
        $stmUpdate->execute([
            "added_hours" => $added_hours,
            "id"          => $may_id
        ]);
    }
}

// Chuyển hướng về lại màn hình khóa máy trạm cho khách tiếp theo[cite: 5]
header("Location: index.php?route=client_login&may_id=" . $may_id);
exit();
?>
