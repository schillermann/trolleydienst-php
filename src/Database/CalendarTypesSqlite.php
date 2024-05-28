<?php

namespace App\Database;

class CalendarTypesSqlite
{
    private \PDO $pdo;

    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    function all(int $offset, int $limit): \Generator
    {
        $stmt = $this->pdo->prepare(<<<SQL
            SELECT id_shift_type AS id, name, user_per_shift_max AS publishers_per_shift, info, updated AS updated_on, created AS created_on
            FROM shift_types
            LIMIT :offset, :limit
        SQL);

        $stmt->execute([
            'offset' => $offset,
            'limit' => $limit
        ]);

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $calendarType) {
            yield new CalendarTypeSqlite(
                $calendarType["id"],
                $calendarType
            );
        }
    }
}
