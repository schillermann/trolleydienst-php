<?php

namespace App\Database;

class ShiftSlotsSqlite
{
    private \PDO $pdo;

    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    function slots(int $routeId): \Generator
    {
        $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift AS route_id, id_user AS publisher_id, position AS shift_position, created AS created_on, first_name AS firstname, last_name AS lastname
            FROM shift_user_maps
            LEFT JOIN publisher ON shift_user_maps.id_user = publisher.id
            WHERE id_shift = :routeId
            ORDER BY shift_position  ASC
        SQL);
        $stmt->execute([
            'routeId' => $routeId
        ]);

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $participant) {
            yield new ShiftSlotSqlite($participant);
        }
    }
}
