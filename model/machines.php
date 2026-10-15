<?php
class MachineModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function layTatCa($tu_khoa = '') {
        if ($tu_khoa != '') {
            $sql = "SELECT may.*, zone.zone_name FROM may JOIN zone ON may.zone_id = zone.id WHERE may.computer_name LIKE ? OR zone.zone_name LIKE ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(["%$tu_khoa%", "%$tu_khoa%"]);
        } else {
            $sql = "SELECT may.*, zone.zone_name FROM may JOIN zone ON may.zone_id = zone.id";
            $stmt = $this->db->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function layTheoId($id) {
        $stmt = $this->db->prepare("SELECT * FROM may WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function layDanhSachKhuVuc() {
        return $this->db->query("SELECT * FROM zone")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function themMoi($data) {
        $sql = "INSERT INTO may (computer_name, zone_id, specs, hourly_price, status, note) VALUES (?, ?, ?, ?, 'offline', ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['computer_name'],
            $data['zone_id'],
            $data['specs'],
            $data['hourly_price'],
            $data['note']
        ]);
    }

    public function capNhat($id, $data) {
        $sql = "UPDATE may SET computer_name = ?, zone_id = ?, specs = ?, hourly_price = ?, status = ?, note = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['computer_name'],
            $data['zone_id'],
            $data['specs'],
            $data['hourly_price'],
            $data['status'],
            $data['note'],
            $id
        ]);
    }

    public function xoa($id) {
        $stmt = $this->db->prepare("DELETE FROM may WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
