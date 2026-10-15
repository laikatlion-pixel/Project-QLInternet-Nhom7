<?php
declare(strict_types=1);

/**
 * Lớp kết nối CSDL theo Singleton Pattern (tránh mở nhiều kết nối trùng lặp)
 */
class Database
{
    private static ?PDO $instance = null;

    /**
     * Lấy đối tượng PDO duy nhất (singleton)
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../config/config.php';
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset']
            );
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                self::$instance = new PDO($dsn, $config['username'], $config['password'], $options);
            } catch (PDOException $e) {
                exit('Không thể kết nối CSDL: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }

    /**
     * Cấm khởi tạo bên ngoài (singleton)
     */
    private function __construct() {}
    private function __clone() {}
}
