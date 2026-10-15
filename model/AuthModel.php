<?php
class AuthModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Kiểm tra thông tin đăng nhập của Admin/Nhân viên
    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
        $stmt->execute([
            'username' => $username, 
            'password' => $password
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>