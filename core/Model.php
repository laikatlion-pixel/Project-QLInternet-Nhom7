<?php
declare(strict_types=1);

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    protected string $table = '';

 
    public function all(): array
    {
        $stm = $this->db->query("SELECT * FROM {$this->table} ORDER BY id ASC");
        return $stm->fetchAll();
    }

   
    public function find(int $id): ?array
    {
        $stm = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stm->execute(['id' => $id]);
        $row = $stm->fetch();
        return $row ?: null;
    }

  
    public function delete(int $id): bool
    {
        $stm = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stm->execute(['id' => $id]);
    }
}
