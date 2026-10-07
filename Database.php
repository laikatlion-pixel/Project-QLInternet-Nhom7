<?php
$host = 'localhost';
$dbname = 'may_tinh'; // Tên CSDL khớp với hình phpMyAdmin của bạn
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Cấu hình chế độ báo lỗi PDO sang Exception để dễ debug
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}
?>