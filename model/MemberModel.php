<?php
class MemberModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lấy toàn bộ danh sách hội viên
    public function getAllMembers() {
        return $this->pdo->query("SELECT * FROM members ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin chi tiết một hội viên theo ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM members WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tìm kiếm hội viên theo tên tài khoản (dùng để kiểm tra trùng lặp)
    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT id FROM members WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm mới hội viên
    public function create($username, $password, $balance) {
        $stmt = $this->pdo->prepare("INSERT INTO members (username, password, balance, created_at) VALUES (:username, :password, :balance, NOW())");
        return $stmt->execute([
            'username' => $username, 
            'password' => $password, 
            'balance'  => $balance
        ]);
    }

    // Cập nhật thông tin hội viên
    public function update($id, $username, $password, $balance) {
        if (!empty($password)) {
            // Nếu có nhập mật khẩu mới
            $sql = "UPDATE members SET username = :username, password = :password, balance = :balance WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'username' => $username, 
                'password' => $password, 
                'balance'  => $balance, 
                'id'       => $id
            ]);
        } else {
            // Giữ nguyên mật khẩu cũ nếu bỏ trống
            $sql = "UPDATE members SET username = :username, balance = :balance WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'username' => $username, 
                'balance'  => $balance, 
                'id'       => $id
            ]);
        }
    }

    // Xóa hội viên theo ID
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM members WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>