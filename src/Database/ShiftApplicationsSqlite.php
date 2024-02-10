<?php

namespace App\Database;

class ShiftApplicationsSqlite
{
    private \PDO $pdo;
    private int $shiftId;

    function __construct(\PDO $pdo, int $shiftId)
    {
        $this->pdo = $pdo;
        $this->shiftId = $shiftId;
    }

    function slots(): \Generator
    {
        $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift AS shift_id, id_user AS publisher_id, position AS shift_position, created AS created_on, first_name AS firstname, last_name AS lastname
            FROM shift_user_maps
            LEFT JOIN publisher ON shift_user_maps.id_user = publisher.id
            WHERE id_shift = :shiftId
            ORDER BY shift_position  ASC
        SQL);
        $stmt->execute([
            'shiftId' => $this->shiftId
        ]);

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $participant) {
            yield new ShiftApplicationSqlite($participant);
        }
    }
}
