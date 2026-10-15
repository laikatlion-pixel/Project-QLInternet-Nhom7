<?php
declare(strict_types=1);


class Machine extends Model
{
    protected string $table = 'may';

   
    public function getAllWithZone(string $keyword = ''): array
    {
        if ($keyword !== '') {
            $stm = $this->db->prepare(
                "SELECT m.*, z.zone_name FROM may m
                 LEFT JOIN zone z ON m.zone_id = z.id
                 WHERE m.computer_name LIKE :kw1 OR z.zone_name LIKE :kw2
                 ORDER BY m.id ASC"
            );
            $stm->execute(['kw1' => "%$keyword%", 'kw2' => "%$keyword%"]);
        } else {
            $stm = $this->db->query(
                "SELECT m.*, z.zone_name FROM may m
                 LEFT JOIN zone z ON m.zone_id = z.id
                 ORDER BY m.id ASC"
            );
        }
        return $stm->fetchAll();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO may (computer_name, zone_id, specs, hourly_price, status, note, peripheral_details, total_play_hours)
                VALUES (:computer_name, :zone_id, :specs, :hourly_price, 'offline', :note, :peripheral_details, 0)";
        $stm = $this->db->prepare($sql);
        return $stm->execute([
            'computer_name'      => $data['computer_name'],
            'zone_id'            => $data['zone_id'],
            'specs'              => $data['specs'],
            'hourly_price'       => $data['hourly_price'],
            'note'               => $data['note'],
            'peripheral_details' => $data['peripheral_details'],
        ]);
    }

    
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE may SET
                    computer_name      = :computer_name,
                    zone_id            = :zone_id,
                    specs              = :specs,
                    hourly_price       = :hourly_price,
                    status             = :status,
                    note               = :note,
                    peripheral_details = :peripheral_details,
                    total_play_hours   = :total_play_hours
                WHERE id = :id";
        $stm = $this->db->prepare($sql);
        return $stm->execute(array_merge($data, ['id' => $id]));
    }

   
    public function markOnline(int $id, string $loginTime): bool
    {
        $stm = $this->db->prepare("UPDATE may SET status = 'online', last_login = :now_time WHERE id = :id");
        return $stm->execute(['now_time' => $loginTime, 'id' => $id]);
    }

   
    public function markOfflineAndAddHours(int $id, float $addedHours): bool
    {
        $stm = $this->db->prepare(
            "UPDATE may SET status = 'offline', total_play_hours = total_play_hours + :added_hours WHERE id = :id"
        );
        return $stm->execute(['added_hours' => $addedHours, 'id' => $id]);
    }
}
