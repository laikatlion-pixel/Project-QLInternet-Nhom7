<?php
declare(strict_types=1);


class Member extends Model
{
    protected string $table = 'members';

    public function search(string $keyword = ''): array
    {
        if ($keyword !== '') {
            $stm = $this->db->prepare("SELECT * FROM members WHERE username LIKE :kw ORDER BY id ASC");
            $stm->execute(['kw' => "%$keyword%"]);
        } else {
            $stm = $this->db->query("SELECT * FROM members ORDER BY id ASC");
        }
        return $stm->fetchAll();
    }

    
    public function existsByUsername(string $username): bool
    {
        $stm = $this->db->prepare("SELECT id FROM members WHERE username = :username");
        $stm->execute(['username' => $username]);
        return $stm->rowCount() > 0;
    }

  
    public function create(string $username, string $password, int $balance): bool
    {
        $stm = $this->db->prepare(
            "INSERT INTO members (username, password, balance, created_at) VALUES (:username, :password, :balance, NOW())"
        );
        return $stm->execute(['username' => $username, 'password' => $password, 'balance' => $balance]);
    }

   
    public function update(int $id, string $username, int $balance, string $password = ''): bool
    {
        if ($password !== '') {
            $stm = $this->db->prepare(
                "UPDATE members SET username = :username, password = :password, balance = :balance WHERE id = :id"
            );
            return $stm->execute(['username' => $username, 'password' => $password, 'balance' => $balance, 'id' => $id]);
        }
        $stm = $this->db->prepare("UPDATE members SET username = :username, balance = :balance WHERE id = :id");
        return $stm->execute(['username' => $username, 'balance' => $balance, 'id' => $id]);
    }

    
    public function authenticateClient(string $username, string $password, ?string &$errorMessage): ?array
    {
        $stm = $this->db->prepare("SELECT * FROM members WHERE username = :username AND password = :password");
        $stm->execute(['username' => $username, 'password' => $password]);
        $member = $stm->fetch();

        if (!$member) {
            $errorMessage = "Tài khoản hoặc mật khẩu không hợp lệ!";
            return null;
        }
        if (($member['balance'] ?? 0) <= 0) {
            $errorMessage = "Tài khoản của bạn đã hết tiền (0 VNĐ)! Vui lòng ra quầy nạp thêm.";
            return null;
        }
        return $member;
    }

    public function topup(string $username, int $moneyAdd): bool
    {
        $stm = $this->db->prepare("UPDATE members SET balance = balance + :money WHERE username = :username");
        return $stm->execute(['money' => $moneyAdd, 'username' => $username]);
    }

    
    public function deduct(string $username, float $cost): bool
    {
        $stm = $this->db->prepare("UPDATE members SET balance = balance - :cost WHERE username = :username");
        return $stm->execute(['cost' => $cost, 'username' => $username]);
    }
}
