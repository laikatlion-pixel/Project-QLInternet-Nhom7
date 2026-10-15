<?php
declare(strict_types=1);

class Zone extends Model
{
    protected string $table = 'zone';

  
    public function getAll(): array
    {
        $stm = $this->db->query("SELECT * FROM zone ORDER BY id ASC");
        return $stm->fetchAll();
    }
}
