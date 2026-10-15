<?php
declare(strict_types=1);

/**
 * Lớp Model cha - cung cấp kết nối PDO cho mọi Model con
 */
abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Tên bảng CSDL tương ứng (mỗi model con sẽ override)
     */
    protected string $table = '';

    /**
     * Lấy tất cả bản ghi
     */
    public function all(): array
    {
        $stm = $this->db->query("SELECT * FROM {$this->table} ORDER BY id ASC");
        return $stm->fetchAll();
    }

    /**
     * Tìm bản ghi theo ID
     */
    public function find(int $id): ?array
    {
        $stm = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stm->execute(['id' => $id]);
        $row = $stm->fetch();
        return $row ?: null;
    }

    /**
     * Xóa bản ghi theo ID - trả về true/false
     */
    public function delete(int $id): bool
    {
        $stm = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stm->execute(['id' => $id]);
    }
}
