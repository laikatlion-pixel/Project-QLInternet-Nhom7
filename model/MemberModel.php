<?php
class MemberModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllMembers() {
        return $this->pdo->query("SELECT * FROM members ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM members WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT id FROM members WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $password, $balance) {
        $stmt = $this->pdo->prepare("INSERT INTO members (username, password, balance, created_at) VALUES (:username, :password, :balance, NOW())");
        return $stmt->execute([
            'username' => $username, 
            'password' => $password, 
            'balance'  => $balance
        ]);
    }

    public function update($id, $username, $password, $balance) {
        if (!empty($password)) {
            $sql = "UPDATE members SET username = :username, password = :password, balance = :balance WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'username' => $username, 
                'password' => $password, 
                'balance'  => $balance, 
                'id'       => $id
            ]);
        } else {
            $sql = "UPDATE members SET username = :username, balance = :balance WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'username' => $username, 
                'balance'  => $balance, 
                'id'       => $id
            ]);
        }
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM members WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
