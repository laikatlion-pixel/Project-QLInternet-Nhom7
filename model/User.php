<?php
declare(strict_types=1);

class User extends Model
{
    protected string $table = 'user';

  
    public function authenticate(string $username, string $password): ?array
    {
        $stm = $this->db->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
        $stm->execute(['username' => $username, 'password' => $password]);
        $user = $stm->fetch();
        return $user ?: null;
    }
}
