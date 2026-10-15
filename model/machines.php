<?php
class MachineModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllMachines($keyword = '') {
        if (!empty($keyword)) {
            $stmt = $this->pdo->prepare("SELECT may.*, zone.zone_name FROM may JOIN zone ON may.zone_id = zone.id WHERE may.computer_name LIKE :kw OR zone.zone_name LIKE :kw");
            $stmt->execute(['kw' => "%$keyword%"]);
        } else {
            $stmt = $this->pdo->query("SELECT may.*, zone.zone_name FROM may JOIN zone ON may.zone_id = zone.id");
        }
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM may WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getZones() {
        return $this->pdo->query("SELECT * FROM zone ORDER BY id ASC")->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO may (computer_name, zone_id, specs, hourly_price, status, note, peripheral_details, total_play_hours)
                VALUES (:computer_name, :zone_id, :specs, :hourly_price, 'offline', :note, :peripheral_details, 0)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($data) {
        $sql = "UPDATE may SET 
                    computer_name = :computer_name, 
                    zone_id = :zone_id, 
                    specs = :specs, 
                    hourly_price = :hourly_price, 
                    status = :status, 
                    note = :note,
                    peripheral_details = :peripheral_details,
                    total_play_hours = :total_play_hours
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM may WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
